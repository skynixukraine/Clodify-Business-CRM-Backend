<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/5/18
 * Time: 9:57 PM
 */

namespace app\models;

use app\components\Bootstrap;
use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "clients".
 *
 * @property integer $id
 * @property string $name
 * @property string $domain
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $trial_expires
 * @property string $prepaid_for
 * @property string $mysql_user
 * @property string $mysql_password
 * @property integer $is_active
 * @property integer $is_confirmed
 *
 * @package app\models
 */
class CoreClient extends ActiveRecord
{
    const IS_ACTIVE = 1;

    const SCENARIO_PRE_REGISTER_VALIDATION  = 'pre-register';
    const SCENARIO_REGISTER_VALIDATION      = 'register';

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'clients';
    }

    public function rules()
    {
        return [
            [['domain'], 'string', 'max' => 80, 'on' => [self::SCENARIO_PRE_REGISTER_VALIDATION, self::SCENARIO_REGISTER_VALIDATION]],
            [['name', 'email', 'first_name', 'last_name'], 'string', 'max' => 255, 'on' => [self::SCENARIO_PRE_REGISTER_VALIDATION, self::SCENARIO_REGISTER_VALIDATION]],
            [['mysql_user', 'mysql_password'], 'string', 'max' => 45, 'on' => [self::SCENARIO_REGISTER_VALIDATION]],
            [['name', 'domain', 'email', 'mysql_user', 'mysql_password'], 'required', 'on' => [self::SCENARIO_REGISTER_VALIDATION]],
            [['name', 'domain', 'email'], 'required', 'on' => [self::SCENARIO_PRE_REGISTER_VALIDATION]],
            [['is_active', 'is_confirmed'], 'boolean'],
            ['email', 'email'],
            [['email'], 'unique', 'on'=> [self::SCENARIO_PRE_REGISTER_VALIDATION, self::SCENARIO_REGISTER_VALIDATION]],
            ['domain', function () {
                    if( CoreClient::find()->where(['domain' => $this->getConvertedDomain()])->one() ) {
                        $this->addError('domain', Yii::t('app', 'Client with this domain already exists. If this belongs to you please contact administrator.'));
                    }
                },
                'on'=> [self::SCENARIO_PRE_REGISTER_VALIDATION, self::SCENARIO_REGISTER_VALIDATION]
            ],

        ];
    }

    public function getConvertedDomain()
    {
        return str_replace([' ', '-'], '_', $this->domain);
    }

    public function getUnConvertedDomain()
    {
        return str_replace('_', '-', $this->domain);
    }

    public static function getDb()
    {
        return Yii::$app->dbCore;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ( $insert === true ) {

            $dbName = Bootstrap::$dbPrefix . $this->domain;

            $dsnParts = explode(";", Yii::$app->dbCore->dsn);
            $coreDbName = explode("=", $dsnParts[1])[1];

            $databases = Yii::$app->dbCore
                ->createCommand('SHOW DATABASES;')
                ->queryAll();

            $skip = false;
            foreach ( $databases as $db ) {

                if ( $db['Database'] === $dbName ) {

                    $skip = true;

                }
            }
            if ( $skip === false ) {

                Yii::$app->dbCore
                    ->createCommand('CREATE DATABASE ' . $dbName . ';')
                    ->execute();
                Yii::$app->dbCore
                    ->createCommand("CREATE USER '" . $this->mysql_user . "'@'%' IDENTIFIED BY '" . $this->mysql_password . "';")
                    ->execute();
                Yii::$app->dbCore
                    ->createCommand("GRANT ALL PRIVILEGES ON " . $dbName . ".* TO '"  . $this->mysql_user . "'@'%' WITH GRANT OPTION;")
                    ->execute();

                Yii::$app->dbCore
                    ->createCommand("use " . $dbName)
                    ->execute();

                Yii::$app->dbCore
                    ->createCommand(file_get_contents( Yii::$app->basePath . '/modules/api/tests/_data/dump.sql' ))
                    ->execute();

                //Prepare a new database
                //Truncate old test data
                $tables = [
                    'api_auth_access_tokens',
                    'availability_logs',
                    'payment_methods',
                    'busineses',
                    'financial_reports',
                    'operation_types',
                    'project_customers',
                    'project_developers',
                    'reports',
                    'projects',
                    'users',
                ];

                foreach ( $tables as $table ) {

                    Yii::$app->db
                        ->createCommand("SET FOREIGN_KEY_CHECKS=0; TRUNCATE `" . $table . "`; SET FOREIGN_KEY_CHECKS=1;")
                        ->execute();

                }
                //Create ADMIN user
                $user = new User();
                $user->role          = User::ROLE_ADMIN;
                $user->first_name    = $this->first_name;
                $user->last_name     = $this->last_name;
                $user->email         = $this->email;
                $user->password      = Yii::$app->security->generateRandomString( 12 );
                $user->is_active     = User::ACTIVE_USERS;
                $user->auth_type     = User::DATABASE_AUTH;
                $user->save();
            }

            Yii::$app->dbCore
                ->createCommand("use " . $coreDbName )
                ->execute();

            $clientKeys = new \app\models\CoreClientKey();
            $clientKeys->client_id      = $this->id;
            $clientKeys->valid_until    = date('Y-m-d', strtotime('now +1day'));
            $clientKeys->access_key     = Yii::$app->security->generateRandomString( 45 );
            $clientKeys->save();

            /** @var $setting Setting */
            if ( ($setting = Setting::find()
                ->where(['key' => Setting::CLIENT_ID])
                ->one() )) {

                $setting->value = $this->id;
                $setting->save(false, ['value']);

            }
            /** @var $setting Setting */
            if ( ($setting = Setting::find()
                ->where(['key' => Setting::CLIENT_ACCESS_KEY])
                ->one() )) {

                $setting->value = $clientKeys->access_key;
                $setting->save(false, ['value']);

            }
            
        }
    }

    /**
     * @param $model
     * @return mixed
     */
    public function defaultVal() : Array
    {
        $list['id'] = $this->id;
        $list['domain'] = $this->domain;
        $list['name'] = $this->name;
        $list['email'] = $this->email;
        $list['first_name'] = $this->first_name;
        $list['last_name'] = $this->last_name;
        $list['trial_expires'] = $this->trial_expires;
        $list['prepaid_for'] = $this->prepaid_for;
        $list['is_active'] = $this->is_active;

        return $list;
    }

}
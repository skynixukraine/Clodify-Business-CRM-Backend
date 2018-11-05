<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/5/18
 * Time: 9:57 PM
 */

namespace app\models;

use Yii;
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
            [['domain'], 'string', 'max' => 80],
            [['name', 'email', 'first_name', 'last_name'], 'string', 'max' => 255],
            [['mysql_user', 'mysql_password'], 'string', 'max' => 45],
            [['name', 'domain', 'email', 'mysql_user', 'mysql_password'], 'required'],
            [['is_active', 'is_confirmed'], 'boolean']
        ];
    }

    public static function getDb()
    {
        return Yii::$app->dbCore;
    }


}
<?php

namespace app\models;

use app\modules\cp\controllers\IndexController;
use Yii;
use yii\web\IdentityInterface;
use yii\db\Expression;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $role
 * @property string $phone
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $company
 * @property string $tags
 * @property string $about
 * @property string $date_signup
 * @property string $date_login
 * @property string $date_salary_up
 * @property integer $is_active
 * @property integer $salary
 * @property integer $month_logged_hours
 * @property integer $year_logged_hours
 * @property integer $total_logged_hours
 * @property integer $month_paid_hours
 * @property integer $year_paid_hours
 * @property integer $total_paid_hours
 * @property string $invite_hash
 * @property integer $is_delete
 *
 * @property ProjectCustomers[] $projectCustomers
 * @property Projects[] $projects
 * @property ProjectDevelopers[] $projectDevelopers
 * @property Projects[] $projects0
 * @property Reports[] $reports
 * @property SalaryHistory[] $salaryHistories
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const ROLE_ADMIN    = "ADMIN";
    const ROLE_PM       = "PM";
    const ROLE_DEV      = "DEV";
    const ROLE_CLIENT   = "CLIENT";
    const ROLE_FIN      = "FIN";

    public $rawPassword;
    private $auth_key   = "XnM";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role'], 'string'],
            [['email', 'first_name', 'last_name'], 'required'],
            [['email'], 'unique'],
            [['date_signup', 'date_login', 'date_salary_up'], 'safe'],
            [['is_active', 'salary', 'month_logged_hours', 'year_logged_hours', 'total_logged_hours', 'month_paid_hours', 'year_paid_hours', 'total_paid_hours', 'is_delete'], 'integer'],
            [['phone'], 'string', 'max' => 25],
            [['email', 'company'], 'string', 'max' => 150],
            [['password', 'first_name', 'last_name', 'middle_name', 'invite_hash'], 'string', 'max' => 45],
            [['tags'], 'string', 'max' => 500],
            [['about'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'phone' => 'Phone',
            'email' => 'Email',
            'password' => 'Password',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'middle_name' => 'Middle Name',
            'company' => 'Company',
            'tags' => 'Tags',
            'about' => 'About',
            'date_signup' => 'Date Signup',
            'date_login' => 'Date Login',
            'date_salary_up' => 'Date Salary Up',
            'is_active' => 'Is Active',
            'salary' => 'Salary',
            'month_logged_hours' => 'Month Logged Hours',
            'year_logged_hours' => 'Year Logged Hours',
            'total_logged_hours' => 'Total Logged Hours',
            'month_paid_hours' => 'Month Paid Hours',
            'year_paid_hours' => 'Year Paid Hours',
            'total_paid_hours' => 'Total Paid Hours',
            'invite_hash' => 'Invite Hash',
            'is_delete' => 'Is Delete'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectCustomers()
    {
        return $this->hasMany(ProjectCustomers::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])->viaTable('project_customers', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectDevelopers()
    {
        return $this->hasMany(ProjectDevelopers::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevelopers()
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])->viaTable('project_developers', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Reports::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaryHistories()
    {
        return $this->hasMany(SalaryHistory::className(), ['user_id' => 'id']);
    }

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    /* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }


    public static function hasPermission( $roles )
    {

        $role = Yii::$app->user->identity->role;

        if(in_array($role,$roles)){

            return true;

        } else {

            return false;

        }

    }

    public function beforeSave($insert)
    {
        if( $this->isNewRecord ){

            if( !$this->invite_hash ){

                $this->invite_hash = md5(time());
            }

            if( !$this->is_active ) {

                $this->is_active = 0;
            }

            if( $this->password ) {

                $this->rawPassword = $this->password;
                $this->password = md5($this->password);
            }
        }/*else
            $this->modified = new Expression('NOW()');*/
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public  function  afterSave($insert, $changedAttributes)
    {
        if( $this->rawPassword ) {

            Yii::$app->mailer->compose('inviteUser', [

                'user' => $this->first_name,
                'email' => $this->email,
                'password' => $this->rawPassword,
                'adminName' => Yii::$app->user->identity->first_name,
                'hash' => $this->invite_hash

            ])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($this->email)
                ->setSubject('You invited')
                ->send();
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public static function generatePassword()
    {
        $chars = '[a-zA-Z0-9!@#$%.?]';
        $password = Yii::$app->user->password;

        for ($i = 0; $i < 8; $i++){

            $index = rand(0, count($chars)-1);
            $password .= $chars[$index];

        }

        return $password;

    }

    public static function allCustomers()
    {
        return self::find()
            //->from('project_customers')
            //->leftJoin('users ON users.id=project_customers.user_id')
            ->from(User::tableName())
            ->rightJoin(ProjectCustomer::tableName(), ProjectCustomer::tableName() . ".user_id=id")
            ->groupBy(ProjectCustomer::tableName() . ".user_id")
            ->all();
    }

    public static function allDevelopers()
    {
        return self::find()
            ->from(User::tableName())
            ->rightJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".user_id=id")
            ->groupBy(ProjectDeveloper::tableName() . ".user_id")
            ->all();

    }

}
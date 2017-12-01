<?php

namespace app\models;

use app\modules\cp\controllers\IndexController;
use Yii;
use yii\web\IdentityInterface;
use yii\db\Expression;
use yii\db\ActiveQuery;
use yii\web\UploadedFile;

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
 * @property string $photo
 * @property string $sing
 * @property string $bank_account_en
 * @property string $bank_account_ua
 * @property integer $is_published

 *
 * @property ProjectCustomer[] $projectCustomers
 * @property Project[] $projects
 * @property ProjectDeveloper[] $projectDevelopers
 * @property Project[] $projects0
 * @property Report[] $reports
 * @property SalaryHistory[] $salaryHistories
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const ROLE_ADMIN    = "ADMIN";
    const ROLE_PM       = "PM";
    const ROLE_DEV      = "DEV";
    const ROLE_CLIENT   = "CLIENT";
    const ROLE_FIN      = "FIN";
    const ROLE_GUEST    = "GUEST";
    const ROLE_SALES    = "SALES";
    
    const ACTIVE_USERS  = 1;
    const DELETED_USERS = 1;
    const PUBLISHED_USERS = 1;

    const SCENARIO_CHANGE_PASSWORD = 'change_password';
    const SCENARIO_UPDATE_USER = 'api-update-user';
    const SCENARIO_CREATE_USER = 'api-create-user';
    const SCENARIO_UPDATE_USER_SINGLE = 'api-update-user-single';


    const ATTACH_USERS_SIGN = 'api-attach-sign';
    const ATTACH_PHOTO_USERS = 'api-attach-photo';

    public $rawPassword;

    /**
     * Passoword for Edit User Form
     * @var $xHsluIp
     */
    public $xHsluIp;

    public $status = [];
    private $auth_key = "XnM";
    public $ticketId;
    public $captcha;
    public $code;

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
            [['role', 'code', 'slug', 'languages', 'residence', 'link_linkedin',
                'link_video', 'birthday', 'position', 'degree'], 'string'],
            [['photo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpeg, jpg, png, gif', 'wrongExtension'=>'Upload {extensions} files only', 'on' => [self::ATTACH_PHOTO_USERS]],
            [['sing'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpeg, jpg, png, gif', 'wrongExtension'=>'You can\'t upload files of this type.', 'on' => self::ATTACH_USERS_SIGN],
            ['email', 'required', 'except' => ['settings', self::ATTACH_PHOTO_USERS, self::ATTACH_USERS_SIGN]],
            ['password', 'required', 'except' => ['settings',self::SCENARIO_UPDATE_USER, self::SCENARIO_CREATE_USER, self::SCENARIO_CHANGE_PASSWORD, self::ATTACH_PHOTO_USERS, self::ATTACH_USERS_SIGN]],
            ['role', function () {
                if(!in_array (strtoupper($this->role), [self::ROLE_ADMIN, self::ROLE_PM,  self::ROLE_CLIENT, self::ROLE_SALES, self::ROLE_FIN , self::ROLE_DEV])) {
                    $this->addError('role', Yii::t('yii', 'Role is invalid'));
                }
            }],
            [['email'], 'unique', 'except'=> ['api-login', self::SCENARIO_CHANGE_PASSWORD, self::ATTACH_USERS_SIGN, self::ATTACH_PHOTO_USERS]],
            [['first_name', 'last_name', 'role'], 'required', 'except'=> ['settings','api-login', self::SCENARIO_CHANGE_PASSWORD, self::ATTACH_PHOTO_USERS, self::ATTACH_USERS_SIGN]],
            [['first_name', 'last_name'], 'string', 'max' => 45],
            ['email', 'email'],
            [['date_signup', 'date_login', 'date_salary_up'], 'safe'],
            [['is_active', 'salary', 'month_logged_hours', 'year_logged_hours', 'total_logged_hours', 'month_paid_hours',
                'year_paid_hours', 'total_paid_hours', 'is_delete', 'ticketId', 'is_published', 'experience_year'], 'integer'],
            ['phone', 'string', 'max' => 25],
            ['company', 'string', 'max' => 55],
            [['email'], 'string', 'max' => 150],
            [['password', 'first_name', 'last_name', 'middle_name', 'invite_hash', 'xHsluIp'], 'string', 'max' => 45],
            [['tags'], 'string', 'max' => 500],
            [['about'], 'string', 'max' => 1000],
            [['first_name', 'last_name'], 'match', 'pattern' => '/^\S[^0-9_]*$/i'],
            [['password', 'xHsluIp'], 'match', 'pattern' => '/^\S*$/i'],
            [['bank_account_ua', 'bank_account_en'], 'string'],
            ['captcha', 'required', 'on' => self::SCENARIO_CHANGE_PASSWORD],
            ['captcha', \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => Yii::$app->params['captchaSecret'],  'on' => self::SCENARIO_CHANGE_PASSWORD, ],
            [['photo', 'sing'], 'string', 'on' => ['settings']],
            ['official_salary', 'number', 'on' => [self::SCENARIO_UPDATE_USER, self::SCENARIO_CREATE_USER]]

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'role'          => 'Role',
            'phone'         => 'Phone',
            'email'         => 'Email',
            'password'      => 'Password',
            'xHsluIp'       => 'Enter New Password',
            'first_name'    => 'First Name',
            'last_name'     => 'Last Name',
            'middle_name'   => 'Middle Name',
            'company'       => 'Company',
            'tags'          => 'Tags',
            'about'         => 'About',
            'date_signup'   => 'Date Signup',
            'date_login'    => 'Date Login',
            'date_salary_up' => 'Date Salary Up',
            'is_active'     => 'Is Active',
            'salary'        => 'Salary',
            'month_logged_hours'    => 'Month Logged Hours',
            'year_logged_hours'     => 'Year Logged Hours',
            'total_logged_hours'    => 'Total Logged Hours',
            'month_paid_hours'      => 'Month Paid Hours',
            'year_paid_hours'       => 'Year Paid Hours',
            'total_paid_hours'      => 'Total Paid Hours',
            'invite_hash'           => 'Invite Hash',
            'is_delete'             => 'Is Delete',
            'password_reset_token'  => 'Password Reset Token',
            'official_salary'       => 'Official Salary'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectCustomers()
    {
        return $this->hasMany(ProjectCustomer::className(), ['user_id' => 'id']);
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
        return $this->hasMany(ProjectDeveloper::className(), ['user_id' => 'id']);
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
        return $this->hasMany(Report::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaryHistories()
    {
        return $this->hasMany(SalaryHistory::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkHistory()
    {
        return $this->hasMany(WorkHistory::className(), ['user_id' => 'id']);
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
     * @param  string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
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
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }


    /** Permission on the role of the current user */
    public static function hasPermission($roles)
    {

        if(isset(Yii::$app->user->identity->role)){

        $role = Yii::$app->user->identity->role;
    } else {
            return false;
        }

        if (in_array($role, $roles)) {

            return true;

        } else {

            return false;

        }

    }

    /** Save the  field’s value in the database if this is s new record */
    public function beforeSave($insert)
    {

        if ($this->isNewRecord) {
            if (!$this->invite_hash) {

                $this->invite_hash = md5(time());
            }

            if (!$this->is_active) {

                $this->is_active = 0;
            }

            if ($this->password) {

                $this->rawPassword = $this->password;
                $this->password = md5($this->password);
            }

            $this->date_signup = date('Y-m-d H:i:s');
            $this->date_login = null;
            //$this->getCustomers()->one()->receive_invoices = 1;
        } else {
            $oldData = $this->getOldAttributes();
            if ($this->salary && $this->salary != $oldData['salary']) {
                $this->date_salary_up = date("Y-m-d");
            }
            
            if ($this->password && $this->password != $oldData['password']) {
                $this->rawPassword = $this->password;
                $this->password = md5($this->password);
            } else {
                unset($this->password);
            }
            if ($this->email && $this->email != $oldData['email']) {
                // sending letter to old email
                Yii::$app->mailer->compose('changeEmail', [
                    'user' => $this->first_name,
                    'email' => $this->email,
                    'password' => $this->rawPassword,
                    'adminName' => (isset(Yii::$app->user->identity->first_name)) ? Yii::$app->user->identity->first_name : 'Skynix Company'
                ])
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($oldData['email'])
                    ->setSubject('Skynix CRM: Your email address to access CRM is changed')
                    ->send();
            }
        }
        /*else
            $this->modified = new Expression('NOW()');*/
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        if( !$insert && isset( $changedAttributes['password'] ))  {
            if ($this->rawPassword) {
                Yii::$app->mailer->compose('newPassword', [

                    'user' => $this->first_name,
                    'email' => $this->email,
                    'password' => $this->rawPassword,
                    'adminName' => (isset(Yii::$app->user->identity->first_name)) ? Yii::$app->user->identity->first_name : 'Skynix Company'
                ])
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($this->email)
                    ->setSubject('Skynix CRM: You have a new password')
                    ->send();
            }
        } else {
            if( !$insert && isset( $changedAttributes['email'] )) {
                Yii::$app->mailer->compose('changeEmail', [
                    'user' => $this->first_name,
                    'email' => $this->email,
                    'password' => $this->rawPassword,
                    'adminName' => (isset(Yii::$app->user->identity->first_name)) ? Yii::$app->user->identity->first_name : 'Skynix Company'
                ])
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($this->email)
                    ->setSubject('Skynix CRM: Your email address to access CRM is changed')
                    ->send();
            } 

            if ($this->role == User::ROLE_GUEST) {
                if ($this->rawPassword) {

                    Yii::$app->mailer->compose('newticketUser', [

                        'user' => $this->first_name,
                        'email' => $this->email,
                        'password' => $this->rawPassword,
                        'adminName' => (isset(Yii::$app->user->identity->first_name)) ? Yii::$app->user->identity->first_name : 'Skynix Company',
                        'ticket' => $this->ticketId

                    ])
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($this->email)
                        ->setSubject('Welcome to Skynix CRM, Please activate your account')
                        ->send();
                }

            } else {
                if (($this->role != User::ROLE_GUEST) && (!isset($changedAttributes['is_active']))) {
                    if ($this->rawPassword) {

                        Yii::$app->mailer->compose('inviteUser', [

                            'user' => $this->first_name,
                            'email' => $this->email,
                            'password' => $this->rawPassword,
                            'adminName' => (isset(Yii::$app->user->identity->first_name)) ? Yii::$app->user->identity->first_name : 'Skynix Company',
                            'hash' => $this->invite_hash

                        ])
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setTo($this->email)
                            ->setSubject('Welcome to Skynix CRM, Please activate your account')
                            ->send();
                    }
                }

            }
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /** Find all customers from database */
    public static function allCustomers()
    {
        return self::find()
            ->where(User::tableName() . ".is_delete=0 AND " . User::tableName() . ".is_active=1 AND " .
                User::tableName() . ".role IN ('" . User::ROLE_CLIENT . "')")
            ->groupBy(User::tableName() . ".id")
            ->all();
    }

    /** Find all developers from database */
    public static function allDevelopers()
    {
        return self::find()
            ->where(User::tableName() . ".is_delete=0 AND " . User::tableName() . ".is_active=1 AND " .
                User::tableName() . ".role IN ('" . User::ROLE_PM . "', '" . User::ROLE_DEV . "','" . User::ROLE_ADMIN . "','" .
                                                    User::ROLE_FIN . "','" . User::ROLE_SALES . "')")
            ->groupBy(User::tableName() . ".id")
            ->all();
    }

    /** Find all customers where receive invoices = 1 */
    public static function allCustomersWhithReceive()
    {
        return self::find()
            ->where(User::tableName() . ".is_delete=0 AND " . User::tableName() . ".is_active=1")
            ->andWhere([User::tableName() . '.role' => User::ROLE_CLIENT])
            ->all();
    }

    public static function generatePassword()
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnoprstuvwxyz0123456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < 8; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    public static function temmateUser($userId)
    {
        $r = self::find()
            ->from(User::tableName())
            ->where(User::tableName() . ".is_delete=0 AND " . User::tableName() . ".is_active=1 AND id=:userId", [
                ":userId" => $userId
            ])
            ->one();
        return $r;
    }

    /**
     * @param $userId
     * @param bool $idsOnly
     * @return array|Team[]
     */
    public static function getUserTeams($userId, $idsOnly = false)
    {
        $result = Teammate::find()
            ->from(Teammate::tableName())
            ->where(Teammate::tableName() . ".user_id=:userId", [
                ":userId" => $userId
            ])
            ->all();
        if ($idsOnly) {
            $result = self::getTeamIds($result);
        }
        return $result;
    }

    /**
     * @param array|Team[] $userTeams
     * @return array
     */
    protected static function getTeamIds($userTeams)
    {
        $result = [];
        foreach ($userTeams as $team) {
            $result[] = $team->team_id;
        }
        return $result;
    }

    /**
     * @param User[] $customers
     * @param $value
     * @return array
     */
    public static function getCustomersDropDown($customers, $value)
    {
        $result = [];
        foreach ($customers as $customer) {
            $result[$customer->{$value}] = $customer->first_name . ' ' . $customer->last_name;
        }
        return $result;
    }

    public static function teamUs()
    {
        $teamIds = Team::find()->where(Team::tableName() . '.team_leader_id=:Id', [':Id' => Yii::$app->user->id])->all();
        $result = [];
        foreach ($teamIds as $team) {
            $result[] = $team->id;
        }
        return $teamsus = Teammate::find()
            ->where(Teammate::tableName() . '.team_id IN ("' . implode(', ', $result) . '")')
            ->all();

    }

    public static function setUserPhoto($fileName)
    {
        $user = self::findOne(Yii::$app->user->id);
        $user->photo = $fileName;
        $user->save(true, ['photo']);

    }

    public static function setUserSing($fileName)
    {
        $user = self::findOne(Yii::$app->user->id);
        $user->sing = $fileName;
        $user->save(true, ['sing']);

    }
    public static function getUserPhoto()
    {
        $user = self::findOne(Yii::$app->user->id);
        if (isset($user->photo)) {
            return $user->photo;
        }else{
            return false;
        }

    }
    public static function getUserSing()
    {
        $user = self::findOne(Yii::$app->user->id);
        if (isset($user->sing)){
            return $user->sing;
        }else{
            return false;
        }

    }

    public function getUserSingPath()
    {
        return Yii::getAlias('@app') .  '/data/' . $this->id . '/sing/' . $this->sing;
    }
    public static function assignProject($project)
    {
        $data = [
            'user_id'       => Yii::$app->user->id,
            'project_id'    => $project,
        ];
        $model = ProjectDeveloper::find()
            ->where($data)->one();

        $data = [
            'ProjectDeveloper' => $data
        ];
        $model = $model ?: new ProjectDeveloper();
        $model->load($data);
        $model->status = ProjectDeveloper::STATUS_ACTIVE;
        $model->validate();
        $model->save();
    }

    public static function unassignProject($project)
    {

        $model = ProjectDeveloper::find()
            ->where([
                'user_id'       => Yii::$app->user->id,
                'project_id'    => $project,
            ])->one();

        $data = [
            'ProjectDeveloper' => [
                'user_id' => Yii::$app->user->id,
                'project_id' => $project,
            ]
        ];
        $model = $model ?: new ProjectDeveloper();
        $model->load($data);
        $model->status = ProjectDeveloper::STATUS_INACTIVE;
        $model->validate();
        $model->save();
    }

    public static function AssigneTo($id){
        return self::find()
            ->leftJoin(SupportTicket::tableName(), SupportTicket::tableName() . ".assignet_to=" . User::tableName() . ".id")
            ->leftJoin(SupportTicketComment::tableName(), SupportTicketComment::tableName() . ".support_ticket_id=" . SupportTicket::tableName() . ".id")

            ->where(SupportTicket::tableName() . '.id=:id', [':id' => $id])->one()->email;
    }

    public static function ClientTo($id){
        return self::find()
            ->leftJoin(SupportTicket::tableName(), SupportTicket::tableName() . ".client_id=" . User::tableName() . ".id")
            ->leftJoin(SupportTicketComment::tableName(), SupportTicketComment::tableName() . ".support_ticket_id=" . SupportTicket::tableName() . ".id")

            ->where(SupportTicket::tableName() . '.id=:id', [':id' => $id])->one()->email;
    }

    // returns list of customers that works on common projects with current SALES user
    public static function getCustomersForSalesUser()
    {
        $projectsID = [];
        $customersID = [];
        // getting Sale's projects
        $projects = Project::find()
            ->leftJoin(  ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id=" . Project::tableName() . ".id")
            ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectDeveloper::tableName() . ".user_id")
            ->where([ProjectDeveloper::tableName() . '.user_id' => Yii::$app->user->id])
            ->andWhere([ProjectDeveloper::tableName() . '.is_sales' => 1])
            ->andWhere([Project::tableName() . '.is_delete' => 0])
            ->all();
        // array of Sale's projects IDs
        foreach ($projects as $project) {
            $projectsID[] = $project->id;
        }
        // customers on these projects
        $customers = ProjectCustomer::getProjectCustomer($projectsID)->all();
        foreach ($customers as $customer) {
            $customersID[] = $customer->user;
        }
        return $customersID;
    }

    public static function getCustomersForSales()
    {
        $projectsID = [];
        $customersID = [];
        // getting Sale's projects
        $projects = Project::find()
            ->leftJoin(  ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id=" . Project::tableName() . ".id")
            ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectDeveloper::tableName() . ".user_id")
            ->where([ProjectDeveloper::tableName() . '.user_id' => Yii::$app->user->id])
            ->andWhere([ProjectDeveloper::tableName() . '.is_sales' => 1])
            ->andWhere([Project::tableName() . '.is_delete' => 0])
            ->all();
        // array of Sale's projects IDs
        foreach ($projects as $project) {
            $projectsID[] = $project->id;
        }
        // customers on these projects
        $customers = ProjectCustomer::getProjectCustomer($projectsID, $withInvoice = false)->all();
        foreach ($customers as $customer) {
            $customersID[] = $customer->user;
        }
        return $customersID;
    }

	/**
	 * 
	 * @return array
	 */
	public static function getRoles(){
		return [
			self::ROLE_ADMIN => 'ADMIN',
			self::ROLE_DEV => 'DEV',
			self::ROLE_FIN => 'FIN',
			self::ROLE_CLIENT => 'CLIENT',
			self::ROLE_PM => 'PM',
			self::ROLE_SALES => 'SALES'
		];
	}

    /**
     * generate and set password_reset_token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . time();
    }

    /**
     * @return mixed
     */
    public function getPasswordResetToken()
    {
        return $this->password_reset_token;
    }

    /**
     * @param $user
     * @return array
     */
    public static function getTags($user) {
        $skills = [];
        if ($user && $user->tags) {
            $tagsArray = array_map('trim', explode(",", $user->tags));
            $skills['top'] = array_slice($tagsArray, 0, 4);
            $skills['additional'] = array_slice($tagsArray, 4, count($tagsArray));
            return $skills;
        } else {
            return $skills;
        }
    }

    /**
     * Check that a passed user has a role DEV, SALES, FIN
     * @param $id
     * @return bool
     */
    public static function validateRoleForSalaryList($id)
    {
        $user= User::findOne($id);
        if($user->role == self::ROLE_DEV || $user->role == self::ROLE_FIN || $user->role == self::ROLE_SALES){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check that a passed user is active
     * @param $id
     * @return bool
     */
    public static function isActiveUser($id)
    {
        $user= User::findOne($id);
        if($user->is_active == self::ACTIVE_USERS){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check that user→salary > 0 & user→official_salary > 0
     * @param $id
     * @return bool
     */
    public static function validateSalaryForSalaryList($id)
    {
        $user= User::findOne($id);
        if($user->salary > 0 && $user->official_salary > 0){
            return true;
        } else {
            return false;
        }
    }

    public static function getUserFirstName()
    {
        $user = self::findOne(Yii::$app->user->id);
        return $user->first_name;

    }

    public static function getUserFirstNameById($id)
    {
        $user = self::findOne($id);
        return $user->first_name;

    }

    public static function getUserRoleById($id)
    {
        $user = self::findOne($id);
        return $user->role;

    }

    public static function getUserObjectById($id)
    {
        $arr = [];
        $user= User::findOne($id);
        $arr['id'] = $id;
        $arr['first_name'] = $user->first_name;
        $arr['last_name'] = $user->last_name;
        return $arr;
    }

}
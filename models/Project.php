<?php

namespace app\models;

use app\components\DateUtil;
use Faker\Factory as Faker;
use Yii;
use app\models\ProjectCustomer;
use yii\filters\RateLimiter;

/**
 * This is the model class for table "projects".
 *
 * @property integer $id
 * @property string $name
 * @property string $jira_code
 * @property integer $total_logged_hours
 * @property integer $total_paid_hours
 * @property integer $total_approved_hours
 * @property string $type
 * @property string $status
 * @property string $date_start
 * @property string $date_end
 * @property integer $is_delete
 * @property integer $cost
 * @property ProjectCustomers[] $projectCustomers
 * @property Users[] $users
 * @property ProjectDevelopers[] $projectDevelopers
 * @property Users[] $users0
 * @property Reports[] $reports
 * @property string|null $api_key
 */
class Project extends \yii\db\ActiveRecord
{
    const STATUS_NEW        = "NEW";
    const STATUS_ONHOLD     = "ONHOLD";
    const STATUS_INPROGRESS = "INPROGRESS";
    const STATUS_DONE       = "DONE";
    const STATUS_CANCELED   = "CANCELED";
    const INTERNAL_TASK     = "Internal (Non Paid) Tasks";

    const TYPE_HOURLY       = 'HOURLY';
    const TYPE_FIXED_PRICE  = 'FIXED_PRICE';

    const PROJECT_PUBLISHED = 1;

    const SCENARIO_CREATE   = 'api-create';
    const SCENARIO_UPDATE_ADMIN   = 'api-update-admin';
    const SCENARIO_UPDATE_SALES   = 'api-update-sales';


    public $customers;
    public $developers;
    public $invoice_received;
    public $is_pm;
    public $is_sales;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required', 'on'=>[ self::SCENARIO_CREATE, self::SCENARIO_UPDATE_ADMIN, self::SCENARIO_UPDATE_SALES ]],
            ['status', 'required', 'on'=>[ self::SCENARIO_CREATE, self::SCENARIO_UPDATE_ADMIN ]],
            [['customers', 'invoice_received', 'type'], 'required',
                'on' => [self::SCENARIO_UPDATE_ADMIN, self::SCENARIO_CREATE]
            ],
            [['developers'], 'required',
                'on' => [self::SCENARIO_UPDATE_ADMIN, self::SCENARIO_CREATE, self::SCENARIO_UPDATE_SALES]
            ],
            [['is_sales', 'is_pm'], 'required', 'on' => [ self::SCENARIO_CREATE, self::SCENARIO_UPDATE_ADMIN ]],
            [['invoice_received', 'is_pm', 'is_delete', 'is_sales', 'is_published'], 'integer',
                'on' => [ self::SCENARIO_CREATE, self::SCENARIO_UPDATE_ADMIN ]
            ],
            [['total_logged_hours', 'total_paid_hours'], 'number', 'on' => [ self::SCENARIO_CREATE, self::SCENARIO_UPDATE_ADMIN ]],
            [['status'], 'string', 'on' => [ self::SCENARIO_CREATE, self::SCENARIO_UPDATE_ADMIN ]],
            [['date_start', 'date_end'], 'safe', 'on' => [ self::SCENARIO_CREATE, self::SCENARIO_UPDATE_ADMIN ]],
            [['name'], 'string', 'max' => 150, 'on' => [ self::SCENARIO_CREATE, self::SCENARIO_UPDATE_ADMIN, self::SCENARIO_UPDATE_SALES ]],
            [['jira_code'], 'string', 'max' => 15, 'on' => [ self::SCENARIO_CREATE, self::SCENARIO_UPDATE_ADMIN ]],
            [['customers'], 'safe', 'on' => [ self::SCENARIO_CREATE, self::SCENARIO_UPDATE_ADMIN ]],
            [['developers'], 'safe', 'on' => [ self::SCENARIO_CREATE, self::SCENARIO_UPDATE_ADMIN, self::SCENARIO_UPDATE_SALES ]],
            ['is_pm', function() {
                $exists = false;
                if ( $this->developers && count($this->developers) ) {

                    foreach ( $this->developers as $dev ) {

                        if ( $dev['id'] === $this->is_pm ) {

                            $exists = true;
                            break;

                        }
                    }

                }
                if(empty($this->developers && $this->is_pm) || $exists === false) {
                    $this->addError('is_pm', Yii::t('app', 'Pm was not assigned'));
                }
            }, 'on' => [ self::SCENARIO_CREATE, self::SCENARIO_UPDATE_ADMIN ]],
            ['is_sales', function() {
                if ($user = User::findOne($this->is_sales)) {
                    if ($user->role != User::ROLE_SALES) {
                        $this->addError('is_sales', Yii::t('app', 'Selected user can not be sales'));
                    }
                }

                $exists = false;
                if ( $this->developers && count($this->developers) ) {

                    foreach ( $this->developers as $dev ) {

                        if ( $dev['id'] === $this->is_sales ) {

                            $exists = true;
                            break;

                        }
                    }

                }

                if(empty($this->developers && $this->is_sales) || $exists === false) {

                    $this->addError('is_sales', Yii::t('app', 'Sales was not assigned'));
                }
            }, 'on' => [ self::SCENARIO_CREATE, self::SCENARIO_UPDATE_ADMIN ]]

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'name'              => 'Name',
            'jira_code'         => 'Jira Code',
            'total_logged_hours'=> 'Total Logged Hours',
            'total_paid_hours'  => 'Total Paid Hours',
            'status'            => 'Status',
            'date_start'        => 'Date Start',
            'date_end'          => 'Date End',
            'is_delete'         => 'Is Delete',
            'cost'              => 'Cost'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectCustomers()
    {
        return $this->hasMany(ProjectCustomer::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('project_customers', ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectDevelopers()
    {
        return $this->hasMany(ProjectDeveloper::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevelopers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('project_developers', ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::className(), ['project_id' => 'id']);
    }

    /** Projects where role: DEV, user: current projects.is_delete = 0  */
    public static function getUsersProjects($userId)
    {
        return self::findBySql('SELECT projects.id, projects.name, projects.jira_code, project_developers.status,'.
            ' projects.status
            FROM projects
            LEFT JOIN project_developers ON projects.id=project_developers.project_id
            LEFT JOIN users ON project_developers.user_id=users.id AND (users.role=:role OR users.role=:roleA OR users.role=:roleP OR users.role=:roleS OR users.role=:roleF )
            WHERE users.id=:userId AND projects.is_delete = 0 AND projects.status=:status 
            AND project_developers.status IN ("' . ProjectDeveloper::STATUS_ACTIVE . '")
            GROUP by projects.id', [
            ':role'      => User::ROLE_DEV,
            ':roleA'     => User::ROLE_ADMIN,
            ':roleP'     => User::ROLE_PM,
            ':roleS'     => User::ROLE_SALES,
            ':roleF'     => User::ROLE_FIN,
            ':userId'    => $userId,
            ':status'    => self::STATUS_INPROGRESS
        ])->all();
    }

    /** Save the  field’s value in the database */
    public function beforeSave($insert)
    {

        $this->date_start = DateUtil::convertData($this->date_start);

        $this->date_end = DateUtil::convertData($this->date_end);

        $this->total_approved_hours = 0; //TODO we will do this later

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {

        $connection = Yii::$app->db;

        if(User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES]) && $this->customers) {

            /* Delete from ProjectCustomers*/
            $connection->createCommand()
                ->delete(ProjectCustomer::tableName(), [
                    'project_id' => $this->id,
                ])
                ->execute();

            /* Add to ProjectCustomers*/

            foreach (User::allCustomers() as $customer) {
                if(($this->invoice_received == $customer->id) || (in_array($customer->id, $this->customers))){
                    $connection->createCommand()
                        ->insert(ProjectCustomer::tableName(), [
                            'project_id' => $this->id,
                            'user_id' => $customer->id,
                            /*'receive_invoices' => 1,*///when add project to some user receive_invoices from project_customers = 1
                            'receive_invoices' => ($this->invoice_received==$customer->id),
                        ])->execute();
                }

            }
        }

        if ($this->developers) {
            if ($this->getScenario() == self::SCENARIO_CREATE) {
                if( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES]) ) {
                    /* Delete from ProjectCustomers*/
                    $connection->createCommand()
                    ->delete(ProjectDeveloper::tableName(), [
                        'project_id' => $this->id,
                    ])
                    ->execute();
                    
                    /* Add to ProjectDevelopers*/
                    foreach ($this->developers as $developer) {
                        $connection->createCommand()
                        ->insert(ProjectDeveloper::tableName(), [
                            'project_id' => $this->id,
                            'user_id' => $developer['id'],
                            'is_sales' => ($this->is_sales == $developer['id']),
                            'is_pm' => ($this->is_pm == $developer['id']),
                            'alias_user_id' => isset($developer['alias']) ? $developer['alias'] : null
                        ])->execute();
                        
                    }
                    
                }
            } elseif ($this->getScenario() == self::SCENARIO_UPDATE_ADMIN) {
                if( User::hasPermission([User::ROLE_ADMIN]) ) {
                    /* Delete from ProjectCustomers*/
                    $connection->createCommand()
                    ->delete(ProjectDeveloper::tableName(), [
                        'project_id' => $this->id,
                    ])
                    ->execute();
                    
                    /* Add to ProjectDevelopers*/
                    foreach ($this->developers as $developer) {
                        $connection->createCommand()
                        ->insert(ProjectDeveloper::tableName(), [
                            'project_id' => $this->id,
                            'user_id' => $developer['id'],
                            'is_sales' => ($this->is_sales == $developer['id']),
                            'is_pm' => ($this->is_pm == $developer['id']),
                            'alias_user_id' => isset($developer['alias']) ? $developer['alias'] : null
                        ])->execute();
                        
                    }
                    
                }
            } elseif ($this->getScenario() === self::SCENARIO_UPDATE_SALES && User::hasPermission([User::ROLE_SALES])) {
                $pm = ProjectDeveloper::findOne([
                    'project_id' => $this->id,
                    'is_pm' => true
                ]);

                $sales = ProjectDeveloper::findOne([
                    'project_id' => $this->id,
                    'is_sales' => true
                ]);

                ProjectDeveloper::deleteAll([
                    'project_id' => $this->id,
                    'is_pm' => false,
                    'is_sales' => false
                ]);

                foreach ($this->developers as $developer) {
                    if ($developer['id'] == ($pm->user_id ?? 0) || $developer['id'] == ($sales->user_id ?? 0)) {
                        continue;
                    }

                    $connection->createCommand()
                        ->insert(ProjectDeveloper::tableName(), [
                            'project_id' => $this->id,
                            'user_id' => $developer['id'],
                            'is_sales' => false,
                            'is_pm' => false,
                            'alias_user_id' => $developer['alias'] ?? null,
                        ])->execute();
                }
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }


    public static function ProjectsCurrentUser($curentUser)
    {
        return self::find()
            ->leftJoin(ProjectCustomer::tableName(), ProjectCustomer::tableName() . '.project_id=id')
            ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . '.project_id=id')
            ->where(Project::tableName() . '.is_delete=0 AND ' .
                    ProjectDeveloper::tableName() . '.user_id=' . $curentUser . ' AND ' .
                    ProjectDeveloper::tableName() . '.status IN ("' . ProjectDeveloper::STATUS_ACTIVE . '", "' . ProjectDeveloper::STATUS_INACTIVE . '") AND ' .
                    Project::tableName() . '.status IN ("' . Project::STATUS_INPROGRESS . '", "' . Project::STATUS_NEW . '")')
            ->all();
    }
    // Returns projects with all available statuses
    public static function ProjectsCurrentUserAllStatuses($curentUser)
    {
        return self::find()
            ->leftJoin(ProjectCustomer::tableName(), ProjectCustomer::tableName() . '.project_id=id')
            ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . '.project_id=id')
            ->where(Project::tableName() . '.is_delete=0 AND ' .
                ProjectDeveloper::tableName() . '.user_id=' . $curentUser . ' AND ' .
                ProjectDeveloper::tableName() . '.status IN ("' . ProjectDeveloper::STATUS_ACTIVE . '", "' . ProjectDeveloper::STATUS_INACTIVE . '")')
            ->all();
    }
    public static function ProjectsCurrentClient($curentClient)
    {
        return self::find()
            ->leftJoin(ProjectCustomer::tableName(), ProjectCustomer::tableName() . '.project_id=id')
            ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . '.project_id=id')
            ->where (Project::tableName() . '.is_delete=0 AND ' .
                ProjectCustomer::tableName() . '.user_id=' . $curentClient . ' AND ' .
                ProjectDeveloper::tableName() . '.status IN ("' . ProjectDeveloper::STATUS_ACTIVE . '", "' . ProjectDeveloper::STATUS_INACTIVE . '")')
            ->all();
    }

    public static function getProjectsDropdownForSales($userId)
    {
        return self::find()
            ->leftJoin(  ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id=" . Project::tableName() . ".id")
            ->where([ProjectDeveloper::tableName() . '.user_id' => $userId])
            ->andWhere(Project::tableName() . '.is_delete=0')
            ->andWhere(ProjectDeveloper::tableName() . '.is_sales=1')
            ->andWhere(Project::tableName() . '.status IN ( "' . Project::STATUS_INPROGRESS
                . '", "' . Project::STATUS_ONHOLD . '")')
            ->all();
    }
    public static function getProjectsDropdownForClient($userId)
    {
        return self::find()
            ->leftJoin(ProjectCustomer::tableName(), ProjectCustomer::tableName() . '.project_id=' . Project::tableName() . '.id')
            ->where([ProjectCustomer::tableName() . '.user_id' => $userId])
            ->andWhere(Project::tableName() . '.is_delete=0')
            ->andWhere(Project::tableName() . '.status IN ( "' . Project::STATUS_INPROGRESS
                . '", "' . Project::STATUS_ONHOLD . '")')
            ->all();
    }
    public static function getProjectsDropdownForAdminAndFin($userId)
    {
        return self::find()
            ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . '.project_id=' .
                Project::tableName() . '.id')
            ->where(Project::tableName() . '.is_delete=0')
            ->andWhere(Project::tableName() . '.status IN ( "' . Project::STATUS_INPROGRESS
                . '", "' . Project::STATUS_ONHOLD . '")')
            ->all();
    }
    public static function getClientProjectsDropdown($clientId)
    {
        $listProjects = [];
        $projects = self::find()
            ->leftJoin(  ProjectCustomer::tableName(), ProjectCustomer::tableName() . ".project_id=" . Project::tableName() . ".id")
            ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . '.project_id=' . Project::tableName() . '.id')
            ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectCustomer::tableName() . ".user_id")
            ->where(ProjectCustomer::tableName() . ".user_id=" . $clientId)
            ->andWhere(Project::tableName() . '.is_delete=0');
        if (User::hasPermission([User::ROLE_SALES])) {
            $projects = $projects->andWhere([ProjectDeveloper::tableName() . '.user_id' => Yii::$app->user->id])
                ->andWhere([ProjectDeveloper::tableName() . '.is_sales' => 1]);
        }
            $projects = $projects->groupBy('id')
                ->all();

        foreach ($projects as $project) {
            $listProjects[$project->id] = $project->name;
        }
        return $listProjects;
    }
    public static function projectsName($userId)
    {
        return self::find()
            ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . '.project_id=' . Project::tableName() . '.id')
            ->where(ProjectDeveloper::tableName() . '.user_id=:ID', [':ID' => $userId])
            ->all();
    }
    public function isInCustomers($user_id){
        if(!is_array($this->customers)){
            return false;
        }

        return in_array($user_id, $this->customers);
    }
    public function isInvoiced($user_id){
        if(!is_array($this->projectCustomers)){
            return false;
        }
        foreach ($this->projectCustomers as $projectCustomer){
            if($projectCustomer->receive_invoices && $projectCustomer->user_id == $user_id){
                return true;
            }
        }
        return false;
    }

    public function isInDevelopers($user_id){
        if(!is_array($this->developers)){
            return false;
        }

        return in_array($user_id, $this->developers);
    }
    public function isPm($user_id){
        if(!is_array($this->projectDevelopers)){
            return false;
        }
        foreach ($this->projectDevelopers as $projectDeveloper){
            if($projectDeveloper->is_pm && $projectDeveloper->user_id == $user_id){
                return true;
            }
        }
        return false;
    }
    public function isSales($user_id){
        if(!is_array($this->projectDevelopers)){
            return false;
        }
        foreach ($this->projectDevelopers as $projectDeveloper){
            if($projectDeveloper->is_sales && $projectDeveloper->user_id == $user_id){
                return true;
            }
        }
        return false;
    }

    public function setRandomApiKey()
    {
        $this->api_key = Faker::create()->regexify('[A-Za-z0-9]{32}');
    }

    public function getProjectEnvironments()
    {
        return $this->hasMany(ProjectEnvironment::class, ['project_id' => 'id']);
    }

    public function addMasterEnv(): void
    {
        if (! $this->id) {
            return;
        }

        $masterEnv = new ProjectEnvironment();
        $masterEnv->branch = 'master';
        $masterEnv->access_roles = 'ADMIN';
        $masterEnv->project_id = $this->id;
        $masterEnv->save();
    }

    public function addStagingEnv(): void
    {
        if (! $this->id) {
            return;
        }

        $stagingEnv = new ProjectEnvironment();
        $stagingEnv->branch = 'staging';
        $stagingEnv->access_roles = 'ADMIN, SALES, PM, DEV';
        $stagingEnv->project_id = $this->id;
        $stagingEnv->save();
    }
}

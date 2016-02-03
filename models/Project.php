<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property integer $id
 * @property string $name
 * @property string $jira_code
 * @property integer $total_logged_hours
 * @property integer $total_paid_hours
 * @property string $status
 * @property string $date_start
 * @property string $date_end
 *
 * @property ProjectCustomers[] $projectCustomers
 * @property Users[] $users
 * @property ProjectDevelopers[] $projectDevelopers
 * @property Users[] $users0
 * @property Reports[] $reports
 */
class Project extends \yii\db\ActiveRecord
{
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
            [['id'], 'required'],
            [['id', 'total_logged_hours', 'total_paid_hours'], 'integer'],
            [['status'], 'string'],
            [['date_start', 'date_end'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['jira_code'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'jira_code' => 'Jira Code',
            'total_logged_hours' => 'Total Logged Hours',
            'total_paid_hours' => 'Total Paid Hours',
            'status' => 'Status',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
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

    public static function getDeveloperProjects($userId)
    {
        return self::findBySql('SELECT projects.id, projects.name, projects.jira_code, project_developers.status,'.
            ' projects.status
            FROM projects
            LEFT JOIN project_developers ON projects.id=project_developers.project_id
            LEFT JOIN users ON project_developers.user_id=users.id AND users.role=:role
            WHERE users.id=:userId
            GROUP by projects.id', [
            ':role'     => User::ROLE_DEV,
            ':userId'   => $userId
        ])->all();
    }

    /*public static function allProjects($userRole, $userId)
    {
        if( User::hasPermission( [User::ROLE_ADMIN, User::ROLE_FIN] ) == $userRole ){

            return self::find()
                ->all();
        }
        if( User::hasPermission( [User::ROLE_CLIENT] ) == $userRole ){

            return self::find()
                ->leftJoin  ( 'project_customers', 'projects.id=project_customers.project_id', [])
                ->leftJoin  ( 'users', 'project_customers.user_id=users.id', [])
                ->where     ( 'users.id=:userId', [':userId'   => $userId])
                ->groupBy   ( 'projects.id')
                ->all();
        }

        if( User::hasPermission( [User::ROLE_PM] ) == $userRole ){

            return self::find()
                ->leftJoin  ( 'project_customers', 'projects.id=project_customers.project_id', [])
                ->leftJoin  ( 'users', 'project_customers.user_id=users.id AND users.role=:role', [':role' => $userRole,])
                ->where     ( 'users.id=:userId', [':userId'   => $userId])
                ->groupBy   ( 'projects.id')
                ->all();
        }
    }*/

}

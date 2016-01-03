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
        return $this->hasMany(ProjectCustomers::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('project_customers', ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectDevelopers()
    {
        return $this->hasMany(ProjectDevelopers::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers0()
    {
        return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('project_developers', ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Reports::className(), ['project_id' => 'id']);
    }
}

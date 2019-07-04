<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "project_environments".
 *
 * @property int $id
 * @property int $project_id
 * @property string $branch
 * @property string $access_roles
 * @property string $last_updated
 *
 * @property ProjectEnvironmentVariable[] $projectEnvironmentVariables
 * @property Project $project
 */
class ProjectEnvironment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_environments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id'], 'integer'],
            [['last_updated'], 'safe'],
            [['branch'], 'string', 'max' => 150],
            [['access_roles'], 'string', 'max' => 25],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'branch' => 'Branch',
            'access_roles' => 'Access Roles',
            'last_updated' => 'Last Updated',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProjectEnvironmentVariables()
    {
        return $this->hasMany(ProjectEnvironmentVariable::class, ['project_environment_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }
}

<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "project_environment_variables".
 *
 * @property int $id
 * @property int $project_environment_id
 * @property string $name
 * @property string $value
 *
 * @property ProjectEnvironment $projectEnvironment
 */
class ProjectEnvironmentVariable extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_environment_variables';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_environment_id'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['value'], 'string', 'max' => 250],
            [['project_environment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectEnvironment::class, 'targetAttribute' => ['project_environment_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_environment_id' => 'Project Environment ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectEnvironment()
    {
        return $this->hasOne(ProjectEnvironment::class, ['id' => 'project_environment_id']);
    }

    public function behaviors()
    {
        return [
            'encryption' => [
                'class' => '\nickcv\encrypter\behaviors\EncryptionBehavior',
                'attributes' => [
                    'value',
                ],
            ],
        ];
    }
}

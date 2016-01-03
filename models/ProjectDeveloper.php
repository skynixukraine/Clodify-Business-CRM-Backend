<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_developers".
 *
 * @property integer $user_id
 * @property integer $project_id
 * @property integer $alias_user_id
 * @property integer $is_pm
 * @property string $status
 *
 * @property Projects $project
 * @property Users $user
 */
class ProjectDeveloper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_developers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'project_id'], 'required'],
            [['user_id', 'project_id', 'alias_user_id', 'is_pm'], 'integer'],
            [['status'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'project_id' => 'Project ID',
            'alias_user_id' => 'Alias User ID',
            'is_pm' => 'Is Pm',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}

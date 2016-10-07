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
 * @property integer $is_sales
 * @property string $status
 *
 * @property Project $project
 * @property User $user
 */
class ProjectDeveloper extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE     = "ACTIVE";
    const STATUS_INACTIVE   = "INACTIVE";
    const STATUS_HIDDEN     = "HIDDEN";
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
            [['user_id', 'project_id', 'alias_user_id', 'is_pm', 'is_sales'], 'integer'],
            [['status'], 'string']
        ];
    }
    public static function allPmUsers($pmId)
    {
        return self::find()

            ->where (ProjectDeveloper::tableName() . '.user_id=:userId AND '. ProjectDeveloper::tableName() .'.is_pm=1 ', [':userId' => $pmId])
            ->all();
    }
    public static function allSalesUsers($salesId)
    {
        return self::find()

            ->where (ProjectDeveloper::tableName() . '.user_id=:userId AND '. ProjectDeveloper::tableName() .'.is_sales=1 ', [':userId' => $salesId])
            ->all();

    }
    public static function getReportsOfSales($salesId)
    {
        return self::find()
            ->where(ProjectDeveloper::tableName() . ".user_id=:sId AND is_sales=1" , [

                ':sId' => $salesId
            ])
            ->all();

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
            'is_sales'  => 'Is Sales',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}

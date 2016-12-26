<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_customers".
 *
 * @property integer $user_id
 * @property integer $project_id
 * @property integer $receive_invoices
 *
 * @property Projects $project
 * @property Users $user
 */
class ProjectCustomer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_customers';
    }

    public static function primaryKey()
    {


        return static::getTableSchema()->primaryKey;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'project_id'], 'required'],
            [['user_id', 'project_id', 'receive_invoices'], 'integer']
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
            'receive_invoices' => 'Receive Invoices',
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

    public static function getReportsOfCustomer($customerId)
    {
        return self::find()
            ->where(ProjectCustomer::tableName() . ".user_id=:cID", [

                ':cID' => $customerId
            ])
            ->all();

    }

    /** Find all users who work on Client`s project*/
    public static function allClientWorkers($clientId)
    {
        return self::find()
            ->select(ProjectDeveloper::tableName() . '.user_id')
            ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . '.project_id=' .
                ProjectCustomer::tableName() . '.project_id')
            ->where(ProjectCustomer::tableName() . '.user_id=:clientId', [':clientId' => $clientId])
            ->groupBy(ProjectDeveloper::tableName() . '.user_id')
            ->all();
    }

    public static function getProjectCustomer($projectId)
    {
        return self::find()
            ->where([ProjectCustomer::tableName() . '.project_id' => $projectId])
            ->andWhere(ProjectCustomer::tableName() . '.receive_invoices=1')
            ->all();
    }
}

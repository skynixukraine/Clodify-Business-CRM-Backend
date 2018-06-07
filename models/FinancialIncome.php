<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "financial_income".
 *
 * @property int $id
 * @property int $date
 * @property double $amount
 * @property string $description
 * @property int $project_id
 * @property int $added_by_user_id
 * @property int $developer_user_id
 *
 * @property Projects $project
 * @property Users $addedByUser
 */
class FinancialIncome extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'financial_income';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'project_id', 'added_by_user_id', 'developer_user_id'], 'integer'],
            [['amount'], 'number'],
            [['description'], 'string'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['added_by_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['added_by_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'date'              => 'Date',
            'amount'            => 'Amount',
            'description'       => 'Description',
            'project_id'        => 'Project ID',
            'added_by_user_id'  => 'Added By User ID',
            'developer_user_id' => 'Developer User ID',
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
    public function getAddedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'added_by_user_id']);
    }
}

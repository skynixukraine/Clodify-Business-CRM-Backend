<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "monthly_reports".
 *
 * @property integer $id
 * @property string $date_created
 * @property string $date_reported
 * @property integer $user_id
 * @property string $income
 * @property string $salary
 * @property string $rent
 * @property string $tax
 * @property string $extra_outcome
 * @property string $profit
 * @property string $status
 * @property string $note
 *
 * @property MydbUsers $user
 */
class MonthlyReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monthly_reports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'required'],
            [['id', 'user_id'], 'integer'],
            [['date_created', 'date_reported'], 'safe'],
            [['income', 'salary', 'rent', 'tax', 'extra_outcome', 'profit'], 'number'],
            [['status', 'note'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_created' => 'Date Created',
            'date_reported' => 'Date Reported',
            'user_id' => 'User ID',
            'income' => 'Income',
            'salary' => 'Salary',
            'rent' => 'Rent',
            'tax' => 'Tax',
            'extra_outcome' => 'Extra Outcome',
            'profit' => 'Profit',
            'status' => 'Status',
            'note' => 'Note',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(MydbUsers::className(), ['id' => 'user_id']);
    }
}

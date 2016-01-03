<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "salary_history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date
 * @property string $amount
 * @property string $extra_amount
 * @property string $note
 *
 * @property Users $user
 */
class SalaryHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'salary_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'required'],
            [['id', 'user_id'], 'integer'],
            [['date'], 'safe'],
            [['amount', 'extra_amount'], 'number'],
            [['note'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'date' => 'Date',
            'amount' => 'Amount',
            'extra_amount' => 'Extra Amount',
            'note' => 'Note',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}

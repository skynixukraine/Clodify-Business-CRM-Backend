<?php

namespace app\models;

/**
 * This is the model class for table "vacation_history_items".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $days
 * @property date $date
 */
class VacationHistoryItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vacation_history_items';
    }
    
    /**
     * @inheritdoc
     */
    
    public function rules()
    {
        return [
            [['user_id', 'days', 'days', 'date'], 'required'],
            [['user_id', 'days'], 'integer'],
            [['date'], 'date'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'user_id'       => 'User ID',
            'days'          => 'Days',
            'date'          => 'Date'
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
}
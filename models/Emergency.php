<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "emergencies".
 *
 * @property int $id
 * @property int $user_id
 * @property int $date_registered
 * @property string $summary
 *
 * @property Users $user
 */
class Emergency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emergencies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'date_registered'], 'integer'],
            [['summary'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'date_registered' => 'Date Registered',
            'summary' => 'Summary',
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

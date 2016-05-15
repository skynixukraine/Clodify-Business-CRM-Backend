<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "survey_voters".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $ip
 * @property string $ua_hash
 * @property integer $survey_id
 * @property integer $option_id
 *
 * @property Surveys $survey
 * @property Users $user
 */
class SurveyVoter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'survey_voters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['survey_id', 'option_id'], 'required'],
            [['user_id', 'survey_id', 'option_id'], 'integer'],
            [['ip'], 'string', 'max' => 25],
            [['ua_hash'], 'string', 'max' => 45],
            [['survey_id'], 'exist', 'skipOnError' => true, 'targetClass' => Surveys::className(), 'targetAttribute' => ['survey_id' => 'id']],
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
            'ip' => 'Ip',
            'ua_hash' => 'Ua Hash',
            'survey_id' => 'Survey ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSurvey()
    {
        return $this->hasOne(Surveys::className(), ['id' => 'survey_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

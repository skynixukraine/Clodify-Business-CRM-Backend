<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "surveys_options".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $survey_id
 * @property integer $votes
 */
class SurveysOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'surveys_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['survey_id', 'votes'], 'integer'],
            [['name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'survey_id' => 'Survey ID',
            'votes' => 'Votes',
        ];
    }
}

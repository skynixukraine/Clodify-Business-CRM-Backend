<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "surveys".
 *
 * @property integer $id
 * @property string $shortcode
 * @property string $question
 * @property string $description
 * @property string $date_start
 * @property string $date_end
 * @property integer $is_private
 * @property integer $user_id
 * @property integer $total_votes
 */
class Surveys extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'surveys';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['date_start', 'date_end'], 'safe'],
            [['is_private', 'user_id', 'total_votes'], 'integer'],
            [['shortcode', 'question'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shortcode' => 'Shortcode',
            'question' => 'Question',
            'description' => 'Description',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'is_private' => 'Is Private',
            'user_id' => 'User ID',
            'total_votes' => 'Total Votes',
        ];
    }
}

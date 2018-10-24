<?php

namespace app\models;

/**
 * This is the model class for table "reviews".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date_from
 * @property string $date_to
 * @property integer $score_loyalty
 * @property integer $score_performance
 * @property integer $score_earnings
 * @property integer $score_total
 * @property string $notes
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['user_id', 'date_from', 'date_to', 'score_loyalty', 'score_performance', 'score_earnings', 'score_total'], 'required'],
            [['user_id', 'score_loyalty', 'score_performance', 'score_earnings', 'score_total'], 'integer'],
            [['notes'], 'string'],
            [['date_from', 'date_to'], 'string'],
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
            'date_from'    => 'Date From',
            'date_to'          => 'Date To',
            'score_loyalty'    => 'Score Loyalty',
            'score_performance'     => 'Score Performance',
            'score_earnings'        => 'Score Earnings',
            'score_total'     => 'Score Total',
            'notes'          => 'Notes'
        ];
    }
}
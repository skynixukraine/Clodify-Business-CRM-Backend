<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "support_tickets".
 *
 * @property integer $id
 * @property string $subject
 * @property string $description
 * @property integer $is_private
 * @property integer $assignet_to
 * @property string $status
 * @property integer $client_id
 * @property string $date_added
 * @property string $date_completed
 */
class SupportTicket extends \yii\db\ActiveRecord
{
    public $subject = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support_tickets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'status'], 'string'],
            [['is_private', 'assignet_to', 'client_id'], 'integer'],
            [['date_added', 'date_completed'], 'safe'],
            [['subject'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'description' => 'Description',
            'is_private' => 'Is Private',
            'assignet_to' => 'Assignet To',
            'status' => 'Status',
            'client_id' => 'Client ID',
            'date_added' => 'Date Added',
            'date_completed' => 'Date Completed',
        ];
    }
    public static function supportSearch()
    {
        return self::find()
            ->where("subject LIKE '%s%' ")
            ->all();
    }




}

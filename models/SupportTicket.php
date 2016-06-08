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
    const STATUS_NEW        = "NEW";
    const STATUS_ASSIGNED   = "ASSIGNED";
    const STATUS_COMPLETED  = "COMPLETED";
    const STATUS_CANCELLED  = "CANCELLED";

    public $email;
    public $password;
    public $comment;
    public $assignee;
    public $complete;

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
            [['description', 'status', 'password', 'email', 'comment'], 'string'],
            [['description'], 'required'],
            [['is_private', 'assignet_to', 'client_id', 'assignee'], 'integer'],
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
            'id'             => 'ID',
            'subject'        => 'Subject',
            'description'    => 'Description',
            'is_private'     => 'Is Private',
            'assignet_to'    => 'Assignet To',
            'status'         => 'Status',
            'client_id'      => 'Client ID',
            'date_added'     => 'Date Added',
            'date_completed' => 'Date Completed',
        ];
    }
      public static function getSupport($words)
    {
        return self::find()
            ->where("subject LIKE '%" . $words . "%' AND is_private=0")
            ->all();

    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['client_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDev()
    {
        return $this->hasOne(User::className(), ['assignet_to' => 'id']);
    }



}

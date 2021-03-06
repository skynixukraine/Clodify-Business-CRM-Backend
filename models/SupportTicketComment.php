<?php

namespace app\models;

use Yii;
use app\models\User;
use app\models\SupportTicket;

/**
 * This is the model class for table "support_ticket_comments".
 *
 * @property integer $id
 * @property string $comment
 * @property string $date_added
 * @property integer $user_id
 * @property integer $support_ticket_id
 */
class SupportTicketComment extends \yii\db\ActiveRecord
{
    public $model;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support_ticket_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment'], 'string'],
            [['date_added'], 'safe'],
            [['user_id', 'support_ticket_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment' => 'Comment',
            'date_added' => 'Date Added',
            'user_id' => 'User ID',
            'support_ticket_id' => 'Support Ticket ID',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'id']);
    }
    public function getAssign()
    {
        return $this->hasOne(SupportTicket::className(), ['support_ticket_id' => 'id']);
    }
    public function afterSave($insert, $changedAttributes)
    {
        if(SupportTicket::findOne($this->support_ticket_id)->assignet_to != null) {
            Yii::$app->mailer->compose("ticket", [
                "ticket"    =>  $this -> support_ticket_id,
                "id"        =>  $this -> support_ticket_id
            ])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo(User::AssigneTo($this->support_ticket_id))
                ->setSubject('New ticket#' . $this->support_ticket_id)
                ->send();
        }
        Yii::$app->mailer->compose("newTicket", [
            "active"    => User::findOne($this->user_id)->is_active,
            "email"     => User::findOne($this->user_id)->email,
            "ticket"    =>  $this -> support_ticket_id,
            "id"        =>  $this -> support_ticket_id
        ])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo(User::ClientTo($this->support_ticket_id))
            ->setSubject('You Skynix ticket# ' . $this->support_ticket_id)
            ->send();
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}

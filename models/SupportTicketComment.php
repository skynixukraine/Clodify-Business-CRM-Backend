<?php

namespace app\models;

use Yii;

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
}

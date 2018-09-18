<?php

namespace app\models;


/**
 * This is the model class for table "email_templates".
 *
 * @property integer $id
 * @property string $subject
 * @property string $reply_to
 * @property string $body

 */
class EmailTemplate extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_templates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'reply_to', 'body'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'subject' => 'Subject',
            'reply_to' => 'Reply to',
            'body' => 'Body'
        ];
    }



}

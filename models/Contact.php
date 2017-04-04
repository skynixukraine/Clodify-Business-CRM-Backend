<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Contact is the model behind the contact form.
 * @property string name
 * @property string email
 * @property string subject
 * @property string message
 * @property string verifyCode
 * @property array attachment
 * @property array file_id
 */
class Contact extends ActiveRecord
{
    public $attachments;
    public $file;

    const SCENARIO_ATTACH_FILES = 'attachments';
    const SCENARIO_CONTACT_FORM = 'contact';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and message are required
            [['name', 'email', 'subject', 'message'], 'required', 'except' => self::SCENARIO_ATTACH_FILES],
            // email has to be a valid email address
            ['email', 'email'],
            // max length for email, message, name and subject
            [['email', 'message'], 'string', 'max' => 150],
            [['name', 'subject'], 'string', 'max' => 45],
            ['attachments', 'each', 'rule' => ['integer']],
            // 10485760 bytes - 10 megabytes
            ['file', 'required', 'on' => self::SCENARIO_ATTACH_FILES],
            [['file'], 'file', 'on' => self::SCENARIO_ATTACH_FILES]
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            $to             = $email;
            $fromName       = "Skynix Administration";
            $replyToEmail   = $this->email;
            $replyToName    = $fromName;
            $message        = $this->message;
            if ( strstr($this->subject, 'Synpass') !== false ) {

                $to             = Yii::$app->params['synpassAdminEmail'];
                $fromName       = "Synpass Administration";
                $replyToName    = "Synpass Guest";
                $message        = "Welcome Synpass Guest, \n".
                                    "We will inform you as soon as the service is launch.";

                Yii::$app->mailer->compose()
                    ->setTo($this->email)
                    ->setReplyTo([$to => $fromName])
                    ->setFrom([Yii::$app->params['adminEmail'] => $fromName])
                    ->setSubject($this->subject)
                    ->setTextBody($message)
                    ->send();


                Yii::$app->mailer->compose('synpass_welcome')
                    ->setTo($to)
                    ->setReplyTo([$replyToEmail => $replyToName])
                    ->setFrom([Yii::$app->params['adminEmail'] => $fromName])
                    ->setSubject($this->subject)
                    ->setTextBody($message)
                    ->send();

            } else {

                Yii::$app->mailer->compose()
                    ->setTo($to)
                    ->setReplyTo([$replyToEmail => $replyToName])
                    ->setFrom([Yii::$app->params['adminEmail'] => $fromName])
                    ->setSubject($this->subject)
                    ->setTextBody($message)
                    ->send();
                
            }
            

            return true;
        }
        return false;
    }
}
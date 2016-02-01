<?php
namespace app\modules\cp\models;
/**
 * Created by WebAIS Company.
 * URL: webais.company
 * Developer: alekseyyp
 * Date: 01.02.16
 * Time: 12:01
 */

use Yii;
use yii\base\Model;

class EmailTesterForm extends Model
{
    public $email;
    public $subject;
    public $body;
    public $textbody;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'subject', 'body'], 'required'],
            [['textbody'], 'string', 'max' => 100000],
            [['body'], 'string', 'max' => 100000],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email'         => 'Your Email',
            'subject'       => 'Subject',
            'body'          => 'Email Body (HTML)',
            'textbody'      => 'Text Version of Email'
        ];
    }

    public function send()
    {

        return Yii::$app->mailer->compose()
            ->setTo( $this->email )
            ->setFrom( Yii::$app->params['adminEmail'])
            ->setSubject( $this->subject )
            ->setHtmlBody( $this->body )
            ->setTextBody( $this->textbody )
            ->send();

    }
}
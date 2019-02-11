<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 2/8/19
 * Time: 5:52 PM
 */

namespace app\components;
use app\models\EmailTemplate;
use Yii;

class SkynixMail
{
    private $defaultVariables = [];

    public function __construct()
    {
        $this->defaultVariables['SiteUrl']      = Yii::$app->env->getAbsoluteAppUrl();
        $this->defaultVariables['adminEmail']   = Yii::$app->params['adminEmail'];
    }

    /**
     * Send an email
     * @param $template
     * @param string|array $to receiver email address.
     * You may pass an array of addresses if multiple recipients should receive this message.
     * You may also specify receiver name in addition to email address using format:
     * `[email => name]`.
     * @param $variables
     * @return bool
     * @throws \Exception
     */
    public function send($template, $to, $variables)
    {
        $variables = array_merge($this->defaultVariables, $variables);
        /** @var $emailTemplate EmailTemplate */
        if ( ($emailTemplate = EmailTemplate::find()->where(['template' => $template])->one())) {

            $subject    = $this->_replace($emailTemplate->subject, $variables);
            $body       = $this->_replace($emailTemplate->body, $variables);
            $replyTo    = $this->_replace($emailTemplate->reply_to, $variables);
            return Yii::$app->mailer
                ->compose('email-layout', [
                    'body'  => $body
                ])
                ->setTo($to)
                ->setSubject($subject)
                ->setReplyTo($replyTo)
                ->setFrom([
                    Yii::$app->params['fromEmail'] => 'Clodify Notification'
                ])
                ->send();

        } else {

            throw new \Exception('Email template is not found.');
        }
    }

    private function _replace($text, $vars)
    {
        foreach ( $vars as $k=>$v ) {

            $text = str_replace('{' . $k . '}', $v, $text);
        }
        return $text;
    }
}
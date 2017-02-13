<?php
/**
 * Created by Skynix Team
 * Date: 8/6/16
 * Time: 21:31
 */

namespace viewModel;

use app\models\Contact;
use app\models\Contract;
use app\models\User;
use Yii;
use yii\web\UploadedFile;
use app\modules\api\components\Api\Processor;

class Contacts extends ViewModelAbstract
{
    /** @var  \app\models\Contact */
    public $model;

    public function define()
    {
        $this->model->attachment = UploadedFile::getInstancesByName('attachment');

        if ($this->validate() && ($reciever = User::findOne(Yii::$app->params['contractorId']))) {
            $secret = Yii::$app->params['captchaSecret'];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                "secret={$secret}&response={$this->model->verifyCode}");
            $server_output = curl_exec ($ch);

            curl_close ($ch);

            // The response is a JSON object:
            $server_output = json_decode($server_output);
            if ($server_output['success'] && $this->model->contact($reciever->email)) {
                $dir = '/data/contact-attachments/';
                $id = Contact::find()->max('id') + 1;
                $filePath = [];
                foreach ($this->model->attachment as $file) {
                    if (!is_dir($dir)) {
                        @mkdir($dir, 0777, true);
                    }
                    $file->saveAs(Yii::getAlias('@app') .  $dir . $id . $file->name);
                    $filePath[] = $dir . $id . $file->name;
                }
                $this->model->attachment = json_encode($filePath);
                $this->model->save();
            } else {
                $this->addError('verifyCode', Yii::t('yii', 'Sorry, you have not passed BOT check'));
            }
        }

    }

}

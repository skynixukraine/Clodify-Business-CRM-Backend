<?php
/**
 * Created by Skynix Team
 * Date: 8/6/16
 * Time: 21:31
 */

namespace viewModel;

use app\models\Contact;
use app\modules\api\components\Api\Processor;
use Yii;
use yii\helpers\FileHelper;

class Contacts extends ViewModelAbstract
{
    /** @var  \app\models\Contact */
    public $model;

    public function define()
    {
        if ($this->validate()) {
            $this->doContact();
        } else {
            $this->doContact($validation = false);
        }
    }

    private function doContact($validation = true)
    {
        $path = Yii::getAlias('@app') . '/data/contact-attachments';
        if (!is_dir($path)) {
            FileHelper::createDirectory($path);
        }
        if ($filesId = $this->model->attachments) {
            $uploads = Yii::getAlias('@runtime/uploads');
            $id = Contact::find()->max('id') + 1;
            $idFolder = $path . '/' . $id;
            FileHelper::createDirectory($idFolder);
            if (count($filesId) <= 5) {
                $size = 0;
                foreach ($filesId as $fileId) {
                    $fullPath = glob($uploads . '/' . $fileId . '*')[0];
                    $fileName = explode('/', $fullPath);
                    $fileName = end($fileName);
                    if (file_exists($fullPath)) {
                        $size += filesize($fullPath);
                        if ($size <= 10485760) {  // 10485760 bytes - 10 mb
                            copy($fullPath, $idFolder . '/' . $fileName);
                            @unlink($fullPath);
                        } else {
                            $this->addError('attachments', Yii::t('app','You are trying upload files with total size ' . $this->formatBytes($size) . ' but maximum size you can upload is 10 MB'));
                        }
                    }
                }
            } else {
                $this->addError('attachments', Yii::t('app','You are trying upload ' . count($filesId) . ' files but you can upload a maximum of 5 files'));
            }
        }

        if ($validation) {
            $this->model->contact(Yii::$app->params['adminEmail']);
            $this->model->save();
        }
    }

    private function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array("", " KB", " MB", " GB", " TB");

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }


}

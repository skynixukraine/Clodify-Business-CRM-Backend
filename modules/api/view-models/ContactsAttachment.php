<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 09.02.17
 * Time: 13:15
 */

namespace viewModel;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ContactsAttachment extends ViewModelAbstract
{

    public function define()
    {
        $attachments = UploadedFile::getInstancesByName('fileName');
        if (!empty($attachments)) {
            $path = Yii::getAlias('@runtime/uploads');
            FileHelper::createDirectory($path);
            $key = 'ETA';
            $data = Yii::$app->cache->exists($key) ? Yii::$app->cache->get($key) : [];
            foreach ($attachments as $idx => $attachment) {
                $file = $path . '/' . $attachment->name;
                if($attachment->saveAs($file)) {
                    $fileKey = md5($attachment->name);
                    $data[$fileKey] = $file;
                }
            }
            Yii::$app->cache->set($key, $data, 3600);
            $this->setData(['key' => $fileKey]);
        }
    }

}
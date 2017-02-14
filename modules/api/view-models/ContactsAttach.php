<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 14.02.17
 * Time: 16:06
 */

namespace viewModel;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ContactsAttach extends ViewModelAbstract
{
    /** @var  \app\models\Contact */
    public $model;

    public function define()
    {
        $this->model->attachment = UploadedFile::getInstancesByName('fileName');
        if (!empty($this->model->attachment) && $this->validate()) {
            $path = Yii::getAlias('@runtime/uploads');
            if (!is_dir($path)) {
                FileHelper::createDirectory($path);
            }
            $key = 'attach';
            $fileKeys = [];
            $data = Yii::$app->cache->exists($key) ? Yii::$app->cache->get($key) : [];
            foreach ($this->model->attachment as $idx => $attachment) {
                $file = $path . '/' . $attachment->name;
                if($attachment->saveAs($file)) {
                    $fileKey = md5($attachment->name);
                    $data[$fileKey] = $file;
                    $fileKeys[] = $fileKey;
                }
            }
            Yii::$app->cache->set($key, $data, 3600);
            $this->setData(['id' => $fileKeys]);
        }

    }
}
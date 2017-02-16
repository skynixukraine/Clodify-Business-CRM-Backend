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
            $field = Yii::$app->cache->exists($key) ? Yii::$app->cache->get($key) : 0;
            foreach ($this->model->attachment as $idx => $attachment) {
                $file = $path . '/' . $field . '.' . $attachment->getExtension();
                if($attachment->saveAs($file)) {
                    $fileKeys[] = $field;
                    $field++;
                }
            }
            Yii::$app->cache->set($key, $field);
            $this->setData(['file_id' => $fileKeys]);
        }

    }
}
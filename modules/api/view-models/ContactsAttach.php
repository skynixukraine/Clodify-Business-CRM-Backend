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
        $this->model->attachment = UploadedFile::getInstanceByName('fileName');
        if ($this->validate()) {
            $path = Yii::getAlias('@runtime/uploads');
            if (!is_dir($path)) {
                FileHelper::createDirectory($path);
            }
            $key = 'attach';
            $field = Yii::$app->cache->exists($key) ? Yii::$app->cache->get($key) : 0;
            $field++;
            $file = $path . '/' . $field . '.' . $this->model->attachment->getExtension();
            if($this->model->attachment->saveAs($file)) {
                Yii::$app->cache->set($key, $field);
                $this->setData(['file_id' => $field]);
            } else {
                $this->addError('attachment', $this->model->getErrors());
            }

        }

    }
}
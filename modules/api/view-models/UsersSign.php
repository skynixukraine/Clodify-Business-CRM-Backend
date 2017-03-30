<?php
/**
 * Created by Skynix Team
 * Date: 30.03.17
 * Time: 16:30
 */

namespace viewModel;

use Yii;
use yii\web\UploadedFile;
use app\models\User;

/**
 * Class UsersSign
 * @package viewModel
 */
class UsersSign extends ViewModelAbstract
{

    public $model;

    public function define()
    {
        $fileName = 'sign';
        $file = UploadedFile::getInstanceByName($fileName);
        $this->model->sing = $file;

        if ($this->validate()) {
            $uploadPath = Yii::getAlias('@app') . '/data/' . Yii::$app->user->id . '/';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
                chmod($uploadPath, 0777);
            }

            $uploadPath = $uploadPath . 'sign/';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
                chmod($uploadPath, 0777);
            }

            if ($file->size <= 2097152) { // 2097152 bytes - 2 mb
                if ($file->saveAs($uploadPath . '/' . $file->name)) {
                    $pathFile = 'data/' . Yii::$app->user->id . '/' . $file->name;
                    $this->setData(['sign' => $pathFile]);

                    //Now save file data to database
                    User::setUserSing($file->name);
                }
            } else {
                $fileSize = round(($file->size / 1024)/1024, 2);
                $this->addError('sign', 'File is too big: ' . $fileSize . 'MiB' . '. Max fileSize: 2 MiB.');
            }
        }
    }

}
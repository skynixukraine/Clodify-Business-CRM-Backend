<?php
/**
 * Created by Skynix Team
 * Date: 13.03.17
 * Time: 8:43
 */
namespace viewModel;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use app\models\User;

/**
 * Class UserPhoto
 * @package viewModel
 */
class UserPhoto extends ViewModelAbstract
{

    public $model;

    public function define()
    {
        $fileName = 'photo';
        $file = \yii\web\UploadedFile::getInstanceByName($fileName);
        $this->model->photo = $file;

        if ($this->validate()) {
            $uploadPath = Yii::getAlias('@app') . '/data/' . Yii::$app->user->id . '/';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
                chmod($uploadPath, 0777);
            }
            $uploadPath = $uploadPath . 'photo/';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
                chmod($uploadPath, 0777);
            }

            if ($file->size <= 5242880) { // 5242880 bytes - 5 mb
                if ($file->saveAs($uploadPath . '/' . $file->name)) {
                    $pathFile = 'data/' . Yii::$app->user->id . '/' . $file->name;
                    $this->setData(['photo' => $pathFile]);

                    //Now save file data to database
                    User::setUserPhoto($file->name);
                }
            } else {
                $this->addError('photo', 'fileSize is too big. Max fileSize is 5 MiB.');
            }
        }

    }

}

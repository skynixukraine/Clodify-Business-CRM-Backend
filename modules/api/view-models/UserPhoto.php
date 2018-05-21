<?php
/**
 * Created by Skynix Team
 * Date: 11.04.17
 * Time: 18:01
 */

namespace viewModel;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use app\models\User;
use app\models\Storage;

/**
 * Class UserPhoto
 * @package viewModel
 */
class UserPhoto extends ViewModelAbstract
{

    public function define()
    {
        $result = User::uploadPhoto($this->model->photo);
        if ($result['ObjectURL']) {
            $this->setData(['photo' => $result['ObjectURL']]);
        } else {
            $this->addError('photo', 'Foto not saved.');
        }

//     save to db

//        $fileName = 'photo';
//        $file = \yii\web\UploadedFile::getInstanceByName($fileName);
//        $this->model->photo = $file;
//        if ($this->validate()) {
//            if ($file->size <= 5242880) { // 5242880 bytes - 5 mb
//                $s = new Storage();
//                $pathFile = 'data/' . Yii::$app->user->id . '/photo/';
//                $result = $s->upload($pathFile . $file->name, $file->tempName);
//                if ($result['ObjectURL']) {
//                    $this->setData(['photo' => $result['ObjectURL']]);
//
//                    //Now save file data to database
//                    User::setUserPhoto($file->name);
//                }
//            } else {
//                $this->addError('photo', 'fileSize is too big. Max fileSize is 5 MiB.');
//            }
//        }
    }

}
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
use app\models\Storage;

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
            if ($file->size <= 2097152) { // 2097152 bytes - 2 mb
                $s = new Storage();
                $pathFile = 'data/' . Yii::$app->user->id . '/sign/' . $file->name;
                $result = $s->upload($pathFile, $file->tempName);
                if ($result['ObjectURL']) {
                    $this->setData(['sign' => $result['ObjectURL']]);

                    //Now save file data to database
                    User::setUserSing($file->name);
                }
            } else {
                $fileSizeMib = round(($file->size / 1024)/1024, 2);
                $this->addError('sign', 'File is too big: '
                                . $fileSizeMib . 'MiB. Max fileSize: 2 MiB.');
            }
        }
    }

}
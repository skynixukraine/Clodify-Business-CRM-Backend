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
            $this->addError('photo', 'Sorry, by some reason we could not upload your photo, try again later.');
        }

    }

}
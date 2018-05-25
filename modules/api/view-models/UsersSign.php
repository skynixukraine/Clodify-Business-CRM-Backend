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

    public function define()
    {
        $result = User::uploadSign($this->model->sing);
        if ($result['ObjectURL']) {
            $this->setData(['sign' => $result['ObjectURL']]);
        }

    }

}
<?php
/**
 * Created by Skynix Team
 * Date: 01.12.16
 * Time: 11:45
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;

use app\models\User;


class ProfileController extends Controller
{
    public function actionIndex($name, $public_key)
    {
        $initials = explode('-', $name);
        $user = User::find()->where(['first_name' =>ucfirst(strtolower($initials[0]))])
                            ->andWhere(['last_name' => ucfirst(strtolower($initials[1]))])
                            ->andWhere(['public_profile_key' => $public_key])->one();
        $this->layout = "main_en";
        $defaultPhoto = User::getUserPhoto();
        $defaultSing = User::getUserSing();
        return $this->render("index", ['user' => $user,
            'defaultPhoto' => $defaultPhoto,
            'defaultSing' => $defaultSing]);

       /* $user->andWhere(['public_profile_key' => $public_key]);
        $defaultPhoto = User::getUserPhoto();

        $defaultSing = User::getUserSing();
        $this->layout = "main_en";

        return $this->render("index", ['model' => $user,
            'defaultPhoto' => $defaultPhoto,
            'defaultSing' => $defaultSing]); */
    }
}
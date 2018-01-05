<?php
/**
 * Created by Skynix Team
 * Date: 25.04.17
 * Time: 16:46
 */

namespace viewModel;

use Yii;
use app\models\User;
use app\models\Storage;
use app\modules\api\models\AccessKey;
use yii\helpers\Url;



class UserViewPhoto extends ViewModelAbstract
{

    public function define()
    {
        //$id = Yii::$app->request->getQueryParam('id');

//        $userPhoto = User::find()
//            ->select('photo')
//            ->where(['id' => $id])
//            ->andWhere(['is_delete' => !User::DELETED_USERS])
//            ->andWhere(['is_active' => User::ACTIVE_USERS])
//            ->andWhere(['is_published' => User::PUBLISHED_USERS])
//            ->one();
//
//        if ($userPhoto) {
//            $s = new Storage();
//            $result = $s->download('data/' . $id . '/photo/' . $userPhoto->photo);
//            $path_info = pathinfo($userPhoto->photo);
//            header('Content-Type: ' . $result['ContentType'] . '/' . $path_info['extension']);
//            echo $result['Body'];
//            exit();
//        } else {
//            throw new \yii\web\NotFoundHttpException;
//        }

        $id = Yii::$app->request->getQueryParam('id');
        $s = new Storage();
        $pathFile = 'data/' . $id . '/photo/';
        header('Content-type: image/jpeg');

        try {
            $photo = $s->download($pathFile . 'avatar');
            if(isset($photo['Body'])) {
                $str = $photo['Body'];
            } else {
                $str = file_get_contents(Yii::getAlias('@webroot').'/img/avatar.png');
            }
        } catch (\Exception $e) {
            $str = file_get_contents(Yii::getAlias('@webroot').'/img/avatar.png');
        }
        $base = base64_encode($str);
        $data = [$base];
        $this->setData($data);
    }

}
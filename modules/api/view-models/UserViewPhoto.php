<?php
/**
 * Created by Skynix Team
 * Date: 25.04.17
 * Time: 16:46
 */

namespace viewModel;

use Yii;
use app\models\User;

class UserViewPhoto extends ViewModelAbstract
{

    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');

        $userPhoto = User::find()
            ->select('photo')
            ->where(['id' => $id])
            ->andWhere(['is_delete' => !User::DELETED_USERS])
            ->andWhere(['is_active' => User::ACTIVE_USERS])
            ->andWhere(['is_published' => User::PUBLISHED_USERS])
            ->one();

        if ($userPhoto) {
            $src = Yii::getAlias('@app') . '/data/' . $id . '/photo/' . $userPhoto->photo;
            $size = getimagesize($src);
            if ($size['mime'] == image_type_to_mime_type(IMAGETYPE_JPEG)) {
                header("Content-type: " . image_type_to_mime_type(IMAGETYPE_JPEG));
                return imagejpeg(imagecreatefromstring(file_get_contents($src)));
            }

            if ($size['mime'] == image_type_to_mime_type(IMAGETYPE_PNG)) {
                header("Content-type: " . image_type_to_mime_type(IMAGETYPE_PNG));
                return imagepng(imagecreatefromstring(file_get_contents($src)));
            }

            if ($size['mime'] == image_type_to_mime_type(IMAGETYPE_GIF)) {
                header("Content-type: " . image_type_to_mime_type(IMAGETYPE_GIF));
                return imagegif(imagecreatefromstring(file_get_contents($src)));
            }

        } else {
            throw new \yii\web\NotFoundHttpException;
        }
    }

}
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

        $imageSize = getimagesize($this->model->photo);

        if($imageSize[0] > 150 || $imageSize[1] > 150) {
            $photo = $this->resizeImage($this->model->photo, 150, 150);
            ob_start();
            imagejpeg($photo);
            $contents = ob_get_contents();
            ob_end_clean();
            $dataUri = "data:image/jpeg;base64," . base64_encode($contents);
            $photo = $dataUri;
        } else {
            $photo = $this->model->photo;
        }

        $result = User::uploadPhoto($photo);

        if ($result['ObjectURL']) {
            $this->setData(['photo' => $result['ObjectURL']]);
        } else {
            $this->addError('photo', 'Sorry, by some reason we could not upload your photo, try again later.');
        }

    }

    function resizeImage($file, $w, $h, $crop=FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }

        $source_properties = getimagesize($file);
        $image_type = $source_properties[2];

        if( $image_type == IMAGETYPE_JPEG ) {
            $src = imagecreatefromjpeg($file);
        }
        elseif( $image_type == IMAGETYPE_GIF )  {
            $src = imagecreatefromgif($file);  }
        elseif( $image_type == IMAGETYPE_PNG ) {
            $src = imagecreatefrompng($file);
        }

        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        return $dst;
    }

}
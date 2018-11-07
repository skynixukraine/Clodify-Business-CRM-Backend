<?php
/**
 * Created by Skynix Team
 * Date: 11.04.17
 * Time: 18:01
 */

namespace viewModel;

use app\models\User;


/**
 * Class UserPhoto
 * @package viewModel
 */
class UserPhoto extends ViewModelAbstract
{

    public function define()
    {

        $imageSize = @getimagesize($this->model->photo);

        if(is_array($imageSize) && count($imageSize) && ($imageSize[0] > 150 || $imageSize[1] > 150)) {

            $oldImageWidth = $imageSize[0];
            $oldImageHeight = $imageSize[1];

            if($oldImageWidth <= $oldImageHeight) {
                $newImageWidth = 150;
                $newImageHeight = ceil($oldImageHeight/$oldImageWidth*150);
            } else {
                $newImageHeight = 150;
                $newImageWidth = ceil($oldImageWidth/$oldImageHeight*150);
            }

            $photo = $this->resizeImage($this->model->photo, $newImageWidth, $newImageHeight);
            ob_start();
            imagejpeg($photo);
            $contents = ob_get_contents();
            ob_end_clean();
            $dataUri = "data:image/jpeg ;base64," . base64_encode($contents);
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
            $newWidth = $w;
            $newHeight = $h;
        } else {
            if ($w/$h > $r) {
                $newWidth = $h*$r;
                $newHeight = $h;
            } else {
                $newHeight = $w/$r;
                $newWidth = $w;
            }
        }

        $sourceProperties = getimagesize($file);
        $imageType = $sourceProperties[2];

        if( $imageType == IMAGETYPE_JPEG ) {
            $src = imagecreatefromjpeg($file);
        }
        elseif( $imageType == IMAGETYPE_GIF )  {
            $src = imagecreatefromgif($file);  }
        elseif( $imageType == IMAGETYPE_PNG ) {
            $src = imagecreatefrompng($file);
        } else {
            return $file;
        }

        $dst = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        return $dst;
    }

}
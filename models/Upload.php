<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 08.04.16
 * Time: 11:48
 */
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class Upload extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $file;
    public $fileName;
    public $imageFiles = [];

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function upload()
    {

        if ($this->validate()) {

            $this->fileName = time() . "_" . $this->file->baseName . '.' . $this->file->extension;
            $path = Yii::getAlias('@app/data/documents/');
            if ( !file_exists( $path ) ) {

                mkdir( $path, 0775);
                chmod( $path, 0775);

            }
            $this->file->saveAs( $path . $this->fileName );
            return true;

        } else {

            return false;

        }
    }

    public function uploadimg()
    {
        var_dump('0');
        if ($this->validate()) {
var_dump('1');
            $path = Yii::getAlias("@app") . "/data/" . Yii::$app->user->id . "/photo/";
            if ( !file_exists( $path ) ) {
                var_dump('2');

                mkdir( $path, 0775);
                chmod( $path, 0775);

            }

            foreach ($this->imageFiles as $img) {
                var_dump('3');

                $img->fileName = time() . "_" . $this->file->baseName . '.' . $this->file->extension;
                $img->saveAs($path . $img->baseName . '.' . $img->extension);
            }
            exit();
            return true;
        } else {
            var_dump('5');

            exit();
            return false;
        }
    }
}
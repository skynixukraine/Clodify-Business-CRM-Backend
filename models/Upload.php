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
     * @var UploadedFile
     */
    public $file;
    public $fileName;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false],
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
}
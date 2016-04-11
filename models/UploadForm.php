<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 08.04.16
 * Time: 11:48
 */
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;
    public $fileName;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, odt, txt'],
        ];
    }

    public function upload()
    {


        if ($this->validate()) {
            foreach ($this->files as $file) {
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
}
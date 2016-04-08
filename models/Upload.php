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
            [['file'], 'file', 'skipOnEmpty' => true],
        ];
    }

    public function upload()
    {

        if ($this->validate()) {
            var_dump($this->file);
            exit();
            //$this->file->saveAs('uploads/' . $this->file->baseName . '.' . $this->file->extension);
            $this->fileName = date('Y-m-d') . "_" . $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs( getcwd() . '/data/documents/' . $this->fileName);
            return true;
        } else {
            return false;
        }
    }
}
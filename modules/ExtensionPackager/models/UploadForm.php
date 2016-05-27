<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 27.05.16
 * Time: 13:35
 */
namespace app\modules\ExtensionPackager\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $picture;
    public $license;
    public $user_guide;
    public $installation_guide;

    public function rules()
    {
        return [
            [['picture'], 'file', 'skipOnEmpty' => false, 'checkExtensionByMimeType' => false, 'extensions' => 'jpg', 'mimeTypes' => 'image/jpeg'],
            [['license'], 'file', 'skipOnEmpty' => false, 'checkExtensionByMimeType' => false, 'extensions' => 'txt', 'mimeTypes' => 'text/plain'],
            [['user_guide', 'installation_guide'], 'file', 'skipOnEmpty' => false, 'checkExtensionByMimeType' => false, 'extensions' => 'pdf', 'mimeTypes' => 'application/pdf'],
        ];
    }
  
}
<?php
/**
 * Created by Skynix Team
 * Date: 8/6/16
 * Time: 21:31
 */

namespace viewModel;

use app\models\Contact;
use app\models\User;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class Contacts extends ViewModelAbstract
{
    /** @var  \app\models\Contact */
    public $model;

    public function define()
    {
        if ($this->validate()) {
            $path = Yii::getAlias('@app') . '/data/contact-attachments';
            if (!is_dir($path)) {
                FileHelper::createDirectory($path);
            }
            if ($filesId = $this->model->file_id) {
                $uploads = Yii::getAlias('@runtime/uploads');
                $id = Contact::find()->max('id') + 1;
                $idFolder = $path . '/' . $id;
                FileHelper::createDirectory($idFolder);
                $files = array_diff(scandir($uploads, 1), array('.', '..'));
                foreach ($filesId as $fileId) {
                    foreach ($files as $file) {
                        $fileName = explode('.', $file)[0]; // return filename without extension
                        if ($fileName == $fileId) {
                            copy($uploads . '/' . $file, $idFolder . '/' . $file);
                            @unlink($uploads . '/' . $file);
                        }
                    }
                }
                @rmdir($uploads);
                $this->model->contact(Yii::$app->params['adminEmail']);
            } else {
                $this->model->contact(Yii::$app->params['adminEmail']);
            }
            $this->model->save();
        }
    }

}

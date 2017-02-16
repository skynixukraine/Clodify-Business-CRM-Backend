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
            if ($this->model->contact(Yii::$app->params['adminEmail'])) {
                $newDir = Yii::getAlias('@app') . '/data/contact-attachments';
                if (!is_dir($newDir)) {
                    FileHelper::createDirectory($newDir);
                }
                $dir = Yii::getAlias('@runtime/uploads');
                $id = Contact::find()->max('id') + 1;
                // @runtime/uploads exists only if user uploaded attachments
                if (is_dir($dir)) {
                    $files = array_diff(scandir($dir, 1), array('.', '..'));
                    foreach ($files as $file) {
                        copy($dir . '/' . $file, $newDir . '/' . $id . $file);
                        @unlink($dir . '/' . $file);
                    }
                    @rmdir($dir);
                }
                $this->model->save();
            }
        }

    }

}

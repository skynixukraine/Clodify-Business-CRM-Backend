<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 14.02.17
 * Time: 16:41
 */

namespace viewModel;

use Yii;

class ContactsAttachDelete extends ViewModelAbstract
{
    /** @var  \app\models\Contact */
    public $model;
    
    public function define()
    {
        $fileKey = Yii::$app->request->getQueryParam('id');
        $key  = 'attach';
        $data = Yii::$app->cache->exists($key) ? Yii::$app->cache->get($key) : [];
        if (isset($data[$fileKey])) {
            $file = $data[$fileKey];
            unset($data[$fileKey]);
            // remove the file if it was a new uploaded attachment
            if (Yii::getAlias('@runtime/uploads') == dirname($file)) {
                @unlink($file);
            }
        }
        Yii::$app->cache->set($key, $data, 3600);
    }
}
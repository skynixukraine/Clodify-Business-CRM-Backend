<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 19.10.17
 * Time: 10:26
 */

namespace viewModel;

use app\models\Setting;
use app\models\User;
use app\modules\api\components\Api\Processor;
use yii;

/**
 * Class SettingUpdate
 * @package viewModel
 */
class SettingUpdate extends ViewModelAbstract
{

    public function define()
    {
        $key = Yii::$app->request->getQueryParam('key');

        if (User::hasPermission([User::ROLE_ADMIN])) {
            $settingRow = Setting::find()
                ->where(['key' => $key])
                ->one();

            if ($settingRow) {
                if (isset($this->postData['value'])) {
                    $settingRow->value = $this->postData['value'];
                    $settingRow->save();
                }
            } else {
                return $this->addError($key, Yii::t('app', 'The ' . $key . ' does not exist'));
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM,
                Yii::t('app', 'You have no permission for this action'));
        }
    }
}
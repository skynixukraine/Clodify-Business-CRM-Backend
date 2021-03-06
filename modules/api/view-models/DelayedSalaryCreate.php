<?php
/**
 * Created by Skynix Team
 * Date: 27.04.18
 * Time: 10:29
 */

namespace viewModel;


use app\models\Report;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * Class DelayedSalaryCreate
 *
 * @package viewModel
 * @see     https://jira.skynix.co/browse/SCA-147
 * @author  Igor (Skynix)
 */
class DelayedSalaryCreate extends ViewModelAbstract
{

    public function define()
    {
        // TODO: Implement define() method.

        if (User::hasPermission([User::ROLE_ADMIN])) {

            $this->model->raised_by = Yii::$app->user->id;

            if ($this->validate() && $this->model->save()) {

                $this->setData([
                    'delayed_salary_id' => $this->model->id
                ]);
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }

}
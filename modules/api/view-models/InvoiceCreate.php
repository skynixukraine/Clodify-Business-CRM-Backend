<?php
/**
 * Created by Skynix Team
 * Date: 21.04.17
 * Time: 13:28
 */

namespace viewModel;

use app\components\DateUtil;
use app\models\Invoice;
use app\models\ProjectCustomer;
use Yii;
use app\models\User;
use app\modules\api\components\Api\Processor;

class InvoiceCreate extends ViewModelAbstract
{
    /**
     * @var Invoice
     */
    protected $model;

    public function define()
    {
        if (!User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }

        if ($this->model->project_id !== null) {
            $projectExists = ProjectCustomer::find()->where([
                'user_id' => $this->model->user_id,
                'project_id' => $this->model->project_id,
            ])->exists();

            if (!$projectExists) {
                return $this->addError(Processor::ERROR_PARAM, 'project_id must correspond to a passed customer');
            }
        }

        $this->model->created_by = Yii::$app->user->id;
        $this->model->date_start = DateUtil::convertData($this->model->date_start);
        $this->model->date_end = DateUtil::convertData($this->model->date_end);
        $this->model->date_created = date('Y-m-d');

        if ($this->validate() && $this->model->save()) {
            $this->setData([
                'invoice_id' => $this->model->id,
            ]);
        }
    }
}
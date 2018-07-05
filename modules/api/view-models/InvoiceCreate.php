<?php
/**
 * Created by Skynix Team
 * Date: 21.04.17
 * Time: 13:28
 */

namespace viewModel;

use app\components\DateUtil;
use app\models\Invoice;
use Yii;
use app\models\Contract;
use app\models\User;
use app\modules\api\components\Api\Processor;

class InvoiceCreate extends ViewModelAbstract
{
    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) {
            $this->model->created_by = Yii::$app->user->id;
            $this->model->date_start = DateUtil::convertData( $this->model->date_start );
            $this->model->date_end = DateUtil::convertData( $this->model->date_end );
            $this->model->date_created = date('Y-m-d');

            if ($this->validate() && $this->model->save()) {
                $this->setData([
                    'invoice_id' => $this->model->id
                ]);
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }
}
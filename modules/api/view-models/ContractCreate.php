<?php
/**
 * Created by Skynix Team
 * Date: 20.04.17
 * Time: 14:09
 */

namespace viewModel;

use Yii;
use app\components\DateUtil;

class ContractCreate extends ViewModelAbstract
{
    public function define()
    {
        $this->model->created_by = Yii::$app->user->id;
        if ($this->validate()) {
            $this->model->start_date = DateUtil::convertData($this->model->start_date);
            $this->model->end_date = DateUtil::convertData($this->model->end_date);
            $this->model->act_date = DateUtil::convertData($this->model->act_date);

            $this->model->save();
            $this->setData([
                'contract_id' => $this->model->id
            ]);
        }
    }

}
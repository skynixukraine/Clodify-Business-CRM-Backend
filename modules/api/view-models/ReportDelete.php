<?php
/**
 * Created by Skynix Team
 * Date: 03.03.17
 * Time: 14:09
 */
namespace viewModel;


use app\models\Report;
use Yii;


class ReportDelete extends ViewModelAbstract
{
    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');
        //$data = $this->model->getDatePeriods();
      //  $this->setData($data);

    }
}
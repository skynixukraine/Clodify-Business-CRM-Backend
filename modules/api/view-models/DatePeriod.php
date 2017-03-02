<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 24.02.17
 * Time: 12:20
 */

namespace viewModel;


use app\models\Report;
use Yii;



class DatePeriod extends ViewModelAbstract
{
	public function define()
	{
		$data = $this->model->getDatePeriods();
		$this->setData($data);

	}
}
<?php
/**
 * Created by Skynix Team
 * Date: 03.03.17
 * Time: 13:37
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
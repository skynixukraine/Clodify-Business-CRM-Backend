<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 24.02.17
 * Time: 12:20
 */

namespace viewModel;

use app\components\DataTable;
use app\models\Project;
use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
use app\models\Report;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;
use DateTime;
use app\modules\api\components\SortHelper;


class DatePeriod extends ViewModelAbstract
{
	public function define()
	{
		$data = $this->model->getDatePeriods();
		$this->setData($data);

	}
}
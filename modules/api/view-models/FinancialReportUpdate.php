<?php
/**
 * Created by Skynix Team
 * Date: 23.07.17
 * Time: 15:17
 */

namespace viewModel;

use app\models\FinancialReport;
use app\models\SurveysOption;
use app\components\DateUtil;
use app\models\Survey;
use yii;
use yii\helpers\ArrayHelper;

class FinancialReportUpdate extends ViewModelAbstract
{

    public function define()
    {
        if ($id = Yii::$app->request->get('id')) {
            if ($this->validate() && ($this->model = FinancialReport::findOne($id)) ) {
                $this->model->setAttributes($this->postData);
                $this->model->save();
            }
        }
    }
}
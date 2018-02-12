<?php
/**
 * Created by Skynix Team
 * Date: 12.02.17
 * Time: 14:48
 */

namespace app\commands;

use app\models\Report;
use yii\console\Controller;


class ReportController extends Controller
{
    /**
     *
     */
    public function actionApproveToday()
    {
        try {
            Report::approveTodayReports();
            echo 0;
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            echo $e->getMessage();
        }
    }
}

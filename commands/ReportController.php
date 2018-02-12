<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Report;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
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

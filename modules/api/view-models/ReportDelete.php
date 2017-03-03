<?php
/**
 * Created by Skynix Team
 * Date: 03.03.17
 * Time: 14:09
 */
namespace viewModel;


use app\models\Report;
use app\models\User;
use app\models\Project;

use Yii;

/**
 * Class ReportDelete
 * Delete the report by id
 * @package viewModel
 */
class ReportDelete extends ViewModelAbstract
{
    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');
        $model   = Report::findOne($id);
        if($model) {
            if ($model->invoice_id == null) {
                $model->is_delete = 1;
                if ($model->save(true, ['is_delete'])) {
                    $user    = User::findOne($model->user_id);
                    $project = Project::findOne($model->project_id);
                    $project->cost -= round($model->hours * ($user->salary / Report::SALARY_HOURS), 2);
                    $project->total_logged_hours -= $model->hours;
                    $project->save(true, ['total_logged_hours', 'cost']);
                }
            } else {
                $this->addError('invoice', Yii::t('app','Invoice was created for this report'));
            }
        } else {
            $this->addError('id', Yii::t('app','Such report is not existed'));
        }
        $this->setData([]);
    }
}
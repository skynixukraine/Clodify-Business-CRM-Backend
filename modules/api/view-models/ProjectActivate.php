<?php
/**
 * Created by Skynix Team
 * Date: 14.04.17
 * Time: 12:49
 */

namespace viewModel;

use app\models\Project;
use Yii;

class ProjectActivate extends ViewModelAbstract
{
    public function define()
    {
        if ($id = Yii::$app->request->getQueryParam('id')) {
            if (($model  = Project::findOne($id))
                && $model->is_delete == 0
                && $model->status != Project::STATUS_INPROGRESS
            ) {
                $model->status = Project::STATUS_INPROGRESS;
                $model->save();
            }
        }
    }

}
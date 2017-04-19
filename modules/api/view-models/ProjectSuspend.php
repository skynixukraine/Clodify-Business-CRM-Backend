<?php
/**
 * Created by Skynix Team
 * Date: 14.04.17
 * Time: 14:25
 */

namespace viewModel;

use app\models\Project;
use Yii;

class ProjectSuspend extends ViewModelAbstract
{
    public function define()
    {
        if ($id = Yii::$app->request->getQueryParam('id')) {
            if (($model = Project::findOne($id))
                && $model->is_delete == 0
                && $model->status != Project::STATUS_ONHOLD
            ) {
                $model->status = Project::STATUS_ONHOLD;
                $model->save();
            }
        }
    }

}
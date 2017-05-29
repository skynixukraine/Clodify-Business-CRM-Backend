<?php
/**
 * Created by Skynix Team
 * Date: 14.04.17
 * Time: 12:16
 */

namespace viewModel;

use app\models\Project;
use Yii;

class ProjectDelete extends ViewModelAbstract
{
    public function define()
    {
        if ($id = Yii::$app->request->getQueryParam('id')) {
            if (($model  = Project::findOne( $id )) && $model->is_delete == 0) {
                $model->is_delete = 1;
                $model->save(true, ['is_delete']);
            }
        }
    }
}
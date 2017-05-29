<?php
/**
 * Created by Skynix Team
 * Date: 13.04.17
 * Time: 17:04
 */

namespace viewModel;

use Yii;
use app\models\Project;

class ProjectEdit extends ViewModelAbstract
{
    public $model;

    public function define()
    {
        if ($id = Yii::$app->request->get('id')) {
            if ($this->validate() && ($this->model = Project::findOne($id)) && $this->model->is_delete == 0) {
                $this->model->setAttributes($this->postData);
                $this->model->save();
            }
        }
    }

}
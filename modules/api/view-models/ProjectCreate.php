<?php
/**
 * Created by Skynix Team
 * Date: 15.03.17
 * Time: 10:54
 */

namespace viewModel;

use app\models\Project;
use Yii;



class ProjectCreate extends ViewModelAbstract
{
    public function define()
    {
        $this->model->alias = $this->postData['alias_name'];
        $this->model->status = Project::STATUS_NEW;

        if($this->validate()){
            $this->model->save();
        }
    }
}
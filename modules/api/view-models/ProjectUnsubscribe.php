<?php
/**
 * Created by SkynixTeam.
 * User: Oleg
 * Date: 22.08.18
 * Time: 16:01
 */

namespace viewModel;
use Yii;
use app\models\ProjectDeveloper;
use app\modules\api\components\Api\Processor;

class ProjectSubscribe extends ViewModelAbstract
{
    public function define(){

        $projectDeveloperId = Yii::$app->request->getQueryParam('id');
        $projectDeveloper = ProjectDeveloper::findOne(['project_id' => $projectDeveloperId]);

        if(is_null($projectDeveloper)){
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app','project is\'t found by Id'));
        }


        $projectDeveloper->status = 'INACTIVE';

        if($this->validate()) {
            $projectDeveloper->save();
        }

    }
}
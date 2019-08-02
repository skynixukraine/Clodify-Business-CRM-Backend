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

            $projectDeveloper = ProjectDeveloper::find()
                ->where([
                    'project_id' => Yii::$app->request->getQueryParam('id', 0),
                    'user_id' => Yii::$app->getUser()->identity->getId(),
                ])
                ->one();

            if(is_null($projectDeveloper)){
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app','project is\'t found by Id'));
            }


            $projectDeveloper->status = 'ACTIVE';

            if($this->validate()) {
                $projectDeveloper->save();
                $this->setData([]);
            }

    }
}
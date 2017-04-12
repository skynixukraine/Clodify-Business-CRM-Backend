<?php
/**
 * Created by Skynix Team
 * Date: 11.04.17
 * Time: 12:35
 */

namespace viewModel;

use Yii;
use app\models\Survey;
use app\models\SurveysOption;
use app\modules\api\components\Api\Processor;


class SurveysDelete extends ViewModelAbstract
{
    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');
        if (($model = Survey::findOne($id)) && $model->is_delete == 0) {
            $model->is_delete = 1;
            $model->save(true, ['is_delete']);
        } else {
            return $this->addError(Processor::ERROR_PARAM, 'This survey was not found.');
        }
    }
}
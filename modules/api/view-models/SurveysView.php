<?php
/**
 * Created by Skynix Team
 * Date: 11.04.17
 * Time: 18:28
 */

namespace viewModel;

use Yii;
use app\models\Survey;
use yii\helpers\ArrayHelper;

class SurveysView extends ViewModelAbstract
{
    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');

        $surveys = Survey::find()
            ->with('surveys')
            ->where([Survey::tableName() . '.id' => $id])
            ->andWhere(['is_delete' => !Survey::IS_DELETE])
            ->all();

        $surveys = ArrayHelper::toArray($surveys, [
            'app\models\Survey' => [
                'shortcode', 'question', 'description', 'date_start', 'date_end', 'is_private',
                'options' => 'surveys'
            ],
            'app\models\SurveysOption' => [
                'name' , 'description'
            ],
        ]);

        $this->setData($surveys);
    }
}

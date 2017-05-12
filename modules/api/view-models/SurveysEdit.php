<?php
/**
 * Created by Skynix Team
 * Date: 28.04.17
 * Time: 16:23
 */

namespace viewModel;

use app\models\SurveysOption;
use app\components\DateUtil;
use app\models\Survey;
use yii;
use yii\helpers\ArrayHelper;

class SurveysEdit extends ViewModelAbstract
{
    public function define()
    {
        $surveyId = Yii::$app->request->getQueryParam('survey_id');

        /** @var $model Survey */
        $model  = Survey::findOne($surveyId);
        if ($model->is_delete == 0 && $this->validate()) {
            $deletedIDs = ArrayHelper::getColumn($model->surveys, 'id');
            $flag = null;
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $model->setAttributes($this->postData);
                $model->date_start = DateUtil::convertDatetime($model->date_start);
                $model->date_end = DateUtil::convertDatetime($model->date_end);
                if (($flag = $model->save()) && isset($this->postData['options'])) {
                    if (!empty($deletedIDs) && !empty($this->postData['options'])) {
                        SurveysOption::deleteAll(['id' => $deletedIDs]);
                    }
                    foreach ($this->postData['options'] as $option) {
                        $sOption = new SurveysOption();
                        $sOption->name = $option['name'];
                        $sOption->description = $option['description'];
                        $sOption->survey_id = $model->id;
                        if (!($flag = $sOption->save())) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                }

                if ($flag) {
                    $transaction->commit();
                }

            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
    }

}
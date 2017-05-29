<?php
/**
 * Created by Skynix Team
 * Date: 10.04.17
 * Time: 17:36
 */

namespace viewModel;

use app\models\SurveysOption;
use app\components\DateUtil;
use app\models\User;

class SurveysCreate extends ViewModelAbstract
{
    public function define()
    {
        if($this->validate()) {

            $this->model->date_start = DateUtil::convertDatetime($this->model->date_start);
            $this->model->date_end = DateUtil::convertDatetime($this->model->date_end);
            $flag = null;
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if ($flag = $this->model->save()) {
                    foreach ($this->model->options as $option) {
                        $sOption = new SurveysOption();
                        $sOption->name = $option['name'];
                        $sOption->description = $option['description'];
                        $sOption->survey_id = $this->model->id;
                        if (!($flag = $sOption->save())) {
                            $transaction->rollBack();
                            $this->addError('options', 'Data can not be saved');
                            break;
                        }
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    $this->setData([
                        'surveys_id' => $this->model->id
                    ]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
    }

}
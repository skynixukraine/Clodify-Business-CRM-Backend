<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "surveys_options".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $survey_id
 * @property integer $votes
 */
class SurveysOption extends \yii\db\ActiveRecord
{
    public $survayOptions = [];
    /**
     * Creates and populates a set of models.
     *
     * @param string $modelClass
     * @param array $multipleModels
     * @return array
     */
    public static function createMultiple($modelClass, $multipleModels = [])
    {
        $model    = new $modelClass;
        $formName = $model->formName();
        $post     = Yii::$app->request->post($formName);
        $models   = [];

        if (! empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                    $models[] = $multipleModels[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'surveys_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['survey_id', 'votes'], 'integer'],
            [['name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'survey_id' => 'Survey ID',
            'votes' => 'Votes',
        ];
    }
    public function getSurvay(){
        $this->hasOne(Surveys::className(),['survey_id'=>'id']);
    }
}

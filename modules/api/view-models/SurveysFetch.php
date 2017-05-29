<?php
/**
 * Created by Skynix Team
 * Date: 10.04.17
 * Time: 14:31
 */

namespace viewModel;

use Yii;
use app\models\Survey;
use app\components\DataTable;
use app\components\DateUtil;
use app\modules\api\components\SortHelper;

class SurveysFetch extends ViewModelAbstract
{
    public function define()
    {
        $order       = Yii::$app->request->getQueryParam('order', []);
        $keyword     = Yii::$app->request->getQueryParam('search_query');
        $start       = Yii::$app->request->getQueryParam('start') ? Yii::$app->request->getQueryParam('start') : 0;
        $limit       = Yii::$app->request->getQueryParam('limit') ? Yii::$app->request->getQueryParam('limit') : SortHelper::DEFAULT_LIMIT;

        $query = Survey::find()
            ->where(Survey::tableName() . '.is_delete != ' . Survey::IS_DELETE);

        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( $limit )
            ->setStart( $start )
            ->setSearchValue( $keyword )
            ->setSearchParams([ 'or',
                ['like', 'question', $keyword],
                ['like', 'shortcode', $keyword],
                ['like', 'description', $keyword],
            ]);

        if (!empty($keyword) && ($date = DateUtil::convertData($keyword)) !== $keyword) {
            $dataTable->setSearchParams([ 'or',
                ['like', 'date_start', $date],
                ['like', 'date_end', $date],
            ]);
        }
        if ($order) {
            foreach ($order as $name => $value) {
                $dataTable->setOrder(Survey::tableName() . '.' . $name, $value);
            }

        } else {
            $dataTable->setOrder( Survey::tableName() . '.id', 'asc');
        }

        $activeRecordsData = $dataTable->getData();

        $list = null;

        foreach ($activeRecordsData as $model) {
            $list[] = [
                'id' => $model->id,
                'shortcode' => $model->shortcode,
                'question' => $model->question,
                'date_start' => $model->date_start,
                'date_end' => $model->date_end,
                'is_private' => $model->is_private ? 'Yes' : 'No',
                'votes' => $model->total_votes
            ];
        }

        $data = [
            'surveys' => $list,
            'total_records' => DataTable::getInstance()->getTotal(),
        ];
        $this->setData($data);
    }

}
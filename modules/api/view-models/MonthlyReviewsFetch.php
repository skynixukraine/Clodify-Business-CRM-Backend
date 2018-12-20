<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 12/17/18
 * Time: 5:28 PM
 */

namespace viewModel;

use app\components\DataTable;
use app\components\DateUtil;
use app\models\Review;
use app\modules\api\components\Api\Processor;
use app\modules\api\components\SortHelper;
use Yii;
use app\models\User;

class MonthlyReviewsFetch extends ViewModelAbstract
{
    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES, User::ROLE_FIN, User::ROLE_PM, User::ROLE_DEV])) {

            $userId     = Yii::$app->request->getQueryParam('id');
            $start      = Yii::$app->request->getQueryParam('start', 0);
            $limit      = Yii::$app->request->getQueryParam('limit', SortHelper::DEFAULT_LIMIT);
            $order      = Yii::$app->request->getQueryParam('order', []);

            if ( User::hasPermission([User::ROLE_SALES, User::ROLE_FIN, User::ROLE_PM, User::ROLE_DEV]) ) {

                $userId = Yii::$app->user->id;

            }
            $query = Review::find();

            if ( $userId > 0 ) {

                $query->andWhere(['user_id' => $userId]);

            }

            $dataTable = DataTable::getInstance()
                ->setQuery($query)
                ->setLimit($limit)
                ->setStart($start);

            if ($order) {
                foreach ($order as $name => $value) {
                    $dataTable->setOrder(Review::tableName() . '.' . $name, $value);
                }

            } else {
                $dataTable->setOrder( Review::tableName() . '.id', 'asc');
            }


            $activeRecordsData = $dataTable->getData();
            $list = [];
            /** @var  $model Review */
            foreach ($activeRecordsData as $key => $model) {

                $user = $model->getUser()->one();
                $list[] = [
                    'id'        => $model->id,
                    'user'      => [
                        'id'            => $user->id,
                        'first_name'    => $user->first_name,
                        'last_name'     => $user->last_name
                    ],
                    'date_from'     => DateUtil::reConvertData( $model->date_from ),
                    'date_to'       => DateUtil::reConvertData( $model->date_to ),
                    'score_loyalty' => $model->score_loyalty,
                    'score_performance' => $model->score_performance,
                    'score_earnings'    => $model->score_earnings,
                    'score_total'       => $model->score_total,
                    'notes'             => $model->notes
                ];
            }
            $data = [
                'reviews' => $list,
                'total_records' => (int) DataTable::getInstance()->getTotal()
            ];
            $this->setData($data);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }
}
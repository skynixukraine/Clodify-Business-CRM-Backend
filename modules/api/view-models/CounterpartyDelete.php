<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 07.11.17
 * Time: 14:17
 */

namespace viewModel;

use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * Delete counterparties data. Accepts one GET param - id.
 * Class CounterpartyDelete
 * @package viewModel
 */
class CounterpartyDelete extends ViewModelAbstract
{

    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');

    }
}
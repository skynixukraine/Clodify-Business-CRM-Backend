<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11.03.17
 * Time: 19:11
 */

namespace viewModel;


use app\models\ProjectCustomer;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * Delete user data. Accepts one GET param - user id.
 * Class UserDelete
 * @package viewModel
 */
class UserDelete extends ViewModelAbstract
{
    /** @var \app\models\User */
    public $model;

    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');
        if ( ($model = User::findOne( $id )) && User::hasPermission([User::ROLE_ADMIN])) {
            $model->is_delete = 1;
            $model->save(true, ['is_delete']);

            $projectCustomer = ProjectCustomer::find()->where(['user_id' => $id])->all();
            //When we are deleting client, we should delete all relations between this customer and his projects
            if( $projectCustomer ) {
                foreach ($projectCustomer as $projectCustomerRelation) {
                    $projectCustomerRelation->delete();
                }
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no access for this action');
        }

    }
}
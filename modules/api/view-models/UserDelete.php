<?php
/**
 * Created by Skynix Team
 * Date: 11.03.17
 * Time: 19:11
 */

namespace viewModel;


use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
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
        // Run delete action only if user with requested ID exists and was not deleted.
        // Action available only for ADMIN role.
        if ( ($model = User::findOne( $id )) && User::hasPermission([User::ROLE_ADMIN]) && $model->is_delete == 0) {
            $model->is_delete = 1;
            $model->save(true, ['is_delete']);


            //When we are deleting client, we should delete all relations between this customer and his projects
            // Same with developers
            if( $projectCustomer = ProjectCustomer::find()->where(['user_id' => $id])->all() ) {
                foreach ($projectCustomer as $projectCustomerRelation) {
                    $projectCustomerRelation->delete();
                }

            } elseif ($projectDeveloper = ProjectDeveloper::find()->where(['user_id' => $id])->all()) {
                foreach ($projectDeveloper as $projectDeveloperRelation) {
                    $projectDeveloperRelation->delete();
                }
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no access for this action');
        }

    }
}
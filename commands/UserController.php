<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/26/18
 * Time: 11:45 PM
 */

namespace app\commands;

namespace app\commands;

use Yii;
use app\models\User;
use yii\console\Controller;
use app\components\CrowdComponent;

class UserController extends Controller
{
    /**
     * Sync crowd groups
     */
    public function actionSync()
    {
        $users = User::find()->where(['auth_type'   => User::CROWD_AUTH, 'is_delete' => 0])->all();
        /** @var  $user User */
        foreach ( $users as $user ) {

            if (($response = CrowdComponent::refToGroupInCrowd( $user->email )) ) {

                $role       = $response['role'];
                $success    = $response['success'];
                $code       = $response['code'];

                if ( $success === true && $role != null ) {

                    $user->role         = $role;
                    $user->is_active    = 1;
                    $user->save(false, ['role', 'is_active']);

                } elseif ( $success === true && $role === null ) {

                    $user->role         = User::ROLE_GUEST;
                    $user->is_active    = 0;
                    $user->save(false, ['role', 'is_active']);

                } elseif ( $code === CrowdComponent::CODE_NOT_FOUND ) {
                    //User does not exist, delete it from CRM
                    $user->role         = User::ROLE_GUEST;
                    $user->is_active    = 0;
                    $user->is_delete    = 1;
                    $params[]           = 'is_active';
                    $params[]           = 'is_delete';
                    $user->save(false, ['role', 'is_active', 'is_delete']);

                }

            }

        }
    }
}
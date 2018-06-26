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
        $users = User::find()->where(['auth_type'   => User::CROWD_AUTH])->all();
        /** @var  $user User */
        foreach ( $users as $user ) {

            if (($role = CrowdComponent::refToGroupInCrowd( $user->email )) ) {

                $user->role = $role;
                $user->save(false, ['role']);

            }

        }
    }
}
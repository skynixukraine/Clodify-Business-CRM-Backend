<?php
/**
 *  Created by SkynixTeam.
 *  User: Oleg
 *  Date: 15.08.17
 *  Time: 13:24
 */

namespace viewModel;

use app\models\Business;
use app\models\User;

/**
 *  Class BusinessCreate
 *  @see https://jira.skynix.co/browse/SCA-232
 *  @package viewModel
 */
class BusinessCreate extends ViewModelAbstract
{
    public function define() {
        if (User::hasPermission([User::ROLE_ADMIN])) {

        }
    }
}

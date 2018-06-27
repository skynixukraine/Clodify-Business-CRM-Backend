<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/27/18
 * Time: 10:11 AM
 */

namespace viewModel;


use app\models\Setting;

class SSOFetch extends ViewModelAbstract
{
    public function define()
    {
        $this->setData([
            'name'  => Setting::getSSOCookieDomain()
        ]);
    }

}
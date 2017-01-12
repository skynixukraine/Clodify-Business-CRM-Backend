<?php
/**
 * Created by Skynix Team
 * Date: 8/6/16
 * Time: 13:27
 */

namespace app\modules\api\components\ApiProcessor;


interface ApiProcessorAccessInterface
{
    public function getMethods();
    public function shouldCheckAccess();
}
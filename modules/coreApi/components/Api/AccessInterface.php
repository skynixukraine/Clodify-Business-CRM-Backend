<?php
/**
 * Created by Skynix Team
 * Date: 12/17/16
 * Time: 07:28
 */
namespace app\modules\coreApi\components\Api;


interface AccessInterface
{
    public function getMethods();
    public function shouldCheckAccess();
}
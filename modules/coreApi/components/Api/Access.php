<?php
/**
 * Created by Skynix Team
 * Date: 12/17/16
 * Time: 07:29
 */
namespace app\modules\coreApi\components\Api;

class Access implements AccessInterface
{

    public $methods;
    public $checkAccess;

    public function __construct(){}

    /**
     * @return mixed
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @return mixed
     */
    public function shouldCheckAccess()
    {
        return $this->checkAccess;
    }
}
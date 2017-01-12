<?php
/**
 * Created by Skynix Team
 * Date: 8/6/16
 * Time: 13:04
 */

namespace app\modules\api\components\ApiProcessor;


class ApiProcessorAccess implements ApiProcessorAccessInterface
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
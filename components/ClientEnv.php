<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/22/18
 * Time: 5:55 PM
 */

namespace app\components;

use Yii;
use app\models\Storage;

class ClientEnv
{
    const DOMAIN_DEVELOP = 'develop.core.api.skynix.co';
    const DOMAIN_STAGING = 'staging.core.api.skynix.co';
    const DOMAIN_PRODUCT = 'core.api.skynix.co';

    const DOMAIN_TEST_API   = 'test.skynix-llc.api.skynix.co';
    const DOMAIN_TEST_CORE = 'test.core.api.skynix.co';

    const ENV_TEST      = "test";
    const ENV_DEVELOP   = "develop";
    const ENV_STAGING   = "staging";


    /**
     * @var mixed
     */
    private $host;
    /**
     * @var mixed
     */
    private $s3Folder;
    /**
     * @var
     */
    private $dbPrefix;
    /**
     * @var
     */
    private $clientDomain;
    /**
     * @var bool
     */
    private $isCore = false;
    /**
     * @var bool
     */
    private $isTest = false;

    /**
     * @var string
     */
    private $env    = "";

    /**
     * ClientEnv constructor.
     */
    public function __construct()
    {
        $this->host = parse_url(\Yii::$app->request->getAbsoluteUrl(), PHP_URL_HOST);
        switch ( $this->host ) {

            case self::DOMAIN_TEST_API :
            case self::DOMAIN_TEST_CORE :
                //DO NOTHING FOR TESTS (uses databases from ymls)
                $this->s3Folder = self::ENV_TEST;
                $this->dbPrefix = Yii::$app->params['testDatabasePrefix'];
                $this->isTest   = true;
                $this->env      = self::ENV_TEST;
                break;
            case self::DOMAIN_DEVELOP :
                $this->env      = self::ENV_DEVELOP;
            case self::DOMAIN_STAGING :
                $this->env      = self::ENV_STAGING;
            case self::DOMAIN_PRODUCT :
                //DO NOTHING FOR CORE
                $this->s3Folder = "core";
                $this->isCore   = true;
                break;
            default :

                if ( strstr($this->host, self::ENV_DEVELOP ) !== false ) {

                    $this->env = self::ENV_DEVELOP;

                } else if (strstr($this->host, self::ENV_STAGING ) !== false ) {

                    $this->env = self::ENV_STAGING;

                }
                $this->s3Folder =
                    $this->clientDomain = str_replace(
                        "-",
                        "_",
                        str_replace(['.api.skynix.co', (!empty($this->env) ? $this->env . "." : "")],
                            '',
                            $this->host)
                    );

                break;
        }
        Storage::$folder = $this->s3Folder;
    }

    /**
     * @return bool
     */
    public function isCore()
    {
        return $this->isCore;
    }

    /**
     * @return bool
     */
    public function isTest()
    {
        return $this->isTest;
    }

    /**
     * @return mixed
     */
    public function getClientDomain()
    {
        return $this->clientDomain;
    }

    /**
     * @return string
     */
    public function getEnv()
    {
        return $this->env;
    }
}
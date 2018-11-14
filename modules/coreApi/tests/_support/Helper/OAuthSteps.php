<?php
namespace Helper;
use app\models\Setting;
use app\models\CoreClient;

class OAuthKey
{
    public static $key;
}

class OAuthSteps extends \FunctionalTester
{

    /**
     * This class uses public Login method from http://confluence.skynix.co:8090/pages/viewpage.action?spaceKey=SKYN&title=Skynix+CRM+-+RESTful+API+Specification#SkynixCRM-RESTfulAPISpecification-1.1LoginMethod
     *
     */
    public function login()
    {

        $I = $this;

        $clientId = Setting::getClientId();
        $client = CoreClient::findOne($clientId);
        $accessKey = Setting::getClientAccessKey();

        codecept_debug("Logged In As " . $client->email);

        OAuthKey::$key = $accessKey;

        $I->haveHttpHeader('skynix-access-key', OAuthKey::$key);
    }

}
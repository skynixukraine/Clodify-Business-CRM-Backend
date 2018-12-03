<?php
namespace Helper;
use app\models\CoreClientKey;
use app\models\Setting;
use app\models\CoreClient;

class OAuthKey
{
    public static $key;
}

class OAuthSteps extends \FunctionalTester
{

    /**
     * @param $clientId
     */
    public function login($clientId)
    {

        $I = $this;

        $client = CoreClient::findOne($clientId);

        $accessKey = CoreClientKey::findOne(['id' => $clientId]);

        codecept_debug("Logged In As " . $client->email);

        OAuthKey::$key = $accessKey;

        $I->haveHttpHeader('skynix-access-key', OAuthKey::$key);
    }

}
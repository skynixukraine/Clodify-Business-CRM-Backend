<?php
namespace Helper;
use app\modules\coreApi\components\Processor;

class OAuthToken
{
    public static $key;
}

class OAuthSteps extends \FunctionalTester
{

    /**
     * This class uses public Login method from http://confluence.skynix.co:8090/pages/viewpage.action?spaceKey=SKYN&title=Skynix+CRM+-+RESTful+API+Specification#SkynixCRM-RESTfulAPISpecification-1.1LoginMethod
     *
     * @param $email
     * @param $password
     */
    public function login($email = 'crm-admin@skynix.co', $password = 'B19E$d4n$yc@Lu6fQIO#1d')
    {
        $I = $this;
        //Request Access Token using simple auth
        $I->sendPOST('/api/auth', json_encode([
            'email'  => $email,
            'password'  => $password
        ]));
        $I->seeResponseCodeIs(200);

        $I->seeResponseMatchesJsonType([
            'data' => [
                'access_token'   => 'string',
                'user_id'		 => 'integer',
                'role'           => 'string'
            ]
        ]);
        $response  = json_decode($I->grabResponse());
        codecept_debug("Logged In As " . $email);
        $accessToken = $response->data->access_token;
        OAuthToken::$key = $accessToken;

        $I->haveHttpHeader('skynix-access-token', OAuthToken::$key);
    }

}
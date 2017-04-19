<?php
namespace Helper;
use app\modules\api\components\Processor;

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
    public function login($email = "maryt@skynix.co", $password = "admin")
    {
        $I = $this;
        if ( !OAuthToken::$key ) {
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
            $accessToken = $response->data->access_token;
            codecept_debug($accessToken);
            OAuthToken::$key = $accessToken;
        }
        $I->haveHttpHeader('skynix-access-token', OAuthToken::$key);
    }

}
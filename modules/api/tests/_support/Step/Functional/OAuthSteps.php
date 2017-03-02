<?php
namespace api\Step\Functional;

use app\modules\api\components\Api\Processor;

class OAuthToken
{
	public static $key;
}

class OAuthSteps extends \api\FunctionalTester
{

	/**
	 * https://feinternational.atlassian.net/wiki/display/API/API+Documentation%2C+version+0.9.0?focusedCommentId=42270797#APIDocumentation,version0.9.0-1oAuth2Authorization
	 *
	 * @param $name
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
				'access_token'  => 'string',
				'user_id'       => 'integer'
			]);
			$accessToken = $I->grabDataFromResponseByJsonPath('access_token');

			codecept_debug( $accessToken );
			//If get the accessToken we are adding it to all further headers

			OAuthToken::$key = $accessToken[0];
		}
		$I->haveHttpHeader(Processor::HEADER_ACCESS_TOKEN, OAuthToken::$key);
	}

}
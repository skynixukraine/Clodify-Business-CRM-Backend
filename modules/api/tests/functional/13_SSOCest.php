<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/27/18
 * Time: 9:55 AM
 */

use Helper\ValuesContainer;
use Helper\ApiEndpoints;

class SSOCest
{
    private $ownReportId;
    private $newTask;
    private $userId;
    private $notOwnReportId;

    public function testFetchSSOCookieDomainConfig(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Test that SSO config is available');

        $I->sendGET(ApiEndpoints::SSO_CONFIG );
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->assertNotEmpty($response->data->name);

    }

    public function testSSOCookieCheck(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Test that a fake SSO token checked and returned errors');

        $I->sendPOST(ApiEndpoints::SSO_TOKEN_CHECK, json_encode([
            'token' => 'CDHJCIHDIUBCHJBDSC768' //Invalid Token
        ]) );
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);


        $I->wantTo('Test that a valid SSO token passed, create a new user account and returned success');

        $I->sendPOST(ApiEndpoints::SSO_TOKEN_CHECK, json_encode([
            'token' => 'D00000001230000123' //Valid Token
        ]) );
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'access_token' => 'string',
                'user_id'       => 'integer',
                'role'          => 'string',
                'crowd_token'   => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);


        $I->wantTo('Test that a valid SSO token passed, existing user authorized and returned success');

        $I->sendPOST(ApiEndpoints::SSO_TOKEN_CHECK, json_encode([
            'token' => 'D00000001230000124' //Valid Token
        ]) );
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'access_token' => 'string',
                'user_id'       => 'integer',
                'role'          => 'string',
                'crowd_token'   => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);

    }

}
<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/7/18
 * Time: 6:00 PM
 */

use Helper\ValuesContainer;
use Helper\OAuthSteps;
use Helper\ApiEndpoints;

class ClientCest
{
    public function createClientTest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->sendPOST(ApiEndpoints::CLIENTS, json_encode(
            [

                "domain"        => "synpass-agency",
                "name"          => "Synpass LLC Test Agency",
                "first_name"    => "John",
                "last_name"     => "Doe",
                "email"         => "agency@synpass.pro"

            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

    }


    /**
     * @see    https://jira-v2.skynix.company/browse/SCA-283
     * @param FunctionalTester $I
     */
    public function updateClientTest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('update client method test');
        $I->sendPUT(ApiEndpoints::CLIENTS . '/' . ValuesContainer::$clientId,json_encode(ValuesContainer::$userClient));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [],
            'errors' => [],
            'success' => 'boolean'
        ]);

    }

    /**
     * @see https://jira.skynix.co/browse/SCA-283
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function updateClientForbiddenNotAuthorizedTest(FunctionalTester $I)
    {

        \Helper\OAuthToken::$key = null;

        $I->wantTo('update client forbidden for not authorized test');
        $I->sendPUT(ApiEndpoints::CLIENTS . '/' . ValuesContainer::$clientId,json_encode(ValuesContainer::$userClient));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [
                "param" => "error",
                "message" => "You are not authorized to access this action"
            ],
            "success" => false
        ]);


    }





    /**
     * @see https://jira.skynix.co/browse/SCA-234
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateBusinessAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('test update business  is successful for ADMIN');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPUT('/api/businesses/' . ValuesContainer::$BusinessId, json_encode(ValuesContainer::$updateBusinessData));

        \Helper\OAuthToken::$key = null;
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'name' => 'string',
                'director_id' => 'integer',
                'address' => 'string',
                'is_default' => 'boolean|integer'
            ],
            'errors' => [],
            'success' => 'boolean'
        ]);

    }


    /**
     * @see https://jira.skynix.co/browse/SCA-234
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateBusinessForbiddenNotAuthorized(FunctionalTester $I)
    {
        \Helper\OAuthToken::$key = null;

        $I->wantTo('test update business is not allowed for not authorized');


        $I->sendPUT('/api/businesses/' . ValuesContainer::$BusinessId, json_encode(ValuesContainer::$updateBusinessData));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [
                "param" => "error",
                "message" => "You are not authorized to access this action"
            ],
            "success" => false
        ]);

    }
}
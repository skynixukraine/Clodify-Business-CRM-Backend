<?php
/**
 * Create By Skynix Team
 * Author: Oleg
 * Date: 11/7/18
 * Time: 6:00 PM
 */

use Helper\ValuesContainer;
use Helper\OAuthSteps;
use Helper\ApiEndpoints;

class ClientOrderCest
{

    /**
     * @see    https://jira-v2.skynix.company/browse/SCA-285
     * @param FunctionalTester $I
     */
    public function updateClientOrderTest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$clientId);

        $I->wantTo('testing update client order data');
        $I->sendPUT(ApiEndpoints::CLIENTS . '/' . ValuesContainer::$clientId . '/orders/' . ValuesContainer::$clientOrderId, json_encode(ValuesContainer::$coreClientOrderData));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [[]],
            'errors' => [],
            'success' => 'boolean'
        ]);

    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SCA-285
     * @param FunctionalTester $I
     */
    public function updateClientNotExistOrderTest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$clientId);

        $I->wantTo('testing update client order data');
        $I->sendPUT(ApiEndpoints::CLIENTS . '/' . ValuesContainer::$clientNotExistsId . '/orders/' . ValuesContainer::$clientOrderId, json_encode(ValuesContainer::$coreClientOrderData));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [
                "param" => "error",
                "message" => "The action is not allowed for you"
            ],
            "success" => false
        ]);

    }

    /**
     * @see https://jira.skynix.co/browse/SCA-285
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function updateClientOrderNotAuthorizedTest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$clientId);

        $I->wantTo('testing update client order not authorized data');
        $I->sendPUT(ApiEndpoints::CLIENTS . '/' . ValuesContainer::$clientId . '/orders/' . ValuesContainer::$clientOrderId, json_encode(ValuesContainer::$coreClientOrderData));
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


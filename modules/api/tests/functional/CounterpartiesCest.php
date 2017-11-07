<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 07.11.17
 * Time: 10:00
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

/**
 * Class CounterpartiesCest
 */
class CounterpartiesCest
{
    private $counterpartyId;

    /**
     * @see    https://jira.skynix.company/browse/SCA-43
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCounterpartyCreation(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPOST(ApiEndpoints::COUNTERPARTY, json_encode([
            "name" => "Project"
        ]));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $counterpartyId = $response->data->counterparty_id;
        $this->counterpartyId = $counterpartyId;
        codecept_debug($counterpartyId);
    }

    /**
     * @see    https://jira.skynix.company/browse/SCA-43
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCounterpartyCreationWithoutName(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPOST(ApiEndpoints::COUNTERPARTY);
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->seeResponseContainsJson([
            "data"   => null,
            "errors" => [
                "param"   => "error",
                "message" => "You have to provide name of the counterparty"
            ],
            "success" => false
        ]);
    }
}
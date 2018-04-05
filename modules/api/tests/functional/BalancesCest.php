
<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 05.04.18
 * Time: 11:41
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

/**
 * Class BalancesCest
 */
class BalancesCest
{

    /**
     * @see    https://jira.skynix.company/browse/SCA-111
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchBalance(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch balance');
        $I->sendGET(ApiEndpoints::FETCH_BALANCE ."?business_id=" . ValuesContainer::$BusinessID . "&from_date=". ValuesContainer::$unix);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['references' => 'array',

                'total_records' => 'integer'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**@see https://jira.skynix.co/browse/SCA-111
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFetchBalanceWithoutBusinessId(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create new operation');
        $I->sendGET(ApiEndpoints::FETCH_BALANCE);
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [
                "param" => "error",
                "message" => "You should provide business_id"
            ],
            "success" => false
        ]);
    }
}
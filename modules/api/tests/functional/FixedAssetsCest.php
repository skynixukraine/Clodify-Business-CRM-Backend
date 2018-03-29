<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 29.03.18
 * Time: 15:10
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

/**
 * Class FixedAssetsCest
 */
class FixedAssetsCest
{

    /**@see https://jira.skynix.co/browse/SCA-110
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFetchFixedAsset(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create new operation');
        $I->sendGET(ApiEndpoints::FETCH_FIXED_ASSETS ."?business_id=" . ValuesContainer::$BusinessID);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'data'    => [
                    'fixed_assets' => 'array',
                ],
                'errors'  => 'array',
                'success' => 'boolean'
            ]
        );
    }

    /**@see https://jira.skynix.co/browse/SCA-110
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFetchFixedAssetWithoutBusinessId(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create new operation');
        $I->sendGET(ApiEndpoints::FETCH_FIXED_ASSETS);
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
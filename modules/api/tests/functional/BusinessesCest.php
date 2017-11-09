<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 08.11.17
 * Time: 12:03
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;

/**
 * Class BusinessesCest
 */
class BusinessesCest
{
    /**
     * @see    https://jira.skynix.company/browse/SCA-54
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchBusinessesCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch counterparties data');
        $I->sendGET(ApiEndpoints::BUSINESS);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['businesses' =>
                [
                    [
                        'id' => 'integer',
                        'name' => 'string',
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }
}
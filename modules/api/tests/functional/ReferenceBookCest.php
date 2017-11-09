<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 09.11.17
 * Time: 9:43
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;

/**
 * Class ReferenceBookCest
 */
class ReferenceBookCest
{
    private $finacialReportId;

    /**
     * @param \Codeception\Scenario $scenario
     */
    public function _before(\Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
    }

    /**
     * @see    https://jira.skynix.company/browse/SCA-51
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchReferenceBookCest(FunctionalTester $I)
    {

        $I->wantTo('Testing fetch financial report data');
        $I->sendGET(ApiEndpoints::REFERENCE_BOOK);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['references' =>
                [
                    [
                        'id' => 'integer',
                        'name' => 'string',
                        'code' => 'integer',
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }
}
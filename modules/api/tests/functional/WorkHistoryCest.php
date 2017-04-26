<?php
/**
 * Created by Skynix Team
 * Date: 19.04.17
 * Time: 18:46
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

class WorkHistoryCest
{
    /**
     * @see    https://jira-v2.skynix.company/browse/SI-850
     * @param  FunctionalTester $I
     */
    public function testViewWorkHisrtoryCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing view work history data');
        $I->sendGET(ApiEndpoints::USERS . '/' . ValuesContainer::$userSlug . '/work-history');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['workHistory' =>
                [
                    [
                        'id' => 'integer',
                        'date_start' => 'string',
                        'date_end' => 'string',
                        'type' => 'string',
                        'title' => 'string',
                    ]
                ]
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

}
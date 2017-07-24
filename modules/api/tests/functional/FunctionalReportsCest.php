<?php
/**
 * Created by Skynix Team
 * Date: 21.07.17
 * Time: 17:16
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;

/**
 * Class FunctionalReportsCest
 *
 * @see    https://jira-v2.skynix.company/browse/SI-1022
 * @author Oleksii Griban (Skynix)
 */
class FunctionalReportsCest
{
    /**
     * @see    https://jira-v2.skynix.company/browse/SI-972
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCreateFunctionalReportCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create functional reports');
        $I->sendPOST(ApiEndpoints::FUNCTIONAL_REPORT, json_encode(
            [
                'report_date' => '2019-02-03'
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'data'    => [
                    'report_id' => 'integer',
                ],
                'errors'  => 'array',
                'success' => 'boolean'
            ]
        );
    }
}
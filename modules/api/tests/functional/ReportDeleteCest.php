<?php
use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Yii;

/**
 * Class ReportDeleteCest
 * Test the removing of report by id
 * Only authorized users can perform this action
 */
class ReportDeleteCest
{
    /**
     * @see    http://jira.skynix.company:8070/browse/SI-840
     * @param  FunctionalTester      $I
     * @return void
     */
    public function deleteReports(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $reportId = 1;
        $I->sendDELETE(ApiEndpoints::REPORT . '/'. $reportId);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        //Not authorize to do this action
        $I->assertNotEmpty($response->errors);

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
        $I->sendDELETE(ApiEndpoints::REPORT . '/'. $reportId);
        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson([
            "data"      => [],
            "errors"    => [],
            "success"   => true
        ]);
        $response = json_decode($I->grabResponse());
        codecept_debug($response->errors);
        $I->assertEmpty($response->errors);
        $I->assertEquals(1, $response->success);
    }
}
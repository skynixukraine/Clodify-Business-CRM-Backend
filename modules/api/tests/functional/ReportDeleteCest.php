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
     * @param  FunctionalTester $I
     * @return void
     */
    public function deleteReports(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $ownReportId = 1;
        $I->sendDELETE(ApiEndpoints::REPORT . '/' . $ownReportId);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        //Not authorize to do this action
        $I->assertNotEmpty($response->errors);

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
        $userId = json_decode($I->grabResponse())->data->user_id;

        //Try to delete not own report
        $I->sendGET(ApiEndpoints::REPORT, [
            'from_date' => date('Y-m-d', strtotime('-1 year')),
            'to_date' => date('Y-m-d')
        ]);

        $response = json_decode($I->grabResponse());
        $reports = $response->data->reports;

        $notOwnReportId = 0;
        foreach ($reports as $report) {
            if (($report->reporter->id != $userId) && ($report->is_invoiced == 0)) {
                $notOwnReportId  = $report->report_id;
            }
        }

        $I->sendDELETE(ApiEndpoints::REPORT . '/'. $notOwnReportId);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);

        $I->seeResponseContainsJson([
            "data"   => [],
            "errors" => [
                "param"   => "error",
                "message" => "You can delete only own reports"
            ],
            "success" => false
        ]);

        $I->sendDELETE(ApiEndpoints::REPORT . '/'. $ownReportId);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->seeResponseContainsJson([
            "data"      => [],
            "errors"    => [],
            "success"   => true
        ]);
        $I->assertEmpty($response->errors);
        $I->assertEquals(1, $response->success);
    }
}
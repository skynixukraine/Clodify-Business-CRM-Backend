<?php

use Helper\ApiEndpoints;
use Helper\OAuthSteps;

class ReportCreateCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }


    /**
     * @see    http://jira.skynix.company:8070/browse/SI-837
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCreateReport(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        define('project_id', 10);
        define('date_report', '05/03/2017');
        define('hours', 2);
        define('task', 'task description, task description, task description');

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPOST(ApiEndpoints::REPORT, json_encode([
            'project_id'    => project_id,
            'task'          => task,
            'hours'         => hours,
            'date_report'   => date_report
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data'   => [
                'report_id'   => 'integer'
            ],
            'errors' => 'array',
            'success'=> 'boolean'
        ]);

    }
}

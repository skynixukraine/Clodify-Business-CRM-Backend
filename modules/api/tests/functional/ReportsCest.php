<?php
use Helper\ApiEndpoints;
use Helper\OAuthSteps;
use Yii;
/**
 * Created by Skynix Team
 * Date: 09.03.17
 * Time: 12:15
 */
class ReportsCest
{
    public function testReports(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        /* 2.1.1 Create Report Data
         * @see    http://jira.skynix.company:8070/browse/SI-837
         */
        define('project_id', 1);
        define('date_report', str_replace('-', '/', date('d-m-Y')));
        define('hours', 2);
        define('task', 'task description, task description, task description');

        $I->wantTo('Create report without authorization');
        //Try to create report without authorization
        $I->sendPOST(ApiEndpoints::REPORT, json_encode([
            'project_id' => project_id,
            'task' => task,
            'hours' => hours,
            'date_report' => date_report
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
        $userId = json_decode($I->grabResponse())->data->user_id;


        /**
         * 2.1.1 Create Report Data
         *  @see    http://jira.skynix.company:8070/browse/SI-837
         */
        $I->wantTo('Create report with authorization');

        $I->sendPOST(ApiEndpoints::REPORT, json_encode([
            'project_id' => project_id,
            'task' => task,
            'hours' => hours,
            'date_report' => date_report
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'report_id' => 'integer'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        $ownReportId = $response->data->report_id;
        /*2.1.3 Fetch Reports Data
        * @see  http://jira.skynix.company:8070/browse/SI-824
        * Check if  data was created
       */
        $I->wantTo('Check if report was created with using fetch method');
        $I->sendGET(ApiEndpoints::REPORT, [
            'limit'   => 1
        ]);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'reports'       => 'array',
                "total_records" => 'string',
                "total_hours"   => 'string',
                "total_cost"    => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        $I->seeResponseContainsJson([
            'data' =>
                [
                    'reports' => [
                        'report_id' =>$ownReportId,
                        'task'      => task
                    ],

                ]
        ]);

        /*
         * 2.1.2 Edit Report Data
         * http://jira.skynix.company:8070/browse/SI-865
         */
        $I->wantTo('Edit previously created report');
        $newTask  = task . 'NEW';
        $newHours = hours + 1;

        $I->sendPUT(ApiEndpoints::REPORT . '/'.$ownReportId, json_encode([
            'task' => $newTask,
            'hours' => $newHours
        ]));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);

        /*2.1.3 Fetch Reports Data
        * @see  http://jira.skynix.company:8070/browse/SI-824
         * Check if  data was updated
        */
        $I->wantTo('Check if report was updated with using fetch method');
        $I->sendGET(ApiEndpoints::REPORT, [
            'limit'   => 1
        ]);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'reports'       => 'array',
                "total_records" => 'string',
                "total_hours"   => 'string',
                "total_cost"    => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        $I->seeResponseContainsJson([
            'data' =>
                [
                    'reports' => [
                        'report_id' =>$ownReportId,
                        'task'      => $newTask
                    ],

                ]
        ]);

        //Try to get id of not own report by using fetch method
        $I->wantTo('Get not own id of report');
        $I->sendGET(ApiEndpoints::REPORT, [
            'from_date' => date('Y-m-d', strtotime('-1 year')),
            'to_date' => date('Y-m-d')
        ]);

        $response = json_decode($I->grabResponse());
        $reports = $response->data->reports;
        //Get not own report id from all reports
        $notOwnReportId = 0;
        foreach ($reports as $report) {
            if (($report->reporter->id != $userId) && ($report->is_invoiced == 0)) {
                $notOwnReportId  = $report->report_id;
            }
        }
        /*2.1.4 Delete Reports Data
         * @see   http://jira.skynix.company:8070/browse/SI-840
         *
         */
        $I->wantTo('Delete not own report');
        //Try to delete not own report
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
        $I->wantTo('Delete previously created report');
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

        //Check if data was deleted
        /*2.1.3 Fetch Reports Data
       * @see  http://jira.skynix.company:8070/browse/SI-824
        * Check if  data was deleted
       */
        $I->wantTo('Check if previously created report was deleted');
        $I->sendGET(ApiEndpoints::REPORT, [
            'limit'   => 1
        ]);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'reports'       => 'array',
                "total_records" => 'string',
                "total_hours"   => 'string',
                "total_cost"    => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        $I->cantseeResponseContainsJson([
            'data' =>
                [
                    'reports' => [
                        'report_id' =>$ownReportId,
                        'task'      => $newTask
                    ],

                ]
        ]);


        /*
         * 2.1.5 Report DatePeriod List
         * @see  http://jira.skynix.company:8070/browse/SI-841
         *
         */
        $I->wantTo('Get list with date periods for report');
        $I->sendGET(ApiEndpoints::REPORT . '/date-period');
        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson([
            "data" => [
                [
                    "id" => 1,
                    "date_period" => "Today's reports"
                ],
                [
                    "id" => 2,
                    "date_period" => "This week reports"
                ],
                [
                    "id" => 3,
                    "date_period" => "This month reports"
                ],
                [
                    "id" => 4,
                    "date_period" => "Last month reports"
                ],
            ]
        ]);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(1, $response->success);
    }

}
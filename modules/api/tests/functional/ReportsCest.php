<?php
use Helper\ApiEndpoints;
use Helper\OAuthSteps;
/**
 * Created by Skynix Team
 * Date: 09.03.17
 * Time: 12:15
 */

use Helper\ValuesContainer;

class ReportsCest
{
    private $ownReportId;
    private $newTask;
    private $userId;
    private $notOwnReportId;



    /* 2.1.1 Create Report Data
     * @see    http://jira.skynix.company:8070/browse/SI-837
     */
    public function testCreateWithotAuthReports(FunctionalTester $I)
    {
        define('DATE_REPORT', date('d/m/Y'));
        define('HOURS', 2);
        define('TASK', 'task description, task description, task description');

        $I->wantTo('Create report without authorization');

        //Try to create report without authorization
        $I->sendPOST(ApiEndpoints::REPORT, json_encode([
            'project_id' => ValuesContainer::$projectId,
            'task' => TASK,
            'hours' => HOURS,
            'date_report' => DATE_REPORT
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $this->userId = ValuesContainer::$userId;

    }

    /**
     * 2.1.1 Create Report Data
     * @see    http://jira.skynix.company:8070/browse/SI-837
     */
    public function testCreateWithAuthReports(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Create report with authorization');

        $I->sendPOST(ApiEndpoints::REPORT, json_encode([
            'project_id' => ValuesContainer::$projectId,
            'task' => TASK,
            'hours' => HOURS,
            'date_report' => DATE_REPORT
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
        $this->ownReportId = $response->data->report_id;

    }

    /*2.1.3 Fetch Reports Data
    * @see  http://jira.skynix.company:8070/browse/SI-824
    * Check if  data was created
    */
    public function testCheckForCreateReports(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Check if report was created with using fetch method');
        $I->sendGET(ApiEndpoints::REPORT, [
            'limit' => 1
        ]);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'reports' => 'array',
                "total_records" => 'string',
                "total_hours" => 'string',
                "total_cost" => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        $I->seeResponseContainsJson([
            'data' =>
                [
                    'reports' => [
                        'report_id' => $this->ownReportId,
                        'task' => TASK
                    ],

                ]
        ]);
    }

    /**
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFetchReports(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch reports data');
        $I->sendGET(ApiEndpoints::REPORT);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['reports' =>
                [
                    [
                        'report_id' => 'integer',
                        'project' => [
                            'id' => 'integer',
                            'name' => 'string'
                        ],
                        'created_date' => 'string',
                        'task' => 'string',
                        'hour' => 'string',
                        'cost' => 'string',
                        'is_approved' => 'boolean',
                        'reporter' => [
                            'id' => 'integer',
                            'name' => 'string'
                        ],
                        'reported_date' => 'string',
                        'is_invoiced' => 'integer'
                    ]
                ],
                'total_records' => 'string',
                'total_hours' => 'string',
                'total_cost' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }


    /*
    * 2.1.2 Edit Report Data
    * http://jira.skynix.company:8070/browse/SI-865
    */
    public function testEditReports(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Edit previously created report');
        $this->newTask = TASK . 'NEW';
        $newHours = HOURS + 1;

        $I->sendPUT(ApiEndpoints::REPORT . '/' . $this->ownReportId, json_encode([
            'task' => $this->newTask,
            'hours' => $newHours
        ]));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);

    }


    /*2.1.3 Fetch Reports Data
    * @see  http://jira.skynix.company:8070/browse/SI-824
     * Check if  data was updated
    */
    public function testCheckForEditCreatedReports(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Check if report was updated with using fetch method');
        $I->sendGET(ApiEndpoints::REPORT, [
            'limit' => 1
        ]);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'reports' => 'array',
                "total_records" => 'string',
                "total_hours" => 'string',
                "total_cost" => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        $I->seeResponseContainsJson([
            'data' =>
                [
                    'reports' => [
                        'report_id' => $this->ownReportId,
                        'task' => $this->newTask
                    ],

                ]
        ]);

    }

    //Try to get id of not own report by using fetch method
    public function testGetNotOwnReports(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Get not own id of report');
        $I->sendGET(ApiEndpoints::REPORT, [
            'from_date' => date('Y-m-d', strtotime('-1 year')),
            'to_date' => date('Y-m-d')
        ]);

        $response = json_decode($I->grabResponse());
        $reports = $response->data->reports;
        //Get not own report id from all reports
        $this->notOwnReportId = ValuesContainer::$deleteReportId;
        foreach ($reports as $report) {
            if (($report->reporter->id != $this->userId) && ($report->is_invoiced == 0)) {
                $this->notOwnReportId = $report->report_id;
            }
        }
    }


    /*2.1.4 Delete Reports Data
     * @see   http://jira.skynix.company:8070/browse/SI-840
     *
     */
    public function testDeleteNotOwnReport(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Delete not own report');
        //Try to delete not own report
        $I->sendDELETE(ApiEndpoints::REPORT . '/' . $this->notOwnReportId);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);

        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [
                "param" => "error",
                "message" => "You can delete only own reports"
            ],
            "success" => false
        ]);
        $I->wantTo('Delete previously created report');
        $I->sendDELETE(ApiEndpoints::REPORT . '/' . $this->ownReportId);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [],
            "success" => true
        ]);
        $I->assertEmpty($response->errors);
        $I->assertEquals(1, $response->success);
    }

    //Check if data was deleted
    /*2.1.3 Fetch Reports Data
   * @see  http://jira.skynix.company:8070/browse/SI-824
    * Check if  data was deleted
   */
    public function testCheckForDeletePrevReport(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Check if previously created report was deleted');
        $I->sendGET(ApiEndpoints::REPORT, [
            'limit' => 1
        ]);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'reports' => 'array',
                "total_records" => 'string',
                "total_hours" => 'string',
                "total_cost" => 'string|integer'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        $I->cantSeeResponseContainsJson([
            'data' =>
                [
                    'reports' => [
                        'report_id' => $this->ownReportId,
                        'task' => $this->newTask
                    ],

                ]
        ]);

    }

    /*
     * 2.1.5 Report DatePeriod List
     * @see  http://jira.skynix.company:8070/browse/SI-841
     *
     */
    public function testGetListPeriodsReport(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

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

    /**
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFetchReportsForClient(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $userId = $I->haveInDatabase('users', array(
            'first_name' => 'clientUsers',
            'last_name' => 'clientSNUsers',
            'email' => 'clientUser@email.com',
            'role' => 'CLIENT',
            'password' => md5('client')
        ));

        $projectId = $I->haveInDatabase('projects', array(
            'name' => 'Hello World!'
        ));

        $I->haveInDatabase('reports', array(
            'user_id' => $userId,
            'project_id' => $projectId,
            'date_added' => '2017-03-09',
            'task' => 'bla task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null,
            'is_approved' => 1
        ));

        $I->haveInDatabase('project_customers', array(
            'user_id' => $userId,
            'project_id' => $projectId
        ));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login("clientUser@email.com", "client");

        $I->wantTo('Testing fetch reports data');
        $I->sendGET(ApiEndpoints::REPORT);

        \Helper\OAuthToken::$key = null;

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['reports' =>
                [
                    [
                        'report_id' => 'integer',
                        'project' => [
                            'id' => 'integer',
                            'name' => 'string'
                        ],
                        'created_date' => 'string',
                        'task' => 'string',
                        'hour' => 'string',
                        // no coct for client  'cost' => 'string',
                        'is_approved' => 'boolean',
                        'reporter' => [
                            'id' => 'integer',
                            'name' => 'string'
                        ],
                        'reported_date' => 'string',
                        'is_invoiced' => 'integer'
                    ]
                ],
                'total_records' => 'string',
                'total_hours' => 'string',
// no                'total_cost' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * Testing fetch only own reports data for dev otherwise return empty array
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFetchReportsForDev(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $userId = $I->haveInDatabase('users', array(
            //'id' => 3,
            'first_name' => 'clientUsers',
            'last_name' => 'clientSNUsers',
            'email' => 'clientUser@email.com',
            'role' => 'DEV',
            'password' => md5('dev')
        ));

        $projectId = $I->haveInDatabase('projects', array(
            'name' => 'Hello World!'
        ));

        $I->haveInDatabase('reports', array(
            //      'id' => 1,
            'user_id' => ValuesContainer::$userDevId,
            'project_id' => $projectId,
            'date_added' => '2017-03-09',
            'task' => 'bla task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null
        ));

        $I->haveInDatabase('project_developers', array(
            'user_id' => $userId,
            'project_id' => $projectId,
            'is_sales'  => 0
        ));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login("clientUser@email.com", "dev");

        $I->wantTo('Testing fetch only own reports data for dev');
        $I->sendGET(ApiEndpoints::REPORT);

        \Helper\OAuthToken::$key = null;

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['reports' =>
                [],
                'total_records' => 'string',
                'total_hours' => 'string',
                'total_cost' => 'integer'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * Testing fetch reports data for sales only if he is marked as is_sales for project otherwise return empty array
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFetchReportsForSales(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $userId = $I->haveInDatabase('users', array(
            'first_name' => 'clientUsers',
            'last_name' => 'clientSNUsers',
            'email' => 'clientUser@email.com',
            'role' => 'SALES',
            'password' => md5('sales')
        ));

        $projectId = $I->haveInDatabase('projects', array(
            'name' => 'Hello World!'
        ));

        $I->haveInDatabase('reports', array(
            //      'id' => 1,
            'user_id' => $userId,   // 5
            'project_id' => $projectId,
            'date_added' => '2017-03-09',
            'task' => 'bla task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null
        ));

        $I->haveInDatabase('project_developers', array(
            'user_id' => $userId,
            'project_id' => $projectId,
            'is_sales'  => 0
        ));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login("clientUser@email.com", "sales");

        $I->wantTo('Testing fetch reports data for sales projects');
        $I->sendGET(ApiEndpoints::REPORT);

        \Helper\OAuthToken::$key = null;

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['reports' =>
                [],
                'total_records' => 'string',
                'total_hours' => 'string',
                'total_cost' => 'integer'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * SALES can approve only reports of participants of their projects and  CAN NOT approve own reports
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testSalesCanApproveReport(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $userId = $I->haveInDatabase('users', array(
            'first_name' => 'clientUsers',
            'last_name' => 'clientSNUsers',
            'email' => 'clientUser@email.com',
            'role' => 'SALES',
            'password' => md5('sales')
        ));

        $projectId = $I->haveInDatabase('projects', array(
            'name' => 'Hello World!'
        ));

        $repId = $I->haveInDatabase('reports', array(
            //      'id' => 1,
            'user_id' => $userId,   // 5
            'project_id' => $projectId,
            'date_added' => '2017-03-09',
            'task' => 'bla task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null
        ));

        $I->haveInDatabase('project_developers', array(
            'user_id' => $userId,
            'project_id' => $projectId,
            'is_sales'  => 1
        ));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login("clientUser@email.com", "sales");

        $I->wantTo('Test approving report');
        $I->sendPUT(ApiEndpoints::REPORT . '/' . $repId . '/approve');

        \Helper\OAuthToken::$key = null;

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->seeResponseContainsJson([
            "data"   => null,
            "errors" => [
                "param"   => "error",
                "message" => "You can not approve own report"
            ],
            "success" => false
        ]);
    }

    /**
     * FIN can approve any reports except of own
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFinCanApproveReportExeptOwn(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $userId = $I->haveInDatabase('users', array(
            'first_name' => 'finUsers',
            'last_name' => 'finUserLast',
            'email' => 'finUser@email.com',
            'role' => 'FIN',
            'password' => md5('fin')
        ));

        $projectId = $I->haveInDatabase('projects', array(
            'name' => 'Hello World!'
        ));

        $repId = $I->haveInDatabase('reports', array(
            //      'id' => 1,
            'user_id' => $userId,   // 5
            'project_id' => $projectId,
            'date_added' => '2017-03-09',
            'task' => 'bla task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null
        ));

        $I->haveInDatabase('project_developers', array(
            'user_id' => $userId,
            'project_id' => $projectId,
            'is_sales'  => 1
        ));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login("finUser@email.com", "fin");

        $I->wantTo('Test approving report for fin exept own');
        $I->sendPUT(ApiEndpoints::REPORT . '/' . $repId . '/approve');

        \Helper\OAuthToken::$key = null;

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->seeResponseContainsJson([
            "data"   => 'array|null',
            "errors" => [
                "param"   => "error",
                "message" => "You can not approve own report"
            ],
            "success" => false
        ]);
    }

}

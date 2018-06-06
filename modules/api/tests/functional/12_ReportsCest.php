<?php
use Helper\ApiEndpoints;
use Helper\OAuthSteps;
/**
 * Created by Skynix Team
 * Date: 09.03.17
 * Time: 12:15
 */

use Helper\ValuesContainer;
define('DATE_REPORT', date('d/m/Y'));
define('HOURS', 2);
define('MAX_HOURS', 12);
define('TASK', 'task description, task description, task description');

class ReportsCest
{
    private $ownReportId;
    private $newTask;
    private $userId;
    private $notOwnReportId;

    public function testCreateReportAsDev(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Create create a report as a dev user');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userDev['id']));
        $pas    = ValuesContainer::$userDev['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

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

        $this->notOwnReportId = $response->data->report_id;



        $I->sendPOST(ApiEndpoints::REPORT, json_encode([
            'project_id' => ValuesContainer::$projectId,
            'task' => TASK,
            'hours' => HOURS,
            'date_report' => date('d/m/Y', strtotime('now -1day'))
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);

    }

    /* 2.1.1 Create Report Data
     * @see    http://jira.skynix.company:8070/browse/SI-837
     */
    public function testCreateWithotAuthReports(FunctionalTester $I)
    {


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
        $this->userId = ValuesContainer::$userAdmin['id'];
    }

    /**
     * 2 Report Now Page: change the max value of hours from 10 to 12
     * @see  https://jira.skynix.co/browse/SCA-118
     */
    public function testCreateReportForMaxHours(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Create report with authorization');

        $I->sendPOST(ApiEndpoints::REPORT, json_encode([
            'project_id'    => ValuesContainer::$projectId,
            'task'          => TASK,
            'hours'         => (MAX_HOURS-HOURS),
            'date_report'   => DATE_REPORT
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response->errors);
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'report_id' => 'integer'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        if ( $response->data->report_id > 0 ) {

            $I->wantTo('Delete previously created report');
            $I->sendDELETE(ApiEndpoints::REPORT . '/' . $response->data->report_id);
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

    }

    /**
     * 2.1.1 Create Report Data
     * @see    http://jira.skynix.company:8070/browse/SI-837
     */
    public function testCreateWithAuthReports(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Create some reports with authorization');

        $I->sendPOST(ApiEndpoints::REPORT, json_encode([
            'project_id' => ValuesContainer::$projectId,
            'task' => TASK,
            'hours' => HOURS,
            'date_report' => date('d/m/Y', strtotime(DATE_REPORT . ' -1 day'))
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->sendPOST(ApiEndpoints::REPORT, json_encode([
            'project_id' => ValuesContainer::$projectId,
            'task' => TASK,
            'hours' => HOURS,
            'date_report' => date('d/m/Y', strtotime(DATE_REPORT . ' -2 days'))
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();


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


    /**
     * 2 Report Now Page: change the max value of hours from 10 to 12
     * @see  https://jira.skynix.co/browse/SCA-118
     */
    public function testCanNotCreateReportForMoreThanMaxHours(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Create report with authorization');

        $I->sendPOST(ApiEndpoints::REPORT, json_encode([
            'project_id'    => ValuesContainer::$projectId,
            'task'          => TASK,
            'hours'         => MAX_HOURS,
            'date_report'   => DATE_REPORT
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);

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
            'limit' => 1,
            'order' => ['id' => 'DESC']

        ]);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'reports' => 'array',
                "total_records" => 'string',
                "total_hours" => 'string',
                "total_cost" => 'float|integer'
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
                'total_cost' => 'float|integer'
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
            'limit' => 1,
            'order' => ['id' => 'DESC']
        ]);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'reports' => 'array',
                "total_records" => 'string',
                "total_hours" => 'string',
                "total_cost" => 'float|integer'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        $I->seeResponseContainsJson([
            'report_id' => $this->ownReportId,
            'task' => $this->newTask
        ]);

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
                'reports'       => 'array',
                "total_records" => 'string',
                "total_hours"   => 'string',
                "total_cost"    => 'float|integer'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        $I->cantSeeResponseContainsJson([
            'data' =>
                [
                    'reports' => [
                        [
                            'report_id' => $this->ownReportId,
                            'task' => $this->newTask
                        ],
                    ]

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

        $I->haveInDatabase('reports', array(
            'user_id'       => ValuesContainer::$userClient['id'],
            'project_id'    =>  ValuesContainer::$projectId,
            'date_added' => '2017-03-09',
            'task' => 'bla task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null,
            'is_approved' => 1
        ));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login( ValuesContainer::$userClient['email'],  ValuesContainer::$userClient['password']);

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


        $I->haveInDatabase('reports', array(
            'user_id'       => ValuesContainer::$userDev['id'],
            'project_id'    => ValuesContainer::$projectId,
            'date_added'    => date('Y-m-d'),
            'task' => 'bla task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null
        ));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userDev['email'], ValuesContainer::$userDev['password']);

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
                'total_cost'    => 'float|integer',
                'total_hours'   => 'string'
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

        $I->haveInDatabase('reports', array(
            'user_id'    => ValuesContainer::$userSales['id'],   // 5
            'project_id' => ValuesContainer::$projectId,
            'date_added' => '2017-03-09',
            'task' => 'bla task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null
        ));


        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userSales['email'], ValuesContainer::$userSales['password']);

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
                'total_cost' => 'float|integer'
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


        $repId = $I->haveInDatabase('reports', array(
            'user_id'   => ValuesContainer::$userSales['id'],   // 5
            'project_id' => ValuesContainer::$projectId,
            'date_added' => '2017-03-09',
            'task' => 'bla task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null
        ));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userSales['email'], ValuesContainer::$userSales['password']);

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
                "message" => "You (role sales) can not approve own report"
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


        $repId = $I->haveInDatabase('reports', array(
            'user_id' => ValuesContainer::$userFin['id'],   // 5
            'project_id' => ValuesContainer::$projectId,
            'date_added' => '2017-03-09',
            'task' => 'bla task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null
        ));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userFin['email'], ValuesContainer::$userFin['password']);

        $I->wantTo('Test approving report for fin exept own');
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
                "message" => "You (role fin) can not approve own report"
            ],
            "success" => false
        ]);
    }

    /**
     * ADMIN can disapprove any report
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testDisApproveReport(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $repId = $I->haveInDatabase('reports', array(
            'user_id'   => ValuesContainer::$userSales['id'],   // 5
            'project_id' => ValuesContainer::$projectId,
            'date_added' => '2017-03-09',
            'task' => 'bla task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null,
            'is_approved' => 1
        ));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->wantTo('Test disapproving report');
        $I->sendPUT(ApiEndpoints::REPORT . '/' . $repId . '/disapprove');

        \Helper\OAuthToken::$key = null;

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [],
            "success" => true
        ]);
    }

    /**
     * SALES can disapprove only reports of participants of their projects and  CAN NOT DISapprove own reports
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testSalesCanDisApproveReport(FunctionalTester $I, \Codeception\Scenario $scenario)
    {


        $repId = $I->haveInDatabase('reports', array(
            'user_id' => ValuesContainer::$userSales['id'],   // 5
            'project_id' => ValuesContainer::$projectId,
            'date_added' => '2017-03-09',
            'task' => 'bla task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null,
            'is_approved' => 1
        ));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userSales['email'], ValuesContainer::$userSales['password']);

        $I->wantTo('Test approving report for client exept own');
        $I->sendPUT(ApiEndpoints::REPORT . '/' . $repId . '/disapprove');

        \Helper\OAuthToken::$key = null;

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->seeResponseContainsJson([
            "data"   => null,
            "errors" => [
                "param"   => "error",
                "message" => "You (role sales) can not disapprove own report"
            ],
            "success" => false
        ]);
    }

    /**
     * FIN can disapprove any reports except of own
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFinCanDisApproveReportExeptOwn(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $repId = $I->haveInDatabase('reports', array(
            'user_id'       => ValuesContainer::$userFin['id'],   // 5
            'project_id'    => ValuesContainer::$projectId,
            'date_added'    => '2017-03-09',
            'task' => 'bla task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null,
            'is_approved' => 1
        ));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userFin['email'], ValuesContainer::$userFin['password']);

        $I->wantTo('Test disapproving report for fin exept own');
        $I->sendPUT(ApiEndpoints::REPORT . '/' . $repId . '/disapprove');

        \Helper\OAuthToken::$key = null;

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->seeResponseContainsJson([
            "data"   => null,
            "errors" => [
                "param"   => "error",
                "message" => "You (role fin) can not disapprove own report"
            ],
            "success" => false
        ]);
    }

}

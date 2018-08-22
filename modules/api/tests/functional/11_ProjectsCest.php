<?php
/**
 * Created by Skynix Team
 * Date: 15.03.17
 * Time: 12:18
 */
use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

/**
 * Class ProjectsCest
 */
class ProjectsCest
{
    private $projectId;

    private $fixedPriceProjectId;

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-876
     * @param  FunctionalTester $I
     * @return void
     */
    public function testProjectCreation(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPOST(ApiEndpoints::PROJECT, json_encode([
            "name"          => "Project",
            "jira_code"     => "SI-21",
            "date_start"    => date('d/m/Y'),
            "date_end"      => date('d/m/Y', strtotime('+1 year')),
            "type"          => "HOURLY",
            "developers"    => [
                [
                    'id' => ValuesContainer::$userDev['id']
                ],
                [
                    'id' => ValuesContainer::$userSales['id']
                ]
            ],
            "customers"         => [ValuesContainer::$userClient['id']],
            "invoice_received"  => ValuesContainer::$userClient['id'],
            "is_pm"             => ValuesContainer::$userDev['id'],
            "is_sales"          => ValuesContainer::$userSales['id'],
            "is_published"      => 1,
            "status"            => "INPROGRESS"
        ]));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $projectId = $response->data->project_id;
        $this->projectId = $projectId;
        codecept_debug($projectId);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-958
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchProject(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch projects data');
        $I->sendGET(ApiEndpoints::PROJECT, [
            'limit' => 1
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['projects' =>
                [
                    [
                        'id' => 'integer',
                        'name' => 'string',
                        'jira' => 'string',
                        'type'  => 'string',
                        'total_logged' => 'float|integer',
                        'cost' => 'string',
                        'total_paid' => 'float|integer',
                        'date_start' => 'string',
                        'date_end' => 'string',
                        "is_pm"         => 'integer|null',
                        "is_sales"      => 'integer|null',
                        'developers' => [
                            [
                                'id'            => 'integer',
                                'first_name'    => 'string',
                                'last_name'     => 'string',
                                'role'          => 'string'
                            ]
                        ],
                        'milestones'=> 'array',
                        'clients'   => 'array',
                        'status'    => 'string',
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira.skynix.co/browse/SCA-122
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchProjectById(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch one project data by its ID');
        $I->sendGET(ApiEndpoints::PROJECT, [
            'id'    => $this->projectId
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->assertEquals(1, $response->data->total_records);

    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-959
     * @param  FunctionalTester $I
     * @return void
     */
    public function testEditProject(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing edit projects data');
        $I->sendPUT(ApiEndpoints::PROJECT . '/' . $this->projectId, json_encode([
            "name"               =>  "Project",
            "jira_code"          =>  "SI-21",
            "date_start"         => date('d/m/Y'),
            "date_end"           => date('d/m/Y', strtotime('+1 year')),
            "status"             => "INPROGRESS",
            "customers"          => [ValuesContainer::$userClient['id']],
            "invoice_received"   => ValuesContainer::$userClient['id'],
            "developers"         => [
                [
                    'id'        => ValuesContainer::$userDev['id'],
                    'alias'     => ValuesContainer::$userAdmin['id']
                ],
                [
                    'id'    => ValuesContainer::$userSales['id'],
                ],
                [
                    'id'    => ValuesContainer::$userAdmin['id']
                ]
            ],
            "is_pm"              => ValuesContainer::$userDev['id'],
            "is_sales"           => ValuesContainer::$userSales['id'],
            "is_published"       => 1,
        ]));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean',
        ]);

        $I->wantTo('Testing edit project by SALES. Can edit name and developers only, posting other params as well');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas    = ValuesContainer::$userSales['password'];

        $initialDevelopers = [
            [
                'id'        => ValuesContainer::$userDev['id'],
                'alias'     => ValuesContainer::$userAdmin['id']
            ],
            [
                'id'    => ValuesContainer::$userSales['id'],
            ],
            [
                'id'    => ValuesContainer::$userAdmin['id']
            ],
            [
                'id'    => ValuesContainer::$userPm['id']
            ],
            [
                'id'    => ValuesContainer::$fakeSalesID
            ]
        ];


        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $I->sendPUT(ApiEndpoints::PROJECT . '/' . $this->projectId, json_encode([
            "name"               =>  "Project [edited]",
            "jira_code"          =>  "SI-21  [edited]",
            "date_start"         => date('d/m/Y', strtotime('-1 day')),
            "date_end"           => date('d/m/Y', strtotime('+2 years')),
            "status"             => "DONE",
            "customers"          => [ 123 ],
            "invoice_received"   => 123,
            "type"               => "FIXED_PRICE",
            "developers"         => $initialDevelopers,
            "is_pm"              => ValuesContainer::$userDev['id'],
            "is_sales"           => ValuesContainer::$fakeSalesID,
            "is_published"       => 1,
        ]));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean',
        ]);

        $I->wantTo('Login as admin');
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendGET(ApiEndpoints::PROJECT, [
            'id'    => $this->projectId
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), true);
        codecept_debug($response);
        $I->assertEmpty($response['errors']);
        $I->assertEquals(true, $response['success']);
        $I->assertEquals(1, $response['data']['total_records']);
        $project = $response['data']['projects'][0];
        $I->assertEquals("Project [edited]", $project['name']);
        $I->assertEquals("HOURLY", $project['type']);
        $I->assertEquals("SI-21", $project['jira']);
        $I->assertEquals("INPROGRESS", $project['status']);
        $I->assertEquals(date('d/m/Y'), $project['date_start']);
        $I->assertEquals(date('d/m/Y', strtotime('+1 year')), $project['date_end']);
        $I->assertEquals(ValuesContainer::$userDev['id'], $project["is_pm"]);
        $I->assertEquals(ValuesContainer::$userSales['id'], $project["is_sales"]);


        $I->assertEquals([ValuesContainer::$userClient['id']], [$project['clients'][0]['id']]);

        foreach ( $project['developers'] as $dev ) {

            foreach ( $initialDevelopers as $k=>$v ) {

                if ( $v['id'] === $dev['id'] ) {

                    unset($initialDevelopers[$k]);
                    break;

                }
            }

        }
        $I->assertEquals(0, count($initialDevelopers));
        $I->wantTo('Now testing edit project by SALES. Can edit name and developers only');
        $initialDevelopers = [
            [
                'id'        => ValuesContainer::$userDev['id'],
                'alias'     => ValuesContainer::$userAdmin['id']
            ],
            [
                'id'    => ValuesContainer::$userSales['id'],
            ],
            [
                'id'    => ValuesContainer::$userAdmin['id']
            ],
            [
                'id'    => ValuesContainer::$userPm['id']
            ],
            [
                'id'    => ValuesContainer::$fakeSalesID
            ]
        ];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $I->sendPUT(ApiEndpoints::PROJECT . '/' . $this->projectId, json_encode([
            "name"               =>  "Project [edited 2]",
            "developers"         => $initialDevelopers,
        ]));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean',
        ]);

        $I->wantTo('Login as admin');
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendGET(ApiEndpoints::PROJECT, [
            'id'    => $this->projectId
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), true);
        codecept_debug($response);
        $I->assertEmpty($response['errors']);
        $I->assertEquals(true, $response['success']);
        $I->assertEquals(1, $response['data']['total_records']);
        $project = $response['data']['projects'][0];
        $I->assertEquals("Project [edited 2]", $project['name']);
        $I->assertEquals("HOURLY", $project['type']);
        $I->assertEquals("SI-21", $project['jira']);
        $I->assertEquals("INPROGRESS", $project['status']);
        $I->assertEquals(date('d/m/Y'), $project['date_start']);
        $I->assertEquals(date('d/m/Y', strtotime('+1 year')), $project['date_end']);
        $I->assertEquals(ValuesContainer::$userDev['id'], $project["is_pm"]);
        $I->assertEquals(ValuesContainer::$userSales['id'], $project["is_sales"]);


        $I->assertEquals([ValuesContainer::$userClient['id']], [$project['clients'][0]['id']]);

        foreach ( $project['developers'] as $dev ) {

            foreach ( $initialDevelopers as $k=>$v ) {

                if ( $v['id'] === $dev['id'] ) {

                    unset($initialDevelopers[$k]);
                    break;

                }
            }

        }
        $I->assertEquals(0, count($initialDevelopers));
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-962
     * @param  FunctionalTester $I
     * @return void
     */
    public function testSuspendProject(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing suspend project');
        $I->sendPUT(ApiEndpoints::PROJECT . '/' . $this->projectId . '/suspend');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean',
        ]);
    }


    /**
     * @see    https://jira-v2.skynix.company/browse/SI-961
     * @param  FunctionalTester $I
     * @return void
     */
    public function testActivateProject(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing activate project');
        $I->sendPUT(ApiEndpoints::PROJECT . '/' . $this->projectId . '/activate');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean',
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-960
     * @param  FunctionalTester $I
     * @return void
     */
    public function testDeleteProject(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing delete project');
        $I->sendDELETE(ApiEndpoints::PROJECT . '/' . $this->projectId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean',
        ]);
    }

    public function testFixedPriceProject(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
        $I->wantTo('Create a Fixed Price project');
        $I->sendPOST(ApiEndpoints::PROJECT, json_encode([
            "name"          => "Fixed Price Project",
            "jira_code"     => "FXSI3",
            "date_start"    => date('d/m/Y'),
            "date_end"      => date('d/m/Y', strtotime('+1 year')),
            "type"          => "FIXED_PRICE",
            "developers"    => [
                [
                    'id' => ValuesContainer::$userDev['id']
                ],
                [
                    'id' => ValuesContainer::$userSales['id']
                ]
            ],
            "customers"         => [ValuesContainer::$userClient['id']],
            "invoice_received"  => ValuesContainer::$userClient['id'],
            "is_pm"             => ValuesContainer::$userDev['id'],
            "is_sales"          => ValuesContainer::$userSales['id'],
            "is_published"      => 1,
            "status"            => "INPROGRESS"
        ]));
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $this->fixedPriceProjectId = $response->data->project_id;

        $I->wantTo('Create a Milestone');
        $I->sendPOST(ApiEndpoints::PROJECT . '/' . $this->fixedPriceProjectId . '/milestones', json_encode([
            "name"          => "Milestone 1 - Install third party modules",
            "start_date"    => date('d/m/Y'),
            "end_date"      => date('d/m/Y', strtotime('+5 days')),
            "estimated_amount"  => 350,
        ]));
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        //$milestoneId = $response->data->milestone_id;

        $I->wantTo('Create another Milestone when one OPENed exists. This should not be possible');
        $I->sendPOST(ApiEndpoints::PROJECT . '/' . $this->fixedPriceProjectId . '/milestones', json_encode([
            "name"          => "Milestone 2 - Theme coding",
            "start_date"    => date('d/m/Y'),
            "end_date"      => date('d/m/Y', strtotime('+15 days')),
            "estimated_amount"  => 1250,
        ]));
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);


        $I->wantTo('Close a Milestone');
        $I->sendPUT(ApiEndpoints::PROJECT . '/' . $this->fixedPriceProjectId . '/milestones' );

        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

        $I->wantTo('Create another Milestone when all are CLOSED');
        $I->sendPOST(ApiEndpoints::PROJECT . '/' . $this->fixedPriceProjectId . '/milestones', json_encode([
            "name"          => "Milestone 2 - Theme coding",
            "start_date"    => date('d/m/Y'),
            "end_date"      => date('d/m/Y', strtotime('+15 days')),
            "estimated_amount"  => 1250,
        ]));
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

    }

    public function testAddFinancialIncomeForFixedPriceProjectCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Testing add financial income data by SALES for a Fixed Price project when milestone is OPENed');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas = ValuesContainer::$userSales['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $I->sendPOST(ApiEndpoints::FINANCIAL_REPORTS . '/' . ValuesContainer::$FinancialReportId . ApiEndpoints::FINANCIAL_REPORTS_INCOME,
            json_encode([
                'from_date' => 1,
                'to_date'   => 2,
                'amount'    => 1250,
                'description' => "Upwork Contract May #32",
                'project_id' => $this->fixedPriceProjectId,
                'developer_user_id' => ValuesContainer::$userDev['id'],
            ])
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), true);
        codecept_debug($response);
        $I->assertNotEmpty($response['errors']);
        $I->assertEquals(false, $response['success']);
        $I->assertEquals([
            [
                'param'     => 'project_id',
                'message'   => 'Please CLOSE the milestone to add financial income'
            ]
        ], $response['errors']);


        $I->wantTo('Close a Milestone');
        $I->sendPUT(ApiEndpoints::PROJECT . '/' . $this->fixedPriceProjectId . '/milestones' );
        $I->seeResponseCodeIs(200);


        /*$I->wantTo('Testing add financial income data by SALES for a Fixed Price project when milestones are CLOSED');
        $I->sendPOST(ApiEndpoints::FINANCIAL_REPORTS . '/' . ValuesContainer::$FinancialReportId . ApiEndpoints::FINANCIAL_REPORTS_INCOME,
            json_encode([
                'from_date' => 1,
                'to_date'   => 2,
                'amount'    => 1250,
                'description' => "Upwork Contract May #32",
                'project_id' => $this->fixedPriceProjectId,
                'developer_user_id' => ValuesContainer::$userDev['id'],
            ])
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty( $response->errors );
        $I->assertEquals(true, $response->success);*/

    }

    /*public function testFetchFinancialIncomeForAFixedPriceProjectWithMilestoneCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Testing fetch financial income data by SALES with milestones');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas    = ValuesContainer::$userSales['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $I->sendGET(ApiEndpoints::FINANCIAL_REPORTS . '/' . ValuesContainer::$FinancialReportId . ApiEndpoints::FINANCIAL_REPORTS_INCOME);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            "data"  => [
                "id"        => 'integer',
                "from_date" => 'integer',
                "to_date"   => 'integer',
                "date"      => 'integer',
                "amount"    => 'integer',
                "description"   => "string",
                "project"   => [
                    "id"    => "intgers",
                    "name"  => "string",
                    "milestones"    => 'array'
                ],
                "developer_user"    => "array",
                "added_by_user"     => "array"
            ],
            'errors'  => 'array',
            'success' => 'boolean'
        ]);


    }*/


    /**
     * @see https://jira.skynix.co/browse/SCA-237
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testSubscribeProjectForbiddenNotAuthorized(FunctionalTester $I)
    {
        \Helper\OAuthToken::$key = null;

        $I->wantTo('test subscribe project is not allowed for not authorized');


        $I->sendPOST('/api/projects/' . ValuesContainer::$ProjectId . '/subscription');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [
                "param" => "error",
                "message" => "You are not authorized to access this action"
            ],
            "success" => false
        ]);

    }


    /**
     * @see https://jira.skynix.co/browse/SCA-237
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testSubscribeProjectNotExistProject(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('test subscribe project  return error on case when set id, what project doesn\'t exist in database');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPOST('/api/projects/555/subscription');

        \Helper\OAuthToken::$key = null;
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->assertEquals('project is\'t found by Id', $response->errors[0]->message);
    }

    /**
     * @see https://jira.skynix.co/browse/SCA-238
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUnsubscribeProjectForbiddenNotAuthorized(FunctionalTester $I)
    {
        \Helper\OAuthToken::$key = null;

        $I->wantTo('test subscribe project is not allowed for not authorized');


        $I->sendDELETE('/api/projects/' . ValuesContainer::$ProjectId . '/subscription');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [
                "param" => "error",
                "message" => "You are not authorized to access this action"
            ],
            "success" => false
        ]);

    }


    /**
     * @see https://jira.skynix.co/browse/SCA-238
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUnsubscribeProjectNotExistProject(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('test subscribe project  return error on case when set id, what project doesn\'t exist in database');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendDELETE('/api/projects/555/subscription');

        \Helper\OAuthToken::$key = null;
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->assertEquals('project is\'t found by Id', $response->errors[0]->message);
    }

}
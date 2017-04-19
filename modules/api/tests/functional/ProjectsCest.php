<?php
/**
 * Created by Skynix Team
 * Date: 15.03.17
 * Time: 12:18
 */
use Helper\OAuthSteps;
use Helper\ApiEndpoints;

/**
 * Class ProjectsCest
 */
class ProjectsCest
{
    private $projectId;
    private $salesUserId;
    private $devUserId;
    private $clientUserId;

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-876
     * @param  FunctionalTester $I
     * @return void
     */
    public function testProjectCreation(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        //Create SALES ( 2.2.3 Create User Request )
        $I->sendPOST(ApiEndpoints::USERS, json_encode(
            [
                "role"               =>  "Sales",
                "first_name"         =>  "Sales",
                "last_name"          =>  "LastName Sales",
                "email"              => 'sales' . substr(md5(rand(1, 1000)), 0, 5) .  '@gmail.com'
            ]
         ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $salesUserId = $response->data->user_id;

        //Create DEV
        $I->sendPOST(ApiEndpoints::USERS, json_encode(
            [
                "role"               =>  "Dev",
                "first_name"         =>  "Dev",
                "last_name"          =>  "LastName Dev",
                "email"              =>   'dev' . substr(md5(rand(1, 1000)), 0, 5) .  '@gmail.com'
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $devUserId = $response->data->user_id;

        //Create CLIENT
        $I->sendPOST(ApiEndpoints::USERS, json_encode(
            [
                "role"               =>  "Client",
                "first_name"         =>  "Client",
                "last_name"          =>  "LastName Client",
                "email"              =>   'client' . substr(md5(rand(1, 1000)), 0, 5) .  '@gmail.com'
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $clientUserId = $response->data->user_id;

        $I->sendPOST(ApiEndpoints::PROJECT, json_encode([
            "name"               =>  "Project",
            "jira_code"          =>  "SI-21",
            "date_start"         => date('d/m/Y'),
            "date_end"           => date('Y-m-d', strtotime('-1 year')),
            "developers"         => [$devUserId, $salesUserId],
            "customers"          => [$clientUserId],
            "invoice_received"   => $clientUserId,
            "is_pm"              => $devUserId,
            "is_sales"           => $salesUserId
        ]));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $projectId = $response->data->project_id;
        $this->projectId = $projectId;
        $this->clientUserId = $clientUserId;
        $this->devUserId = $devUserId;
        $this->salesUserId = $salesUserId;
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
                        'total_logged' => 'string',
                        'cost' => 'string',
                        'total_paid' => 'string',
                        'date_start' => 'string',
                        'date_end' => 'string',
                        'developers' => 'string',
                        'clients' => 'string',
                        'status' => 'string',
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
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
            "date_end"           => date('Y-m-d', strtotime('-1 year')),
            "status"             => "OnHold",
            "customers"          => [$this->clientUserId],
            "invoice_received"   => $this->clientUserId,
            "developers"         => [$this->devUserId, $this->salesUserId],
            "is_pm"              => $this->devUserId,
            "is_sales"           => $this->salesUserId,
            "alias_name"         => [13, 45]
        ]));
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

}
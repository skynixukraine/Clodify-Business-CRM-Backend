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
            "name"               =>  "Project",
            "jira_code"          =>  "SI-21",
            "date_start"         => date('d/m/Y'),
            "date_end"           => date('Y-m-d', strtotime('-1 year')),
            "developers"         => [ValuesContainer::$userDevId, ValuesContainer::$userSalesId],
            "customers"          => [ValuesContainer::$userClientId],
            "invoice_received"   => ValuesContainer::$userClientId,
            "is_pm"              => ValuesContainer::$userDevId,
            "is_sales"           => ValuesContainer::$userSalesId,
            "is_published"       => 1,
            "status"             => "INPROGRESS"
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
                        'total_logged' => 'float|integer',
                        'cost' => 'string',
                        'total_paid' => 'float|integer',
                        'date_start' => 'string',
                        'date_end' => 'string',
                        'developers' => 'array',
                        'clients' => 'array',
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
     * @see    https://jira-v2.skynix.company/browse/SI-959
     * @param  FunctionalTester $I
     * @return void
     */
    public function testEditProject(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing edit projects data');
        $I->sendPUT(ApiEndpoints::PROJECT . '/' . ValuesContainer::$projectId, json_encode([
            "name"               =>  "Project",
            "jira_code"          =>  "SI-21",
            "date_start"         => date('d/m/Y'),
            "date_end"           => date('Y-m-d', strtotime('-1 year')),
            "status"             => "INPROGRESS",
            "customers"          => [ValuesContainer::$userClientId],
            "invoice_received"   => ValuesContainer::$userClientId,
            "developers"         => [ValuesContainer::$userDevId, ValuesContainer::$userSalesId, ValuesContainer::$userId],
            "is_pm"              => ValuesContainer::$userDevId,
            "is_sales"           => ValuesContainer::$userSalesId,
            "alias_name"         => [13, 45],
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

}
<?php
/**
 * Created by Skynix Team
 * Date: 20.04.17
 * Time: 14:39
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;

class ContractsCest
{
    private $contractId = 5;
    private $customerId;
    private $projectId;

    public function serviceCreateContractProjectCreation(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        //Create SALES ( 2.2.3 Create User Request )
        $I->sendPOST(ApiEndpoints::USERS, json_encode(
            [
                "role"               =>  "Sales",
                "first_name"         =>  "Sales",
                "last_name"          =>  "LastName Sales",
                "email"              => 'sales' . substr(md5(time()), 0, 5) .  '@gmail.com'
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $salesUserId = $response->data->user_id;
        $this->customerId = $salesUserId;

        //Create DEV
        $I->sendPOST(ApiEndpoints::USERS, json_encode(
            [
                "role"               =>  "Dev",
                "first_name"         =>  "Dev",
                "last_name"          =>  "LastName Dev",
                "email"              =>   'dev' . substr(md5(time()), 0, 5) .  '@gmail.com'
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
                "email"              =>   'client' . substr(md5(time()), 0, 5) .  '@gmail.com'
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
        codecept_debug($projectId);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-968
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCreateContractCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        define('DATE_START_CONTRACT_CREATE', '20/03/2017');
        define('DATE_END_CONTRACT_CREATE', '21/03/2017');
        define('DATE_ACT_CONTRACT_CREATE', '21/03/2017');
        define('CONTRACT_ID_CREATE', rand(100, 10000));
        define('CONTRACT_ID_ACT_CREATE', rand(100, 10000));

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create contract data');
        $I->sendPOST(ApiEndpoints::CONTRACTS, json_encode([
                'customer_id' => $this->customerId,
                'contract_id' => CONTRACT_ID_CREATE,
                'project_id' => $this->projectId,
                'contract_template_id' => 1,
                'contract_payment_method_id' => 1,
                'created_by' => $this->customerId,
                'act_number' => CONTRACT_ID_ACT_CREATE,
                'start_date' => DATE_START_CONTRACT_CREATE,
                'end_date' => DATE_END_CONTRACT_CREATE,
                'act_date' => DATE_ACT_CONTRACT_CREATE,
                'total' => 100,

            ])
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $this->contractId = $response->data->contract_id;
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'contract_id' => 'integer',
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-970
     * @param  FunctionalTester $I
     * @return void
     */
    public function testEditContractCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        define('DATE_START_CONTRACT_EDIT', '2017/03/20');
        define('DATE_END_CONTRACT_EDIT', '2017/03/21');
        define('DATE_ACT_CONTRACT_EDIT', '2017/03/21');
        define('CONTRACT_ID_EDIT', rand(100, 10000));
        define('CONTRACT_ID_ACT_EDIT', rand(100, 10000));

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing edit contract data');
        $I->sendPUT(ApiEndpoints::CONTRACTS . '/' . $this->contractId, json_encode([
                'contract_id' => CONTRACT_ID_EDIT,
                'customer_id' => $this->customerId,
                'project_id' => $this->projectId,
                'contract_template_id' => 1,
                'contract_payment_method_id' => 1,
                'act_number' => CONTRACT_ID_ACT_EDIT,
                'start_date' => DATE_START_CONTRACT_EDIT,
                'end_date' => DATE_END_CONTRACT_EDIT,
                'act_date' => DATE_ACT_CONTRACT_EDIT,
                'total' => 100,

            ])
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-967
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchContractsCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch contracts data');
        $I->sendGET(ApiEndpoints::CONTRACTS, [
            'limit' => 1
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['contracts' =>
                [
                    [
                        'id' => 'integer',
                        'contract_id' => 'integer',
                        'created_by' => 'array|null',
                        'customer' => 'array|null',
                        'act_number' => 'integer',
                        'start_date' => 'string',
                        'end_date' => 'string',
                        'act_date' => 'string',
                        'total' => 'string',
                        'total_hours' => 'string|integer',
                        'expenses' => 'string',
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-969
     * @param  FunctionalTester $I
     * @return void
     */
    public function testViewContractsCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch contracts data');
        $I->sendGET(ApiEndpoints::CONTRACTS . '/' . $this->contractId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'contract_id' => 'integer',
                'customer' => 'array|null',
                'act_number' => 'integer',
                'start_date' => 'string',
                'end_date' => 'string',
                'act_date' => 'string',
                'total' => 'string',
                'download_contract_url' => 'string',
                'download_act_url' => 'string',
                'download_invoice_url' => 'string|null',
                'created_by' => 'array|null',
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-971
     * @param  FunctionalTester $I
     * @return void
     */
    public function testDeleteContractCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing delete contracts data');
        $I->sendDELETE(ApiEndpoints::CONTRACTS . '/' . $this->contractId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

}
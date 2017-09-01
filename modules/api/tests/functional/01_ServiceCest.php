<?php
/**
 * Created by Skynix Team
 * Date: 27.04.17
 * Time: 12:12
 */

use Helper\ValuesContainer;
use Helper\OAuthSteps;
use Helper\ApiEndpoints;

class ServiceCest {

    public function createUsersTest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        //Create SALES ( 2.2.3 Create User Request )
        $I->sendPOST(ApiEndpoints::USERS, json_encode(
            [
                "role"               =>  "Sales",
                "first_name"         =>  "Sales",
                "last_name"          =>  "LastName Sales",
                "email"              =>  "SalesService@gmail.com",
                "is_published"       => 1,
                "is_active"          => 1,
                "salary"             => 3000,
                "official_salary"    => 2500
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        ValuesContainer::$userSalesId = $response->data->user_id;

        //Create DEV
        $I->sendPOST(ApiEndpoints::USERS, json_encode(
            [
                "role"               =>  "Dev",
                "first_name"         =>  "Dev",
                "last_name"          =>  "LastName Dev",
                "email"              =>  "DevService@gmail.com"
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        ValuesContainer::$userDevId = $response->data->user_id;

        //Create CLIENT
        $I->sendPOST(ApiEndpoints::USERS, json_encode(
            [
                "role"               =>  "Client",
                "first_name"         =>  "Client",
                "last_name"          =>  "LastName Client",
                "email"              =>  "ClientService@gmail.com"
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        ValuesContainer::$userClientId = $response->data->user_id;
    }

    public function createProjectTest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPOST(ApiEndpoints::PROJECT, json_encode([
            "name"               =>  "Project",
            "jira_code"          =>  "SI-1",
            "status"             => "INPROGRESS",
            "date_start"         => date('d/m/Y'),
            "date_end"           => date('Y-m-d', strtotime('-1 year')),
            "developers"         => [ValuesContainer::$userDevId, ValuesContainer::$userSalesId],
            "customers"          => [ValuesContainer::$userClientId],
            "invoice_received"   => ValuesContainer::$userClientId,
            "is_pm"              => ValuesContainer::$userDevId,
            "is_sales"           => ValuesContainer::$userSalesId,
            "is_published"       => 1,
        ]));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        ValuesContainer::$projectId = $response->data->project_id;
    }

    public function createContractTest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        define('DATE_START_CONTRACT_CREATE_SERVICE', '20/03/2017');
        define('DATE_END_CONTRACT_CREATE_SERVICE', '21/03/2017');
        define('DATE_ACT_CONTRACT_CREATE_SERVICE', '21/03/2017');
        define('CONTRACT_ID_CREATE_SERVICE', time());
        define('CONTRACT_ID_ACT_CREATE_SERVICE', time());

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create contract data');
        $I->sendPOST(ApiEndpoints::CONTRACTS, json_encode([
                'customer_id' => ValuesContainer::$userId,
                'contract_id' => CONTRACT_ID_CREATE_SERVICE,
                'project_id' => ValuesContainer::$projectId,
                'contract_template_id' => 1,
                'contract_payment_method_id' => 1,
                'created_by' => ValuesContainer::$userId,
                'act_number' => CONTRACT_ID_ACT_CREATE_SERVICE,
                'start_date' => DATE_START_CONTRACT_CREATE_SERVICE,
                'end_date' => DATE_END_CONTRACT_CREATE_SERVICE,
                'act_date' => DATE_ACT_CONTRACT_CREATE_SERVICE,
                'total' => 100,

            ])
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        ValuesContainer::$contractId = $response->data->contract_id;
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


}
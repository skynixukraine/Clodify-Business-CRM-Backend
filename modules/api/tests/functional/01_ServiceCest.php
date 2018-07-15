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

    public $userDevId;
    public $userSalesId;
    public $userFinId;
    public $userPmId;
    public $userClientId;
    public $projectId;

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
        $this->userSalesId = $response->data->user_id;

        $I->sendPOST(ApiEndpoints::USERS, json_encode(
            [
                "role"               =>  "FIN",
                "first_name"         =>  "Fin",
                "last_name"          =>  "LastName Fin",
                "email"              =>  "crm-fin2@skynix.co",
                "is_published"       => 1,
                "is_active"          => 1,
                "salary"             => 3000,
                "official_salary"    => 2500
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $this->userFinId = $response->data->user_id;

        $I->sendPOST(ApiEndpoints::USERS, json_encode(
            [
                "role"               =>  "PM",
                "first_name"         =>  "Pm",
                "last_name"          =>  "LastName Pm",
                "email"              =>  "crm-pm2@skynix.co",
                "is_published"       => 1,
                "is_active"          => 1,
                "salary"             => 3000,
                "official_salary"    => 2500
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $this->userPmId = $response->data->user_id;


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
        $this->userDevId = $response->data->user_id;

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
        $this->userClientId = $response->data->user_id;
    }

    /**
     * @see https://jira.skynix.co/browse/SCA-200
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testCreateAProjectWithAnotherSalesCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPOST(ApiEndpoints::PROJECT, json_encode([
            "name"               =>  "Project Without Sales",
            "jira_code"          =>  "PWS-1",
            "date_start"         => date('d/m/Y', strtotime('now -10 days')),
            "date_end"           => date('d/m/Y', strtotime('+1 year')),
            "type"               => "HOURLY",
            "developers"         => [
                [

                    'id'    => $this->userDevId,
                ],
                [
                    'id'    => $this->userSalesId
                ],
                [
                    'id'    => ValuesContainer::$userSales['id']
                ]
            ],
            "customers"          => [$this->userClientId],
            "invoice_received"   => $this->userClientId,
            "is_pm"              => $this->userDevId,
            "is_sales"           => $this->userSalesId,
            "is_published"       => 1
        ]));
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        ValuesContainer::$projectIDWithoutSales = $response->data->project_id;

        $I->wantTo('enable project for reports');
        $I->sendPUT(ApiEndpoints::PROJECT . '/' . ValuesContainer::$projectIDWithoutSales . '/activate');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

    }


}
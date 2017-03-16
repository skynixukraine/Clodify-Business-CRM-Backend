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
        codecept_debug($projectId);
    }
}
<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/7/18
 * Time: 6:00 PM
 */

use Helper\ValuesContainer;
use Helper\OAuthSteps;
use Helper\ApiEndpoints;

class ClientCest
{
    public function createClientTest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->sendPOST(ApiEndpoints::CLIENTS, json_encode(
            [

                "domain"        => "synpass-agency",
                "name"          => "Synpass LLC Test Agency",
                "first_name"    => "John",
                "last_name"     => "Doe",
                "email"         => "agency@synpass.pro"

            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

    }
}
<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/27/18
 * Time: 9:55 AM
 */

use Helper\ValuesContainer;
use Helper\ApiEndpoints;

class SSOCest
{
    private $ownReportId;
    private $newTask;
    private $userId;
    private $notOwnReportId;

    public function testFetchSSOCookieDomainConfig(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Test that SSO config is available');

        $I->sendGET(ApiEndpoints::SSO_CONFIG );
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->assertNotEmpty($response->data->name);

    }

}
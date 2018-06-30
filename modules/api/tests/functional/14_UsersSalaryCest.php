<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/30/18
 * Time: 2:21 PM
 */
use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

class UsersSalaryCest
{
    public function testUsersSalaryWasRaisedWhenFinReportWasLocked(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendGET(ApiEndpoints::USERS . '/' . ValuesContainer::$userDev['id']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

        // compare types of returned common fields for all roles
        $I->seeResponseMatchesJsonType([
            'data' => [

                'salary_up'   => 'string|null',
                'salary'      => 'integer',
            ]
        ]);
        $I->wantTo('test that salary of the developer was raised by delayed salary');
        $I->assertEquals(ValuesContainer::$DevSalary, $response->data->salary);
    }
}
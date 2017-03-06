<?php

use Helper\OAuthSteps;
use Helper\ApiEndpoints;

class UsersCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * @see    http://jira.skynix.company:8070/browse/SI-853
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchUsersData(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendGET(ApiEndpoints::USERS);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'  => ['users' =>
                [
                    [
                'id'          => 'integer',
                'image'       => 'string',
                'first_name'  => 'string',
                'last_name'   => 'string',
                'company'     => 'string',
                'role'        => 'string',
                'email'       => 'string',
                'phone'       => 'string',
                'last_login'  => 'string',
                'joined'      => 'string',
                'is_active'   => 'integer',
                'salary'      => 'string',
                'salary_up'   => 'string'
                    ]
                ]
            ],
            'errors' => 'array',
            'success'=> 'boolean'
        ]);
    }
}

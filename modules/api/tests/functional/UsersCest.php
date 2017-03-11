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

        $I->sendGET(ApiEndpoints::USERS, [
            'limit'   => 1
        ]);
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

        /**
         * 2.2.6 Activate Users Data
         * @see http://jira.skynix.company:8070/browse/SI-859
         * 2.2.7 Deactivate Users Data
         * @see http://jira.skynix.company:8070/browse/SI-860
         */

        $userId = $response->data->users[0]->id;
        $is_active = $response->data->users[0]->is_active;
        codecept_debug($is_active);
        
        if($userId) {
            if($is_active) {
                //Deactivate user
                $I->sendPUT(ApiEndpoints::USERS . '/' . $userId . '/deactivate');
                $I->seeResponseCodeIs(200);
                $I->seeResponseIsJson();
                $response = json_decode($I->grabResponse());
                $I->assertEmpty($response->errors);
                $I->assertEquals(true, $response->success);

                //Check if user was activated
                $I->sendGET(ApiEndpoints::USERS, [
                    'limit'   => 1
                ]);
                $I->seeResponseCodeIs(200);
                $response = json_decode($I->grabResponse());
                $I->assertEmpty($response->errors);
                $I->assertEquals(0, $response->data->users[0]->is_active);


            } else {
                //Activate user
                $I->sendPUT(ApiEndpoints::USERS . '/' . $userId . '/activate');
                $I->seeResponseCodeIs(200);
                $I->seeResponseIsJson();
                $response = json_decode($I->grabResponse());
                $I->assertEmpty($response->errors);
                $I->assertEquals(true, $response->success);

                //Check if user was deactivated
                $I->sendGET(ApiEndpoints::USERS, [
                    'limit'   => 1
                ]);
                $I->seeResponseCodeIs(200);
                $response = json_decode($I->grabResponse());
                $I->assertEmpty($response->errors);
                $I->assertEquals(1, $response->data->users[0]->is_active);

            }

        }
    }

    /**
     * @see    http://jira.skynix.company:8070/browse/SI-854
     * @param  FunctionalTester $I
     * @return void
     */
    public function testViewSingleUserPage(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        define('userId', 1);
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendGET(ApiEndpoints::USERS . '/' . userId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

        // compare types of returned common fields for all roles
        $I->seeResponseMatchesJsonType([
            'data' => [
                'first_name'  => 'string',
                'last_name'   => 'string',
                'middle_name' => 'string',
                'company'     => 'string',
                'tags'        => 'string',
                'about'       => 'string',
                'photo'       => 'string',
                'sign'        => 'string',
                'bank_account_en' => 'string',
                'bank_account_ua' => 'string',
                'email'       => 'string',
                'phone'       => 'string',
            ]
        ]);
    }

}

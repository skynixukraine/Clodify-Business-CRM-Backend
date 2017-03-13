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
    }

    /**
     * @see    http://jira.skynix.company:8070/browse/SI-854
     * @param  FunctionalTester $I
     * @return void
     */
    public function testViewSingleUserData(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        define('userIdView', 1);
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendGET(ApiEndpoints::USERS . '/' . userIdView);
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
                'bank_account_en' => 'string|null',
                'bank_account_ua' => 'string|null',
                'email'       => 'string',
                'phone'       => 'string',
            ]
        ]);
    }

    /**
     * 2.2.4 Edit User Request
     * @see http://jira.skynix.company:8070/browse/SI-857
     */
    public function testEditUserData(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        define('userIdEdit', 1);
        define('first_name', 'ChangedFirst');
        define('last_name', 'ChangedLast');
        define('salary', 150);
        define('phone', '12345678985');

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPUT(ApiEndpoints::USERS . '/' . userIdEdit, json_encode([
            'first_name' => first_name,
            'last_name'  => last_name,
            'salary'     => salary,
            'phone'      => phone
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

        // Make sure that user's data was updated
        $I->sendGET(ApiEndpoints::USERS . '/' . userIdEdit);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEquals(first_name, $response->data->first_name);
        $I->assertEquals(last_name, $response->data->last_name);
        $I->assertEquals('$' . salary, $response->data->salary);
        $I->assertEquals(phone, $response->data->phone);
    }

    /**
     * 2.2.6 Activate Users Data
     * @see http://jira.skynix.company:8070/browse/SI-859
     * 2.2.7 Deactivate Users Data
     * @see http://jira.skynix.company:8070/browse/SI-860
     */
    public function testActivateDeactivateUser(FunctionalTester $I, \Codeception\Scenario $scenario)
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

        $userId = $response->data->users[0]->id;
        $is_active = $response->data->users[0]->is_active;

        if($is_active) {
            //Deactivate user
            $I->sendPUT(ApiEndpoints::USERS . '/' . $userId . '/deactivate');
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

    /**
     * @see    http://jira.skynix.company:8070/browse/SI-858
     * @param  FunctionalTester $I
     * @return void
     */
    public function testDeleteUser(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        define('userIdDelete', 1);
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendDELETE(ApiEndpoints::USERS . '/' . userIdDelete);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
    }

}

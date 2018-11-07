<?php

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;
define('ROLE', 'DEV');
define('ROLE_PM', 'PM');
define('ROLE_SALES', 'SALES');

class UsersCest
{
    private $userId;

    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * 2.2.3 Create User Request
     * @see https://jira-v2.skynix.company/browse/SI-856
     */
    public function testCreateUser(FunctionalTester $I, \Codeception\Scenario $scenario)
    {


        define('FIRST_NAME', 'Test');
        define('LAST_NAME', 'Test');
        define('EMAIL', substr(md5(rand(1, 1000)), 0, 5) .  '@gmail.com');

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPOST(ApiEndpoints::USERS, json_encode([
            'role'            => ROLE,
            'first_name'      => FIRST_NAME,
            'last_name'       => LAST_NAME,
            'email'           => EMAIL,
            'official_salary' => 3200
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $this->userId = $response->data->user_id;
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

        /*Check if user was added */

        $I->sendGET(ApiEndpoints::USERS, [
            'limit'   => 1
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

        $I->canSeeResponseContainsJson([
            'data' => [
                'users' => [
                    'first_name' => FIRST_NAME,
                    'last_name'  => LAST_NAME,
                    'email'      => EMAIL,
                    'role'       => ROLE,
                    'is_active' => 1
                ]
            ]
        ]);
    }

    public function testFailedUserLogin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        define('WRONG_EMAIL', 'wrong.email@gmail.com');
        define('WRONG_PASSWORD', '324324fdvdfvsfv');

        //Request Access Token using simple auth
        $I->sendPOST('/api/auth', json_encode([
            'email'     => WRONG_EMAIL,
            'password'  => WRONG_PASSWORD
        ]));
        $I->seeResponseCodeIs(200);

        $I->seeResponseMatchesJsonType([
            'errors' => [
                [
                    'param'     => 'string',
                    'message'   => 'string'
                ]
            ]
        ]);
        $I->seeResponseContainsJson([
            'errors' => [
                [
                    'param'     => 'password',
                    'message'   => 'Username or password is wrong'
                ]
            ],
            'success' => false
        ]);
    }

    public function testFailedUserLoginToCrowd(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        define('WRONG_CROWD_EMAIL', 'wrong.email@skynix.co');

        //Request Access Token using simple auth
        $I->sendPOST('/api/auth', json_encode([
            'email'     => WRONG_CROWD_EMAIL,
            'password'  => WRONG_PASSWORD
        ]));
        $I->seeResponseCodeIs(200);

        $I->seeResponseMatchesJsonType([
            'errors' => [
                [
                    'param'     => 'string',
                    'message'   => 'string'
                ]
            ]
        ]);
        $I->seeResponseContainsJson([
            'errors' => [
                [
                    'param'     => 'password',
                    'message'   => 'Username or password is wrong'
                ]
            ]
        ]);
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
                'id'               => 'integer',
                'image'            => 'string',
                'first_name'       => 'string',
                'last_name'        => 'string',
                'company'          => 'string|null',
                'role'             => 'string',
                'email'            => 'string',
                'phone'            => 'string|null',
                'last_login'       => 'string',
                'joined'           => 'string',
                'is_active'        => 'integer',
                'salary'           => 'string',
                'official_salary'  => 'integer|null',
                'salary_up'        => 'string',
                'delayed_salary'   => 'array|null',
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
                'role'        => 'string',
                'middle_name' => 'string|null',
                'company'     => 'string',
                'tags'        => 'string',
                'about'       => 'string|null',
                'photo'       => 'string',
                'sign'        => 'string|null',
                'bank_account_en' => 'string|null',
                'bank_account_ua' => 'string|null',
                'official_salary' => 'integer|null',
                'email'       => 'string',
                'phone'       => 'string',
                'salary_up'   => 'string|null',
                'month_logged_hours'    => 'integer',
                'year_logged_hours'     => 'integer',
                'total_logged_hours'    => 'integer',
                'month_paid_hours'      => 'integer',
                'year_paid_hours'       => 'integer',
                'total_paid_hours'      => 'integer',
                'auth_type'             => 'integer',
                'joined'                => 'string',
                'is_active'             => 'integer',
                'salary'                => 'integer',
            ]
        ]);
    }

    /**
     * 2.2.4 Edit User Request
     * @see http://jira.skynix.company:8070/browse/SI-857
     */
    public function testEditUserData(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        define('first_name', 'ChangedFirst');
        define('last_name', 'ChangedLast');
        define('salary', 150);
        define('phone', '12345678985');
        define('AUTH_TYPE_CROWD', 1);

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPUT(ApiEndpoints::USERS . '/' . ValuesContainer::$userDev['id'], json_encode([
            'first_name'      => first_name,
            'last_name'       => last_name,
            'salary'          => salary,
            'phone'           => phone,
            'official_salary' => 8000,
            'auth_type'       => AUTH_TYPE_CROWD,
            'slug'            => 'crm-dev',
            'is_published'    => true
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

        // Make sure that user's data was updated
        $I->sendGET(ApiEndpoints::USERS . '/' . ValuesContainer::$userDev['id']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEquals(first_name, $response->data->first_name);
        $I->assertEquals(last_name, $response->data->last_name);
        $I->assertEquals( salary, $response->data->salary);
        $I->assertEquals(phone, $response->data->phone);
        $I->assertEquals(AUTH_TYPE_CROWD, $response->data->auth_type);
    }

    /**
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFinEditUserData(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login( ValuesContainer::$userFin['email'], ValuesContainer::$userFin['password']);

        $I->wantTo('Testing fin can edit user data');
        $I->sendPUT(ApiEndpoints::USERS . '/' .  ValuesContainer::$userDev['id'], json_encode([
            'official_salary' => 8000
        ]));

        \Helper\OAuthToken::$key = null;

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array | null',
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        $I->seeInDatabase('users', ['id' => ValuesContainer::$userDev['id'], 'official_salary' => 8000]);
    }

    /**
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFailEditUserData(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userClient['email'], ValuesContainer::$userClient['password']);

        $I->wantTo('Testing user can not edit another user data');
        $I->sendPUT(ApiEndpoints::USERS . '/' . ValuesContainer::$userDev['id'], json_encode([
            'first_name' => 'devSuperUsers',
            'last_name' => 'devLastName',
            'official_salary' => 8500
        ]));

        \Helper\OAuthToken::$key = null;

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->seeResponseContainsJson([
            "data"   => null,
            "errors" => [
                "param"   => "error",
                "message" => "You have no permission for this action"
            ],
            "success" => false
        ]);
    }


    /**
     * @see    https://jira-v2.skynix.company/browse/SI-983
     * @param  FunctionalTester $I
     * @return void
     */
    public function testViewPhotoUser(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendGET(ApiEndpoints::USER . '/' . ValuesContainer::$userAdmin['id'] . '/photo');
        $I->seeResponseCodeIs(200);
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
        define('userIdDelete', $this->userId);
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendDELETE(ApiEndpoints::USERS . '/' . userIdDelete);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
    }
    /**
     * @see    https://jira-v2.skynix.company/browse/SI-981
     * @param  FunctionalTester $I
     * @return void
     */
    public function getAccessToken(FunctionalTester $I, \Codeception\Scenario $scenario) {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
        $I->sendGET(ApiEndpoints::USERS . '/access-token/' . ValuesContainer::$userAdmin['id']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'access_token' => 'string'
            ]
        ]);
    }

    /**
     * @see    http://jira.skynix.company:8070/browse/SI-853
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchUsersFilterbyRoles(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $roles = [
            ROLE,
            ROLE_PM,
            ROLE_SALES
        ];

        $I->sendGET(ApiEndpoints::USERS, [
            'limit'     => 100,
            'roles'     => $roles
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

        foreach( $response->data->users as $user ) {

            if ( in_array( $user->role, $roles)) {

                foreach ( $roles as $k=>$v ) {

                    if ( $user->role == $v ) {

                        unset($roles[$k]);

                    }

                }

            }

        }
        $I->assertEquals(0, count($roles));
    }



    /**
     * @see    http://jira.skynix.company:8070/browse/SI-853
     * @param  FunctionalTester $I
     * @return void
     */
    public function testAdminCanLoginAsAnotherUser(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $roles = [
            ROLE,
            ROLE_PM,
            ROLE_SALES
        ];

        $I->sendGET(ApiEndpoints::USERS, [
            'limit'     => 100,
            'roles'     => $roles
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

        foreach( $response->data->users as $user ) {

            if ( in_array( $user->role, $roles)) {

                foreach ( $roles as $k=>$v ) {

                    if ( $user->role == $v ) {

                        unset($roles[$k]);

                    }

                }

            }

        }
        $I->assertEquals(0, count($roles));
    }


}

<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 6.04.18
 * Time: 10:10
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

/**
 * Class ResourcesCest
 */
class ResourcesCest
{

    /**@see https://jira.skynix.co/browse/SCA-125
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFetchResources(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch resources');
        $I->sendGET(ApiEndpoints::FETCH_RESOURCES);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'data'    => [
                    'resources' => 'array',
                ],
                'errors'  => 'array',
                'success' => 'boolean'
            ]
        );
    }

    /**@see https://jira.skynix.co/browse/SCA-126
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testResourcesIavailable(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->haveInDatabase('users', array(
            'id' => 5,
            'first_name' => 'devUsers',
            'last_name' => 'devUsersLast',
            'email' => 'devUser@email.com',
            'role' => 'DEV',
            'password' => md5('dev')
        ));

        $email = $I->grabFromDatabase('users', 'email', array('id' => 5));
        $pas = $I->grabFromDatabase('users', 'role', array('id' => 5));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, strtolower($pas));

        $I->wantTo('Testing resources I am available');
        $I->sendPUT(ApiEndpoints::FETCH_RESOURCES);

        \Helper\OAuthToken::$key = null;

        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'data'    => 'null',
                'errors'  => 'array',
                'success' => 'boolean'
            ]
        );

        $I->seeInDatabase('availability_logs', ['user_id' => 5, 'is_available' => 1]);
    }
}
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
        $I->sendGET(ApiEndpoints::RESOURCES);
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
        $I->sendPUT(ApiEndpoints::RESOURCES);

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

    /**
     * @see   https://jira.skynix.co/browse/SCA-127
     */
    public function testUserAvailableStart(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->haveInDatabase('users', array(
            'id' => 8,
            'first_name' => 'devUsers',
            'last_name' => 'devUsersLast',
            'email' => 'devUser@email.com',
            'role' => 'DEV',
            'password' => md5('dev'),
        ));

        $I->haveInDatabase('availability_logs', array(
            'id' => 1,
            'user_id' => 8,
            'date' =>  time()-7200,
            'is_available' => 1
        ));

        $I->haveInDatabase('projects', array(
            'id' => 1,
            'name' => "Internal (Non Paid) Tasks",
        ));

        $I->haveInDatabase('project_developers', array(
            'user_id' => 8,
            'project_id' => 1,
        ));

        $email = $I->grabFromDatabase('users', 'email', array('id' => 8));
        $pas = $I->grabFromDatabase('users', 'role', array('id' => 8));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, strtolower($pas));

        $I->wantTo('Testing resources I am available');
        $I->sendPOST(ApiEndpoints::RESOURCES);

        \Helper\OAuthToken::$key = null;

        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data' => 'null',
            'errors' => 'array',
            'success' => 'boolean'
        ]);

        $I->seeInDatabase('reports', ['user_id' => 8, 'task' => "Idle Time - I was waiting for tasks"]);

    }
}
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
    public function testResourcesIsAvailable(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userDev['id']));
        $pas = ValuesContainer::$userDev['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

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

        $I->seeInDatabase('availability_logs', ['user_id' => ValuesContainer::$userDev['id'], 'is_available' => 1]);
    }

    /**
     * @see   https://jira.skynix.co/browse/SCA-127
     */
    public function testUserUnAvailableStartedWorking(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $date = time()-60; // two hours before

        $I->haveInDatabase('availability_logs', array(
            'id'        => 2,
            'user_id'   => ValuesContainer::$userDev['id'],
            'date'      =>  $date,
            'is_available' => 1
        ));

        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userDev['id']));
        $pas    = ValuesContainer::$userDev['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

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

        $I->seeInDatabase('reports', [
            'user_id' => ValuesContainer::$userDev['id'],
            'task' => "Idle Time - I was waiting for tasks",
            'project_id' => ValuesContainer::$nonPaidProjectId
        ]);

    }
}
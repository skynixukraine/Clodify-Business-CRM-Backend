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
}
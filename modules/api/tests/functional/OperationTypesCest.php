<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 08.11.17
 * Time: 13:30
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;

/**
 * Class OperationTypesCest
 */
class OperationTypesCest
{
    /**
     * @see    https://jira.skynix.company/browse/SCA-49
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchOperationTypesCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch operation types data');
        $I->sendGET(ApiEndpoints::OPERATION_TYPES);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['operation-types' =>
                [
                    [
                        'id' => 'integer',
                        'name' => 'string',
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }
}
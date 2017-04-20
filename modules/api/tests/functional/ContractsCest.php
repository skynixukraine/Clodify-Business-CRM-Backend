<?php
/**
 * Created by Skynix Team
 * Date: 20.04.17
 * Time: 11:59
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;

class ContractsCest
{
    private $contarctId;

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-967
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchContractsCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch contracts data');
        $I->sendGET(ApiEndpoints::CONTRACTS, [
            'limit' => 1
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['contracts' =>
                [
                    [
                        'id' => 'integer',
                        'contract_id' => 'integer',
                        'created_by' => 'array|null',
                        'customer' => 'array|null',
                        'act_number' => 'integer',
                        'start_date' => 'string',
                        'end_date' => 'string',
                        'act_date' => 'string',
                        'total' => 'string',
                        'total_hours' => 'integer',
                        'expenses' => 'string',
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }
}
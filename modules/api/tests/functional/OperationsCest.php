<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 09.11.17
 * Time: 16:41
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

/**
 * Class CounterpartiesCest
 */
class OperationsCest
{
    /**
     * @param \Codeception\Scenario $scenario
     */
    public function _before (\Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
    }

    /**
     * @see    https://jira.skynix.company/browse/SCA-55
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCounterpartyCreation(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Testing create new operation');
        $I->sendPOST(ApiEndpoints::OPERATION, json_encode(
            [
                'bussiness_id' =>  '1',
                'name' =>  'myName',
                'operation_type_id' =>  '1',
                'transaction_name' =>  'BUY',
                'amount' =>  '12.5',
                'currency' =>  'UAH',
                'debit_reference_id' =>  '1',
                'credit_reference_id' =>  '1',
                'debit_counterparty_id' =>  '1',
                'credit_counterparty_id' =>  '1'
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'data'    => [
                    'operation' => 'integer',
                ],
                'errors'  => 'array',
                'success' => 'boolean'
            ]
        );
    }
}
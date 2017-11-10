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
    private $operationId;

    /**
     * @see    https://jira.skynix.company/browse/SCA-55
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCounterpartyCreationForAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

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
        $operationId = $response->data->operation;
        $this->operationId = $operationId;
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

    /**
     * @see    https://jira.skynix.company/browse/SCA-55
     * @param  FunctionalTester $I
     * @return void
     */
    public function testOperationCreateForbiddenForDevClientPmSales(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->haveInDatabase('users', array(
            'id' => 4,
            'first_name' => 'salesUsers',
            'last_name' => 'salesUsersLast',
            'email' => 'salesUser@email.com',
            'role' => 'SALES',
            'password' => md5('sales')
        ));

        $I->haveInDatabase('users', array(
            'id' => 5,
            'first_name' => 'devUsers',
            'last_name' => 'devUsersLast',
            'email' => 'devUser@email.com',
            'role' => 'DEV',
            'password' => md5('dev')
        ));

        $I->haveInDatabase('users', array(
            'id' => 6,
            'first_name' => 'pmUsers',
            'last_name' => 'pmUsersLast',
            'email' => 'pmUser@email.com',
            'role' => 'PM',
            'password' => md5('pm')
        ));

        $I->haveInDatabase('users', array(
            'id' => 7,
            'first_name' => 'clientUsers',
            'last_name' => 'clientUsersLast',
            'email' => 'clientUser@email.com',
            'role' => 'CLIENT',
            'password' => md5('client')
        ));

        for ($i = 4; $i < 8; $i++) {
            $email = $I->grabFromDatabase('users', 'email', array('id' => $i));
            $pas = $I->grabFromDatabase('users', 'role', array('id' => $i));

            \Helper\OAuthToken::$key = null;

            $oAuth = new OAuthSteps($scenario);
            $oAuth->login($email, strtolower($pas));

            $I->wantTo('Test that operation creation forbidden for  DEV, PM, CLIENT, SALES role');
            $I->sendPOST(ApiEndpoints::OPERATION);

            \Helper\OAuthToken::$key = null;

            $response = json_decode($I->grabResponse());
            $I->assertNotEmpty($response->errors);
            $I->seeResponseContainsJson([
                "data" => null,
                "errors" => [
                    "param" => "error",
                    "message" => "You have no permission for this action"
                ],
                "success" => false
            ]);
        }

    }
}
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
    public function testOperationCreationForAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
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

    /**
     * @see    https://jira.skynix.company/browse/SCA-56
     * @param  FunctionalTester $I
     * @return void
     */
    public function testUpdateOperationForAdminCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing update operations data for admin');
        $I->sendPUT(ApiEndpoints::OPERATION. '/' . $this->operationId,
            json_encode([
                'name'                   => 'dudfjjjjjf',
                'operation_type_id'      => 1,
                'transaction_name'       => 'ubunfffjjj',
                'amount'                 => 775577,
                'currency'               => 'UAH',
                'status'                 => 'CANCELED'
            ])
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira.skynix.company/browse/SCA-56
     * @param  FunctionalTester $I
     * @return void
     */
    public function testOperationUpdateForbiddenForFinDevClientPmSales(FunctionalTester $I, \Codeception\Scenario $scenario)
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

        $I->haveInDatabase('users', array(
            'id' => 8,
            'first_name' => 'finUsers',
            'last_name' => 'finUsersLast',
            'email' => 'finUser@email.com',
            'role' => 'FIN',
            'password' => md5('fin')
        ));

        for ($i = 4; $i < 9; $i++) {
            $email = $I->grabFromDatabase('users', 'email', array('id' => $i));
            $pas = $I->grabFromDatabase('users', 'role', array('id' => $i));

            \Helper\OAuthToken::$key = null;

            $oAuth = new OAuthSteps($scenario);
            $oAuth->login($email, strtolower($pas));

            $I->wantTo('Test that operation updating forbidden for  DEV, PM, CLIENT, SALES, FIN role');
            $I->sendPUT(ApiEndpoints::OPERATION. '/' . $this->operationId);

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

    /**
     * @see    https://jira.skynix.company/browse/SCA-56
     * @param  FunctionalTester $I
     * @return void
     */
    public function testUpdateOperationWhithWrongDataCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing update operations data for admin');
        $I->sendPUT(ApiEndpoints::OPERATION. '/' . $this->operationId,
            json_encode([
                'name'                   => 'dudfjjjjjf',
                'operation_type_id'      => 1,
                'transaction_name'       => 15,     // insted of allowed string 'ubunfffjjj'
                'amount'                 => 775577,
                'currency'               => 'UAH',
                'status'                 => 'CANCELED'
            ])
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [
                "param" => "error",
                "message" => "Sorry, but the entered data is not correct and updating failed"
            ],
            "success" => false
        ]);

        $I->sendPUT(ApiEndpoints::OPERATION. '/' . $this->operationId,
            json_encode([
                'name'                   => 'dudfjjjjjf',
                'operation_type_id'      => 3,             // operation_type_id is out of allowed
                'transaction_name'       => 'ubunfffjjj',
                'amount'                 => 775577,
                'currency'               => 'UAH',
                'status'                 => 'CANCELED'
            ])
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [
                "param" => "error",
                "message" => "Your operation_type_id is out of allowed"
            ],
            "success" => false
        ]);
    }

    /**
     * @see    https://jira.skynix.company/browse/SCA-99
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchOperationTypesCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch all operations data');
        $I->sendGET(ApiEndpoints::OPERATION);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['operations' =>
                [
                    [
                        'id'		        => 'integer',
                        'name'	            => 'string',
                        'status'            => 'string',
                        'date_created'	    => 'integer',
                        'date_updated'	    => 'integer',
                        'operation_type_id' => 'integer',
                        'business'          => 'array',
                        'transactions'      => 'array',
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }
}
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

    /**@see https://jira.skynix.co/browse/SCA-108
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testOperationCreationForAdminWithoutFixedAsset(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create new operation');
        $I->sendPOST(ApiEndpoints::OPERATION, json_encode(
            [
                'business_id'            =>  '1',
                'name'                   =>  'myName',
                'operation_type_id'      =>  '1',
                'transaction_name'       =>  'BUY',
                'amount'                 =>  '12.5',
                'currency'               =>  'UAH',
                'debit_reference_id'     =>  '1',
                'credit_reference_id'    =>  '1',
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
        $I->seeInDatabase('transactions', ['operation_id' => $this->operationId]);
        $I->cantSeeInDatabase('fixed_assets_operations', ['operation_id' => $this->operationId, 'operation_business_id' => 1]);
    }

    /**
     * @see    https://jira.skynix.company/browse/SCA-55
     * @param  FunctionalTester $I
     * @return void
     */
    public function testOperationCreationForAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create new operation with/for a fixed asset');
        $I->sendPOST(ApiEndpoints::OPERATION, json_encode(
            [
                'business_id'            =>  '1',
                'name'                   =>  'myName',
                'operation_type_id'      =>  '1',
                'transaction_name'       =>  'BUY',
                'amount'                 =>  '12.5',
                'currency'               =>  'UAH',
                'debit_reference_id'     =>  '1',
                'credit_reference_id'    =>  '1',
                "fixed_asset" => [
                    'name'               => "PC",
                    'cost'               => 100.50,
                    'inventory_number'   => 1002,
                    'amortization_method'=> 'LINEAR',
                    'date_of_purchase'   => '2017-12-29'
                ]
            ]
        ));
        $response = json_decode($I->grabResponse());
        codecept_debug($response->errors);
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
        $I->seeInDatabase('transactions', ['operation_id' => $this->operationId]);
        $I->seeInDatabase('fixed_assets_operations', ['operation_id' => $this->operationId, 'operation_business_id' => 1]);
        $I->cantSeeInDatabase('fixed_assets_operations', ['operation_id' => 7777]);
    }


    /**
     * @see    https://jira.skynix.company/browse/SCA-55
     * @param  FunctionalTester $I
     * @return void
     */
    public function testOperationCreateForbiddenForDevClientPmSales(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Test that operation creation forbidden for  DEV role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userDev['id']));
        $pas = ValuesContainer::$userDev['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

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

        $I->wantTo('Test that operation creation forbidden for  PM role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userPm['id']));
        $pas = ValuesContainer::$userPm['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

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

        $I->wantTo('Test that operation creation forbidden for  CLIENT role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userClient['id']));
        $pas = ValuesContainer::$userClient['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

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

        $I->wantTo('Test that operation creation forbidden for  SALES role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas = ValuesContainer::$userSales['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

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

        $I->wantTo('Test that operation updating forbidden for DEV role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userDev['id']));
        $pas = ValuesContainer::$userDev['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


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


        $I->wantTo('Test that operation updating forbidden for PM role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userPm['id']));
        $pas = ValuesContainer::$userPm['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


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

        $I->wantTo('Test that operation updating forbidden for CLIENT role');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userClient['id']));
        $pas    = ValuesContainer::$userClient['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


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

        $I->wantTo('Test that operation updating forbidden for SALES role');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas    = ValuesContainer::$userSales['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


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

        $I->wantTo('Test that operation updating forbidden for FIN role');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userFin['id']));
        $pas    = ValuesContainer::$userFin['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


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
                'operation_type_id'      => 3000,             // operation_type_id is out of allowed
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
    public function testFetchOperationsCest(FunctionalTester $I, \Codeception\Scenario $scenario)
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
                        'operation_type'    => 'array',
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

    /**
     * @see   https://jira.skynix.co/browse/SCA-143
     * @param  FunctionalTester $I
     * @return void
     */
    public function testViewOneOperationCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing view one operation data');
        $I->sendGET(ApiEndpoints::OPERATION . '/' . $this->operationId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'id'		        => 'integer',
                'name'	            => 'string',
                'status'            => 'string',
                'date_created'	    => 'integer',
                'date_updated'	    => 'integer',
                'operation_type'    => 'array',
                'business'          => 'array',
                'transactions'      => 'array',
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
    * @see    https://jira.skynix.co/browse/SCA-145
    * @param  FunctionalTester $I
    * @return void
    */
    public function testOperationChangeStatusAsDeleteCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->seeInDatabase('operations', ['id' => $this->operationId, 'is_deleted' => 0]);

        $I->wantTo('Testing delete operation');
        $I->sendDELETE(ApiEndpoints::OPERATION . '/' . $this->operationId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean'
        ]);

        $I->seeInDatabase('operations', ['id' => $this->operationId, 'is_deleted' => 1]);
    }
}
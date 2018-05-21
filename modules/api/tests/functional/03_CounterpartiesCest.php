<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 07.11.17
 * Time: 10:00
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

/**
 * Class CounterpartiesCest
 */
class CounterpartiesCest
{
    private $counterpartyId;

    /**
     * @see    https://jira.skynix.company/browse/SCA-43
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCounterpartyCreation(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPOST(ApiEndpoints::COUNTERPARTY, json_encode([
            "name" => "Project"
        ]));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $counterpartyId = $response->data->counterparty_id;
        $this->counterpartyId = $counterpartyId;
        codecept_debug($counterpartyId);
    }

    /**
     * @see    https://jira.skynix.company/browse/SCA-43
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCounterpartyCreationWithoutName(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPOST(ApiEndpoints::COUNTERPARTY);
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->seeResponseContainsJson([
            "data"   => null,
            "errors" => [
                "param"   => "error",
                "message" => "You have to provide name of the counterparty"
            ],
            "success" => false
        ]);
    }

    /**
     * @see    https://jira.skynix.company/browse/SCA-43  &&
     *         https://jira.skynix.company/browse/SCA-44
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCounterpartyCreateAndUpdateForbiddenForDevClientPm(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Test that counterparty creation forbidden for  PM role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userPm['id']));

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, ValuesContainer::$userPm['password']);


        $I->sendPOST(ApiEndpoints::COUNTERPARTY );

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

        $I->wantTo('Test that counterparty update forbidden for  PM role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userPm['id']));
        $pas = ValuesContainer::$userPm['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


        $I->sendPUT(ApiEndpoints::COUNTERPARTY. '/' .$this->counterpartyId, json_encode([
            "name" => "Projectxxx"
        ]));

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


        $I->wantTo('Test that counterparty creation forbidden for  DEV role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userDev['id']));
        $pas = ValuesContainer::$userDev['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPOST(ApiEndpoints::COUNTERPARTY );

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

        $I->wantTo('Test that counterparty update forbidden for  DEV role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userDev['id']));
        $pas = ValuesContainer::$userDev['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPUT(ApiEndpoints::COUNTERPARTY. '/' .$this->counterpartyId, json_encode([
            "name" => "Projectxxx"
        ]));

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


        $I->wantTo('Test that counterparty creation forbidden for  CLIENT role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userClient['id']));
        $pas = ValuesContainer::$userClient['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPOST(ApiEndpoints::COUNTERPARTY );

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

        $I->wantTo('Test that counterparty update forbidden for  CLIENT role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userClient['id']));
        $pas = ValuesContainer::$userClient['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPUT(ApiEndpoints::COUNTERPARTY. '/' .$this->counterpartyId, json_encode([
            "name" => "Projectxxx"
        ]));

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
     * @see    https://jira.skynix.company/browse/SCA-44
     * @param  FunctionalTester $I
     * @return void
     */
    public function testUpdateCounterpartyCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing update financial report data');
        $I->sendPUT(ApiEndpoints::COUNTERPARTY. '/' .$this->counterpartyId, json_encode([
            "name" => "Projectzzz"
        ]));

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
     * @see    https://jira-v2.skynix.company/browse/SI-1024
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchCounterpartiesCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch counterparties data');
        $I->sendGET(ApiEndpoints::COUNTERPARTY);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['counterparties' =>
                [
                    [
                        'id'   => 'integer',
                        'name' => 'string',
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SCA-59
     * @param  FunctionalTester $I
     * @return void
     */
    public function testDeleteCounterpartyUsedInTransaction(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->haveInDatabase('reference_book', array(
            'id'    => 331,
            'code'  => 454,
            'name'  => 'Test Reference'
        ));
        $I->haveInDatabase('operations', array(
            'id' => 1,
            'business_id' => 1,
            'operation_type_id' => 1
        ));
        $I->haveInDatabase('transactions', array(
            'id'                    => 1,
            'counterparty_id'       => $this->counterpartyId,
            'reference_book_id'     => 331,
            'operation_id'          => 1,
            'operation_business_id' => 1
        ));
        $I->wantTo('Counterparty can`t be deleted if it used in transactions');
        $I->sendDELETE(ApiEndpoints::COUNTERPARTY. '/' .$this->counterpartyId );
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [
                "param" => "error",
                "message" => "Sorry, this counteragent can not be deleted"
            ],
            "success" => false
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SCA-59
     * @param  FunctionalTester $I
     * @return void
     */
    public function testDeleteCounterparty(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $id = 2;

        $I->haveInDatabase('counterparties', array(
            'id' => $id
        ));

        $I->haveInDatabase('counterparties', array(
            'id' => 3
        ));

        $I->haveInDatabase('reference_book', array(
            'id' => 332,
            'code' => 454
        ));

        $I->haveInDatabase('busineses', array(
            'id' => 4
        ));



        $I->haveInDatabase('operations', array(
            'id'                => 2,
            'business_id'       => 1,
            'operation_type_id' => 3
        ));

        $I->haveInDatabase('transactions', array(
            'id'                    => 13,
            'counterparty_id'       => 3,
            'reference_book_id'     => 332,
            'operation_id'          => 2,
            'operation_business_id' => 1
        ));

        $I->wantTo('Delete counterparty if not used in transactions');
        $I->sendDELETE(ApiEndpoints::COUNTERPARTY. '/' .$id );
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }
}
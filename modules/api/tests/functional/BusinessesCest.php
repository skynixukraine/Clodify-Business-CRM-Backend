<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 08.11.17
 * Time: 12:03
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

/**
 * Class BusinessesCest
 */
class BusinessesCest
{
    /**
     * @see    https://jira.skynix.co/browse/SCA-233
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchBusinessesAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch counterparties data');
        $I->sendGET(ApiEndpoints::BUSINESS);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [[
                'id' => 'integer',
                'name' => 'string',
                'address' => 'string',
                'is_default' => 'integer|null',
                'director' => [
                    'id' => 'integer',
                    'first_name' => 'string',
                    'last_name' => 'string'
                ]

            ]],
            'errors' => [],
            'success' => 'boolean'
        ]);

    }

    /**
     * @see https://jira.skynix.co/browse/SCA-232
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     *
     */
    public function testFetchBusinessAdminFilterById(FunctionalTester $I, \Codeception\Scenario $scenario){
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('test fetch business filter by is');
        $I->sendGET(ApiEndpoints::BUSINESS . '/' . ValuesContainer::$BusinessId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());

        if(!isset($response->data[0]->id))
        {
            $I->fail('failed receive data associated with specified business');
        }

        if($response->data[0]->id != 1)
        {
            $I->fail('the received business doesn\'t correspond to the searching value');
        }

    }


    /**
     * @see https://jira.skynix.co/browse/SCA-232
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testFetchBusinessForbiddenNotAuthorized(FunctionalTester $I)
    {

        \Helper\OAuthToken::$key = null;

        $I->wantTo('test business create is forbidden for not authorized');
        $I->sendGET(ApiEndpoints::BUSINESS);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [
                "param" => "error",
                "message" => "You are not authorized to access this action"
            ],
            "success" => false
        ]);


    }

    /**
     * @see https://jira.skynix.co/browse/SCA-232
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testFetchBusinessForbiddenNotAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $roles = ['CLIENT', 'DEV', 'FIN', 'SALES', 'PM'];


        foreach($roles as $role) {

            \Helper\OAuthToken::$key = null;

            $testUser = 'user' . ucfirst(strtolower($role));
            $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::${$testUser}['id']));
            $pas = ValuesContainer::${$testUser}['password'];

            $oAuth = new OAuthSteps($scenario);
            $oAuth->login($email, $pas);

            $I->wantTo('test business create is forbidden for ' . $role .' role');
            $I->sendGET(ApiEndpoints::BUSINESS);
            $I->seeResponseCodeIs(200);
            $I->seeResponseIsJson();
            $response = json_decode($I->grabResponse());
            $I->assertNotEmpty($response->errors);
            $I->assertEquals(false, $response->success);
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
     * @see https://jira.skynix.co/browse/SCA-232
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testCreateBusinessAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('test business creation is allowed for ADMIN');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPOST(ValuesContainer::$createBusinessUrlApi, json_encode(ValuesContainer::$createBusinessData));

        \Helper\OAuthToken::$key = null;

        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();

        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);

        $I->seeResponseMatchesJsonType([
            'data' => [
                'business_id' => 'integer|string',
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);


    }

    /**
     * @see https://jira.skynix.co/browse/SCA-232
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testCreateBusinessForbiddenNotAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $roles = ['CLIENT', 'DEV', 'FIN', 'SALES', 'PM'];

        foreach($roles as $role) {

            $testUser = 'user' . ucfirst(strtolower($role));
            $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::${$testUser}['id']));
            $pas = ValuesContainer::${$testUser}['password'];

            \Helper\OAuthToken::$key = null;

            $oAuth = new OAuthSteps($scenario);
            $oAuth->login($email, $pas);

            $I->wantTo('test business create is forbidden for ' . $role .' role');
            $I->sendPOST(ValuesContainer::$createBusinessUrlApi, json_encode(ValuesContainer::$createBusinessData));

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
     * @see https://jira.skynix.co/browse/SCA-232
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testCreateBusinessIsDefault(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('test create default business resets other default 0');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $paymentMethodData['is_default'] = 1;

        $I->sendPOST(ValuesContainer::$createBusinessUrlApi, json_encode(ValuesContainer::$createBusinessData));
        $I->seeResponseCodeIs('200');

        $response = json_decode($I->grabResponse());

        $businessId = $response->data->business_id;

        $is_default = $I->grabFromDatabase('busineses', 'is_default', array('id'=> $businessId) );

        if($is_default == 0 ) {
            $I->fail('false is_default value ');
        }

        $I->sendPOST(ValuesContainer::$createBusinessUrlApi, json_encode(ValuesContainer::$createBusinessData));
        $I->seeResponseCodeIs('200');

        $response = json_decode($I->grabResponse());

        $businessId2 = $response->data->business_id;

        $is_default = $I->grabFromDatabase('busineses', 'is_default', array('id'=> $businessId2) );

        if($is_default == 0 ) {
            $I->fail('false is_default value ');
        }

        $is_default = $I->grabFromDatabase('busineses', 'is_default', array('id'=> $businessId) );

        if($is_default == 1 ) {
            $I->fail('false is_default value ');
        }

        $createBusinessDataModified = ValuesContainer::$createBusinessData;
        $createBusinessDataModified['is_default'] = 0;
        //$I->fail(json_encode($createBusinessDataModified));
        $I->sendPOST(ValuesContainer::$createBusinessUrlApi, json_encode($createBusinessDataModified));
        $I->seeResponseCodeIs('200');

        //$I->fail($I->grabResponse());

        $response = json_decode($I->grabResponse());

        $businessId3 = $response->data->business_id;

        $is_default = $I->grabFromDatabase('busineses', 'is_default', array('id'=> $businessId3) );

        if($is_default == 1 ) {
            $I->fail('false is_default value ');
        }

        $is_default = $I->grabFromDatabase('busineses', 'is_default', array('id'=> $businessId2) );

        if($is_default == 0 ) {
            $I->fail('false is_default value ');
        }


        \Helper\OAuthToken::$key = null;

    }

    /**
     * @see https://jira.skynix.co/browse/SCA-232
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testCreateBusinessNotAllowedRole(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $roles = ['DEV', 'PM'];

        foreach($roles as $role) {
            $testUser = 'user' . ucfirst(strtolower($role));
            $directorId = ValuesContainer::${$testUser}['id'];

            $createBusinessDataModified = ValuesContainer::$createBusinessData;
            $createBusinessDataModified['director_id'] = $directorId;
            $I->wantTo('test create default business with not allowed roles ' . $role);
            $I->sendPOST(ValuesContainer::$createBusinessUrlApi, json_encode($createBusinessDataModified));

            $response = json_decode($I->grabResponse());
            $I->assertNotEmpty($response->errors);

        }

    }

    /**
     * @see https://jira.skynix.co/browse/SCA-234
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateBusinessAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('test update business  is successful for ADMIN');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPUT('/api/businesses/' . ValuesContainer::$BusinessId, json_encode(ValuesContainer::$updateBusinessData));

        \Helper\OAuthToken::$key = null;
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'name' => 'string',
                'director_id' => 'integer',
                'address' => 'string',
                'is_default' => 'boolean|integer'
            ],
            'errors' => [],
            'success' => 'boolean'
        ]);

    }


    /**
     * @see https://jira.skynix.co/browse/SCA-234
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateBusinessForbiddenNotAuthorized(FunctionalTester $I)
    {
        \Helper\OAuthToken::$key = null;

        $I->wantTo('test update business is not allowed for not authorized');


        $I->sendPUT('/api/businesses/' . ValuesContainer::$BusinessId, json_encode(ValuesContainer::$updateBusinessData));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [
                "param" => "error",
                "message" => "You are not authorized to access this action"
            ],
            "success" => false
        ]);

    }

    /**
     * @see https://jira.skynix.co/browse/SCA-234
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateBusinessForbiddenForNotAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $roles = ['CLIENT', 'DEV', 'FIN', 'SALES', 'PM'];

        foreach($roles as $role) {

            $testUser = 'user' . ucfirst(strtolower($role));
            $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::${$testUser}['id']));
            $pas = ValuesContainer::${$testUser}['password'];

            \Helper\OAuthToken::$key = null;

            $oAuth = new OAuthSteps($scenario);
            $oAuth->login($email, $pas);

            $I->wantTo('test update business is forbidden for ' . $role .' role');
            $I->sendPUT('/api/businesses/' . ValuesContainer::$BusinessId, json_encode(ValuesContainer::$updateBusinessData));

            \Helper\OAuthToken::$key = null;

            $I->seeResponseIsJson();
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
     * @see https://jira.skynix.co/browse/SCA-234
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateBusinessRequiredFields(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $businessData = ValuesContainer::$updateBusinessData;

        $I->wantTo('test a update business is unable on missing a required field');

        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        foreach($businessData as $key => $elem) {

            $testData = $businessData;
            unset($testData[$key]);

            $I->sendPUT('/api/businesses/' . ValuesContainer::$BusinessId, json_encode($testData));

            \Helper\OAuthToken::$key = null;

            $I->seeResponseCodeIs('200');
            $I->seeResponseIsJson();

            $response = json_decode($I->grabResponse());
            $I->assertNotEmpty($response->errors);

            $errors = $response->errors;

            $check = false;

            foreach ($errors as $error) {
                if(strpos($error->message,'missed required field') !== false){
                    $check = true;
                }
            }

            if(!$check) {
                $I->fail('missed required field');
            }

            $I->seeResponseMatchesJsonType([
                'data' => "null",
                'errors' => [[
                    "param" => "string",
                    "message" => "string"
                ]],
                'success' => 'boolean'
            ]);

        }
    }

    /**
     * @see https://jira.skynix.co/browse/SCA-234
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateBusinessUpdatedValues(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('test update business  save correctly same data as was put');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPUT('/api/businesses/' . ValuesContainer::$BusinessId, json_encode(ValuesContainer::$updateBusinessData));

        \Helper\OAuthToken::$key = null;
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseContainsJson([
            'data' => [
                'name' => "Method 22",
                'director_id' => 4,
                'address' => "New Address 55",
                'is_default' => 1
            ],
            'errors' => [],
            'success' => true
        ]);
    }

    /**
     * @see https://jira.skynix.co/browse/SCA-234
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateBusinessNotExistBusiness(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('test update business  return error on case when set business id, what business doesn\'t exist in database');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPUT('/api/businesses/222', json_encode(ValuesContainer::$updateBusinessData));

        \Helper\OAuthToken::$key = null;
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->assertEquals('business is\'t found by Id', $response->errors[0]->message);
    }

}
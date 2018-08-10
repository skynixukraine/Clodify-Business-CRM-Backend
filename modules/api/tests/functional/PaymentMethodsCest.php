<?php
/**
 * Created by Skynix Team
 * Date: 03.04.17
 * Time: 12:37
 */

use Helper\OAuthSteps;
use Helper\ValuesContainer;

class PaymentMethodsCest
{

    /**
     * @see    https://jira-v2.skynix.company/browse/SCA-230
     * @param FunctionalTester $I
     */
    public function testFetchPaymentMethods(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('test payment method fetch is forbidden for DEV, PM, CLIENT role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userDev['id']));
        $pas = ValuesContainer::$userDev['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->wantTo('test payment method fetch is forbidden for DEV role');
        $I->sendGET('/api/businesses/1/methods');
        $I->seeResponseCodeIs(200);
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

        \Helper\OAuthToken::$key = null;

        $I->wantTo('test payment method fetch is forbidden for SALES role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas = ValuesContainer::$userSales['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendGET('/api/businesses/1/methods');
        $I->seeResponseCodeIs(200);
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

        \Helper\OAuthToken::$key = null;

        $I->wantTo('test payment method fetch is forbidden for CLIENT role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userClient['id']));
        $pas = ValuesContainer::$userClient['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendGET('/api/businesses/1/methods');
        $I->seeResponseCodeIs(200);
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

        \Helper\OAuthToken::$key = null;


        $I->wantTo('test payment method fetch is forbidden for PM role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userPm['id']));
        $pas = ValuesContainer::$userPm['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendGET('/api/businesses/1/methods');
        $I->seeResponseCodeIs(200);
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

        \Helper\OAuthToken::$key = null;

        $I->wantTo('test payment method fetch is  forbidden for not authorized');

        $I->sendGET('/api/businesses/1/methods');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        @$I->seeResponseMatchesJsonType([
            'data' => 'null',
            'errors' => [
                [
                'param' => 'string',
                'message' => 'string'
                ]
            ],

            'success' => 'boolean'
        ]);

        $I->wantTo('test payment method fetch is allowed for ADMIN role and has the correct structure');

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendGET('/api/businesses/1/methods');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());

        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        @$I->seeResponseMatchesJsonType([
            'data' => [
                    [
                        'name'            => 'string',
                        'name_alt'   => 'string',
                        'address'     => 'string',
                        'address_alt'     => 'string',
                        'represented_by'     => 'string|text',
                        'represented_by_alt'        => 'string|text',
                        'bank_information'     => 'string|text',
                        'bank_information_alt' => 'string|text',
                        'is_default'    => 'boolean|null'

                    ]
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);


    }

    public function testUpdatePaymentMethodDeniedNotAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $roles = ['CLIENT', 'DEV', 'FIN', 'SALES', 'PM'];

        foreach($roles as $role) {

            $testUser = 'user' . ucfirst(strtolower($role));
            $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::${$testUser}['id']));
            $pas = ValuesContainer::${$testUser}['password'];

            \Helper\OAuthToken::$key = null;

            $oAuth = new OAuthSteps($scenario);
            $oAuth->login($email, $pas);

            $I->wantTo('test payment method update is forbidden for ' . $role .' role');
            $I->sendPUT(\Helper\ValuesContainer::$updatePaymentMethodUrlApi , json_encode(\Helper\ValuesContainer::$paymentMethodData));

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

    public function testUpdatePaymentMethodAllowedAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('test payment method updating is allowed for ADMIN role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPUT(\Helper\ValuesContainer::$updatePaymentMethodUrlApi, json_encode(\Helper\ValuesContainer::$paymentMethodData));

        \Helper\OAuthToken::$key = null;

        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();

        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'id' => 'integer',
                'name'=> 'string',
                'address'=> 'string',
                'represented_by'=> 'string',
                'bank_information' => 'string',
                'is_default'=> 'integer',
                'business_id'=> 'integer'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);


    }

    public function testUpdatePaymentMethodNeedRequiredFields(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('test a payment method updating is unable on missing a required field');

        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $paymentMethodData = \Helper\ValuesContainer::$paymentMethodData;
        unset($paymentMethodData['id']);

        foreach($paymentMethodData as $key => $elem) {

            $testData = $paymentMethodData;
            unset($testData[$key]);

            $I->sendPUT(\Helper\ValuesContainer::$updatePaymentMethodUrlApi, json_encode($testData));

            \Helper\OAuthToken::$key = null;

            $I->seeResponseCodeIs('200');
            $I->seeResponseIsJson();

            $response = json_decode($I->grabResponse());
            $I->assertNotEmpty($response->errors);

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

    public function testUpdatePaymentMethodResetsIsDefault(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
//        $I->wantTo('test payment method creation is allowed for ADMIN role');
//        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
//        $pas = ValuesContainer::$userAdmin['password'];
//        $oAuth = new OAuthSteps($scenario);
//        $oAuth->login($email, $pas);
//
//        $I->sendPOST('/api/businesses/1/methods', json_encode($paymentMethodData));
//
//        \Helper\OAuthToken::$key = null;
//
//        $I->seeResponseCodeIs('200');
//        $I->seeResponseIsJson();
//
//        $response = json_decode($I->grabResponse());
//        $I->assertEmpty($response->errors);
//        $I->seeResponseMatchesJsonType([
//            'data' => [
//                'payment_method_id' => 'integer',
//            ],
//            'errors' => 'array',
//            'success' => 'boolean'
//        ]);
    }

    public function testUpdatePaymentMethodSafeIsDefault(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
//        $I->wantTo('test payment method creation is allowed for ADMIN role');
//        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
//        $pas = ValuesContainer::$userAdmin['password'];
//        $oAuth = new OAuthSteps($scenario);
//        $oAuth->login($email, $pas);
//
//        $I->sendPOST('/api/businesses/1/methods', json_encode($paymentMethodData));
//
//        \Helper\OAuthToken::$key = null;
//
//        $I->seeResponseCodeIs('200');
//        $I->seeResponseIsJson();
//
//        $response = json_decode($I->grabResponse());
//        $I->assertEmpty($response->errors);
//        $I->seeResponseMatchesJsonType([
//            'data' => [
//                'payment_method_id' => 'integer',
//            ],
//            'errors' => 'array',
//            'success' => 'boolean'
//        ]);
    }

}

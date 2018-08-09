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
     * @see    https://jira-v2.skynix.company/browse/SI-946
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

}

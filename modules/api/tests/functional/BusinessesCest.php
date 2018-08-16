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
     * @see    https://jira.skynix.company/browse/SCA-54
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchBusinessesCest(FunctionalTester $I, \Codeception\Scenario $scenario)
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
            'data' => ['businesses' =>
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

}
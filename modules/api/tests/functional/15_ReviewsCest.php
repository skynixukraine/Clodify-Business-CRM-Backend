<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 8/5/18
 * Time: 7:18 PM
 */
use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;


class ReviewsCest
{
    public function testReviewsAvailableForAdminAndSalesOnly(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('test fetch reviews by DEV is not possible');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userDev['id']));
        $pas    = ValuesContainer::$userDev['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


        $I->sendGET(ApiEndpoints::REVIEWS );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);


        $I->wantTo('test fetch reviews by PM is not possible');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userPm['id']));
        $pas    = ValuesContainer::$userPm['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


        $I->sendGET(ApiEndpoints::REVIEWS );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);


        $I->wantTo('test fetch reviews by FIN is not possible');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userFin['id']));
        $pas    = ValuesContainer::$userFin['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


        $I->sendGET(ApiEndpoints::REVIEWS );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);

        $I->wantTo('test fetch reviews by CLIENT is not possible');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userClient['id']));
        $pas    = ValuesContainer::$userClient['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


        $I->sendGET(ApiEndpoints::REVIEWS );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);


        $I->wantTo('test fetch reviews by ADMIN is  possible');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas    = ValuesContainer::$userAdmin['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


        $I->sendGET(ApiEndpoints::REVIEWS );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

        $I->wantTo('test fetch reviews by SALES is  possible');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas    = ValuesContainer::$userSales['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


        $I->sendGET(ApiEndpoints::REVIEWS );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

    }


    public function testReviewsAreValid(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('test reviews are valid');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas    = ValuesContainer::$userAdmin['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


        $I->sendGET(ApiEndpoints::REVIEWS );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

        $I->seeResponseMatchesJsonType([
            'data' => [

                [
                    'id'            => 'integer',
                    'date_start'    => 'string',
                    'date_end'      => 'string',
                    'earned'        => 'float|integer',
                    'user'          => [
                        'id'            => 'integer',
                        'last_name'     => 'string',
                        'first_name'    => 'string',
                    ],
                ]
            ]
        ]);

    }
}
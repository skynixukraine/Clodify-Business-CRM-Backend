<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 12/17/18
 * Time: 5:31 PM
 */
use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

class MonthlyReviewCest
{
    public function testOnlyOwnMonthlyReviewsAvailableForDevSalesPmFin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('test fetch only own monthly reviews by DEV is possible');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userDev['id']));
        $pas    = ValuesContainer::$userDev['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


        $I->sendGET(ApiEndpoints::MONTHLY_REVIEWS );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), true);
        $I->assertEmpty($response['errors']);
        $I->assertEquals(true, $response['success']);
        $I->assertLessThanOrEqual(1, $response['data']['total_records']);
        if ( $response['data']['total_records'] > 0 ) {

            $I->assertEquals(ValuesContainer::$userDev['id'], $response['data']['reviews'][0]['user']['id']);

        }

        $I->wantTo('test fetch monthly reviews by PM is possible');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userPm['id']));
        $pas    = ValuesContainer::$userPm['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


        $I->sendGET(ApiEndpoints::MONTHLY_REVIEWS );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), true);
        $I->assertEmpty($response['errors']);
        $I->assertEquals(true, $response['success']);
        $I->assertLessThanOrEqual(1, $response['data']['total_records']);
        if ( $response['data']['total_records'] > 0 ) {

            $I->assertEquals(ValuesContainer::$userPm['id'], $response['data']['reviews'][0]['user']['id']);

        }

        $I->wantTo('test fetch monthly reviews by FIN is possible');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userFin['id']));
        $pas    = ValuesContainer::$userFin['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


        $I->sendGET(ApiEndpoints::MONTHLY_REVIEWS );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), true);
        $I->assertEmpty($response['errors']);
        $I->assertEquals(true, $response['success']);
        $I->assertLessThanOrEqual(1, $response['data']['total_records']);
        if ( $response['data']['total_records'] > 0 ) {

            $I->assertEquals(ValuesContainer::$userFin['id'], $response['data']['reviews'][0]['user']['id']);

        }
        $I->wantTo('test fetch monthly reviews by SALES is possible');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas    = ValuesContainer::$userSales['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendGET(ApiEndpoints::MONTHLY_REVIEWS );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), true);
        $I->assertEmpty($response['errors']);
        $I->assertEquals(true, $response['success']);
        $I->assertLessThanOrEqual(1, $response['data']['total_records']);
        if ( $response['data']['total_records'] > 0 ) {

            $I->assertEquals(ValuesContainer::$userSales['id'], $response['data']['reviews'][0]['user']['id']);

        }

        $I->wantTo('test fetch reviews by CLIENT is not possible');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userClient['id']));
        $pas    = ValuesContainer::$userClient['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendGET(ApiEndpoints::MONTHLY_REVIEWS );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), true);
        $I->assertNotEmpty($response['errors']);
        $I->assertEquals(false, $response['success']);


        $I->wantTo('test fetch monthly reviews by ADMIN is possible');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas    = ValuesContainer::$userAdmin['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);


        $I->sendGET(ApiEndpoints::MONTHLY_REVIEWS );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), true);
        $I->assertEmpty($response['errors']);
        $I->assertEquals(true, $response['success']);
        $I->assertGreaterThanOrEqual(0, $response['data']['total_records']);
        if ( $response['data']['total_records'] > 0 ) {

            $I->seeResponseMatchesJsonType([
                'data' => [

                    'reviews' => [
                        [
                            'id'            => 'integer',
                            'date_from'     => 'string',
                            'date_to'       => 'string',
                            'score_loyalty' => 'integer',
                            'score_performance' => 'integer',
                            'score_earnings'    => 'integer',
                            'score_total'       => 'integer',
                            'user'          => [
                                'id'            => 'integer',
                                'last_name'     => 'string',
                                'first_name'    => 'string',
                            ],
                        ]
                    ],
                    'total_records' => 'integer'
                ]
            ]);

        }

    }
}
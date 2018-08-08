<?php
/**
 * Created by Skynix Team
 * Date: 03.04.17
 * Time: 12:37
 */

use Helper\OAuthSteps;

class PaymentMethodsCest
{

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-946
     * @param FunctionalTester $I
     */
    public function testFetchPaymentMethods(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

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

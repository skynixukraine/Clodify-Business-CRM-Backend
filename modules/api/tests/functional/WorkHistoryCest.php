<?php
/**
 * Created by Skynix Team
 * Date: 19.04.17
 * Time: 18:46
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

class WorkHistoryCest
{
    const TYPE_USER_FAILS       = 'fails';

    const TYPE_USER_EFFORTS     = 'efforts';

    const TYPE_ADMIN_BENEFITS   = 'benefits';

    const TYPE_PUBLIC           = 'public';


    public function testPostACustomItemOfWorkHistoryCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing add a custom work history item');
        $I->sendPOST(ApiEndpoints::USERS . '/' . ValuesContainer::$userFin['id'] . '/work-history', json_encode([
            'type'          => self::TYPE_USER_FAILS,
            'title'         => 'Some fail happened, contract was lost.',
            'date_start'    => date('d/m/Y'),
            'date_end'      => date('d/m/Y'),
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);

        $I->wantTo('Testing a custom work history data added');
        $I->sendGET(ApiEndpoints::USERS . '/' . ValuesContainer::$userFin['id'] . '/work-history',
            ['from_date' => date('d/m/Y'), 'end_date' => date('d/m/Y')]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->assertEquals(1, count($response->data->workHistory));


        $I->sendPOST(ApiEndpoints::USERS . '/' . ValuesContainer::$userDev['id'] . '/work-history', json_encode([
            'type'          => self::TYPE_USER_FAILS,
            'title'         => 'Some fail happened, contract was lost.',
            'date_start'    => date('d/m/Y'),
            'date_end'      => date('d/m/Y'),
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

    }

    /**
     * @see    https://jira.skynix.co/browse/SCA-172
     * @param  FunctionalTester $I
     */
    public function testViewWorkHisrtoryCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing view work history data');
        $I->sendGET(ApiEndpoints::USERS . '/' . ValuesContainer::$userDev['id'] . '/work-history',
            ['from_date' => date('d/m/Y', strtotime('now -61 days'))]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['workHistory' =>
                [
                    [
                        'id' => 'integer',
                        'date_start' => 'string',
                        'date_end' => 'string',
                        'type' => 'string',
                        'title' => 'string',
                    ]
                ]
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        $typeBenefitsExist  = false;
        $typeEffortsExist   = false;
        $typeFailsExist     = false;
        foreach ( $response->data->workHistory as $item) {

            if ( $item->type === self::TYPE_ADMIN_BENEFITS ) {

                $typeBenefitsExist = true;

            } else if ( $item->type === self::TYPE_USER_EFFORTS ) {

                $typeEffortsExist = true;

            } else if ( $item->type === self::TYPE_USER_FAILS ) {

                $typeFailsExist = true;

            }

        }
        $I->wantTo('Testing fail work history data exists');
        $I->assertEquals(true, $typeFailsExist);
        $I->wantTo('Testing benefits work history data exists');
        $I->assertEquals(true, $typeBenefitsExist);
        $I->wantTo('Testing effort work history data exists');
        $I->assertEquals(true, $typeEffortsExist);
    }

    public function testViewPUBLICWorkHisrtoryIsNotAvailableCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('Testing view Public work history data is not avaialble because is not implemented yet');
        $I->sendGET(ApiEndpoints::USERS . '/crm-dev/work-history',
            ['from_date' => date('d/m/Y', strtotime('now -10 days'))]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array',
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        $I->assertEquals(0, count($response->data->workHistory));

    }


}
<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 22.08.17
 * Time: 17:15
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

class SalaryReportsCest
{
 //   private $finacialReportId;

    /**
     * @param \Codeception\Scenario $scenario
     */
    public function _before(\Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
    }

    /**
     * @see    https://jira.skynix.company/browse/SCA-3
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchSalaryReportCest(FunctionalTester $I)
    {
        $I->haveInDatabase('salary_reports', array(
            'id' => 17,
            'report_date' => 1437609600,
            'total_salary' => 9000,
            'official_salary' => 1500,
            'bonuses' => 600,
            'hospital' => 400,
            'day_off' => 0,
            'overtime' => 0,
            'other_surcharges' => 0,
            'subtotal' => 3232,
            'currency_rate' => 26.5,
            'total_to_pay' => 3200,
            'number_of_working_days' => 20
        ));

        $I->wantTo('Testing fetch salary report data');
        $I->sendGET(ApiEndpoints::SALARY_REPORTS);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['reports' =>
                [
                    [
                        'id' => 'integer',
                        'report_date' => 'string',
                        'total_salary' => 'float | integer',
                        'official_salary' => 'float | integer',
                        'bonuses' => 'float | integer',
                        'hospital' => 'float | integer',
                        'day_off' => 'float | integer',
                        'overtime' => 'float | integer',
                        'other_surcharges' => 'float | integer',
                        'subtotal' => 'float | integer',
                        'currency_rate' => 'float | integer',
                        'total_to_pay' => 'float | integer',
                        'number_of_working_days' => 'integer',

                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }
}
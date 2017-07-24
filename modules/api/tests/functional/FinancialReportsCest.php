<?php

/**
 * Created by PhpStorm.
 * User: igor
 * Date: 24.07.17
 * Time: 11:43
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;

/**
 * Class FinancialReportsCest
 */
class FinancialReportsCest
{

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-972
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCreateFinancialReportCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create financial reports');
        $I->sendPOST(ApiEndpoints::FINANCIAL_REPORTS, json_encode(
            [
                'report_date' => '2019-02-03'
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'data'    => [
                    'report_id' => 'integer',
                ],
                'errors'  => 'array',
                'success' => 'boolean'
            ]
        );
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-1025
     * @param  FunctionalTester $I
     * @return void
     */
    public function testViewFinancialReportsCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $income = array(
            array(

                "amount" => 2000,
                "description" => "Some Income1",
                "date" => 123243543545
            ),
        );

        $expenses = array(
            array(
                "amount" => 200,
                "description" => "Some Expenses4",
            ),
        );

        $investments = array(
            array(

                "amount" => 200,
                "description" => "Investments1"
            ),
        );

        $I->haveInDatabase('financial_reports',
            array(
                'id' => 1,
                'report_date' => strtotime('2017-08-01'),
                'currency' => 26.6,
                'income' => json_encode($income),
                'expense_constant' => json_encode($expenses),
                'investments' => json_encode($investments),
                'expense_salary' => 3000,
            )
        );

        $I->wantTo('Testing financial report data');
        $I->sendGET(ApiEndpoints::FINANCIAL_REPORTS . '/' . 1);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'id' => 'integer',
                'report_date' => 'string',
                'income' => 'array',
                'currency' => 'float',
                'expense_constant' => 'array',
                'expense_salary' => 'integer',
                'investments' => 'array',
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }
}
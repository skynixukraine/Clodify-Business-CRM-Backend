<?php

/**
 * Created by Skynix Team
 * Date: 24.07.17
 * Time: 11:43
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

/**
 * Class FinancialReportsCest
 */
class FinancialReportsCest
{
    private $reportId;
    /**
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function _before (FunctionalTester $I, \Codeception\Scenario $scenario)
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

        $spent_corp_events = array(
            array(

                "amount" => 2000,
                "description" => "Spent Corp Events1",
                "date" => 123243543545
            ),
        );

        $I->haveInDatabase('financial_reports',
            array(
                'id' => ValuesContainer::$FinancialReportId,
                'report_date' => strtotime('2017-08-01'),
                'currency' => 26.6,
                'income' => json_encode($income),
                'expense_constant' => json_encode($expenses),
                'investments' => json_encode($investments),
                'spent_corp_events' => json_encode($spent_corp_events),
                'expense_salary' => 3000,
            )
        );

    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-972
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCreateFinancialReportCest(FunctionalTester $I)
    {

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
    public function testViewFinancialReportsCest(FunctionalTester $I)
    {

        $I->wantTo('Testing financial report data');
        $I->sendGET(ApiEndpoints::FINANCIAL_REPORTS . '/' . ValuesContainer::$FinancialReportId);
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
                'spent_corp_events' => 'array',
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-1023
     * @param  FunctionalTester $I
     * @return void
     */
    public function testUpdateFinancialReportsCest(FunctionalTester $I)
    {
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

        $I->wantTo('Testing update financial report data');
        $I->sendPUT(ApiEndpoints::FINANCIAL_REPORTS . '/' . ValuesContainer::$FinancialReportId,
            json_encode([
                'report_date' => 'string',
                'currency' => 26.6,
                'expense_salary' => 3000,
                'income' => $income,
                'expense_constant' => $expenses,
                'investments' => $investments,

            ])
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-1024
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchFinancilReportCest(FunctionalTester $I)
    {

        $I->wantTo('Testing fetch financial report data');
        $I->sendGET(ApiEndpoints::FINANCIAL_REPORTS);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['reports' =>
                [
                    [
                        'id'            => 'integer',
                        'report_date'   => 'string',
                        'balance'       => 'integer',
                        'currency'      => 'integer',
                        'income'        => 'integer',
                        'expenses'      => 'integer',
                        'profit'        => 'integer',
                        'investments'   => 'integer'
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-1023
     * @param  FunctionalTester $I
     * @return void
     */
    public function testLockFinancialReportsCest(FunctionalTester $I)
    {
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

        $spent_corp_events = array(
            array(

                "amount" => 2000,
                "description" => "Spent Corp Events1",
                "date" => 123243543545
            ),
        );

        $I->wantTo('Testing lock financial report data');
        $I->sendPUT(ApiEndpoints::FINANCIAL_REPORTS . '/' . ValuesContainer::$FinancialReportId . '/lock',
            json_encode([
                'year' => 2111,
                'expense_salary' => 3000,
                'income' => $income,
                'expense_constant' => $expenses,
                'investments' => $investments,
                'spent_corp_events' => $spent_corp_events,
            ])
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

}

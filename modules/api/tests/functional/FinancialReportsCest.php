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
    private $finacialReportId;

    /**
     * @param \Codeception\Scenario $scenario
     */
    public function _before (\Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
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
                'report_date' => '7'
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $this->finacialReportId = $response->data->report_id;
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
        $I->sendPUT(ApiEndpoints::FINANCIAL_REPORTS . '/' . $this->finacialReportId,
            json_encode([
                'report_date' => '8',
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
     * @see    https://jira-v2.skynix.company/browse/SI-1025
     * @param  FunctionalTester $I
     * @return void
     */
    public function testViewFinancialReportsCest(FunctionalTester $I)
    {

        $I->wantTo('Testing financial report data');
        $I->sendGET(ApiEndpoints::FINANCIAL_REPORTS . '/' . $this->finacialReportId);
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
                        'currency'      => 'integer|float',
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
}

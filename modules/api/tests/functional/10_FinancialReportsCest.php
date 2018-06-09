<?php

/**
 * Created by Skynix Team
 * Date: 24.07.17
 * Time: 11:43
 */

use app\models\FinancialReport;
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
                'report_date' => ValuesContainer::$FinancialReportDate
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
                "date" => 1533157200
            ),
        );

        $I->wantTo('Testing update financial report data');
        $I->sendPUT(ApiEndpoints::FINANCIAL_REPORTS . '/' . $this->finacialReportId,
            json_encode([

                'currency'            => 26.6,
                'expense_salary'      => 3000,
                'num_of_working_days' => 30,
                'expense_constant'    => $expenses,
                'investments'         => $investments,
                'spent_corp_events'   => $spent_corp_events,

            ])
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'    => 'array|null',
            'errors'  => 'array',
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
                'id'                  => 'integer',
                'report_date'         => 'string',
                'num_of_working_days' => 'integer|null',
                'currency'            => 'float',
                'expense_constant'    => 'array',
                'expense_salary'      => 'integer',
                'investments'         => 'array',
                'spent_corp_events'   => 'array',
            ],
            'errors'  => 'array',
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
        $I->sendGET(ApiEndpoints::FETCH_FINANCIAL_REPORTS);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->meta->errors);
        $I->assertEquals(true, $response->meta->success);
        $I->seeResponseMatchesJsonType([
                'financialReport' =>
                [
                    [
                        'id'                  => 'integer',
                        'report_date'         => 'string',
                        'balance'             => 'integer',
                        'currency'            => 'float',
                        'expenses'            => 'integer',
                        'profit'              => 'integer',
                        'investments'         => 'integer',
                        'spent_corp_events'   => 'integer',
                        'num_of_working_days' => 'integer|null',
                        'is_locked'           => 'integer',
                    ]
                ],
            
            'meta'    => [
                'total'   => 'string',
                'errors'  => 'array',
                'success' => 'boolean'
            ]
        ]);
    }

    public function testFetchFinancilReportWithSearchQueryCest(FunctionalTester $I)
    {
        $period = urlencode("01/" . (ValuesContainer::$FinancialReportDate - 1) . "/" . date("Y") . " ~ " .
            "01/" . (ValuesContainer::$FinancialReportDate + 1) . "/" . date("Y"));
        $I->wantTo('Testing fetch financial report data with search_query e.g. d/m/Y ~ d/m/Y');
        $I->sendGET(ApiEndpoints::FETCH_FINANCIAL_REPORTS . '?search_query=' . $period);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->meta->errors);
        $I->assertEquals(true, $response->meta->success);
        $I->seeResponseMatchesJsonType([
            'financialReport' =>
                [
                    [
                        'id'                  => 'integer',
                        'report_date'         => 'string',
                        'balance'             => 'integer',
                        'currency'            => 'float',
                        'expenses'            => 'integer',
                        'profit'              => 'integer',
                        'investments'         => 'integer',
                        'spent_corp_events'   => 'integer',
                        'num_of_working_days' => 'integer|null',
                        'is_locked'           => 'integer',
                    ]
                ],

            'meta'    => [
                'total'   => 'string',
                'errors'  => 'array',
                'success' => 'boolean'
            ]
        ]);
    }


    public function testFetchFinancilReportBySALESCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $period = urlencode("01/" . (ValuesContainer::$FinancialReportDate - 1) . "/" . date("Y") . " ~ " .
            "01/" . (ValuesContainer::$FinancialReportDate + 1) . "/" . date("Y"));

        $I->wantTo('Testing fetch financial report data by SALES with search_query e.g. d/m/Y ~ d/m/Y');

        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas    = ValuesContainer::$userSales['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $I->sendGET(ApiEndpoints::FETCH_FINANCIAL_REPORTS . '?search_query=' . $period);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->meta->errors);
        $I->assertEquals(true, $response->meta->success);
        $I->seeResponseMatchesJsonType([
            'financialReport' =>
                [
                    [
                        'id'                    => 'integer',
                        'report_date'           => 'string',
                        'developer_expenses'    => 'float|integer',
                        'income'                => 'float|integer',
                        'bonuses'               => 'float|integer'
                    ]
                ],

            'meta'    => [
                'total'   => 'string',
                'errors'  => 'array',
                'success' => 'boolean'
            ]
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-1023
     * @param  FunctionalTester $I
     * @return void
     */
    public function testLockFinancialReportsCest(FunctionalTester $I)
    {

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
        $I->sendPUT(ApiEndpoints::FINANCIAL_REPORTS . '/' . $this->finacialReportId . '/lock',
            json_encode([
                'year'              => 2111,
                'expense_salary'    => 3000,
                'expense_constant'  => $expenses,
                'investments'       => $investments,
                'spent_corp_events' => $spent_corp_events,
            ])
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'    => 'array|null',
            'errors'  => 'array',
            'success' => 'boolean'
        ]);

        $I->seeInDatabase('financial_reports', ['id' => $this->finacialReportId, 'is_locked' => 1]);
        $I->seeInDatabase('delayed_salary', ['is_applied' => 1, 'user_id' => ValuesContainer::$userDev['id'], 'value' => ValuesContainer::$DevSalary, 'month' => ValuesContainer::$DelayedSalaryDate]);
        $I->seeInDatabase('users', ['salary' => ValuesContainer::$DevSalary, 'id' => ValuesContainer::$userDev['id']]);
    }

    public function testUnlockFinancialReportsCest(FunctionalTester $I)
    {
        $I->wantTo('Testing lock financial report data');
        $I->sendPUT(ApiEndpoints::FINANCIAL_REPORTS . '/' . $this->finacialReportId . '/unlock');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'    => 'array|null',
            'errors'  => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-1032
     * @param  FunctionalTester $I
     * @return void
     */
    public function testYearlyFinancialReportsCest(FunctionalTester $I)
    {
        $I->wantTo('Testing yearly financial report data');
        $I->sendGET(ApiEndpoints::FINANCIAL_REPORTS . '/yearly');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                [
                    'id'                => 'integer',
                    'year'              => 'integer',
                    'expense_constant'  => 'integer',
                    'investments'       => 'integer',
                    'expense_salary'    => 'integer',
                    'difference'        => 'integer',
                    'bonuses'           => 'integer',
                    'corp_events'       => 'integer',
                    'profit'            => 'integer',
                    'balance'           => 'integer',
                    'spent_corp_events' => 'integer',

                ],
            ],
            'errors' => 'array',
            'success' => 'boolean'

        ]);
    }

}

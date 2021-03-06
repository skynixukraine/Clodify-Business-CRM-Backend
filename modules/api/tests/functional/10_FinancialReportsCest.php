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

    private $salesIncome = 500.5;

    private $salesIncomeId;

    private $adminIncome = 300;

    private $adminIncomeId;

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
                'report_date'   => ValuesContainer::$FinancialReportDate,
                'report_year'   => ValuesContainer::$FinancialReportYear
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $this->finacialReportId = ValuesContainer::$FinancialReportId = $response->data->report_id;
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
        if ( ValuesContainer::$FinancialReportDate > 1 ) {

            $period = "01/" .
                (ValuesContainer::$FinancialReportDate - 1) . "/" .
                ValuesContainer::$FinancialReportYear;

        } else {

            $period =  "01/12/" . (ValuesContainer::$FinancialReportYear - 1);

        }
        $period .= " ~ ";
        if ( ValuesContainer::$FinancialReportDate < 12 ) {

            $period .= "01/" . (ValuesContainer::$FinancialReportDate + 1) . "/" .
                ValuesContainer::$FinancialReportYear;
        } else {

            $period .= "01/01/" . (ValuesContainer::$FinancialReportYear + 1);

        }

        $I->wantTo('Testing fetch financial report data with search_query e.g. d/m/Y ~ d/m/Y');
        $I->sendGET(ApiEndpoints::FETCH_FINANCIAL_REPORTS . '?search_query=' . urlencode($period));
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
        if ( ValuesContainer::$FinancialReportDate > 1 ) {

            $period = "01/" .
                (ValuesContainer::$FinancialReportDate - 1) . "/" .
                ValuesContainer::$FinancialReportYear;

        } else {

            $period =  "01/12/" . (ValuesContainer::$FinancialReportYear - 1);

        }
        $period .= " ~ ";
        if ( ValuesContainer::$FinancialReportDate < 12 ) {

            $period .= "01/" . (ValuesContainer::$FinancialReportDate + 1) . "/" .
                ValuesContainer::$FinancialReportYear;
        } else {

            $period .= "01/01/" . (ValuesContainer::$FinancialReportYear + 1);

        }
        $I->wantTo('Testing fetch financial report data by SALES with search_query e.g. d/m/Y ~ d/m/Y');

        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas    = ValuesContainer::$userSales['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $I->sendGET(ApiEndpoints::FETCH_FINANCIAL_REPORTS . '?search_query=' . urlencode($period));
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
                        'developer_expenses'    => 'float|integer|string',
                        'income'                => 'float|integer',
                        'bonuses'               => 'float|integer',
                        'is_locked'             => 'integer'
                    ]
                ],

            'meta'    => [
                'total'   => 'string',
                'errors'  => 'array',
                'success' => 'boolean'
            ]
        ]);
    }

    public function testAddFinancialIncomeCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Testing add financial income data by SALES');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas    = ValuesContainer::$userSales['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $I->sendPOST(ApiEndpoints::FINANCIAL_REPORTS . '/' . $this->finacialReportId . ApiEndpoints::FINANCIAL_REPORTS_INCOME,
            json_encode([
                'from_date'         => 1,
                'to_date'           => 2,
                'amount'            => $this->salesIncome,
                'description'       => "Upwork Contract May #32",
                'project_id'        => ValuesContainer::$projectId,
                'developer_user_id' => ValuesContainer::$userDev['id'],
            ])
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'    => 'array|null',
            'errors'  => 'array',
            'success' => 'boolean'
        ]);


        $I->wantTo('Testing add financial income data by ADMIN');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas    = ValuesContainer::$userAdmin['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $I->sendPOST(ApiEndpoints::FINANCIAL_REPORTS . '/' . $this->finacialReportId . ApiEndpoints::FINANCIAL_REPORTS_INCOME,
            json_encode([
                'from_date'         => 2,
                'to_date'           => 3,
                'amount'            => $this->adminIncome,
                'description'       => "Upwork Contract #33",
                'project_id'        => ValuesContainer::$projectId,
                'developer_user_id' => ValuesContainer::$userDev['id'],
            ])
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'    => 'array|null',
            'errors'  => 'array',
            'success' => 'boolean'
        ]);

    }

    public function testFetchFinancilIncomeCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('Testing fetch financial income data by ADMIN');


        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
        $I->sendGET(ApiEndpoints::FINANCIAL_REPORTS . '/' . $this->finacialReportId . ApiEndpoints::FINANCIAL_REPORTS_INCOME);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            "data" => [
                [
                    "id"            => 'integer',
                    "from_date"     => 'integer',
                    "to_date"       => 'integer',
                    "date"          => 'integer',
                    "amount"        => 'integer',
                    "description"   => "string",
                    "project"       => [
                        "id"            => "integer",
                        "name"          => "string",
                        "milestones"    => "array"
                    ],
                    "developer_user" => [
                        "id"    => "integer",
                        "name"  => "string"
                    ],
                    "added_by_user" => [
                        "id"    => "integer",
                        "name"  => "string"
                    ]
                ]
            ],
            'errors'  => 'array',
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



    /**
     * @see https://jira.skynix.co/browse/SCA-177
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFetchFinancialIncomeCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Testing fetch financial income data by SALES');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas    = ValuesContainer::$userSales['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $I->sendGET(ApiEndpoints::FINANCIAL_REPORTS . '/' . $this->finacialReportId . ApiEndpoints::FINANCIAL_REPORTS_INCOME);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'    => 'array',
            'errors'  => 'array',
            'success' => 'boolean'
        ]);
        $amount = 0;
        foreach ( $response->data as $item ) {

            $amount += $item->amount;
            $this->salesIncomeId = $item->id;

        }
        $I->assertEquals($amount, $this->salesIncome);


        $I->wantTo('Testing fetch financial income data by ADMIN');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas    = ValuesContainer::$userAdmin['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $I->sendGET(ApiEndpoints::FINANCIAL_REPORTS . '/' . $this->finacialReportId . ApiEndpoints::FINANCIAL_REPORTS_INCOME);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'    => 'array',
            'errors'  => 'array',
            'success' => 'boolean'
        ]);
        $amount = 0;
        foreach ( $response->data as $item ) {

            $amount += $item->amount;
            if ( $item->added_by_user->id == ValuesContainer::$userAdmin['id'] ) {

                $this->adminIncomeId = $item->id;

            }

        }
        $I->assertEquals($amount, ($this->salesIncome + $this->adminIncome));

    }

    public function testFetchFinancialBonusesCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Testing fetch own financial bonuses  by SALES');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas    = ValuesContainer::$userSales['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendGET(ApiEndpoints::FINANCIAL_REPORTS . '/' . $this->finacialReportId . ApiEndpoints::FINANCIAL_REPORTS_BONUSES);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                [
                    'id'                => 'integer',
                    'added_by'          => 'array',
                    'project'           => 'array',
                    'expenses'          => 'integer',
                    'income'            => 'integer',
                    'bonuses'           => 'integer'

                ],
            ],
            'errors' => 'array',
            'success' => 'boolean'

        ]);

    }


    public function testDeleteFinancialIncomeCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Testing delete not own financial income data by SALES is not available');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas    = ValuesContainer::$userSales['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $I->sendDELETE(ApiEndpoints::FINANCIAL_REPORTS . '/' .
            $this->finacialReportId . ApiEndpoints::FINANCIAL_REPORTS_INCOME . "/" . $this->adminIncomeId );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);

        $I->wantTo('Testing delete own financial income data by SALES is available');

        $I->sendDELETE(ApiEndpoints::FINANCIAL_REPORTS . '/' .
            $this->finacialReportId . ApiEndpoints::FINANCIAL_REPORTS_INCOME . "/" . $this->salesIncomeId );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'    => 'null',
            'errors'  => 'array',
            'success' => 'boolean'
        ]);


        $I->wantTo('Testing delete financial income data by ADMIN');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas    = ValuesContainer::$userAdmin['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $I->sendDELETE(ApiEndpoints::FINANCIAL_REPORTS . '/' .
            $this->finacialReportId . ApiEndpoints::FINANCIAL_REPORTS_INCOME . "/" . $this->adminIncomeId );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'    => 'null',
            'errors'  => 'array',
            'success' => 'boolean'
        ]);


        $I->wantTo('Testing fetch financial income data by ADMIN, no income, it is all deleted');
        $email  = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas    = ValuesContainer::$userAdmin['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);
        $I->sendGET(ApiEndpoints::FINANCIAL_REPORTS . '/' . $this->finacialReportId . ApiEndpoints::FINANCIAL_REPORTS_INCOME);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'    => 'array',
            'errors'  => 'array',
            'success' => 'boolean'
        ]);

        $I->assertEquals(count($response->data), 0);
    }

    private function testWithdrawInvoiceFailForUser(FunctionalTester $I, \Codeception\Scenario $scenario, $user = null)
    {
        if (is_array($user)) {
            $oAuth = new OAuthSteps($scenario);
            $oAuth->login($user['email'], $user['password']);
        }

        $I->sendPOST(ApiEndpoints::FINANCIAL_REPORTS . '/' . ValuesContainer::$FinancialReportId . '/withdraw-invoice/' . ValuesContainer::$invoiceId,
            json_encode([
                'parties' => [
                    [
                        'id' => 1,
                        'amount' => 300,
                    ],
                    [
                        'id' => 3,
                        'amount' => 200,
                    ],
                ],
            ]));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->assertEquals($response->data, null);
    }

    public function withdrawInvoiceFailForRoles(FunctionalTester $I, \Codeception\Scenario $scenario): void
    {
        $this->testWithdrawInvoiceFailForUser($I, $scenario, ValuesContainer::$userDev);
        $this->testWithdrawInvoiceFailForUser($I, $scenario, ValuesContainer::$userClient);
        $this->testWithdrawInvoiceFailForUser($I, $scenario, ValuesContainer::$userPm);
        $this->testWithdrawInvoiceFailForUser($I, $scenario);
    }

    public function withdrawInvoiceFailIfReportNotFound(FunctionalTester $I, \Codeception\Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendPOST(ApiEndpoints::FINANCIAL_REPORTS . '/555/withdraw-invoice/' . ValuesContainer::$invoiceId,
            json_encode([
                'parties' => [
                    [
                        'id' => 1,
                        'amount' => 300,
                    ],
                    [
                        'id' => 3,
                        'amount' => 200,
                    ],
                ],
            ]));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->assertEquals($response->data, null);
    }

    public function withdrawInvoiceFailIfInvoiceNotFound(FunctionalTester $I, \Codeception\Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendPOST(ApiEndpoints::FINANCIAL_REPORTS . '/' . ValuesContainer::$FinancialReportId . '/withdraw-invoice/555',
            json_encode([
                'parties' => [
                    [
                        'id' => 1,
                        'amount' => 300,
                    ],
                    [
                        'id' => 3,
                        'amount' => 200,
                    ],
                ],
            ]));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->assertEquals($response->data, null);
    }

    public function withdrawInvoiceFailIfInvoiceWithdrawn(FunctionalTester $I, \Codeception\Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendPOST(ApiEndpoints::FINANCIAL_REPORTS . '/' . ValuesContainer::$FinancialReportId . '/withdraw-invoice/' . ValuesContainer::$withdrawnInvoiceId,
            json_encode([
                'parties' => [
                    [
                        'id' => 1,
                        'amount' => 300,
                    ],
                    [
                        'id' => 3,
                        'amount' => 200,
                    ],
                ],
            ]));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->assertEquals($response->data, null);
    }

    public function withdrawInvoiceFailIfWrongParams(FunctionalTester $I, \Codeception\Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendPOST(ApiEndpoints::FINANCIAL_REPORTS . '/' . ValuesContainer::$FinancialReportId . '/withdraw-invoice/' . ValuesContainer::$invoiceId, [
            'parties' => 'qwerty'
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->assertEquals($response->data, null);
    }

    public function withdrawInvoiceFailIfWrongKeys(FunctionalTester $I, \Codeception\Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendPOST(ApiEndpoints::FINANCIAL_REPORTS . '/' . ValuesContainer::$FinancialReportId . '/withdraw-invoice/' . ValuesContainer::$invoiceId,
            json_encode([
                'parties' => [
                    [
                        'i2d' => 1,
                        'amou2nt' => 300,
                    ],
                    [
                        'id' => 3,
                        'amount' => 200,
                    ],
                ],
            ]));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->assertEquals($response->data, null);
    }

    public function withdrawInvoiceFailIfWrongAmount(FunctionalTester $I, \Codeception\Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendPOST(ApiEndpoints::FINANCIAL_REPORTS . '/' . ValuesContainer::$FinancialReportId . '/withdraw-invoice/' . ValuesContainer::$invoiceId,
            json_encode([
                'parties' => [
                    [
                        'id' => 1,
                        'amount' => 200,
                    ],
                    [
                        'id' => 3,
                        'amount' => 200,
                    ],
                ],
            ]));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->assertEquals($response->data, null);
    }

    private function testWithdrawInvoiceSuccessForUser(FunctionalTester $I, \Codeception\Scenario $scenario, array $user): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($user['email'], $user['password']);

        $I->sendPOST(ApiEndpoints::FINANCIAL_REPORTS . '/' . ValuesContainer::$FinancialReportId . '/withdraw-invoice/' . (++ValuesContainer::$invoiceId),
            json_encode([
                'parties' => [
                    [
                        'id' => 1,
                        'amount' => 300,
                    ],
                    [
                        'id' => 3,
                        'amount' => 200,
                    ],
                ],
            ]));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals($response->success, true);
        $I->assertEquals($response->data, null);

        $I->seeInDatabase('financial_income', [
            'invoice_id' => ValuesContainer::$invoiceId,
            'financial_report_id' => ValuesContainer::$FinancialReportId,
            'amount' => 300,
            'added_by_user_id' => $user['id'],
            'developer_user_id' => 1,
        ]);

        $I->seeInDatabase('financial_income', [
            'invoice_id' => ValuesContainer::$invoiceId,
            'financial_report_id' => ValuesContainer::$FinancialReportId,
            'amount' => 200,
            'added_by_user_id' => $user['id'],
            'developer_user_id' => 3,
        ]);

        $I->seeInDatabase('invoices', [
            'id' => ValuesContainer::$invoiceId,
            'is_withdrawn' => 1,
        ]);
    }

    public function withdrawInvoiceSuccessForRoles(FunctionalTester $I, \Codeception\Scenario $scenario): void
    {
        $this->testWithdrawInvoiceSuccessForUser($I, $scenario, ValuesContainer::$userAdmin);
        $this->testWithdrawInvoiceSuccessForUser($I, $scenario, ValuesContainer::$userFin);
        $this->testWithdrawInvoiceSuccessForUser($I, $scenario, ValuesContainer::$userSales);
    }
}

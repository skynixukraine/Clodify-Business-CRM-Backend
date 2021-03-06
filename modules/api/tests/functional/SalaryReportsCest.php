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
    private $salaryReportId;
    private $salaryReportListId;

    /**
     * @param \Codeception\Scenario $scenario
     */
    public function _before(\Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
    }

    /**
     * @see    https://jira.skynix.company/browse/SCA-6
     * @param  FunctionalTester $I
     * @return void
     */

    public function testCreateSalaryReportCest(FunctionalTester $I)
    {

        $I->wantTo('Testing create salary reports');
        $I->sendPOST(ApiEndpoints::SALARY_REPORTS, json_encode(
            [
                'report_date'   => ValuesContainer::$FinancialReportDate,
                'report_year'   => ValuesContainer::$FinancialReportYear
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
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
        $this->salaryReportId = $response->data->report_id;
    }


    /**
     * @see    https://jira.skynix.company/browse/SCA-3
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchSalaryReportCest(FunctionalTester $I)
    {
        $I->haveInDatabase('salary_reports', array(
            'id'                     => $this->salaryReportId + 2,
            'report_date'            => date('Y-m-t'),
            'total_salary'           => 9000,
            'official_salary'        => 1500,
            'bonuses'                => 600,
            'hospital'               => 400,
            'day_off'                => 0,
            'overtime'               => 0,
            'other_surcharges'       => 0,
            'subtotal'               => 3232,
            'currency_rate'          => 26.5,
            'total_to_pay'           => 3200,
            'number_of_working_days' => 20,
            'total_employees'        => 12
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
                        'id'                     => 'integer',
                        'report_date'            => 'string',
                        'total_salary'           => 'float | integer',
                        'official_salary'        => 'float | integer',
                        'bonuses'                => 'float | integer',
                        'hospital'               => 'float | integer',
                        'day_off'                => 'float | integer',
                        'overtime'               => 'float | integer',
                        'other_surcharges'       => 'float | integer',
                        'subtotal'               => 'float | integer',
                        'currency_rate'          => 'float | integer',
                        'total_to_pay'           => 'float | integer',
                        'number_of_working_days' => 'integer',
                        "total_reported_hours"   => 'float | integer',
                        "total_approved_hours"   => 'float | integer',
                        'total_users'            => 'integer',
                        'total_lists'            => 'integer',
                        'is_locked'              => 'string',
                        'total_employees'        => 'integer'

                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * see https://jira.skynix.co/browse/SCA-152
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testFetchSalaryReportById(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch one salary report data by its ID');
        $I->sendGET(ApiEndpoints::SALARY_REPORTS, [
            'id'    => $this->salaryReportId
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->assertEquals(1, $response->data->total_records);

    }



    /**
     * @see    https://jira.skynix.company/browse/SCA-6
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCreateSalaryReportListsCest(FunctionalTester $I)
    {
        $I->haveInDatabase('financial_reports', array(
            'report_date' => '2018-01-02',  //  02 Jan 2018
            'currency' => 26.6,
            'expense_salary' => 3000,
            'num_of_working_days' => 30,
        ));

        $I->wantTo('Testing create salary report lists');
        $I->sendPOST(ApiEndpoints::SALARY_REPORTS . '/' . $this->salaryReportId . '/lists', json_encode(
            [
                'user_id'           => ValuesContainer::$userSales['id'],
                'hospital_days'     => '1',
                'bonuses'           => '40',
                'overtime_days'     => '0',
                'other_surcharges'  => '0',
                'vacation_days'     => 0
            ]
        ));
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $this->salaryReportListId = $response->data->list_id;
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'list_id' => 'integer',
                ],
                'errors' => 'array',
                'success' => 'boolean'
            ]
        );
    }


    /**
     * @see    https://jira.skynix.company/browse/SCA-16?src=confmacro
     * @param  FunctionalTester $I
     * @return void
     */
    public function testUpdateSalaryReportListsCest(FunctionalTester $I)
    {

        $I->haveInDatabase('financial_reports', array(
            'report_date'         => '2018-02-01',   //  01 Feb 2018
            'currency'            => 26.6,
            'expense_salary'      => 3000,
            'num_of_working_days' => 30,
        ));


        $I->wantTo('Testing update salary report lists');
        $I->sendPUT(ApiEndpoints::SALARY_REPORTS . '/' . $this->salaryReportId . '/lists/' . $this->salaryReportListId , json_encode(
            [
                'worked_days'      => '21',
                'hospital_days'    => '1',
                'bonuses'          => '40',
                'day_off'          => '0',
                'overtime_days'    => '0',
                'other_surcharges' => '0',
            ]
        ));
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'data' => 'array|null',
                'errors' => 'array',
                'success' => 'boolean'
            ]
        );
    }

     /**
     * @see    https://jira.skynix.company/browse/SCA-7
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchSalaryReportListCest(FunctionalTester $I)
    {

        $I->wantTo('Testing fetch salary report list data');
        $I->sendGET(ApiEndpoints::SALARY_REPORTS . '/' . $this->salaryReportId . '/lists');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        codecept_debug($response);
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['lists' =>
                [
                    [
                        'id'                         => 'integer',
                        'salary_report_id'           => 'integer',
                        'user'                       => 'array',
                        'salary'                     => 'integer',
                        'worked_days'                => 'integer',
                        'actually_worked_out_salary' => 'integer',
                        'official_salary'            => 'integer | float',
                        'hospital_days'              => 'integer',
                        'hospital_value'             => 'integer | float',
                        'bonuses'                    => 'integer | float',
                        'day_off'                    => 'integer',
                        'overtime_days'              => 'integer',
                        'overtime_value'             => 'integer | float',
                        'vacation_days'              => 'integer',
                        'vacation_value'             => 'integer | float',
                        'other_surcharges'           => 'integer | float',
                        'subtotal'                   => 'integer | float',
                        'currency_rate'              => 'integer | float',
                        'subtotal_uah'               => 'integer | float',
                        'total_to_pay'               => 'integer | float',
                        "reported_hours"             => 'integer',
                        "approved_hours"             => 'integer'
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira.skynix.company/browse/SCA-15
     * @param  FunctionalTester $I
     * @return void
     */
    public function testDownloadSalaryReportCest(FunctionalTester $I)
    {

        $I->wantTo('Testing download salary report to pdf');
        $I->sendGET(ApiEndpoints::SALARY_REPORTS . '/' . $this->salaryReportId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'  =>  [
                'pdf'  => 'string',
                'name' => 'string'
            ],
            'errors'  => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira.skynix.company/browse/SCA-15
     * @param  FunctionalTester $I
     * @return void
     */
    public function testDeleteSalaryReportListsCest(FunctionalTester $I)
    {

        $I->wantTo('Testing delete salary report list data');
        $I->sendDELETE(ApiEndpoints::SALARY_REPORTS . '/' . $this->salaryReportId . '/lists/' . $this->salaryReportListId);
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
<?php

/**
 * Created by Skynix Team
 * Date: 27.04.18
 * Time: 11:43
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

/**
 * Class DelayedSalaryCest
 */
class DelayedSalaryCest
{
    private $delayedSalaryId;

    /**
     * @param \Codeception\Scenario $scenario
     */
    public function _before(\Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
    }

    /**
     * @see    https://jira.skynix.co/browse/SCA-147
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCreateDelayedSalaryRequestCest(FunctionalTester $I)
    {

        ValuesContainer::$FinancialReportDate = (int)date('n');
        if ( ValuesContainer::$FinancialReportDate > 1 ) {

            ValuesContainer::$FinancialReportDate--;

        } else {

            ValuesContainer::$FinancialReportDate = 12;

        }
        ValuesContainer::$DelayedSalaryDate     = date('m');

        $I->wantTo('Testing create delayed salary request');
        $I->sendPOST(ApiEndpoints::DELAYED_SALARY, json_encode(
            [
                "user_id"   => ValuesContainer::$userDev['id'],
                "month"     => ValuesContainer::$DelayedSalaryDate,
                "value"     => ValuesContainer::$DevSalary
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $this->delayedSalaryId = $response->data->delayed_salary_id;
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'data' => [
                    'delayed_salary_id' => 'integer',
                ],
                'errors' => 'array',
                'success' => 'boolean'
            ]
        );

        $I->seeInDatabase('delayed_salary', ['id' => $this->delayedSalaryId, 'user_id' => ValuesContainer::$userDev['id']]);
    }
}
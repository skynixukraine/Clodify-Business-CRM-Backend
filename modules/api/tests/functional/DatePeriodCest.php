<?php

use Helper\ApiEndpoints;
use Yii;
use api\Step\Functional\OAuthSteps;

class DatePeriodCest
{
	/**
	 * @see    http://jira.skynix.company:8070/browse/SI-434
	 * @param  FunctionalTester      $I
	 * @return void
	 */
	public function gettingReportsDatePeriod(FunctionalTester $I, \Codeception\Scenario $scenario)
	{

		$I->wantTo('Getting date periods of reports');
		$oAuth = new OAuthSteps($scenario);
		$oAuth->login();
		
		$I->sendGET(ApiEndpoints::REPORT . '/date-period');

		$I->seeResponseCodeIs(200);
		
		$response = json_decode($I->grabResponse());
		codecept_debug($response->errors);
		$I->assertEmpty($response->errors);
		$I->assertEquals(1, $response->success);
	}
}

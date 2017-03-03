    <?php

    use Helper\OAuthSteps;
    use Helper\ApiEndpoints;
    use Yii;

    /**
     * Class DatePeriodCest
     * Test the getting DatePeriod List for reports :
     * Today's reports, This week reports, This month reports, Last month reports
     * Only authorized users can see this information
     */
    class DatePeriodCest
    {
        /**
         * @see    http://jira.skynix.company:8070/browse/SI-841
         * @param  FunctionalTester      $I
         * @return void
         */
        public function gettingReportsDatePeriod(FunctionalTester $I, \Codeception\Scenario $scenario)
        {
            $I->wantTo('Getting date periods of reports');
            $I->sendGET(ApiEndpoints::REPORT . '/date-period');
            $I->seeResponseCodeIs(200);
            $response = json_decode($I->grabResponse());
            //Not authorize to do this action
            $I->assertNotEmpty($response->errors);

            $oAuth = new OAuthSteps($scenario);
            $oAuth->login();
            $I->sendGET(ApiEndpoints::REPORT . '/date-period');
            $I->seeResponseCodeIs(200);

            $I->seeResponseContainsJson([
                "data" => [
                    [
                        "id" => 1,
                        "date_period" => "Today's reports"
                    ],
                    [
                        "id" => 2,
                        "date_period" => "This week reports"
                    ],
                    [
                        "id" => 3,
                        "date_period" => "This month reports"
                    ],
                    [
                        "id" => 4,
                        "date_period" => "Last month reports"
                    ],
                ]
            ]);
            $response = json_decode($I->grabResponse());
            $I->assertEmpty($response->errors);
            $I->assertEquals(1, $response->success);
        }
    }

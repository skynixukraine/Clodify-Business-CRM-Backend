<?php

use Helper\ApiEndpoints;

class PasswordCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * @see    http://jira.skynix.company:8070/browse/SI-436
     * @param  UnitTester $I
     * @return void
     */
    public function testThatChangePasswordPageWorks(FunctionalTester $I)
    {

        $I->wantTo('Test that change password page available');

        $I->sendPOST(ApiEndpoints::PASSWORD);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
            'errors' => [
                [
                    'param' => 'email',
                    'message' => 'Email cannot be blank.'
                ],
                [
                    'param' => 'captcha',
                    'message' => 'Captcha cannot be blank.'
                ],

            ],
        ]);

    }
}

<?php

use Helper\ApiEndpoints;

class PasswordCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    /**
     * @see    http://jira.skynix.company:8070/browse/SI-436
     * @param  UnitTester $I
     * @return void
     */
    public function testThatChangePasswordPageWorks(UnitTester $I)
    {

        $I->wantTo('Test that change password page available');

        // checking VM works
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

<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 10/31/18
 * Time: 10:47 AM
 */
class CheckMySsoAndLoginCest {

    public function ensureThatPageExistsAndRedirectsToLogin(AcceptanceTester $I)
    {
        $I->wantTo('Test that SSO Page exists');
        $I->amOnPage('check-my-sso-and-login');
        $I->seeInCurrentUrl('login');
    }
}
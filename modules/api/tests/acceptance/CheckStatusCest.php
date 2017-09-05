<?php

use yii\helpers\Url as Url;

class CheckStatusCest
{
    public function ensureThatActiveAvailable(AcceptanceTester $I)
    {
        $I->wantTo('Test that word Active available');
        $I->amOnPage('https://develop.skynix.co/cp/check-status');
        $I->see('Active');
    }
}

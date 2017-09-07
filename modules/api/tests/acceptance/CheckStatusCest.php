<?php

use yii\helpers\Url as Url;

class CheckStatusCest
{
    public function ensureThatActiveAvailable(AcceptanceTester $I)
    {
        $I->wantTo('Test that word Active available');
        $I->amOnPage('check-status');
        $I->see('Active');
    }
}

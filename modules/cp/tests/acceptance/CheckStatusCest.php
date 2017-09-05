<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 04.09.17
 * Time: 16:53
 */

//use yii\helpers\Url as Url;
//
//$I = new AcceptanceTester($scenario);
//$I->wantTo('Test that word Active available');
//$I = amOnPage('../check-satatus/index.php');
//$I->see('Active', '.check_active_notice');
?>
<?php
use yii\helpers\Url as Url;

class CheckStatusCestCest
{
    public function ensureThatActiveAvailable(AcceptanceTester $I)
    {
        $I->wantTo('Test that word Active available');
        $I->amOnPage(Url::toRoute('/check-satatus/index'));
        $I->see('Active', '.check_active_notice');
    }
}

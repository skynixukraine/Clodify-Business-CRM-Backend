<?php

use Helper\ApiEndpoints;
use Helper\OAuthSteps;

/**
 * Class AttachPhotoUsersCest
 */
class AttachUsersSignCest
{
    /**
     * @see    https://jira-v2.skynix.company/browse/SI-905
     * @param  FunctionalTester      $I
     * @return void
     */
    public function testAttachingUsersSign(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Test attaching users sign');
        $I->sendPOST(ApiEndpoints::ATTACH_SIGN, [], ['sign' => 'tests/_data/skynix-office.jpg']);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertNotEmpty($response->data);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'sign'   => 'string'
            ]
        ]);
        $I->assertEquals(1, $response->success);
    }
}
<?php

use Helper\ApiEndpoints;
use Helper\OAuthSteps;

/**
 * Class AttachPhotoUsersCest
 */
class AttachPhotoUsersCest
{
    /**
     * @see    https://jira-v2.skynix.company/browse/SI-904
     * @param  FunctionalTester      $I
     * @return void
     */
    public function testAttachingPhotoUsers(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Test attaching the photo');
        $I->sendPOST(ApiEndpoints::ATTACH_PHOTO, [], ['photo' => 'tests/_data/skynix-office.jpg']);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertNotEmpty($response->data);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'photo'   => 'string'
            ]
        ]);
        $I->assertEquals(1, $response->success);
    }
}

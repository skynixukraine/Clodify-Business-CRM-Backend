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

//     save to db
//       $I->sendPOST(ApiEndpoints::ATTACH_PHOTO, [], ['photo' => 'tests/_data/skynix-office.jpg']);

        $I->sendPOST(ApiEndpoints::ATTACH_PHOTO, json_encode(['photo' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAkAAAAMMCACYII=']));
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        //codecept_debug($response);
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
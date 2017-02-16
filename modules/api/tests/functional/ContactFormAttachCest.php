<?php

use Helper\Functional;

class ContactFormAttachCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * @see    http://jira.skynix.company:8070/browse/SI-434
     * @param  FunctionalTester      $I
     * @return void
     */
    public function testAttachingFilesOnContactForm(FunctionalTester $I)
    {
        $I->wantTo('Test attaching the file sending contact form');
        $I->sendPOST(Functional::CONTACT_ATTACH, [], ['fileName' => 'tests/_data/skynix-office.jpg']);
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertNotEmpty($response->data);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'file_id'   => 'integer'
            ]
        ]);
        $I->assertEquals(1, $response->success);
    }
}

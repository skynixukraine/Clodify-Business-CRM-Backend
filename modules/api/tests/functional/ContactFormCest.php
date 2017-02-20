<?php

use Helper\Functional;

class ContactFormCest
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
    public function testSendingContactForm(FunctionalTester $I)
    {
        define('name', 'Tester');
        define('email', 'test.email@gmail.com');
        define('subject', 'test subject');
        define('message', 'message of test mail');

        $I->wantTo('Test sending Contact Form with attaching files');
        $I->sendPOST(Functional::CONTACT, json_encode([
            'name' => name,
            'email' => email,
            'subject' => subject,
            'message' => message,
        ]));
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(1, $response->success);
    }
}

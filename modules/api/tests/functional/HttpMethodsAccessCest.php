<?php

use Helper\ApiEndpoints;
use app\modules\api\components\Api\Processor;

class HttpMethodsAccessCest
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
    public function testThatGetPutAndDeleteMethodsAreNotAvailableOnContactForm(FunctionalTester $I)
    {

        $I->wantTo('Test that api/contacts available only via POST method');

        // GET
        $I->sendGET(ApiEndpoints::CONTACT);
        $response = json_decode($I->grabResponse());
        $I->assertEquals($response->errors[0]->message, 'This HTTP method disallowed'); // (Processor::CODE_METHOD_NOT_ALLOWED, $response->errors[0]->param)
        $I->assertEquals(false, $response->success);

        // PUT
        $I->sendPUT(ApiEndpoints::CONTACT);
        $response = json_decode($I->grabResponse());
        $I->assertEquals($response->errors[0]->message, 'This HTTP method disallowed'); // (Processor::CODE_METHOD_NOT_ALLOWED, $response->errors[0]->param)
        $I->assertEquals(false, $response->success);

        // Delete
        $I->sendDELETE(ApiEndpoints::CONTACT);
        $response = json_decode($I->grabResponse());
        $I->assertEquals($response->errors[0]->message, 'This HTTP method disallowed'); // (Processor::CODE_METHOD_NOT_ALLOWED, $response->errors[0]->param)
        $I->assertEquals(false, $response->success);
    }
}

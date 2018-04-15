<?php
use Helper\ValuesContainer;
use Helper\OAuthSteps;
use Helper\ApiEndpoints;


class EmergencyCest
{
    const HEADER_SECURITY_TOKEN         = 'SkynixEmergency';
    const HEADER_SECURITY_TOKEN_VALUE   = 'JhzK@lDJ02H5GHmN30139kHP';
    /**
     * @see https://jira.skynix.co/browse/SCA-138
     * @param FunctionalTester $I
     */
    public function testEmergencyRegisterCest(FunctionalTester $I)
    {
        $I->wantTo('Testing Emergency is not accessible without access code');
        $I->sendPOST(ApiEndpoints::EMERGENCY);
        $I->seeResponseCodeIs(200);
        $response = $I->grabResponse();
        codecept_debug($response);
        $response = json_decode($response);
        $I->assertEquals(false, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'      => 'null',
            'errors'    => 'array',
            'success'   => 'boolean'
        ]);


        $I->wantTo('Testing Emergency is not accessible for non set user');
        $I->haveHttpHeader(self::HEADER_SECURITY_TOKEN, self::HEADER_SECURITY_TOKEN_VALUE);
        $I->sendPOST(ApiEndpoints::EMERGENCY);
        $I->seeResponseCodeIs(200);
        $response = $I->grabResponse();
        codecept_debug($response);
        $response = json_decode($response);
        $I->assertEquals(false, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'      => 'null',
            'errors'    => 'array',
            'success'   => 'boolean'
        ]);


        /* TODO Commented out until this https://jira.skynix.co/browse/DEVOPS-264 sorted out
         *
         * $I->wantTo('Testing Emergency is working fine');
        $I->haveHttpHeader(self::HEADER_SECURITY_TOKEN, self::HEADER_SECURITY_TOKEN_VALUE);
        $I->sendPOST(ApiEndpoints::EMERGENCY, json_encode([
            'user_id' => ValuesContainer::$userId
        ]));
        $I->seeResponseCodeIs(200);
        $response = $I->grabResponse();
        codecept_debug($response);
        $I->assertEquals(true, $response->success);*/


    }

}

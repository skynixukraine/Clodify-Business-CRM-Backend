<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 19.10.17
 * Time: 11:25
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

class SettingsCest
{

    /**
     * @param \Codeception\Scenario $scenario
     */
    public function _before(\Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
    }


    /**
     * @see    https://jira.skynix.company/browse/SCA-38
     * @param  FunctionalTester $I
     * @return void
     */
    public function testSettingUpdateCest(FunctionalTester $I)
    {
        define('key', 'corp_events_percentage');
        $I->haveInDatabase('settings', array(
            'key' => 'corp_events_percentage',
            'value' => 10,
            'type' => 'INT',
        ));

        $I->wantTo('Testing update salary report lists');
        $I->sendPUT(ApiEndpoints::SETTINGS . '/' . key , json_encode(
            [
                'value' => '21',
            ]
        ));
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType(
            [
                'data' => 'array|null',
                'errors' => 'array',
                'success' => 'boolean'
            ]
        );
    }
}
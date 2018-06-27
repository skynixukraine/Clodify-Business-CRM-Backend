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
    public function _before(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->haveInDatabase('settings', array(
            'key' => 'corp_events_percentage',
            'value' => 10,
            'type' => 'INT',
        ));

    }


    /**
     * @see    https://jira.skynix.company/browse/SCA-38
     * @param  FunctionalTester $I
     * @return void
     */
    public function testSettingUpdateCest(FunctionalTester $I)
    {
        define('KEY', 'corp_events_percentage');

        $I->wantTo('Testing update settings');
        $I->sendPUT(ApiEndpoints::SETTINGS . '/' . KEY , json_encode(
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

    /**
     * @see   https://jira.skynix.company/browse/SCA-39
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchSettingsCest(FunctionalTester $I)
    {
        $I->wantTo('Testing fetch all settings');
        $I->sendGET(ApiEndpoints::SETTINGS);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                    [
                        'id'              => 'integer',
                        'key'             => 'string',
                        'value'           => 'integer|string',
                        'type'            => 'string',
                    ]
            ],
            'errors' => 'array|null',
            'success' => 'boolean'
        ]);
    }
}
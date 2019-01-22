<?php
/**
 * Created by Skynix Team.
 * User: maryna zhezhel
 * Date: 18/1/19
 * Time: 11:13 AM
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;

class VacationHistoryItemsCest
{
    
    /**
     * @see    http:/jira.skynix.co/browse/SCA-323
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchVacationHistoryItemsData(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();
        
        $I->wantTo('Testing fetch vacation history items');      
        $I->sendGET(ApiEndpoints::VACATION_HISTORY_ITEM);
        
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        
        $I->seeResponseMatchesJsonType([
            'data' => ['vacationHistoryItems' =>
                [
                    /* [
                        'id' => 'integer',
                        'user'          => [
                            'id'            => 'integer',
                            'last_name'     => 'string',
                            'first_name'    => 'string',
                        ],
                        'days'          => 'integer',
                        'month'         => 'string',
                    ] */
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }
}

<?php
/**
 * Created by Skynix Team
 * Date: 05.04.17
 * Time: 17:59
 */

use Helper\ApiEndpoints;

class CareersCest
{
    /**
     * @see    https://jira-v2.skynix.company/browse/SI-716
     * @param  FunctionalTester $I
     * @return void
     */
    //TODO First add any career then check
    /*public function testFetchCareersData(FunctionalTester $I)
    {
        $I->sendGET(ApiEndpoints::CAREERS_VIEW);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'  => [
                [
                    'id'          => 'string',
                    'title'       => 'string',
                    'description'  => 'string',
                ]
            ],
            'errors' => 'array',
            'success'=> 'boolean'
        ]);
    }*/

}
<?php
/**
 * Created by Skynix Team
 * Date: 18.04.17
 * Time: 17:10
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;

class ProfilesCest
{
    private $profileId;

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-850
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchProfilesCest(FunctionalTester $I)
    {
        $I->wantTo('Testing fetch profiles data');
        $I->sendGET(ApiEndpoints::PROFILES, [
            'limit' => 1
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['profiles' =>
                [
                    [
                        'slug'     => 'string|null',
                        'photo'    => 'string|null',
                        'position' => 'string|null',
                        'first_name' => 'string',
                        'last_name' => 'string',
                        'email' => 'string',
                        'phone' => 'string|null',
                        'about' => 'string|null',
                        'birthday' => 'string|null',
                        'experience_year' => 'integer',
                        'languages' => 'array|null',
                        'degree' => 'string|null',
                        'residence' => 'string|null',
                        'link_linkedin' => 'string|null',
                        'link_video' => 'string|null',
                        'portfolio' => 'array',
                        'tags' => 'array',
                    ]
                ],
                'total_records' => 'integer',
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }
}
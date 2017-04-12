<?php
/**
 * Created by Skynix Team
 * Date: 11.04.17
 * Time: 15:47
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;

class SurveysCest
{
    private $surveyId;

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-902
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCreateSurveysCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        define('SHORTCODE', substr(md5(rand(1, 1000)), 0, 5));
        define('DATE_START', '20/03/2017 11:00');
        define('DATE_END', '21/03/2017 23:00');

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create surveys');
        $I->sendPOST(ApiEndpoints::SURVEY_CREATE, json_encode([
                'shortcode' => SHORTCODE,
                'question' => 'What is testing?',
                'date_start' => DATE_START,
                'date_end' => DATE_END,
                'is_private' => 0,
                'description' => 'tettttt',
                'options' => [
                    [ 'name' => 'Process', 'description' => '' ],
                    [ 'name' => 'Object', 'description' =>  '' ]
                ]
            ])
        );
        $response = json_decode($I->grabResponse());
        $this->surveyId = $response->data->surveys_id;
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'data' => [
                'surveys_id' => 'integer',
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-901
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchSurveysCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch surveys data');
        $I->sendGET(ApiEndpoints::SURVEYS_FETCH, [
            'limit' => 1
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['surveys' =>
                [
                    [
                        'id' => 'integer',
                        'shortcode' => 'string',
                        'question' => 'string',
                        'date_start' => 'string',
                        'date_end' => 'string',
                        'is_private' => 'string',
                        'votes' => 'integer',
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-907
     * @param  FunctionalTester $I
     * @return void
     */
    public function testDeleteSurveysCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Test Delete Surveys');
        $I->sendDELETE(ApiEndpoints::SURVEY_DELETE . '/' . $this->surveyId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean',
        ]);
    }

}
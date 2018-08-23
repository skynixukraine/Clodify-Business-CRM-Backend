<?php
/**
 * Created by SkynixTeam.
 * User: Oleg
 * Date: 08.11.18
 * Time: 12:03
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

/**
 * Class EmailTemplatesCest
 */
class EmailTemplatesCest
{
    /**
     * @see    https://jira.skynix.co/browse/SCA-240
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchEmailTemplatesAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch counterparties data');
        $I->sendGET(ApiEndpoints::EMAIL_TEMPLATE);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [[
                'id' => 'integer',
                'subject' => 'string',
                'reply_to' => 'string',
                'body' => 'string'
            ]],
            'errors' => [],
            'success' => 'boolean'
        ]);

    }

    /**
     * @see https://jira.skynix.co/browse/SCA-240
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     *
     */
    public function testFetchEmailTemplatesAdminFilterById(FunctionalTester $I, \Codeception\Scenario $scenario){
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('test fetch email templates filter by is');
        $I->sendGET(ApiEndpoints::EMAIL_TEMPLATE . '/' . ValuesContainer::$EmailTemplateId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());

        if(!isset($response->data[0]->id))
        {
            $I->fail('failed receive data associated with specified business');
        }

        if($response->data[0]->id != 1)
        {
            $I->fail('the received business doesn\'t correspond to the searching value');
        }

    }


    /**
     * @see https://jira.skynix.co/browse/SCA-240
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testFetchEmailTemplatesForbiddenNotAuthorized(FunctionalTester $I)
    {

        \Helper\OAuthToken::$key = null;

        $I->wantTo('test fetch email templates is forbidden for not authorized');
        $I->sendGET(ApiEndpoints::EMAIL_TEMPLATE);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->seeResponseContainsJson([
            "data" => null,
            "errors" => [
                "param" => "error",
                "message" => "You are not authorized to access this action"
            ],
            "success" => false
        ]);


    }

    /**
     * @see https://jira.skynix.co/browse/SCA-240
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testFetchEmailTemplatesForbiddenNotAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $roles = ['CLIENT', 'DEV', 'FIN', 'SALES', 'PM'];


        foreach($roles as $role) {

            \Helper\OAuthToken::$key = null;

            $testUser = 'user' . ucfirst(strtolower($role));
            $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::${$testUser}['id']));
            $pas = ValuesContainer::${$testUser}['password'];

            $oAuth = new OAuthSteps($scenario);
            $oAuth->login($email, $pas);

            $I->wantTo('test fetch email templates is forbidden for ' . $role .' role');
            $I->sendGET(ApiEndpoints::EMAIL_TEMPLATE);
            $I->seeResponseCodeIs(200);
            $I->seeResponseIsJson();
            $response = json_decode($I->grabResponse());
            $I->assertNotEmpty($response->errors);
            $I->assertEquals(false, $response->success);
            $I->seeResponseContainsJson([
                "data" => null,
                "errors" => [
                    "param" => "error",
                    "message" => "You have no permission for this action"
                ],
                "success" => false
            ]);

        }


    }

}
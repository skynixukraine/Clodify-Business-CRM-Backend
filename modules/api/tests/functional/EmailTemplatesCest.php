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


    /**
     * @see https://jira.skynix.co/browse/SCA-242
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateEmailTemplateAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('test update email template  is successful for ADMIN');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPUT('/api/email-templates/' . ValuesContainer::$EmailTemplateId, json_encode(ValuesContainer::$updateEmailTemplateData));

        \Helper\OAuthToken::$key = null;
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'subject' => 'string',
                'reply_to' => 'string',
                'body' => 'string'
            ],
            'errors' => [],
            'success' => 'boolean'
        ]);

    }


    /**
     * @see https://jira.skynix.co/browse/SCA-242
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateEmailTemplateForbiddenNotAuthorized(FunctionalTester $I)
    {
        \Helper\OAuthToken::$key = null;

        $I->wantTo('test update email template is not allowed for not authorized');


        $I->sendPUT('/api/email-templates/' . ValuesContainer::$EmailTemplateId, json_encode(ValuesContainer::$updateEmailTemplateData));
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
     * @see https://jira.skynix.co/browse/SCA-242
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateEmailTemplateForbiddenForNotAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $roles = ['CLIENT', 'DEV', 'FIN', 'SALES', 'PM'];

        foreach($roles as $role) {

            $testUser = 'user' . ucfirst(strtolower($role));
            $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::${$testUser}['id']));
            $pas = ValuesContainer::${$testUser}['password'];

            \Helper\OAuthToken::$key = null;

            $oAuth = new OAuthSteps($scenario);
            $oAuth->login($email, $pas);

            $I->wantTo('test update email template is forbidden for ' . $role .' role');
            $I->sendPUT('/api/email-templates/' . ValuesContainer::$EmailTemplateId, json_encode(ValuesContainer::$updateEmailTemplateData));

            \Helper\OAuthToken::$key = null;

            $I->seeResponseIsJson();
            $response = json_decode($I->grabResponse());
            $I->assertNotEmpty($response->errors);
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

    /**
     * @see https://jira.skynix.co/browse/SCA-242
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateEmailTemplateRequiredFields(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $emailTemplateData = ValuesContainer::$updateEmailTemplateData;

        $I->wantTo('test a update email template is unable on missing a required field');

        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        foreach($emailTemplateData as $key => $elem) {

            $testData = $emailTemplateData;
            unset($testData[$key]);

            $I->sendPUT('/api/email-templates/' . ValuesContainer::$EmailTemplateId, json_encode($testData));

            \Helper\OAuthToken::$key = null;

            $I->seeResponseCodeIs('200');
            $I->seeResponseIsJson();

            $response = json_decode($I->grabResponse());
            $I->assertNotEmpty($response->errors);

            $errors = $response->errors;

            $check = false;

            foreach ($errors as $error) {
                if(strpos($error->message,'missed required field') !== false){
                    $check = true;
                }
            }

            if(!$check) {
                $I->fail('missed required field');
            }

            $I->seeResponseMatchesJsonType([
                'data' => "null",
                'errors' => [[
                    "param" => "string",
                    "message" => "string"
                ]],
                'success' => 'boolean'
            ]);

        }
    }

    /**
     * @see https://jira.skynix.co/browse/SCA-242
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateEmailTemplateUpdatedValues(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('test update email template  save correctly same data as was put');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPUT('/api/email-templates/' . ValuesContainer::$EmailTemplateId, json_encode(ValuesContainer::$updateEmailTemplateData));

        \Helper\OAuthToken::$key = null;
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseContainsJson([
            'data' => [
                'subject' => "Update Email Template",
                'reply_to' => "Someone",
                'body' => "Hello, Update Email Template"
            ],
            'errors' => [],
            'success' => true
        ]);
    }

    /**
     * @see https://jira.skynix.co/browse/SCA-242
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateEmailTemplateNotExistEmailTemplate(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('test update email template  return error on case when set id, what business doesn\'t exist in database');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPUT('/api/email-templates/222', json_encode(ValuesContainer::$updateEmailTemplateData));

        \Helper\OAuthToken::$key = null;
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->assertEquals('email template is\'t found by Id', $response->errors[0]->message);
    }

}
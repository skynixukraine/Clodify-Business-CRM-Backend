<?php

declare(strict_types=1);

use Codeception\Scenario;
use Helper\ApiEndpoints;
use Helper\OAuthSteps;
use Helper\ValuesContainer;

class MonitoringServicesCest
{
    private function testFailCreateServiceForUser(FunctionalTester $I, Scenario $scenario, array $user)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($user['email'], $user['password']);

        $I->sendPOST(ApiEndpoints::PROJECT . '/' . ValuesContainer::$projectWithEnvId . '/monitoring-services',
            json_encode([
                'url' => 'http://google.com',
                'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
            ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), false);
        $I->assertNotEmpty($response->errors);
        $I->assertEquals($response->success, false);
        $I->assertEquals($response->data, null);
        $I->cantSeeInDatabase('monitoring_services', [
            'url' => 'http://google.com',
            'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
            'project_id' => ValuesContainer::$projectWithEnvId,
        ]);
    }

    public function createServiceFailedForRolesExceptAdmin(FunctionalTester $I, Scenario $scenario): void
    {
        $this->testFailCreateServiceForUser($I, $scenario, ValuesContainer::$userClient);
        $this->testFailCreateServiceForUser($I, $scenario, ValuesContainer::$userSales);
        $this->testFailCreateServiceForUser($I, $scenario, ValuesContainer::$userDev);
        $this->testFailCreateServiceForUser($I, $scenario, ValuesContainer::$userFin);
        $this->testFailCreateServiceForUser($I, $scenario, ValuesContainer::$userPm);
    }

    public function createServiceFailedIfWrongParams(FunctionalTester $I, Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendPOST(ApiEndpoints::PROJECT . '/' . ValuesContainer::$projectWithEnvId . '/monitoring-services',
            json_encode([
                'url2' => 'http://google.com',
                'notification_emails123' => 'test@gmail.com, qwerty@gmail.com',
            ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), false);
        $I->assertNotEmpty($response->errors);
        $I->assertEquals($response->success, false);
        $I->assertEquals($response->data, null);

        $I->cantSeeInDatabase('monitoring_services', [
            'url' => 'http://google.com',
            'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
            'project_id' => ValuesContainer::$projectWithEnvId,
        ]);
    }

    public function createServiceFailedIfWrongProjectId(FunctionalTester $I, Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendPOST(ApiEndpoints::PROJECT . '/555/monitoring-services',
            json_encode([
                'url' => 'http://google.com',
                'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
            ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), false);
        $I->assertNotEmpty($response->errors);
        $I->assertEquals($response->success, false);
        $I->assertEquals($response->data, null);

        $I->cantSeeInDatabase('monitoring_services', [
            'url' => 'http://google.com',
            'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
            'project_id' => 555,
        ]);
    }

    public function createServiceSuccessForAdmin(FunctionalTester $I, Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendPOST(ApiEndpoints::PROJECT . '/' . ValuesContainer::$projectWithEnvId . '/monitoring-services',
            json_encode([
                'url' => 'http://google.com',
                'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
            ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), false);
        $I->assertEmpty($response->errors);
        $I->assertEquals($response->success, true);
        $I->assertEquals($response->data, null);

        $I->canSeeInDatabase('monitoring_services', [
            'url' => 'http://google.com',
            'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
            'project_id' => ValuesContainer::$projectWithEnvId,
        ]);
    }

    public function getServiceSuccessForAdmin(FunctionalTester $I, Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendGET(ApiEndpoints::PROJECT . '/' . ValuesContainer::$projectWithEnvId . '/monitoring-services');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), false);
        $I->assertEmpty($response->errors);
        $I->assertEquals($response->success, true);

        $I->seeResponseMatchesJsonType([
            'data' => [
                [
                    'id' => 'integer',
                    'status' => 'string',
                    'url' => 'string',
                    'is_enabled' => 'integer',
                    'notification_emails' => 'string',
                    'project_id' => 'integer',
                    'queue' => [
                        [
                            'id' => 'integer',
                            'status' => 'string',
                            'results' => 'string|null',
                            'service_id' => 'integer',
                        ],
                    ],
                ],
            ],
            'errors' => 'array',
            'success' => 'boolean',
        ]);

        $I->assertEquals(count($response->data[0]->queue), 15);
    }

    public function getServiceFailedForAdmin(FunctionalTester $I, Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendGET(ApiEndpoints::PROJECT . '/555/monitoring-services');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), false);
        $I->assertNotEmpty($response->errors);
        $I->assertEquals($response->success, false);
        $I->assertEquals($response->data, null);
    }

    private function testFailGetServiceForUser(FunctionalTester $I, Scenario $scenario, array $user): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($user['email'], $user['password']);

        $I->sendGET(ApiEndpoints::PROJECT . '/' . ValuesContainer::$projectWithEnvId . '/monitoring-services');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), false);
        $I->assertNotEmpty($response->errors);
        $I->assertEquals($response->success, false);
        $I->assertEquals($response->data, null);
    }

    public function getServiceFailedForRolesExceptAdmin(FunctionalTester $I, Scenario $scenario): void
    {
        $this->testFailGetServiceForUser($I, $scenario, ValuesContainer::$userClient);
        $this->testFailGetServiceForUser($I, $scenario, ValuesContainer::$userSales);
        $this->testFailGetServiceForUser($I, $scenario, ValuesContainer::$userDev);
        $this->testFailGetServiceForUser($I, $scenario, ValuesContainer::$userFin);
        $this->testFailGetServiceForUser($I, $scenario, ValuesContainer::$userPm);
    }

    private function testFailUpdateServiceForUser(FunctionalTester $I, Scenario $scenario, array $user): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($user['email'], $user['password']);

        $I->sendPUT(ApiEndpoints::PROJECT . '/' . ValuesContainer::$projectWithEnvId . '/monitoring-services/1',
            json_encode([
                'url' => 'http://google.com',
                'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
                'is_enabled' => 0,
            ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), false);
        $I->assertNotEmpty($response->errors);
        $I->assertEquals($response->success, false);
        $I->assertEquals($response->data, null);
        $I->cantSeeInDatabase('monitoring_services', [
            'id' => 1,
            'url' => 'http://google.com',
            'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
            'project_id' => ValuesContainer::$projectWithEnvId,
            'is_enabled' => 0,
        ]);
    }

    public function updateServiceFailedForRolesExceptAdmin(FunctionalTester $I, Scenario $scenario): void
    {
        $this->testFailUpdateServiceForUser($I, $scenario, ValuesContainer::$userClient);
        $this->testFailUpdateServiceForUser($I, $scenario, ValuesContainer::$userSales);
        $this->testFailUpdateServiceForUser($I, $scenario, ValuesContainer::$userDev);
        $this->testFailUpdateServiceForUser($I, $scenario, ValuesContainer::$userFin);
        $this->testFailUpdateServiceForUser($I, $scenario, ValuesContainer::$userPm);
    }

    public function updateServiceFailedIfWrongParams(FunctionalTester $I, Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendPUT(ApiEndpoints::PROJECT . '/' . ValuesContainer::$projectWithEnvId . '/monitoring-services/1',
            json_encode([
                'url2' => 'http://google.com',
                'notification_emails123' => 'test@gmail.com, qwerty@gmail.com',
                'is_enabled5' => 0,
            ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), false);
        $I->assertNotEmpty($response->errors);
        $I->assertEquals($response->success, false);
        $I->assertEquals($response->data, null);

        $I->cantSeeInDatabase('monitoring_services', [
            'id' => 1,
            'url' => 'http://google.com',
            'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
            'project_id' => ValuesContainer::$projectWithEnvId,
            'is_enabled' => 0,
        ]);
    }

    public function updateServiceFailedIfWrongProjectId(FunctionalTester $I, Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendPUT(ApiEndpoints::PROJECT . '/555/monitoring-services/1',
            json_encode([
                'url' => 'http://google.com',
                'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
                'is_enabled' => 0,
            ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), false);
        $I->assertNotEmpty($response->errors);
        $I->assertEquals($response->success, false);
        $I->assertEquals($response->data, null);

        $I->cantSeeInDatabase('monitoring_services', [
            'id' => 1,
            'url' => 'http://google.com',
            'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
            'project_id' => 555,
            'is_enabled' => 0,
        ]);
    }

    public function updateServiceFailedIfWrongServiceId(FunctionalTester $I, Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendPUT(ApiEndpoints::PROJECT . '/' . ValuesContainer::$projectWithEnvId . '/monitoring-services/555',
            json_encode([
                'url' => 'http://google.com',
                'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
                'is_enabled' => 0,
            ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), false);
        $I->assertNotEmpty($response->errors);
        $I->assertEquals($response->success, false);
        $I->assertEquals($response->data, null);

        $I->cantSeeInDatabase('monitoring_services', [
            'id' => 555,
            'url' => 'http://google.com',
            'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
            'project_id' => ValuesContainer::$projectWithEnvId,
            'is_enabled' => 0,
        ]);
    }

    public function updateServiceSuccessForAdmin(FunctionalTester $I, Scenario $scenario): void
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);

        $I->sendPUT(ApiEndpoints::PROJECT . '/' . ValuesContainer::$projectWithEnvId . '/monitoring-services/1',
            json_encode([
                'url' => 'http://google.com',
                'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
                'is_enabled' => 0,
            ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse(), false);
        $I->assertEmpty($response->errors);
        $I->assertEquals($response->success, true);
        $I->assertEquals($response->data, null);

        $I->canSeeInDatabase('monitoring_services', [
            'url' => 'http://google.com',
            'notification_emails' => 'test@gmail.com, qwerty@gmail.com',
            'project_id' => ValuesContainer::$projectWithEnvId,
            'is_enabled' => 0,
        ]);
    }
}
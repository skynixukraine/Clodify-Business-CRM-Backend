<?php

declare(strict_types=1);

use Codeception\Scenario;
use Helper\ApiEndpoints;
use Helper\OAuthSteps;
use Helper\ValuesContainer;

class MonitoringServicesCest
{
    public function createServiceFailedForRolesExceptAdmin(FunctionalTester $I, Scenario $scenario): void
    {
        function testCreateService(FunctionalTester $I, Scenario $scenario, array $user)
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

        testCreateService($I, $scenario, ValuesContainer::$userClient);
        testCreateService($I, $scenario, ValuesContainer::$userSales);
        testCreateService($I, $scenario, ValuesContainer::$userDev);
        testCreateService($I, $scenario, ValuesContainer::$userFin);
        testCreateService($I, $scenario, ValuesContainer::$userPm);
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

    public function getServiceFailedForRolesExceptAdmin(FunctionalTester $I, Scenario $scenario): void
    {
        function testGetService(FunctionalTester $I, Scenario $scenario, array $user)
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

        testGetService($I, $scenario, ValuesContainer::$userClient);
        testGetService($I, $scenario, ValuesContainer::$userSales);
        testGetService($I, $scenario, ValuesContainer::$userDev);
        testGetService($I, $scenario, ValuesContainer::$userFin);
        testGetService($I, $scenario, ValuesContainer::$userPm);
    }
}
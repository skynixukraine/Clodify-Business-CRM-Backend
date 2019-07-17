<?php
/**
 * Created by Skynix Team
 * Date: 21.04.17
<<<<<<< HEAD
 * Time: 18:16
=======
 * Time: 14:51
>>>>>>> origin/develop
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;
use Helper\ValuesContainer;

define('INVOICE_DATE_START', date('d/m/Y', strtotime('now -1 day')));
define('INVOICE_DATE_END', date('d/m/Y', strtotime('now')));
define('INVOICE_SUBTOTAL', 200);
define('INVOICE_DISCOUNT', 10);
define('INVOICE_TOTAL', 190);
define('INVOICE_NOTE', "Some Note");
define('INVOICE_CURRENCY', "USD");


class InvoicesCest
{
    private $invoiceId = 1;

    private $invoceIdCreatedBySales;

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-972
     * @param  FunctionalTester $I
     * @return void
     */

    public function testCreateInvoiceCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('test invoice creation forbidden for  DEV, PM, CLIENT role');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userDev['id']));
        $pas = ValuesContainer::$userDev['password'];

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->wantTo('Testing create invoice with other then ADMIN roles');
        $I->sendPOST(ApiEndpoints::INVOICES, json_encode([
            "user_id"     =>  ValuesContainer::$userClient['id'],
            "date_start"  => "10/10/2018",
            "date_end"    => "10/11/2018",
            "subtotal"    =>  2444,
            "discount"    =>  20,
            "total"       =>  20000,
            "note"        => "Some Note",
            "currency"    => INVOICE_CURRENCY
        ]));

        \Helper\OAuthToken::$key = null;

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

        $I->wantTo('Testing create invoice as SALES');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas = ValuesContainer::$userSales['password'];


        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPOST(ApiEndpoints::INVOICES, json_encode([
            "user_id"     =>  ValuesContainer::$userClient['id'],
            "date_start"  => date('d/m/Y', strtotime('now -2 days')),
            "date_end"    => date('d/m/Y', strtotime('now -2 days')),
            "subtotal"    =>  100,
            "discount"    =>  0,
            "total"       =>  100,
            "note"        => "Some Note",
            "currency"    => INVOICE_CURRENCY,
            "payment_method_id" => ValuesContainer::$PaymentMethodId
        ]));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());

        $this->invoceIdCreatedBySales = $response->data->invoice_id;
        $I->seeResponseMatchesJsonType([
            'data' => [
                'invoice_id' => 'integer',
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        ValuesContainer::$BusinessInvoiceIncrementId++;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create invoice as ADMIN');
        $I->sendPOST(ApiEndpoints::INVOICES, json_encode([
            "user_id"     =>  ValuesContainer::$userClient['id'],
            "date_start"  => INVOICE_DATE_START,
            "date_end"    => INVOICE_DATE_END,
            "subtotal"    => INVOICE_SUBTOTAL,
            "discount"    => INVOICE_DISCOUNT,
            "total"       => INVOICE_TOTAL,
            "note"        => INVOICE_NOTE,
            "currency"    => INVOICE_CURRENCY,
            "payment_method_id" => ValuesContainer::$PaymentMethodId
        ]));

        $response = json_decode($I->grabResponse());
        $this->invoiceId = $response->data->invoice_id;
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->assertEmpty($response->errors);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'invoice_id' => 'integer',
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        ValuesContainer::$BusinessInvoiceIncrementId++;

    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-967  change with https://jira.skynix.co/browse/SCA-130
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchInvoicesCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPOST(ApiEndpoints::INVOICES, json_encode([
            "user_id"     =>  ValuesContainer::$userClient['id'],
            "date_start"  => "10/10/2018",
            "date_end"    => "10/11/2018",
            "subtotal"    =>  2444,
            "discount"    =>  20,
            "total"       =>  20000,
            "note"        => "Some Note",
            "currency"    => INVOICE_CURRENCY,
            "payment_method_id" => ValuesContainer::$PaymentMethodId
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        ValuesContainer::$BusinessInvoiceIncrementId++;

        $I->wantTo('Testing fetch invoices data');
        $I->sendGET(ApiEndpoints::INVOICES, [
            'limit' => 1
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());

        $I->assertEmpty($response->errors);

        $I->assertEquals(true, $response->success);

        if(!isset($response->data->total_records)) {
            $I->fail("wrong data");
        }

        if($response->data->total_records > 0) {
            $I->seeResponseMatchesJsonType([
                'data' => ['invoices' =>
                    [
                        [
                            'id'            => 'integer',
                            'invoice_id'   => 'integer',
                            'customer'     => 'array|null',
                            'subtotal'     => 'integer|string',
                            'discount'     => 'integer|string',
                            'total'        => 'integer|string',
                            'currency'     => 'string',
                            'created_date' => 'string|null',
                            'sent_date'    => 'string|null',
                            'paid_date'    => 'string|null',
                            'status'       => 'string',
                            'is_withdrawn' => 'integer',
                            'parties'      => 'array'
                        ]
                    ],
                    'total_records' => 'string'
                ],
                'errors' => 'array',
                'success' => 'boolean'
            ]);
        }

    }


    /**
     * @see    https://jira.skynix.co/browse/SCA-132
     * @param  FunctionalTester $I
     * @return void
     */
    public function testViewInvoiceData(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPOST(ApiEndpoints::INVOICES, json_encode([
            "user_id"     =>  ValuesContainer::$userClient['id'],
            "date_start"  => "10/10/2018",
            "date_end"    => "10/11/2018",
            "subtotal"    =>  2444,
            "discount"    =>  20,
            "total"       =>  20000,
            "note"        => "Some Note",
            "currency"    => INVOICE_CURRENCY,
            "payment_method_id" => ValuesContainer::$PaymentMethodId
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        ValuesContainer::$BusinessInvoiceIncrementId++;

        $I->wantTo('Testing view single invoice');
        $I->sendGET(ApiEndpoints::INVOICES . "/" . $this->invoiceId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'  => [
                [
                    'id'            => 'integer',
                    'invoice_id'   => 'integer',
                    'payment_method_id' => 'integer',
                    "customer" =>  'array',
                    "start_date"   => 'string',
                    "end_date"     => 'string',
                    "total_hours"  => 'integer | null',
                    "subtotal"     => 'integer | string',
                    "discount"     => 'integer | string',
                    "total"        => 'integer | string',
                    "currency"     => 'string',
                    "notes"        => 'string',
                    "created_date" => 'string | null',
                    "sent_date"    => 'string | null',
                    "paid_date"    => 'string | null',
                    "status"       => 'string',
                    'is_withdrawn' => 'integer',
                    'parties'      => 'array'
                ]
            ],
            'errors' => 'array',
            'success'=> 'boolean'
        ]);

        $invoice = $response->data[0];
        $I->assertEquals(ValuesContainer::$userClient['id'], $invoice->customer->id);
        $I->assertEquals(ValuesContainer::$PaymentMethodId, $invoice->payment_method_id);
        $I->assertEquals(INVOICE_DATE_START, $invoice->start_date);
        $I->assertEquals(INVOICE_DATE_END, $invoice->end_date);
        $I->assertEquals(INVOICE_SUBTOTAL, $invoice->subtotal);
        $I->assertEquals(INVOICE_DISCOUNT, $invoice->discount);
        $I->assertEquals(INVOICE_TOTAL, $invoice->total);
        $I->assertEquals(INVOICE_NOTE, $invoice->notes);
        $I->assertEquals(INVOICE_CURRENCY, $invoice->currency);
        $I->assertEquals("NEW", $invoice->status);
        $I->assertGreaterThan(0, $invoice->invoice_id);
        $I->assertEquals(ValuesContainer::$BusinessInvoiceIncrementId - 2, $invoice->invoice_id);
    }

    /**
     * see https://jira.skynix.co/browse/SCA-154
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testMakeInvoicePaidCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create invoice as ADMIN');
        $I->sendPOST(ApiEndpoints::INVOICES, json_encode([
            "user_id"     =>  ValuesContainer::$userClient['id'],
            "date_start"  => INVOICE_DATE_START,
            "date_end"    => INVOICE_DATE_END,
            "subtotal"    => INVOICE_SUBTOTAL,
            "discount"    => INVOICE_DISCOUNT,
            "total"       => INVOICE_TOTAL,
            "note"        => INVOICE_NOTE,
            "currency"    => INVOICE_CURRENCY,
            "payment_method_id" => ValuesContainer::$PaymentMethodId
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        ValuesContainer::$BusinessInvoiceIncrementId++;

        $response = json_decode($I->grabResponse());
        $id = $response->data->invoice_id;

        $I->wantTo('Testing delete invoice');
        $I->sendPUT(ApiEndpoints::INVOICES . '/' . $id . '/paid');

        \Helper\OAuthToken::$key = null;

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'data' => [
                'invoice_id' => 'string',
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);

        $I->seeInDatabase('invoices', ['id' => $id, 'status' => 'PAID']);

    }

    /**
     * @see https://jira.skynix.co/browse/SCA-155
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testDownloadPDFInvoice(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $I->wantTo('Test download PDF invoice function is not available for DEV');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userDev['id']));
        $pas = ValuesContainer::$userDev['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendGET(ApiEndpoints::INVOICES . "/" . $this->invoiceId . '/download');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);

        $I->wantTo('Test download PDF invoice function is not available for CLIENT');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userClient['id']));
        $pas = ValuesContainer::$userClient['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendGET(ApiEndpoints::INVOICES . "/" . $this->invoiceId . '/download');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);

        $I->wantTo('Test download PDF invoice function is not available for PM');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userPm['id']));
        $pas = ValuesContainer::$userPm['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendGET(ApiEndpoints::INVOICES . "/" . $this->invoiceId . '/download');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);

        $I->wantTo('Test download PDF invoice function is available for ADMIN');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendGET(ApiEndpoints::INVOICES . "/" . $this->invoiceId . '/download');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'  =>  [
                'pdf'  => 'string',
                'name' => 'string'
            ],
            'errors'  => 'array',
            'success' => 'boolean'
        ]);


        $I->wantTo('Test download PDF invoice function is available for FIN');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userFin['id']));
        $pas = ValuesContainer::$userFin['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendGET(ApiEndpoints::INVOICES . "/" . $this->invoiceId . '/download');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'  =>  [
                'pdf'  => 'string',
                'name' => 'string'
            ],
            'errors'  => 'array',
            'success' => 'boolean'
        ]);

        $I->wantTo('Test download PDF invoice function does not work when SALES is trying to download not own invoice');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas = ValuesContainer::$userSales['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendGET(ApiEndpoints::INVOICES . "/" . $this->invoiceId . '/download');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);

        $I->wantTo('Test download PDF invoice function works when SALES is trying to download own invoice');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userSales['id']));
        $pas = ValuesContainer::$userSales['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendGET(ApiEndpoints::INVOICES . "/" . $this->invoceIdCreatedBySales . '/download');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'  =>  [
                'pdf'  => 'string',
                'name' => 'string'
            ],
            'errors'  => 'array',
            'success' => 'boolean'
        ]);

    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-974  changed with https://jira.skynix.co/browse/SCA-131
     * @param  FunctionalTester $I
     * @return void
     */
    public function testInvoiceDeleteCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->sendPOST(ApiEndpoints::INVOICES, json_encode([
            "user_id"     =>  ValuesContainer::$userClient['id'],
            "date_start"  => "10/10/2018",
            "date_end"    => "10/11/2018",
            "subtotal"    =>  2444,
            "discount"    =>  20,
            "total"       =>  20000,
            "note"        => "Some Note",
            "currency"    => INVOICE_CURRENCY,
            "payment_method_id" => ValuesContainer::$PaymentMethodId
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        ValuesContainer::$BusinessInvoiceIncrementId++;

        $I->seeInDatabase('invoices', ['id' => $this->invoiceId, 'is_delete' => 0]);

        $I->wantTo('Testing delete invoice');
        $I->sendDELETE(ApiEndpoints::INVOICES . '/' . $this->invoiceId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean'
        ]);

        $I->seeInDatabase('invoices', ['id' => $this->invoiceId, 'is_delete' => 1]);
    }

    /**
     * @see    https://jira.skynix.co/browse/SCA-245
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchInvoiceTemplatesAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->wantTo('Testing fetch counterparties data');
        $I->sendGET(ApiEndpoints::INVOICE_TEMPLATE);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [[
                'id' => 'integer',
                'name' => 'string',
                'body' => 'string',
                'variables' => 'string'
            ]],
            'errors' => [],
            'success' => 'boolean'
        ]);

    }

    /**
     * @see https://jira.skynix.co/browse/SCA-245
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     *
     */
    public function testFetchInvoiceTemplatesAdminFilterById(FunctionalTester $I, \Codeception\Scenario $scenario){
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('test fetch invoice templates filter by is');
        $I->sendGET(ApiEndpoints::INVOICE_TEMPLATE . '/' . ValuesContainer::$InvoiceTemplateId);
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
     * @see https://jira.skynix.co/browse/SCA-245
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testFetchInvoiceTemplatesForbiddenNotAuthorized(FunctionalTester $I)
    {

        \Helper\OAuthToken::$key = null;

        $I->wantTo('test fetch invoice templates is forbidden for not authorized');
        $I->sendGET(ApiEndpoints::INVOICE_TEMPLATE);
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
     * @see https://jira.skynix.co/browse/SCA-245
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testFetchInvoiceTemplatesForbiddenNotAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $roles = ['CLIENT', 'DEV', 'FIN', 'SALES', 'PM'];


        foreach($roles as $role) {

            \Helper\OAuthToken::$key = null;

            $testUser = 'user' . ucfirst(strtolower($role));
            $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::${$testUser}['id']));
            $pas = ValuesContainer::${$testUser}['password'];

            $oAuth = new OAuthSteps($scenario);
            $oAuth->login($email, $pas);

            $I->wantTo('test fetch invoice templates is forbidden for ' . $role .' role');
            $I->sendGET(ApiEndpoints::INVOICE_TEMPLATE);
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
     * @see https://jira.skynix.co/browse/SCA-246
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateInvoiceTemplateAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('test update email template  is successful for ADMIN');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPUT('/api/invoice-templates/' . ValuesContainer::$InvoiceTemplateId, json_encode(ValuesContainer::$updateInvoiceTemplateData));

        \Helper\OAuthToken::$key = null;
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => [
                'name' => 'string',
                'body' => 'string'
            ],
            'errors' => [],
            'success' => 'boolean'
        ]);

    }


    /**
     * @see https://jira.skynix.co/browse/SCA-246
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateInvoiceTemplateForbiddenNotAuthorized(FunctionalTester $I)
    {
        \Helper\OAuthToken::$key = null;

        $I->wantTo('test update email template is not allowed for not authorized');


        $I->sendPUT('/api/invoice-templates/' . ValuesContainer::$InvoiceTemplateId, json_encode(ValuesContainer::$updateInvoiceTemplateData));
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
     * @see https://jira.skynix.co/browse/SCA-246
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateInvoiceTemplateForbiddenForNotAdmin(FunctionalTester $I, \Codeception\Scenario $scenario)
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
            $I->sendPUT('/api/invoice-templates/' . ValuesContainer::$InvoiceTemplateId, json_encode(ValuesContainer::$updateInvoiceTemplateData));

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
     * @see https://jira.skynix.co/browse/SCA-246
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateInvoiceTemplateRequiredFields(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $InvoiceTemplateData = ValuesContainer::$updateInvoiceTemplateData;

        $I->wantTo('test a update invoice template is unable on missing a required field');

        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        foreach($InvoiceTemplateData as $key => $elem) {

            $testData = $InvoiceTemplateData;
            unset($testData[$key]);

            $I->sendPUT('/api/invoice-templates/' . ValuesContainer::$InvoiceTemplateId, json_encode($testData));

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
     * @see https://jira.skynix.co/browse/SCA-246
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateInvoiceTemplateUpdatedValues(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('test update invoice template  save correctly same data as was put');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPUT('/api/invoice-templates/' . ValuesContainer::$InvoiceTemplateId, json_encode(ValuesContainer::$updateInvoiceTemplateData));

        \Helper\OAuthToken::$key = null;
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseContainsJson([
            'data' => [
                'name' => "Update invoice template",
                'body' => "Hello, Update invoice template"
            ],
            'errors' => [],
            'success' => true
        ]);
    }

    /**
     * @see https://jira.skynix.co/browse/SCA-246
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     * @return void
     */
    public function testUpdateInvoiceTemplateNotExistInvoiceTemplate(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->wantTo('test update invoice template  return error on case when set id, what business doesn\'t exist in database');
        $email = $I->grabFromDatabase('users', 'email', array('id' => ValuesContainer::$userAdmin['id']));
        $pas = ValuesContainer::$userAdmin['password'];
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login($email, $pas);

        $I->sendPUT('/api/invoice-templates/222', json_encode(ValuesContainer::$updateInvoiceTemplateData));

        \Helper\OAuthToken::$key = null;
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);
        $I->assertEquals(false, $response->success);
        $I->assertEquals('invoice template is\'t found by Id', $response->errors[0]->message);
    }

    public function testCreateInvoiceForAlternateBusinessToCheckInvoiceIdCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create invoice as ADMIN');
        $I->sendPOST(ApiEndpoints::INVOICES, json_encode([
            "user_id"     =>  ValuesContainer::$userClient['id'],
            "date_start"  => INVOICE_DATE_START,
            "date_end"    => INVOICE_DATE_END,
            "subtotal"    => INVOICE_SUBTOTAL,
            "discount"    => INVOICE_DISCOUNT,
            "total"       => INVOICE_TOTAL,
            "note"        => INVOICE_NOTE,
            "currency"    => INVOICE_CURRENCY,
            "payment_method_id" => ValuesContainer::$alternatePaymentMethodID
        ]));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'data' => [
                'invoice_id' => 'integer',
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
        ValuesContainer::$altBusinessInvoiceIncrementId++;

        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $this->invoiceId = $response->data->invoice_id;

        $I->wantTo('Testing view single invoice for alternate business and incremented invoice ID');
        $I->sendGET(ApiEndpoints::INVOICES . "/" . $this->invoiceId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data'  => [
                [
                    'id'            => 'integer',
                    'invoice_id'   => 'integer',
                    'payment_method_id' => 'integer',
                    "customer" =>  'array',
                    "start_date"   => 'string',
                    "end_date"     => 'string',
                    "total_hours"  => 'integer | null',
                    "subtotal"     => 'integer | string',
                    "discount"     => 'integer | string',
                    "total"        => 'integer | string',
                    "currency"     => 'string',
                    "notes"        => 'string',
                    "created_date" => 'string | null',
                    "sent_date"    => 'string | null',
                    "paid_date"    => 'string | null',
                    "status"       => 'string',
                ]
            ],
            'errors' => 'array',
            'success'=> 'boolean'
        ]);

        $invoice = $response->data[0];
        $I->assertEquals(ValuesContainer::$userClient['id'], $invoice->customer->id);
        $I->assertEquals(ValuesContainer::$alternatePaymentMethodID, $invoice->payment_method_id);
        $I->assertEquals(INVOICE_DATE_START, $invoice->start_date);
        $I->assertEquals(INVOICE_DATE_END, $invoice->end_date);
        $I->assertEquals(INVOICE_SUBTOTAL, $invoice->subtotal);
        $I->assertEquals(INVOICE_DISCOUNT, $invoice->discount);
        $I->assertEquals(INVOICE_TOTAL, $invoice->total);
        $I->assertEquals(INVOICE_NOTE, $invoice->notes);
        $I->assertEquals(INVOICE_CURRENCY, $invoice->currency);
        $I->assertEquals("NEW", $invoice->status);
        $I->assertGreaterThan(0, $invoice->invoice_id);
        $I->assertEquals(ValuesContainer::$altBusinessInvoiceIncrementId, $invoice->invoice_id);

    }

    /**
     * @see https://jira.skynix.co/browse/SCA-325
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testEditReportWhenInvoiced(FunctionalTester $I, \Codeception\Scenario $scenario)
    {


        $repId = $I->haveInDatabase('reports', array(
            'user_id'       => ValuesContainer::$userAdmin['id'],
            'project_id'    => ValuesContainer::$projectId,
            'date_added'    => '2017-03-09',
            'date_report'   => date('Y-m-d', strtotime('now -1 day')),
            'task' => 'superhero task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => $this->invoiceId,
            'is_approved' => 1
        ));

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Edit previously created report with invoice');
        $this->newTask = TASK . 'NEW';
        $newHours = HOURS + 1;

        $I->sendPUT(ApiEndpoints::REPORT . '/' . $repId, json_encode([
            'task' => $this->newTask,
            'hours' => $newHours
        ]));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);


        $I->seeResponseContainsJson([
            'errors' => [
                [
                    "param"     => "project_id",
                    "message"   => "You can not edit this report, because it was already invoiced."
                ]
            ],
            'success' => false
        ]);

    }

    /**
     * @see https://jira.skynix.co/browse/SCA-325
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testEditReportWhenUpdatedToInvoicedCustomer(FunctionalTester $I, \Codeception\Scenario $scenario)
    {


        $repId = $I->haveInDatabase('reports', array(
            'user_id'       => ValuesContainer::$userAdmin['id'],
            'project_id'    => ValuesContainer::$nonPaidProjectId,
            'date_added'    => '2017-03-09',
            'date_report'   => date('Y-m-d', strtotime('now -1 day')),
            'task' => 'superhero task',
            'hours' => 5,
            'cost' => 35.5,
            'invoice_id' => null,
            'is_approved' => 1
        ));

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Edit previously created report with invoice');
        $this->newTask = TASK . 'NEW';
        $newHours = HOURS + 1;

        $I->sendPUT(ApiEndpoints::REPORT . '/' . $repId, json_encode([
            'task'      => $this->newTask,
            'hours'     => $newHours,
            'project_id'=> ValuesContainer::$projectId
        ]));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertNotEmpty($response->errors);


        $I->seeResponseContainsJson([
            'errors' => [
                [
                    "param"     => "project_id",
                    "message"   => "You can not change project/date because that billing period is closed, customer invoiced."
                ]
            ],
            'success' => false
        ]);

    }

}

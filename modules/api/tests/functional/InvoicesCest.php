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
    private $invoiceId;

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
            "business_id" =>  1,
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
            "business_id" =>  1,
            "date_start"  => date('d/m/Y', strtotime('now -2 days')),
            "date_end"    => date('d/m/Y', strtotime('now -2 days')),
            "subtotal"    =>  100,
            "discount"    =>  0,
            "total"       =>  100,
            "note"        => "Some Note",
            "currency"    => INVOICE_CURRENCY
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

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create invoice as ADMIN');
        $I->sendPOST(ApiEndpoints::INVOICES, json_encode([
            "user_id"     =>  ValuesContainer::$userClient['id'],
            "business_id" =>  ValuesContainer::$BusinessID,
            "date_start"  => INVOICE_DATE_START,
            "date_end"    => INVOICE_DATE_END,
            "subtotal"    => INVOICE_SUBTOTAL,
            "discount"    => INVOICE_DISCOUNT,
            "total"       => INVOICE_TOTAL,
            "note"        => INVOICE_NOTE,
            "currency"    => INVOICE_CURRENCY
        ]));
        $response = json_decode($I->grabResponse());
        $this->invoiceId = $response->data->invoice_id;
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'data' => [
                'invoice_id' => 'integer',
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);

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

        $I->wantTo('Testing fetch invoices data');
        $I->sendGET(ApiEndpoints::INVOICES, [
            'limit' => 1
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $response = json_decode($I->grabResponse());
        $I->assertEmpty($response->errors);
        $I->assertEquals(true, $response->success);
        $I->seeResponseMatchesJsonType([
            'data' => ['invoices' =>
                [
                    [
                        'id'            => 'integer',
                        'invoice_id'   => 'integer',
                        'business_id'   => 'integer',
                        'customer'     => 'array|null',
                        'subtotal'     => 'integer|string',
                        'discount'     => 'integer|string',
                        'total'        => 'integer|string',
                        'currency'     => 'string',
                        'created_date' => 'string|null',
                        'sent_date'    => 'string|null',
                        'paid_date'    => 'string|null',
                        'status'       => 'string',
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
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
                    'business_id'   => 'integer',
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
        $I->assertEquals(ValuesContainer::$BusinessID, $invoice->business_id);
        $I->assertEquals(INVOICE_DATE_START, $invoice->start_date);
        $I->assertEquals( INVOICE_DATE_END, $invoice->end_date);
        $I->assertEquals(INVOICE_SUBTOTAL, $invoice->subtotal);
        $I->assertEquals(INVOICE_DISCOUNT, $invoice->discount);
        $I->assertEquals(INVOICE_TOTAL, $invoice->total);
        $I->assertEquals(INVOICE_NOTE, $invoice->notes);
        $I->assertEquals(INVOICE_CURRENCY, $invoice->currency);
        $I->assertEquals("NEW", $invoice->status);
    }

    /**
     * see https://jira.skynix.co/browse/SCA-154
     * @param FunctionalTester $I
     * @param \Codeception\Scenario $scenario
     */
    public function testMakeInvoicePaidCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $inv = $I->haveInDatabase('invoices', [
            'is_delete' => 0,
            'status' => 'NEW',
            'business_id' => 1,
            'note' => 'hello',
            'date_end' => '2017-01-25',
            'total' => 200,
            'user_id' => ValuesContainer::$userClient['id'],
            'date_start' => '2017-01-5',
            'subtotal' => 100,
            'discount' => 10
        ]);

        \Helper\OAuthToken::$key = null;

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login(ValuesContainer::$userAdmin['email'], ValuesContainer::$userAdmin['password']);


        $I->wantTo('Testing delete invoice');
        $I->sendPUT(ApiEndpoints::INVOICES . '/' . $inv . '/paid');

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

        $I->seeInDatabase('invoices', ['id' => $inv, 'status' => 'PAID']);

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


}

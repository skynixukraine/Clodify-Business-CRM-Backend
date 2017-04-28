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

class InvoicesCest
{
    private $invoiceId;

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-972
     * @param  FunctionalTester $I
     * @return void
     */
    public function testCreateInvoiceCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
       $oAuth = new OAuthSteps($scenario);
       $oAuth->login();

       $I->wantTo('Testing create invoice');
       $I->sendPOST(ApiEndpoints::CONTRACTS . '/' . ValuesContainer::$contractId . '/invoices');
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
     * @see    https://jira-v2.skynix.company/browse/SI-967
     * @param  FunctionalTester $I
     * @return void
     */
    public function testFetchInvoicesCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing fetch invoices data');
        $I->sendGET(ApiEndpoints::CONTRACTS . '/' . ValuesContainer::$contractId . '/invoices',  [
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
                        'invoice_id' => 'integer',
                        'customer' => 'array|null',
                        'subtotal' => 'integer',
                        'discount' => 'integer',
                        'total' => 'integer|string',
                        'created_date' => 'string|null',
                        'sent_date' => 'string|null',
                        'paid_date' => 'string|null',
                        'status' => 'string',
                    ]
                ],
                'total_records' => 'string'
            ],
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

}


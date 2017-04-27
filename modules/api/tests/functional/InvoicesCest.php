<?php
/**
 * Created by Skynix Team
 * Date: 21.04.17
 * Time: 14:51
 */

use Helper\OAuthSteps;
use Helper\ApiEndpoints;

class InvoicesCest
{
    private $invoiceId;

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-972
     * @param  FunctionalTester $I
     * @return void
     */
    public function testInvoiceCreateCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create invoice');
        $I->sendPOST(ApiEndpoints::CONTRACTS . '/' . ContractsCest::CONTRACT_ID . '/invoices');
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
}
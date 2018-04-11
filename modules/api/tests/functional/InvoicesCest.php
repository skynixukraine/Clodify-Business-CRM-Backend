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
//    public function testCreateInvoiceCest(FunctionalTester $I, \Codeception\Scenario $scenario)
//    {
//       $oAuth = new OAuthSteps($scenario);
//       $oAuth->login();
//
//       $I->wantTo('Testing create invoice');
//       $I->sendPOST(ApiEndpoints::CONTRACTS . '/' . ValuesContainer::$contractId . '/invoices');
//       $response = json_decode($I->grabResponse());
//       $this->invoiceId = $response->data->invoice_id;
//       $I->seeResponseCodeIs(200);
//       $I->seeResponseIsJson();
//       $I->seeResponseMatchesJsonType([
//           'data' => [
//                   'invoice_id' => 'integer',
//       ],
//           'errors' => 'array',
//            'success' => 'boolean'
//        ]);
//    }

    public function testCreateInvoiceCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $I->haveInDatabase('users', array(
            'id'         => 5,
            'first_name' => 'devUsers',
            'last_name'  => 'devUsersLast',
            'email'      => 'devUser@email.com',
            'role'       => 'DEV',
            'password'   => md5('dev')
        ));

        $I->haveInDatabase('users', array(
            'id'         => 6,
            'first_name' => 'pmUsers',
            'last_name'  => 'pmUsersLast',
            'email'      => 'pmUser@email.com',
            'role'       => 'PM',
            'password'   => md5('pm')
        ));

        $I->haveInDatabase('users', array(
            'id'         => 7,
            'first_name' => 'clientUsers',
            'last_name'  => 'clientUsersLast',
            'email'      => 'clientUser@email.com',
            'role'       => 'CLIENT',
            'password'   => md5('client')
        ));

        // test invoice creation forbidden for  DEV, PM, CLIENT role
        for ($i = 5; $i < 8; $i++) {
            $email = $I->grabFromDatabase('users', 'email', array('id' => $i));
            $pas = $I->grabFromDatabase('users', 'role', array('id' => $i));

            \Helper\OAuthToken::$key = null;

            $oAuth = new OAuthSteps($scenario);
            $oAuth->login($email, strtolower($pas));

            $I->wantTo('Testing create invoice with other then ADMIN roles');
            $I->sendPOST(ApiEndpoints::INVOICES, json_encode([
                "user_id"     =>  $i,
                "business_id" =>  1,
                "date_start"  => "10/10/2018",
                "date_end"    => "10/11/2018",
                "subtotal"    =>  2444,
                "discount"    =>  20,
                "total"       =>  20000,
                "note"        => "bla bla"
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
        }

        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing create invoice as ADMIN');
        $I->sendPOST(ApiEndpoints::INVOICES, json_encode([
             "user_id"     =>  100,
             "business_id" =>  1,
             "date_start"  => "10/10/2018",
             "date_end"    => "10/11/2018",
             "subtotal"    =>  2444,
             "discount"    =>  20,
             "total"       =>  20000,
             "note"        => "bla bla"
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
     * @see    https://jira-v2.skynix.company/browse/SI-967
     * @param  FunctionalTester $I
     * @return void
     */
//    public function testFetchInvoicesCest(FunctionalTester $I, \Codeception\Scenario $scenario)
//    {
//        $oAuth = new OAuthSteps($scenario);
//        $oAuth->login();
//
//        $I->wantTo('Testing fetch invoices data');
//        $I->sendGET(ApiEndpoints::CONTRACTS . '/' . ValuesContainer::$contractId . '/invoices',  [
//            'limit' => 1
//        ]);
//        $I->seeResponseCodeIs(200);
//        $I->seeResponseIsJson();
//        $response = json_decode($I->grabResponse());
//        $I->assertEmpty($response->errors);
//        $I->assertEquals(true, $response->success);
//        $I->seeResponseMatchesJsonType([
//            'data' => ['invoices' =>
//                [
//                    [
//                        'invoice_id' => 'integer',
//                        'customer' => 'array|null',
//                        'subtotal' => 'integer',
//                        'discount' => 'integer',
//                        'total' => 'integer|string',
//                        'created_date' => 'string|null',
//                        'sent_date' => 'string|null',
//                        'paid_date' => 'string|null',
//                        'status' => 'string',
//                    ]
//                ],
//                'total_records' => 'string'
//            ],
//            'errors' => 'array',
//            'success' => 'boolean'
//        ]);
//    }


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
                    "customer" =>  'array',
                    "start_date"   => 'string',
                    "end_date"     => 'string',
                    "total_hours"  => 'integer | null',
                    "subtotal"     => 'integer | string',
                    "discount"     => 'integer | string',
                    "total"        => 'integer | string',
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
    }


    /**
     * @see    https://jira-v2.skynix.company/browse/SI-974
     * @param  FunctionalTester $I
     * @return void
     */
    public function testInvoiceDeleteCest(FunctionalTester $I, \Codeception\Scenario $scenario)
    {
        $oAuth = new OAuthSteps($scenario);
        $oAuth->login();

        $I->wantTo('Testing delete invoice');
        $I->sendDELETE(ApiEndpoints::CONTRACTS . '/' . ValuesContainer::$contractId . '/invoices/' . $this->invoiceId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'data' => 'array|null',
            'errors' => 'array',
            'success' => 'boolean'
        ]);
    }

}

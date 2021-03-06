<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/6/18
 * Time: 4:21 PM
 */

namespace viewModel;

use app\components\DateUtil;
use app\models\Business;
use app\models\FinancialReport;
use app\models\Invoice;
use app\models\SalaryReport;
use app\models\SalaryReportList;
use app\models\Storage;
use app\models\User;
use app\modules\api\components\Api\Message;
use app\modules\api\components\Api\Processor;
use Mpdf\Mpdf;
use Yii;

/**
 * @see https://jira.skynix.co/browse/SCA-155
 * Class InvoiceDownload
 * @package viewModel
 */
class InvoiceDownload extends ViewModelAbstract
{
    public function define()
    {
        if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES]) ) {

            ini_set("pcre.backtrack_limit", "5000000");
            /** @var $invoice Invoice */
            /** @var $business Business */
            /** @var $customer User */
            /** @var $director User */
            if ( ( $id = Yii::$app->request->getQueryParam('id') ) &&
                ( $invoice = Invoice::findOne( $id )) &&
                ( $paymentMethod = $invoice->getPaymentMethod()->one()) &&
                ( $customer = $invoice->getUser()->one()) ) {

                if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ||
                    (User::hasPermission([User::ROLE_SALES]) && $invoice->created_by == Yii::$app->user->id)) {


                    $name = "Invoice" . $invoice->invoice_id . ".pdf";

                    //-------------- Download contractor signature from Amazon Simple Storage Service--------//
                    $contractorSign     = 'users/1/sign';
                    $contractorSignData = "";
                    $s = new Storage();
                    try {
                        $contractorSignData = $s->download($contractorSign);
                    }catch (\Aws\S3\Exception\S3Exception $e) {}

                    //----------------Download customer signature from Amazon Simple Storage Service---------//

                    $customerSign       = 'users/' . $customer->id . '/sign';
                    $customerSignData   = "";
                    try {
                        $customerSignData = $s->download($customerSign);
                    } catch (\Aws\S3\Exception\S3Exception $e) {}

                    $signatureContractor = "";
                    $signatureCustomer = "";

                    if(isset($contractorSignData['Body'])) {
                        $signatureContractor = $contractorSignData['Body'];
                    }

                    if(isset($contractorSignData['Body'])) {
                        $signatureCustomer = $customerSignData['Body'];
                    }

                    $html = Yii::$app->controller->renderPartial('invoicePDF', [
                        'id'                    => $invoice->invoice_id,
                        'dateInvoiced'          => DateUtil::reConvertData( $invoice->date_created ),
                        'dateToPay'             => DateUtil::reConvertData( date('Y-m-d', strtotime($invoice->date_created . ' +3 days')) ),
                        'supplierName'          => $paymentMethod->name,
                        'supplierNameUa'        => $paymentMethod->name_alt,
                        'supplierAddress'       => $paymentMethod->address,
                        'supplierAddressUa'     => $paymentMethod->address_alt,
                        'supplierDirector'      => $paymentMethod->represented_by,
                        'supplierDirectorUa'    => $paymentMethod->represented_by_alt,
                        'supplierBank'          => $paymentMethod->bank_information,
                        'supplierBankUa'        => $paymentMethod->bank_information_alt,
                        'customerCompany'       => $customer->company,
                        'customerAddress'       => $customer->address,
                        'customerName'          => $customer->first_name . ' ' . $customer->last_name,
                        'customerBank'          => $customer->bank_account_en,
                        'customerBankUa'        => $customer->bank_account_ua,
                        'currency'              => $invoice->currency,
                        'priceTotal'            => $invoice->total > 0 ? round( $invoice->total, 2):0,
                        'notes'                 => $invoice->note,

                        'dataFrom'              => date('j F', strtotime($invoice->date_start)),
                        'dataTo'                => date('j F', strtotime($invoice->date_end)),
                        'dataFromUkr'           => date('d.m.Y', strtotime($invoice->date_start)),
                        'dataToUkr'             => date('d.m.Y', strtotime($invoice->date_end)),

                        'signatureCustomer'     => $signatureCustomer,
                        'signatureContractor'   => $signatureContractor

                    ]);

                    $pdf = new Mpdf();
                    @$pdf->WriteHTML($html);

                    $this->setData(
                        [
                            'pdf' => base64_encode($pdf->Output($name, 'S')),
                            'name' => $name
                        ]
                    );

                } else {

                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'This invoice is not avaialble for you.'));

                }

            } else {

                if ( !$invoice ) {

                    $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Requested invoice has not been found.'));

                }
                if ( $invoice && !$business ) {

                    $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Business has not been found.'));

                }
                if ( $invoice && $business && !$customer ) {

                    $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Customer has not been found.'));

                }
                if ( $invoice && $business && !$director ) {

                    $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Director has not been found.'));

                }
                return true;

            }

        }else {

            return $this->addError(Processor::ERROR_PARAM, Message::get(Processor::CODE_NOT_ATHORIZED));
        }

    }
}
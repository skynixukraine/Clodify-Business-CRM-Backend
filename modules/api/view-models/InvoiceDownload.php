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
use yii\helpers\ArrayHelper;

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

            /** @var $invoice Invoice */
            /** @var $business Business */
            /** @var $customer User */
            /** @var $director User */
            if ( ( $id = Yii::$app->request->getQueryParam('id') ) &&
                ( $invoice = Invoice::find()->where(['invoice_id' => $id])->one()) &&
                ( $business = $invoice->getBusiness()->one()) &&
                ( $customer = $invoice->getUser()->one()) &&
                ( $director = User::findOne( $business->director_id))) {

                if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ||
                    (User::hasPermission([User::ROLE_SALES]) && $invoice->created_by == Yii::$app->user->id)) {


                    $name = "Invoice" . $invoice->invoice_id . ".pdf";

                    //-------------- Download contractor signature from Amazon Simple Storage Service--------//
                    $contractorSign     = 'users/' . $director->id . '/sign';
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

                    $signatureContractor = 'data: image/jpeg;base64,'.base64_encode( $contractorSignData );

                    $signatureCustomer = 'data: image/jpeg;base64,'.base64_encode($customerSignData);

                    $html = Yii::$app->controller->renderPartial('invoicePDF', [
                        'id'                    => $invoice->invoice_id,
                        'dateInvoiced'          => DateUtil::reConvertData( $invoice->date_created ),
                        'dateToPay'             => DateUtil::reConvertData( date('Y-m-d', strtotime($invoice->date_created . ' +3 days')) ),
                        'supplierName'          => $business->name,
                        'supplierNameUa'        => $business->name_ua,
                        'supplierAddress'       => $business->address,
                        'supplierAddressUa'     => $business->address_ua,
                        'supplierDirector'      => $business->represented_by,
                        'supplierDirectorUa'    => $business->represented_by_ua,
                        'supplierBank'          => $director->bank_account_en,
                        'supplierBankUa'        => $director->bank_account_ua,
                        'customerCompany'       => $customer->company,
                        'customerAddress'       => $customer->address,
                        'customerName'          => $customer->first_name . ' ' . $customer->last_name,
                        'customerBank'          => $customer->bank_account_en,
                        'customerBankUa'        => $customer->bank_account_ua,

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
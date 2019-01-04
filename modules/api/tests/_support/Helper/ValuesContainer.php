<?php
/**
 * Created by Skynix Team
 * Date: 27.04.17
 * Time: 12:02
 */

namespace Helper;

class ValuesContainer
{
    public static $projectId = 1;

    public static $nonPaidProjectId = 2;

    public static $contractId = 2;
    public static $FinancialReportId;
    public static $FinancialReportDate; //This value will be set during fin reports cest
    public static $FinancialReportYear;
    public static $DelayedSalaryDate;
    public static $BusinessID = 1;
    public static $alternateBusinessID = 2;
    public static $alternatePaymentMethodID = 2;
    public static $ProjectId = 1;
    public static $PaymentMethodId = 1;
    public static $unix = 1522912941;
    public static $DevSalary = 5500;
    public static $BusinessId = 1;
    public static $EmailTemplateId = 1;
    public static $InvoiceTemplateId = 1;

    public static $projectIDWithoutSales;

    public static $fakeSalesID;

    public static $BusinessInvoiceIncrementId = 0;
    public static $altBusinessInvoiceIncrementId = 0;


    public static $userAdmin = [
        'id'        => 1,
        'email'     => 'crm-admin@skynix.co',
        'password'  => 'B19E$d4n$yc@Lu6fQIO#1d'
    ];

    public static $userFin = [
        'id'        => 2,
        'email'     => 'crm-fin@skynix.co',
        'password'  => 'Q3zvy#kc@RD'
    ];

    public static $userDev = [
        'id'        => 3,
        'email'     => 'crm-dev@skynix.co',
        'password'  => 'Q$zv#yk2cR4D'
    ];

    public static $userClient = [
        'id'        => 4,
        'email'     => 'crm-client@skynix.co',
        'password'  => 'Q$zR#yk2cR4D'
    ];

    public static $userSales = [
        'id'        => 5,
        'email'     => 'crm-sales@skynix.co',
        'password'  => 'Q$zR#yk2c4R4D'
    ];

    public static $userPm = [
        'id'        => 6,
        'email'     => 'crm-pm@skynix.co',
        'password'  => 'Q$zR3yk2c4R4D'
    ];

    public static $paymentMethodData = [
        'id' => 1,
        'name' => 'p24',
        'address' => 'Kyiv 22, ap 33',
        'represented_by' => 'Privat 24',
        'bank_information' => 'The P24 is a large bank of Ukraine',
        'is_default' => 1,
        'business_id' => 1
    ];

    public static $createBusinessData = [
        'name' => 'Method 1',
        'director_id' => 1,
        'address' => 'Solnechnaia street 2',
        'is_default' => 1
    ];

    public static $updateBusinessData = [
        'name' => "Method 22",
        'director_id' => 4,
        'address' => "New Address 55",
        'is_default' => 1
    ];

    public static $updateEmailTemplateData = [
        'subject' => "Update Email Template",
        'reply_to' => "Someone",
        'body' => "Hello, Update Email Template"
    ];

    public static $updateInvoiceTemplateData = [
        'name' => "Update invoice template",
        'body' => "Hello, Update invoice template"
    ];

    public static $uploadLogoBusinessData = [
        'logo' => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAkAAAAMMCACYII="
    ];

    public static $updatePaymentMethodUrlApi = "/api/businesses/1/methods/1";

    public static $createPaymentMethodUrlApi = '/api/businesses/1/methods';

    public static $deletePaymentMethodUrlApi = '/api/businesses/1/methods/1';

    public static $setDefaultPaymentMethodUrlApi = '/api/businesses/1/methods/1';

    public static $createBusinessUrlApi = '/api/businesses';


 }

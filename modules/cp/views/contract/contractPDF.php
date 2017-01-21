<?php
use app\models\ContractTemplates;
use app\models\PaymentMethod;
use app\models\User;

$contract_template = ContractTemplates::findOne($contract_template_id);
$payment_template = PaymentMethod::findOne($contract_payment_method_id);
$bank_account = User::findOne($customer_id);

$total = number_format($total, 2);
$start_date_eng = date("j F Y", strtotime($start_date));
$start_date_ukr = Yii::t('app', $start_date_eng, [], 'ua-UA'); // does not work translation of month to ukrainian
$search = ['var_contract_id', 'var_start_date_eng', 'var_start_date_ukr', 'var_total'];
$replace = [$contract_id, $start_date_eng, $start_date_ukr, $total];

echo str_replace($search, $replace, $contract_template->content) . $payment_template->description .
    $bank_account->bank_account_en . $bank_account->bank_account_ua ;

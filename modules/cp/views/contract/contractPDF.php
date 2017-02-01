<?php
use app\models\ContractTemplates;
use app\models\PaymentMethod;
use app\models\User;

$contract_template = ContractTemplates::findOne($contract_template_id);
$payment_template = PaymentMethod::findOne($contract_payment_method_id);
$user = User::findOne($customer_id);

$total = number_format($total, 2);
$companyName = $user->company;
$signatureProzhoga = Yii::getAlias('@app') . '/data/signatureProzhoga.png';
$signatureProzhoga = (string) $signatureProzhoga;

$start_date = date("d/m/Y", strtotime($start_date));
$search = ['var_contract_id', 'var_start_date', 'var_total', 'var_company_name'];
$replace = [$contract_id, $start_date, $total, $companyName];

$description = '<table width="570" style="max-width: 570px; margin-left: auto; margin-right: auto; border-collapse: collapse;">

    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse;">
        <td width="285" style =" vertical-align: top; border-left: 1px solid black; border-right: 1px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px; font-family:\'Times New Roman\';font-size:10px; padding: 5px;">
            <table width="285" style="margin:0;border-collapse: collapse;border: 0;">
                <tr>
                    <td align="center" style="margin: 0; font-family:\'Times New Roman\';font-size:10px;">Виконавець</td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0; font-family:\'Times New Roman\';font-size:10px;">
                        <p><span style="color: #ffffff;">.</span></p>
                        <p>Бенефіциар: <strong>Прожога Олексій Юрійович</strong></p>
                        <p>Адреса бенефіциара: <strong>UA 08294</strong></p>
                        <p><strong>Київська обл., м. Буча</strong></p>
                        <p><strong>вул. Тарасiвська д.8а кв.128</strong></p>
                        <p>Рахунок бенефіциара: <strong>26002057002108</strong></p>
                        <p>SWIFT код: <strong>PBANUA2X</strong></p>
                        <p>Банк бенефіциара: <strong>Privatbank, Dnipropetrovsk, Ukraine</strong></p>
                        <p>IBAN Code: <strong>UA323515330000026002057002108</strong></p>
                        <p>Банк-корреспондент: <strong>JP Morgan</strong></p>
                        <p><strong>Chase Bank,New York ,USA</strong></p>
                        <p>Рахунок у банку-кореспонденту: <strong>001-1-000080</strong></p>
                        <p>SWIFT код кореспондента: <strong>CHASUS33</strong></p>
                        <p><br><span style="color: #ffffff;">.</span></p>
                        <p>Прожога О.Ю.</p>
                    </td>
                </tr>
            </table>
        </td>
        <td width="284" style =" vertical-align: top; border-collapse: collapse; border-left: 1px solid black; border-right: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px; font-family:\'Times New Roman\'; font-size:10px; padding: 5px;">
            <table width="284" style="margin:0;border-collapse: collapse;border: 0;">
                <tr>
                    <td align="center" style="margin: 0; font-family:\'Times New Roman\';font-size:10px;">Contractor</td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0; font-family:\'Times New Roman\';font-size:10px;">
                        <p><span style="color: #ffffff;">.</span></p>
                        <p>BENEFICIARY: <strong>Prozhoga Oleksii Yuriyovich</strong></p>
                        <p>BENEFICIARY ADDRESS: <strong>UA 08294 Kiyv,</strong></p>
                        <p><strong>Bucha, Tarasivska st. 8a/128</strong></p>
                        <p><span style="color: #ffffff;">.</span></p>
                        <p>BENEFICIARY ACCOUNT: <strong>26002057002108</strong></p>
                        <p>SWIFT CODE: <strong>PBANUA2X</strong></p>
                        <p>BANK OF BENEFICIARY: <strong>Privatbank,</strong></p>
                        <p><strong>Dnipropetrovsk, Ukraine</strong></p>
                        <p>IBAN Code: <strong>UA323515330000026002057002108</strong></p>
                        <p>CORRESPONDENT BANK: <strong>JP Morgan</strong></p>
                        <p><strong>Chase Bank,New York ,USA</strong></p>
                        <p>CORRESPONDENT ACCOUNT: <strong>001-1-000080</strong></p>
                        <p>SWIFT Code of correspondent bank: <strong>CHASUS33</strong></p>
                        <p><br><span style="color: #ffffff;">.</span></p>
                        <p>Prozhoga O.Y.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>';
echo str_replace($search, $replace, $contract_template->content) . $description;
?>






<table width="570" style="max-width: 570px; margin-left: auto; margin-right: auto; border-collapse: collapse;">

    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td width="285" style ="width: 285px; vertical-align: top;  border-top: 0px solid black; border-left: 1px solid black; border-right: 0px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px; font-family:\'Times New Roman\';font-size:10px;">
            <img src="<?=$signatureProzhoga?>" style="max-width: 120px;">
        </td>
        <td width="284" style ="width: 284px; vertical-align: top; border-collapse: collapse; border-left: 1px solid black; border-right: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px; font-family:\'Times New Roman\';font-size:10px;">
            <img src="<?=$signatureProzhoga?>" style="max-width: 120px;">
        </td>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td width="285" style ="width: 285px; vertical-align: top; border-bottom: 0px solid black; border-left: 1px solid black; border-right: 0px solid black;height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px; font-family:\'Times New Roman\';font-size:10px;">
            <p>Підпис</p>
        </td>
        <td width="284" style ="width: 284px; vertical-align: top; border-collapse: collapse; border-bottom: 0px solid black; border-left: 1px solid black; border-right: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px; font-family:\'Times New Roman\';font-size:10px;">
            <p>Signature</p>
        </td>
    </tr>
</table>



<table width="570" style="max-width: 570px; margin-left: auto; margin-right: auto; border-collapse: collapse;">

    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse;">
        <td width="285" style =" vertical-align: top; border: 1px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px; font-family:'Times New Roman';font-size:10px;">
            <?=$user->bank_account_ua?>
        </td>
        <td width="284" style =" vertical-align: top; border-collapse: collapse; border: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px; font-family:'Times New Roman';font-size:10px;">
            <?=$user->bank_account_en?>
        </td>
    </tr>
</table>

<?php

if ($user->sing) :?>

<table width="570" style=" margin-left: auto; margin-right: auto; border-collapse: collapse;">
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td style =" vertical-align: top; border: 1px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px;">
    <img src="<?=$user->getUserSingPath()?>" width="285">
        </td>
        <td style =" vertical-align: top; border: 1px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px;">
            <img src="<?=$user->getUserSingPath()?>" width="285">
        </td>
    </tr>
</table>

<?php endif; ?>

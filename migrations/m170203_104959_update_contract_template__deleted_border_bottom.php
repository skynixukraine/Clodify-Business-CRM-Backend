<?php

 use app\components\SkynixMigration;

class m170203_104959_update_contract_template__deleted_border_bottom extends SkynixMigration
{
    public function up()
    {
        $content = '
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<table width="570" style=" margin-left: auto; margin-right: auto; border-collapse: collapse;">
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td style =" vertical-align: top; border: 1px solid black; border-bottom:none; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px 4px 5px 4px;">
            <table width="285" style="margin:0;border-collapse: collapse;border: 0;">
                <tr>
                    <td align="center" style="margin: 0; font-family:\'Times New Roman\';font-size:10px;"><strong>КОНТРАКТ №var_contract_id</strong></strong></td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>НА НАДАННЯ ПОСЛУГ</strong></td>
                </tr>
                <tr>
                    <td align="right" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">var_start_date</td>
                </tr>
                <tr>
                    <td align="right" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><span style="color: #ffffff;">.</span></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;">
                        <p style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
                            <span style="color: #ffffff;">.....</span>Компанія "var_company_name" далі
                            по тексту "Замовник" і Компанія ФОП Прожога О.Ю.,
                            Україна,в особі Прожоги Олексія Юрійовича,
                            діючого на підставі реєстрації
                            №22570000000001891 від 01.05.2001р. далі по
                            тексту "Виконавець", далі по тексту Сторони,
                            уклали цей Контракт про наступне:<br><span style="color: #ffffff;">.</span><br>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>1. Предмет Контракту</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"> 1.1.Виконавець зобов\'язується за завданням
                        Замовника надати наступні послуги:
                        Розробка програмного забезпечення(веб
                        сайту)
                    </td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>2. Ціна і загальна сума Контракту</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">2.1. Вартість послуги встановлюється в <strong>$var_total</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">2.2.  Загальна сума Контракту становить <strong>$var_total</strong></td>
                </tr>
                <tr>
                    <td align="left" style="margin: 0;letter-spacing:0px;font-family:\'Times New Roman\';font-size:10px;">
                        2.3.У разі зміни суми Контракту за згодою
                        сторін, Сторони зобов\'язуються підписати додаткову угоду до даного Контракту про
                        збільшення або зменшення загальної суми Контракту.<br><span style="color: #ffffff;">.</span></td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>3. Умови платежу</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">3.1.Замовник здійснює оплату банківським
                        переказом на рахунок Виконавця протягом 5
                        календарних днів з моменту підписання Акту
                        прийому-передачі наданих послуг.</td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
                        3.2. Банківські витрати оплачує замовник</td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
                        3.3. Валюта платежу – USD.</td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>4. Умови надання послуг</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">4.1.Виконавець надає послуги на умовах
                        цього Контракту і Додатків до нього.</td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>5. Відповідальність сторін</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">5.1.Сторони зобов\'язуються нести
                        відповідальність за невиконання або
                        неналежне виконання зобов\'язань за цим
                        Контрактом.</td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>6. Претензії</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">6.1 Претензії щодо якості наданих за даним
                        Контрактом послуг можуть бути пред\'явлені
                        не пізніше 3 робочих днів з дня підписання
                        Акту прийому-передачі наданих послуг.</td>
                </tr>
            </table>
        </td>
        <td style =" vertical-align: top; border-collapse: collapse; border: 1px solid black; border-bottom:none; height: 100%; box-sizing: border-box; padding: 5px 4px 5px 4px;">
            <table width="285" style="margin:0;border-collapse: collapse;border: 0;">
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>CONTRACT №var_contract_id</strong></td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>FOR SERVICES</strong></td>
                </tr>
                <tr>
                    <td align="right" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">var_start_date</td>
                </tr>
                <tr>
                    <td align="right" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><span style="color: #ffffff;">.</span></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;">
                        <p style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
                            <span style="color: #ffffff;">.....</span>The company "var_company_name"
                            hereinafter referred to as "Customer" and the
                            company "<strong>FOP Prozhoga O.Y.</strong>" Ukraine,
                            represented by Prozhoga Oleksii Yuriyovich, who is
                            authorized by check №22570000000001891 from
                            01.05.2001, hereinafter referred to as "Contractor",
                            and both Companies hereinafter referred to as
                            "Parties", have cа яoncluded the present Contract as
                            follows:
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>1. Subject of the Contract</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">1.1.The Contractor undertakes to provide the
                        following services to Customer: Software
                        development (web site)<br><span style="color: #ffffff;">.</span></td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>2. Contract Price and total sum</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">2.1.The price for the Services is established in
                        <strong>$var_total</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
                        2.2.The preliminary total sum of the Contract
                        makes <strong>$var_total</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
                        2.3.In case of change of the sum of the Contract,
                        the Parties undertake to sign the additional
                        agreement to the given Contract on increase or
                        reduction of a total sum of the Contract.</td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>3. Payment Conditions</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">3.1.The Customer shall pay by bank transfer to
                        the account within 5 calendar days from the date
                        of signing the acceptance of the Services.</td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
                        3.2. Bank charges are paid by customer.</td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
                        3.3. The currency of payment is USD.<br><span style="color: #ffffff;">.</span><br></td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>4. Realisation Terms</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">4.1.The Contractor shall deliver of the services on
                        consulting services terms.</td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>5. The responsibility of the Parties</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">5.1. The Parties under take to bear the
                        responsibility for default or inadequate
                        performance of obligations under the present
                        contract</td>
                </tr>
                <tr>
                    <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;"><strong>6. Claims</strong></td>
                </tr>
                <tr>
                    <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">6.1.Claims of quality and quantity of the services
                        delivered according to the present Contract can be
                        made not later 3 days upon the receiving of the
                        Goods.</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
';
        $this->update('contract_templates', ['content' => $content], 'name=:name', [':name' => 'Default template']);
    }

    public function down()
    {
        echo "m170203_104959_update_contract_template__deleted_border_bottom cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

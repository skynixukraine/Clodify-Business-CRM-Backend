<?php

use yii\db\Migration;

class m170121_110057_insert_in_contractr_template extends Migration
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
<table width="570"
       style=" margin-left: auto; margin-right: auto; border-collapse: collapse;">

    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td style =" vertical-align: top; border: 1px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px;">
            <p style="text-align: center; margin: 0;"><strong>КОНТРАКТ №var_contract_id</strong></p>
            <p style="text-align: center; margin: 0;"><strong>НА НАДАННЯ ПОСЛУГ</strong></p>
            <p style="text-align: right">var_start_date_ukr</p>
            <p>
                Компанія "Colourways Limited"(UK) далі
                по тексту "Замовник" і Компанія ФОП Прожога О.Ю.,
                Україна,в особі Прожоги Олексія Юрійовича,
                діючого на підставі реєстрації
                №22570000000009911 від 01.05.2001р. далі по
                тексту "Виконавець", далі по тексту Сторони,
                уклали цей Контракт о наступном:
            </p>
            <p style="text-align: center; margin: 0;"><strong>1. Предмет Контракту</strong></p>
            <p style="margin: 0;"> 1.1.Виконавець зобов\'язується за завданням
                Замовника надати наступні послуги:
                Розробка програмного забезпечення(веб
                сайту)
            </p>
            <p style="text-align: center; margin: 0;"><strong>2. Ціна і загальна сума Контракту</strong></p>
            <p style="margin: 0;">2.1. Вартість послуги встановлюється в</p>
            <p style="margin: 0;"><strong>$var_total</strong></p>
            <p style="margin: 0;">
                2.2.  Загальна сума Контракту становить
            </p>
            <p style="margin: 0;"><strong>$var_total</strong></p>
            <p style="margin: 0;">
                2.3.У разі зміни суми Контракту за згодою
                сторін, Сторони зобов\'язуються підписати
                додаткову угоду до даного Контракту про
                збільшення або зменшення загальної суми
                Контракту.
            </p>
            <p style="text-align: center; margin: 0;"><strong>3. Умови платежу</strong></p>
            <p style="margin: 0;">
                3.1.Замовник здійснює оплату банківським
                переказом на рахунок Виконавця протягом 5
                календарних днів з моменту підписання Акту
                прийому-передачі наданих послуг.
                3.2. Банківські витрати оплачує замовник
                3.3. Валюта платежу – USD.
            </p>
            <p style="text-align: center; margin: 0;"><strong>4. Умови надання послуг</strong></p>
            <p style="margin: 0;">

                4.1.Виконавець надає послуги на умовах
                цього Контракту і Додатків до нього.
            </p>
            <p style="text-align: center; margin: 0;"><strong>5. Відповідальність сторін</strong></p>
            <p style="margin: 0;">

                5.1.Сторони зобов\'язуються нести
                відповідальність за невиконання або
                неналежне виконання зобов\'язань за цим
                Контрактом.
            </p>
            <p style="text-align: center; margin: 0;"><strong>6. Претензії</strong></p>
            <p style="margin: 0;">

                6.1 Претензії щодо якості наданих за даним
                Контрактом послуг можуть бути пред\'явлені
                не пізніше 3 робочих днів з дня підписання
                Акту прийому-передачі наданих послуг.
            </p>
        </td>
        <td style =" vertical-align: top; border-collapse: collapse; border: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px;">
            <p style="text-align: center; margin: 0;">
                <strong>CONTRACT №var_contract_id</strong>
            </p>
            <p style="text-align: center; margin: 0;">
                <strong>FOR SERVICES</strong>
            </p>
            <p style="text-align: right">
                var_start_date_eng
            </p>
            <p>
                The company "Colourways Limited"(UK)
                hereinafter referred to as "Customer" and the
                company "<strong>FOP Prozhoga O.Y.</strong>" Ukraine,
                represented by Prozhoga Oleksii Yuriyovich, who is
                authorized by check №22570000000000001 from
                01.05.2001р., hereinafter referred to as "Contractor",
                and both Companies hereinafter referred to as
                "Parties", have concluded the present Contract as
                follows:
            </p>
            <p style="text-align: center; margin: 0;"><strong>1. Subject of the Contract</strong></p>
            <p style="margin: 0;">

                1.1.The Contractor undertakes to provide the
                following services to Customer: Software
                development (web site)
            </p>
            <p style="text-align: center; margin: 0;"><strong>2. Contract Price and total sum</strong></p>
            <p style="margin: 0;">

                2.1.The price for the Services is established in
                <strong>$var_total</strong>
                2.2.The preliminary total sum of the Contract
                makes <strong>$var_total</strong>
                2.3.In case of change of the sum of the Contract,
                the Party undertake to sign the additional
                agreement to the given Contract on increase or
                reduction of a total sum of the Contract.
            </p>
            <p style="text-align: center; margin: 0;"><strong>3. Payment Conditions</strong></p>
            <p style="margin: 0;">

                3.1.The Customer shall pay by bank transfer to
                the account within 5 calendar days from the date
                of signing the acceptance of the Services.
                3.2. Bank charges are paid by customer.
                3.3. The currency of payment is USD.
            </p>
            <p style="text-align: center; margin: 0;"><strong>4. Realisation Terms</strong></p>
            <p style="margin: 0;">

                4.1.The Contractor shall deliver of the services on
                consulting services terms.
            </p>
            <p style="text-align: center; margin: 0;"><strong>5. The responsibility of the Parties</strong></p>
            <p style="margin: 0;">

                5.1. The Parties under take to bear the
                responsibility for default or inadequate
                performance of obligations under the present
                contract
            </p>
            <p style="text-align: center; margin: 0;"><strong>6. Claims</strong></p>
            <p style="margin: 0;">

                6.1.Claims of quality and quantity of the services
                delivered according to the present Contract can by
                made not later 3 days upon the receiving of the
                Goods.
            </p>

        </td>
    </tr>

</table>
        ';
        $this->insert('contract_templates', [
            'name' => 'Default template',
            'content' => $content
        ]);
    }

    public function down()
    {
        echo "m170121_110057_insert_in_contractr_template cannot be reverted.\n";

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

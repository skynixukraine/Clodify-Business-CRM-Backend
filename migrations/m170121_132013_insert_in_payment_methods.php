<?php

use yii\db\Migration;

class m170121_132013_insert_in_payment_methods extends Migration
{
    public function up()
    {
        $description = '
<table width="570"
       style=" margin-left: auto; margin-right: auto; border-collapse: collapse;">

    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td style =" vertical-align: top; border: 1px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px;">
            <p>Виконавець</p>
            <p>Бенефіциар: Прожога Олексій Юрійович</p>
            <p>Адреса бенефіциара: <strong>UA 08294</strong> Київська м. Буча</p>
            <p>вул. Тарасiвська д.<strong>8</strong>а кв.<strong>128</strong></p>
            <p>Рахунок бенефіциара: <strong>26002057002108</strong></p>
            <p>SWIFT код: <strong>PBANUA2X</strong></p>
            <p>Банк бенефіциара: <strong>Privatbank, Dnipropetrovsk, Ukraine</strong></p>
            <p>IBAN Code: <strong>UA323515330000026002057002108</strong></p>
            <p>Банк-корреспондент: <strong>JP Morgan Chase</strong></p>
            <p><strong>Bank,New York ,USA</strong></p>
            <p>Рахунок у банку-кореспонденту: <strong>001-1-000080</strong></p>
            <p>SWIFT код кореспондента: <strong>CHASUS33</strong></p>
            <p>Прожога О.Ю.</p>
            <img src="signatureProzhoga.png" width="250px" height="150px">
            <p>Підпис</p>
        </td>
        <td style =" vertical-align: top; border-collapse: collapse; border: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px;">
            <p>Contractor</p>
            <p>BENEFICIARY: <strong>Prozhoga Oleksii Yuriyovich</strong></p>
            <p>BENEFICIARY ADDRESS: <strong>UA 08294 Kiyv,</strong></p>
            <p><strong>Bucha, Tarasivska st. 8a/128</strong></p>
            <p>BENEFICIARY ACCOUNT: <strong>26002057002108</strong></p>
            <p>SWIFT CODE: <strong>PBANUA2X</strong></p>
            <p>BANK OF BENEFICIARY: <strong>Privatbank,</strong></p>
            <p><strong>Dnipropetrovsk, Ukraine</strong></p>
            <p>IBAN Code: <strong>UA323515330000026002057002108</strong></p>
            <p>CORRESPONDENT BANK: <strong>JP Morgan Chase</strong></p>
            <p><strong>Bank,New York ,USA</strong></p>
            <p>CORRESPONDENT ACCOUNT: <strong>001-1-000080</strong></p>
            <p>SWIFT Code of correspondent bank: <strong>CHASUS33</strong></p>
            <p>Prozhoga O.Y.</p>
            <img src="signatureProzhoga.png" width="250px" height="150px">
            <p>Signature</p>
        </td>
    </tr>

</table>
</body>
        ';
        $this->insert('payment_methods', [
           'name' => 'Default payment method',
            'description' => $description
        ]);
    }

    public function down()
    {
        echo "m170121_132013_insert_in_payment_methods cannot be reverted.\n";

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

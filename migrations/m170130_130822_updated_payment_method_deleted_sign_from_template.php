<?php

use yii\db\Migration;

class m170130_130822_updated_payment_method_deleted_sign_from_template extends Migration
{
    public function up()
    {
        $description = '
        <table width="570"
       style=" margin-left: auto; margin-right: auto; border-collapse: collapse;">

    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td style =" vertical-align: top; border: 1px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px; font-family:\'Times New Roman\';font-size:10px; border-bottom: none;">
            <p><center><strong>Виконавець</strong></center></p>
            <p>Бенефіциар: <strong>Прожога Олексій Юрійович</strong></p>
            <p>Адреса бенефіциара: <strong>UA 08294 Київська обл., м. Буча</strong></p>
            <p><strong>вул. Тарасiвська д.8а кв.128</strong></p>
            <p>Рахунок бенефіциара: <strong>26002057002108</strong></p>
            <p>SWIFT код: <strong>PBANUA2X</strong></p>
            <p>Банк бенефіциара: <strong>Privatbank, Dnipropetrovsk, Ukraine</strong></p>
            <p>IBAN Code: <strong>UA323515330000026002057002108</strong></p>
            <p>Банк-корреспондент: <strong>JP Morgan</strong></p>
            <p><strong>Chase Bank, New York,USA</strong></p>
            <p>Рахунок у банку-кореспонденту: <strong>001-1-000080</strong></p>
            <p>SWIFT код кореспондента: <strong>CHASUS33</strong></p>
            <p>Прожога О.Ю.</p>
        </td>
        <td style =" vertical-align: top; border-collapse: collapse; border: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px; font-family:\'Times New Roman\';font-size:10px; border-bottom: none">
            <p><center><strong>Contractor</strong></center></p>
            <p>BENEFICIARY: <strong>Prozhoga Oleksii Yuriyovich</strong></p>
            <p>BENEFICIARY ADDRESS: <strong>UA 08294 Kiyv,</strong></p>
            <p><strong>Bucha, Tarasivska st. 8a/128</strong></p>
            <p>BENEFICIARY ACCOUNT: <strong>26002057002108</strong></p>
            <p>SWIFT CODE: <strong>PBANUA2X</strong></p>
            <p>BANK OF BENEFICIARY: <strong>Privatbank,</strong></p>
            <p><strong>Dnipropetrovsk, Ukraine</strong></p>
            <p>IBAN Code: <strong>UA323515330000026002057002108</strong></p>
            <p>CORRESPONDENT BANK: <strong>JP Morgan</strong></p>
            <p><strong>Chase Bank, New York,USA</strong></p>
            <p>CORRESPONDENT ACCOUNT: <strong>001-1-000080</strong></p>
            <p>SWIFT Code of correspondent bank: <strong>CHASUS33</strong></p>
            <p>Prozhoga O.Y.</p>
        </td>
    </tr>

</table>
        ';
        $this->update('payment_methods', ['description' => $description], 'name=:name', [':name' => 'Default payment method']);
    }

    public function down()
    {
        echo "m170130_130822_updated_payment_method_deleted_sign_from_template cannot be reverted.\n";

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

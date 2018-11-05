<?php


use app\components\SkynixMigration;


class m160302_101023_payment_methods_insert_bank_transfer extends SkynixMigration
{
    public function up()
    {
        $this->alterColumn('payment_methods', 'description', 'MEDIUMTEXT');
        $this->insert('payment_methods', [
            'name' => 'bank_transfer',
            'description' => '
                            <tr>
                                <td colspan = "8" width = "570" style="padding: 0; margin: 0;">
                                    <table border="0" cellpadding="0" cellspacing="0" width="570" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">

                                        <tr>
                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">
                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">
                                                    Реквизиты предприятия/Company details
                                                </div>
                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">
                                                    Наименоваение предприятия/company Name
                                                </div>
                                            </td>
                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">
                                                Прожога Олексiй Юрiйович пiдприємец
                                            </td>
                                        </tr>

                                        <tr style="background-color: #eeeeee;">
                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">
                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">
                                                    Счет предприятия в банке/The bank account of the company
                                                </div>
                                            </td>
                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">
                                                26002057002108
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">
                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">
                                                    Наименование банка/Name of the bank
                                                </div>
                                            </td>
                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">
                                                Privatbank, Dnipropetrovsk, Ukraine
                                            </td>
                                        </tr>

                                        <tr style="background-color: #eeeeee;">
                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">
                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">
                                                    SWIFT Code банка/Bank SWIFT Code
                                                </div>
                                            </td>
                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">
                                                PBANUA2X
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">
                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">
                                                    Адрес предприятия/Company address
                                                </div>
                                            </td>
                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">
                                                UA 08294 Київська м Буча вул Тарасiвська д.8а кв.128
                                            </td>
                                        </tr>

                                        <tr style="background-color: #eeeeee;">
                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">
                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">
                                                    IBAN Code
                                                </div>
                                            </td>
                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">
                                                UA323515330000026002057002108
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">
                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">
                                                    Банки-корреспонденты/correspondent banks
                                                </div>
                                                <div style="width: 100%; padding: 18px 0 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">
                                                    Счет в банке-корреспонденте/Account in the correspondent bank
                                                </div>
                                            </td>
                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">
                                                001-1-000080
                                            </td>
                                        </tr>

                                        <tr style="background-color: #eeeeee;">
                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">
                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">
                                                    SWIFT Code
                                                </div>
                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">
                                                    банка-корреспондента/SWIFT-code of the correspondent bank
                                                </div>
                                            </td>
                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">
                                                CHASUS33
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width = "285" valign="top" height="25" style="padding: 7px 5px 20px 5px; margin: 0; border: solid 1px #2c2c2c;">
                                                <div style="width: 100%; padding: 2px 0; font-size: 12px; font-family: \'HelveticaNeue Bold\', sans-serif; font-weight: bold; text-align: left;">
                                                    Банк-корреспондент/correspondent bank
                                                </div>
                                            </td>
                                            <td height="25" valign="top" style="width: 50%; padding: 7px 5px 20px 5px; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif; font-weight: normal; font-size: 12px; text-align: left; border: solid 1px #2c2c2c;">
                                                JP Morgan Chase Bank,New York ,USA
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>',
        ]);
    }

    public function down()
    {
        echo "m160302_101023_payment_methods_insert_bank_transfer cannot be reverted.\n";

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

<?php

use app\components\SkynixMigration;

/**
 * Class m190312_130437_create_project_email_template
 */
class m190312_130437_create_project_email_template extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert(\app\models\EmailTemplate::tableName(), [
            'template'  => 'create_project',
            'subject'   => '{SalesFirstName} created a new project',
            'reply_to'  => '{SalesEmail}',
            'body'      => '<tr>
                            <td width = "29" style="padding: 0; margin: 0;"></td>
                            <td colspan = "3"  height="36" style="padding: 0; margin: 0;">
                                <table border="0" cellpadding="0" cellspacing="0" width="512" style="border-collapse: collapse;
                                 mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;">
                                    <tr>
                                        <td colspan = "2" width = "125" height="12" valign="top" style="padding: 0; margin: 0;"></td>
                                        <td rowspan = "2" width = "262" height="25" style="padding: 0; margin: 0;
                                         font-family: \'HelveticaNeue UltraLight\', sans-serif; font-size: 24px; text-align: center;
                                          vertical-align: middle;"> Hi, <span>{AdminFirstName}</span> </td>
                                        <td colspan = "2" width = "125" height="12" valign="top" style="padding: 0; margin: 0;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan = "2" width = "125" height="0" valign="top" style="padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;"></td>
                                        <td colspan = "2" width = "125" height="0" valign="top" style="padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;"></td>
                                    </tr>
                                </table>
                            </td>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                            </tr>
                            <tr>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                                <td colspan = "3"  height="16" style="padding: 19px 0 10px 0; margin: 0; font-family: \'HelveticaNeue Regular\',
                                sans-serif; font-size: 16px; font-weight: normal; text-align: center;">
                                {SalesFirstName} has created a new project: {ProjectName}
                                </td>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                            </tr>
                            <tr>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                                <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;
                                 font-weight: normal; text-align: center;">Start Date: {ProjectDateStart}</td>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                            </tr>
                            <tr>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                                <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;
                                 font-weight: normal; text-align: center;">End Date: {ProjectDateEnd}</td>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                            </tr>
                            <tr>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                                <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;
                                 font-weight: normal; text-align: center;">Customers: {ProjectCustomers}</td>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                            </tr>
                            <tr>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                                <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;
                                 font-weight: normal; text-align: center;">Developers: {ProjectDevelopers}</td>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                            </tr>
                            <tr>
                                <td colspan = "5"  height="13" style="padding: 0; margin: 0; background-color: #a3d8f0;"></td>
                            </tr>'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190312_130437_create_project_email_template cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190312_130437_create_project_email_template cannot be reverted.\n";

        return false;
    }
    */
}

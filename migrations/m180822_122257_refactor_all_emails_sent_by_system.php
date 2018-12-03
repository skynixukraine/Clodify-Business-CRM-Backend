<?php

 use app\components\SkynixMigration;

/**
 * Class m180822_122257_refactor_all_emails_sent_by_system
 */
class m180822_122257_refactor_all_emails_sent_by_system extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('email_templates', [
            'subject' => 'Skynix CRM: Change password',
            'reply_to' => '{adminEmail}',
            'body' => '<tr>
    <td width = "29" style="padding: 0; margin: 0;"></td>
    <td colspan = "3"  height="36" style="padding: 0; margin: 0;">
        <table border="0" cellpadding="0" cellspacing="0" width="512" style="border-collapse: collapse;
     mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;">
            <tr>
                <td colspan = "2" width = "125" height="12" valign="top" style="padding: 0; margin: 0;"></td>
                <td rowspan = "2" width = "262" height="25" style="padding: 0; margin: 0;
             font-family: \'HelveticaNeue UltraLight\', sans-serif; font-size: 24px; text-align: center;
              vertical-align: middle;"> Hello, <span>{username},</span> </td>
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
    <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;">{username}, go through the link to reset your password.</td>
    <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>

<tr>
    <td colspan = "5"  height="35" style="padding: 8px 0 5px 0; margin: 0; background-color: #a3d8f0;
        font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px; text-align: center; color: #fffefe;">
        THANK YOU FOR YOUR COLLABORATION WE APPRECIATE YOUR BUSINESS </td>
</tr>
<tr>
    <td colspan = "2" width = "237" height="34" style="padding: 0; margin: 0; background-color: #a3d8f0;"></td>

    <td width = "96"  valign="top" style="padding:0; margin: 0; text-align: center; background-color: #a3d8f0;
        vertical-align: middle;">
        <a href={url_crm}/site/code/{token}> title="CLICK HERE" target="_blank" style="text-align: center; text-decoration: none;">
        <img src="http://cdn.skynix.co/skynix/btn-click.png" width="95" height = "34"  border="0"
             alt = "CLICK HERE" style="display: block; padding: 0px; margin: 0px; border: none;"/>
        </a>
    </td>

    <td colspan = "2" width = "237" height="34" style="padding: 0; margin: 0; background-color: #a3d8f0;"></td>
</tr>

<tr>
    <td colspan = "5"  height="13" style="padding: 0; margin: 0; background-color: #a3d8f0;"></td>
</tr>'
        ]);

        $this->insert('email_templates',[
            'subject' => 'Skynix Invoice # {dataPdf->id}',
            'reply_to' => '{adminEmail}',
            'body' => '<tr>
<td width = "29" style="padding: 0; margin: 0;"></td>
<td colspan = "3"  height="36" style="padding: 0; margin: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="512" style="border-collapse: collapse;
     mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;">
        <tr>
            <td colspan = "2" width = "125" height="12" valign="top" style="padding: 0; margin: 0;"></td>
            <td rowspan = "2" width = "262" height="25" style="padding: 0; margin: 0;
             font-family: \'HelveticaNeue UltraLight\', sans-serif; font-size: 24px; text-align: center;
              vertical-align: middle;"> Hello, <span>{nameCustomer}</span> </td>
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
    sans-serif; font-size: 16px; font-weight: normal; text-align: center;">Your invoice #
    <strong style=" font-family: \'HelveticaNeue Bold\', sans-serif; font-size: 16px; font-weight: bold;">{id}</strong></td>
    <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
    <td width = "29" style="padding: 0; margin: 0;"></td>
    <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;">This invoice has been generated by Skynix company for the period:</td>
    <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
    <td width = "29" style="padding: 0; margin: 0;"></td>
    <td colspan = "3"  height="15" style="padding: 0 0 4px 0; margin: 0;
     font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;"><strong style=" font-family: \'HelveticaNeue Bold\', sans-serif;
     font-size: 16px; font-weight: bold;">{dataFrom}  ~ {dataTo}</strong>
    </td>
    <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
    <td width = "29" style="padding: 0; margin: 0;"></td>
    <td colspan = "3"  height="15" style="padding: 10px 0 28px 0; margin: 0; font-family: \'HelveticaNeue Regular\', sans-serif;
    font-size: 15px; font-weight: normal; text-align: center;">The PDF invoice with payment details is attached</td>
    <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
    <td colspan = "5"  height="35" style="padding: 8px 0 5px 0; margin: 0; background-color: #a3d8f0;
        font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px; text-align: center; color: #fffefe;">
        THANK YOU FOR YOUR COLLABORATION <br/> WE APPRECIATE YOUR BUSINESS </td>
</tr>

<tr>
    <td colspan = "5"  height="13" style="padding: 0; margin: 0; background-color: #a3d8f0;"></td>
</tr>']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180822_122257_refactor_all_emails_sent_by_system cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180822_122257_refactor_all_emails_sent_by_system cannot be reverted.\n";

        return false;
    }
    */
}

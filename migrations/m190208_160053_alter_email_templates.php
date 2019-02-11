<?php

use app\components\SkynixMigration;

/**
 * Class m190208_160053_alter_email_templates
 */
class m190208_160053_alter_email_templates extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\EmailTemplate::tableName(), 'template', 'VARCHAR(50)');
        $this->update(\app\models\EmailTemplate::tableName(), [
            'template' => 'change-password'
        ], ['id' => 1]);
        $this->update(\app\models\EmailTemplate::tableName(), [
            'template' => 'invoice'
        ], ['id' => 2]);

        $this->insert(\app\models\EmailTemplate::tableName(), [
            'template'  => 'review_report',
            'subject'   => '{FirstName} edited a report #{ReportID}',
            'reply_to'  => '{adminEmail}',
            'body'      => '<tr>
                            <td width = "29" style="padding: 0; margin: 0;"></td>
                            <td colspan = "3"  height="36" style="padding: 0; margin: 0;">
                                <table border="0" cellpadding="0" cellspacing="0" width="512" style="border-collapse: collapse;
                                 mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;">
                                    <tr>
                                        <td colspan = "2" width = "125" height="12" valign="top" style="padding: 0; margin: 0;"></td>
                                        <td rowspan = "2" width = "262" height="25" style="padding: 0; margin: 0;
                                         font-family: \'HelveticaNeue UltraLight\', sans-serif; font-size: 24px; text-align: center;
                                          vertical-align: middle;"> Hello, <span>{SalesFirstName}</span> </td>
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
                                sans-serif; font-size: 16px; font-weight: normal; text-align: center;">The report: #
                                <strong style=" font-family: \'HelveticaNeue Bold\', sans-serif; font-size: 16px; font-weight: bold;">{ReportID}</strong>
                                {OldReportDate} {OldReportProject} -> {OldReportText} - {OldReportHours}h
                                </td>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                            </tr>
                            <tr>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                                <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;
                                 font-weight: normal; text-align: center;">has just been changed to:</td>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                            </tr>
                            <tr>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                                <td colspan = "3"  height="15" style="padding: 0 0 4px 0; margin: 0;
                                 font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px;
                                 font-weight: normal; text-align: center;">
                                 {NewReportDate} {NewReportProject} -> {NewReportText} - {NewReportHours}h
                                </td>
                                <td width = "29" style="padding: 0; margin: 0;"></td>
                            </tr>
                         
                            <tr>
                                <td colspan = "5"  height="35" style="padding: 8px 0 5px 0; margin: 0; background-color: #a3d8f0;
                                    font-family: \'HelveticaNeue Regular\', sans-serif; font-size: 15px; text-align: center; color: #fffefe;">
                                    
                                    <a href="{SiteUrl}/dashboard/reports/management?from_date={NewReportDate}&limit=10&p=1&project_id={NewReportProjectID}&to_date={NewReportDate}">Click here to review and approve</a>   
                                </td>
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
        echo "m190208_160053_alter_email_templates cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190208_160053_alter_email_templates cannot be reverted.\n";

        return false;
    }
    */
}

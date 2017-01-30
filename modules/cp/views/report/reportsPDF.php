<?php
use yii\helpers\Html;
use app\models\Report;
use app\components\DateUtil;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>&#9993;Reports</title>
    <style>
        a,
        a:hover,
        a:active,
        a:focus{
            outline: 0;
        }

    </style>
</head>
<body style="background-color: #ffffff;">

<table border="0" cellpadding="0" cellspacing="0" width="570" style="border-collapse: collapse; mso-table-lspace: 0pt;
mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;">

    <tr>
        <td colspan="6" width="570" height="17" style="padding: 0; margin: 0;"></td>
    </tr>

    <tr>
        <td colspan="6"  width="570" valign="top" style="padding: 0; margin: 0;">
            <a href="http://skynix.solutions/" title="logo Skynix" target="_blank">
                <img src="http://cdn.skynix.co/skynix/logo_skynix.jpg" alt="Skynix" border="0" width="105" height="30"
                     style="display: block; padding: 0px; margin: 0px; border: none;">
            </a>
        </td>
    </tr>

    <tr>
        <td colspan="6"  width="570"  height="27" style="padding: 0; margin: 0;"></td>

    </tr>

    <tr>
        <td colspan="6"  width="570" height="23" valign="top" style="padding: 0 0 23px 0; margin: 0;
         font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 400; text-align: center;">
            <h1><strong>Reports </strong></h1><span>
            <?php

                 if( (isset($filters['user_name']) || isset($filters['project_name']) || isset($filters['keyword']))) {
                     $text = ' is generated for ';

                     if(isset($filters['user_name'])) {
                         $text .= ' user ' . $filters['user_name'] . ', ';
                     }

                     if(isset($filters['project_name'])) {
                         $text .=  ' project '. $filters['project_name'] . ', ';
                     }
                     if(isset($filters['keyword'])) {
                         $text .= ' keyword '. $filters['keyword'] . '.';
                     }

                     $text = trim($text);
                     if(substr($text, -1) == ',') {
                         $text[strlen($text)-1] = '.';
                     }
                     echo $text;
                 }
            ?>

    </tr>
    <tr>
        <th colspan="1" width="100" height="12" valign="top" style="padding: 4px 5px 13px 5px; margin: 0;
        font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center; border: 1px solid darkgray;">
            <strong>Developer</strong>
        </th>
        <th colspan="1" width="100" height="12" valign="top" style="padding: 4px 5px 13px 5px; margin: 0;
        font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center; border: 1px solid darkgray;">
            <strong>Project</strong>
        </th>
        <th colspan="1" width="80" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
        font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <strong>Date</strong>
        </th>
        <th colspan="1" width="200" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
        font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <strong>Task Description</strong>
        </th>
        <th colspan="1" width="40" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
         font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <strong>Time, hours</strong>
        </th>
    </tr>
<?php foreach( $reportData as $report ):?>
    <tr>
        <td colspan="1" width="100" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
             font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <?= Html::encode($report['developer'])?>
        </td>
        <td colspan="1" width="100" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
             font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <?= $report['project']?>
        </td>
        <td colspan="1" width="80" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
             font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <?= Html::encode(DateUtil::reConvertData($report['date']))?>
        </td>
        <td colspan="1" width="200" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
             font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <?= Html::encode($report['task'])?>
        </td>
        <td colspan="1" width="40" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
             font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <?= Html::encode($report['hours'])?>
        </td>
    </tr>
    <?php endforeach;?>
    <tr>
        <td colspan="6" width="570" height="12" valign="top" style="padding: 4px 0 4px 0; margin: 0;
        font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: center;">
            <strong>Report is generated from
                <span><?=DateUtil::reConvertData($filters['date_start'])?>
                <?php if(isset($filters['date_end'])) {?>
                        </span> to <span><?= DateUtil::reConvertData($filters['date_end'])?></span>
                <?php } ?></strong>

        </td>
    </tr>
    <tr>
        <td colspan="6" width="570" height="12" valign="top" style="padding: 4px 0 4px 0; margin: 0;
        font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: center;">
            <strong>Total hours:
                <span><?= $totalHours ?></span></strong>
        </td>
    </tr>
</table>
</body>
</html>

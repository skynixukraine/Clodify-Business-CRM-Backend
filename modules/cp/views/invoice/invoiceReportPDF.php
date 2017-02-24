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
    <title>&#9993;Skynix email template</title>
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
         font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <h1><strong>Reports according to Invoice #</strong><span><?= $id?></span></h1>
         This document contains a list of reports according to all jobs done for you that were included into the invoice #<span><?= $id?></span>
        </td>
    </tr>
    <tr>
        <th colspan="1" width="50" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
         font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <strong>#</strong>
        </th>
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

    <?php foreach ($r as $a): ?>

        <tr>
            <td colspan="1" width="50" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
             font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
                <?= Html::encode($a->id)?>
            </td>
            <?php
            /** @var  $rr Report*/
                $rr = Report::findOne(['id' => $a->id]);
            ?>
            <td colspan="1" width="100" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
             font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
                <?= Html::encode($rr->reporter_name)?>
            </td>
            <td colspan="1" width="100" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
             font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
                <?= Html::encode($rr->getProject()->one()->name)?>
            </td>

            <td colspan="1" width="80" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
             font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
                <?= Html::encode(DateUtil::reConvertData($a->date_report))?>
            </td>
            <td colspan="1" width="200" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
             font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
                <?= Html::encode($a->task)?>
            </td>
            <td colspan="1" width="40" height="12" valign="top" style="border: 1px solid darkgray; padding: 4px 5px 13px 5px; margin: 0;
             font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
                <?= Html::encode($a->hours)?>
            </td>
        </tr>

    <?php endforeach;?>
    <tr>
        <td colspan="6" width="570" height="12" valign="top" style="padding: 4px 0 4px 0; margin: 0;
        font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: center;">
            <strong>Report is generated from
            <span><?=DateUtil::reConvertData($model->date_start)?></span> to <span><?= DateUtil::reConvertData($model->date_end)?></span></strong>

        </td>
    </tr>
    <tr>
        <td colspan="6" width="570" height="12" valign="top" style="padding: 4px 0 4px 0; margin: 0;
        font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: center;">
            <strong>Total hours:
            <span><?=Yii::$app->Helper->timeLength( $model->total_hours * 3600);?></span></strong>
        </td>
    </tr>

</table >

</body>
</html>

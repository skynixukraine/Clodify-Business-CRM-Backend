<?php
use app\models\Invoice;
use yii\helpers\Html;
use app\models\Report;


$model = Invoice::find()
    ->where("id=:iD",
        [
            ':iD' => $id,
        ])
    ->one();

$r = Invoice::report($model->user_id, $model->date_start, $model->date_end);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>&#9993;Reports according to Invoice</title>
    <style>
        a,
        a:hover,
        a:active,
        a:focus{
            outline: 0;
        }
        body{
            font-size: 50px;
            font-family: "Verdana", "sans-serif";
        }

    </style>
</head>
<body style="background-color: #ffffff;">

<table border="0" cellpadding="0" cellspacing="0" width="570" style="border-collapse: collapse; mso-table-lspace: 0pt;
mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;">
    <tr>
        <td colspan = "8" width = "570"  valign="top" style="padding: 0; margin: 0;">
            <a href="http://skynix.solutions/" title="logo Skynix" target="_blank">
                <img src="http://cdn.skynix.co/skynix/logo_skynix.jpg" alt="Skynix" border="0" width="105" height="30"
                     style="display: block; padding: 0px; margin: 0px; border: none;">
            </a>
        </td>
    </tr>

    <tr>
        <td colspan = "8"  height="27" width = "570" style="padding: 0; margin: 0;"></td>
    </tr>

    <tr>
        <td colspan = "8" width = "570" height="23" valign="top" style="padding: 0 0 23px 0; margin: 0; font-size: 23px;
         font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
         This document contains a list of reports according to all jobs done for you that were included into the invoice
            <span><?= $id?></span>
        </td>
    </tr>

<thead>
    <tr>
        <td colspan = "2" width = "570" height="12" valign="top" style="padding: 4px 0 13px 0; margin: 0;
         font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <strong>Number</strong>
        </td>
        <td colspan = "2" width = "570" height="12" valign="top" style="padding: 4px 0 13px 0; margin: 0;
        font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <strong>Developer Name</strong>
        </td>
        <td colspan = "2" width = "570" height="12" valign="top" style="padding: 4px 0 13px 0; margin: 0;
        font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <strong>Project Name</strong>
        </td>
        <td colspan = "2" width = "570" height="12" valign="top" style="padding: 4px 0 13px 0; margin: 0;
        font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <strong>Reported Date</strong>
        </td>
        <td colspan = "2" width = "570" height="12" valign="top" style="padding: 4px 0 13px 0; margin: 0;
        font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <strong>Task Description</strong>
        </td>
        <td colspan = "2" width = "570" height="12" valign="top" style="padding: 4px 0 13px 0; margin: 0;
         font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <strong>Time, hours</strong>
        </td>
    </tr>
</thead>
    <tbody>
    <?php foreach ($r as $a): ?>
    <tr>
        <td colspan="2" width = "570" height="12" valign="top" style="padding: 4px 0 13px 0; margin: 0;
         font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <?= Html::encode($a->id)?>
        </td>
        <?php
        /** @var  $rr Report*/
            $rr = Report::findOne(['id' => $a->id]);
        ?>
        <td colspan="2" width = "570" height="12" valign="top" style="padding: 4px 0 13px 0; margin: 0;
         font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <?= Html::encode($rr->reporter_name)?>
        </td>
        <td colspan="2" width = "570" height="12" valign="top" style="padding: 4px 0 13px 0; margin: 0;
         font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <?= Html::encode($rr->getProject()->one()->name)?>
        </td>

        <td colspan="2" width = "570" height="12" valign="top" style="padding: 4px 0 13px 0; margin: 0;
         font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <?= Html::encode($a->date_report)?>
        </td>
        <td colspan="2" width = "570" height="12" valign="top" style="padding: 4px 0 13px 0; margin: 0;
         font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <?= Html::encode($a->task)?>
        </td>
        <td colspan="2" width = "570" height="12" valign="top" style="padding: 4px 0 13px 0; margin: 0;
         font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <?= Html::encode($a->hours)?>
        </td>
    </tr>

    <?php endforeach;?>
    </tbody>

    <tr>
        <td colspan = "12" width = "570" height="12" valign="top" style="padding: 4px 0 4px 0; margin: 0;
         font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: center;">
            Below the table should be the following information:
        </td>
    </tr>
    <tr>
        <td colspan = "12" width = "570" height="12" valign="top" style="padding: 4px 0 4px 0; margin: 0;
        font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: center;">
            <strong>Report is generated from :</strong>
            <span><?= $model->date_start?></span> to <span><?= $model->date_end?></span>.
        </td>
    </tr>
    <tr>
        <td colspan = "12" width = "570" height="12" valign="top" style="padding: 4px 0 4px 0; margin: 0;
        font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: center;">
            <strong>Total hours :</strong>
            <span><?= $model->total_hours?></span>.
        </td>
    </tr>



</table >

</body>
</html>

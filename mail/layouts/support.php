<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>

        a{
            text-decoration: none;
        }
        a,
        a:hover,
        a:active,
        a:focus,
        a[href]{
            outline: 0;
            text-decoration: none;
            color: #000000;

        }
        td strong > a{
            color: black !important;
        }

    </style>
</head>
<body style="background-color: #ffffff;">
<?php $this->beginBody() ?>
<table border="0" cellpadding="0" cellspacing="0" width="570" style="border-collapse: collapse; mso-table-lspace: 0pt;
 mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;">
    <tr>
        <td width = "29" height="19" style="padding: 0; margin: 0;"></td>
        <td width = "208" height="19" style="padding: 0; margin: 0;"></td>
        <td width = "96" height="19" style="padding: 0; margin: 0;"></td>
        <td width = "208" height="19" style="padding: 0; margin: 0;"></td>
        <td width = "29" height="19" style="padding: 0; margin: 0;"></td>
    </tr>

    <?= $content ?>

    <tr>
        <td width = "29" style="padding: 0; margin: 0;"></td>
        <td colspan = "3"  height="13" style="padding: 15px 0 43px 0; margin: 0;
         font-family: 'HelveticaNeue UltraLight', sans-serif; font-size: 15px; font-weight: 100; text-align: center;">
            Kind Regards, Skynix Support
        </td>
        <td width = "29" style="padding: 0; margin: 0;"></td>
    </tr>
</table>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>



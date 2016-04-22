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


    </style>
    <!--style="border: solid 1px red"-->
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

   <!-- <tr>
        <td colspan = "5"  height="35" style="padding: 8px 0 5px 0; margin: 0; background-color: #a3d8f0;
        font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px; text-align: center; color: #fffefe;">
            THANK YOU FOR YOUR COLLABORATION WE APPRECIATE YOUR BUSINESS </td>
    </tr>
    <tr>
        <td colspan = "2" width = "237" height="34" style="padding: 0; margin: 0; background-color: #a3d8f0;"></td>

        <td width = "96"  valign="top" style="padding:0; margin: 0; text-align: center; background-color: #a3d8f0;
        vertical-align: middle;">
            <a href="#" title="CLICK HERE" target="_blank" style="text-align: center; text-decoration: none;">
                <img src="http://cdn.skynix.co/skynix/btn-click.png" width="95" height = "34"  border="0"
                     alt = "CLICK HERE" style="display: block; padding: 0px; margin: 0px; border: none;"/>
            </a>
        </td>

        <td colspan = "2" width = "237" height="34" style="padding: 0; margin: 0; background-color: #a3d8f0;"></td>
    </tr>

    <tr>
        <td colspan = "5"  height="13" style="padding: 0; margin: 0; background-color: #a3d8f0;"></td>
    </tr>-->
    <tr>
        <td width = "29" style="padding: 0; margin: 0;"></td>
        <td colspan = "3"  height="13" style="padding: 15px 0 43px 0; margin: 0;
         font-family: 'HelveticaNeue UltraLight', sans-serif; font-size: 15px; font-weight: 100; text-align: center;">
            Kind Regards, Skynix
        </td>
        <td width = "29" style="padding: 0; margin: 0;"></td>
    </tr>
</table>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>



<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?/*= Yii::$app->charset */?>" />
    <title><?/*= Html::encode($this->title) */?></title>
    <?php /*$this->head() */?>
</head>
<body>
    <?php /*$this->beginBody() */?>
    <?/*= $content */?>

    <div>
        Kind Regards<br>
        Skynix
    </div>
    <?php /*$this->endBody() */?>
</body>
</html>-->
<?php /*$this->endPage() */?>


<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\User;
/**
 * Created by Skynix Team.
 * Date: 06.12.16
 * Time: 15:27
 */
/** @var  $model User */
?>

<tr>
    <td width = "29" style="padding: 0; margin: 0;"></td>
    <td colspan = "3"  height="36" style="padding: 0; margin: 0;">
        <table border="0" cellpadding="0" cellspacing="0" width="512" style="border-collapse: collapse;
     mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;">
            <tr>
                <td colspan = "2" width = "125" height="12" valign="top" style="padding: 0; margin: 0;"></td>
                <td rowspan = "2" width = "262" height="25" style="padding: 0; margin: 0;
             font-family: 'HelveticaNeue UltraLight', sans-serif; font-size: 24px; text-align: center;
              vertical-align: middle;"> Hello, <span><?= $user?>,</span> </td>
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
    <td colspan = "3"  height="16" style="padding: 19px 0 10px 0; margin: 0; font-family: 'HelveticaNeue Regular',
    sans-serif; font-size: 16px; font-weight: normal; text-align: center;">
        <strong style=" font-family: 'HelveticaNeue Bold', sans-serif; font-size: 16px; font-weight: bold;"><h2>Welcome to Skynix company!</h2></strong></td>
    <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
    <td width = "29" style="padding: 0; margin: 0;"></td>
    <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center; color: black !important;">Your email was changed. Your email and new login is <strong><?= $email?></strong></td>
    <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
    <td width = "29" style="padding: 0; margin: 0;"></td>
    <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;">Your email was changed by <?= $adminName ?></td>
    <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
    <td colspan = "5"  height="13" style="padding: 0; margin: 0; background-color: #a3d8f0;"></td>
</tr>

<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 02.06.16
 * Time: 19:24
 */
use yii\helpers\Url;
?>
<?php if($active == 0):?>

    <tr>
        <td width = "29" style="padding: 0; margin: 0;"></td>
        <td colspan = "3"  height="36" style="padding: 0; margin: 0;">
            <table border="0" cellpadding="0" cellspacing="0" width="512" style="border-collapse: collapse;
     mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;">
                <tr>
                    <td colspan = "2" width = "125" height="12" valign="top" style="padding: 0; margin: 0;"></td>
                    <td rowspan = "2" width = "262" height="25" style="padding: 0; margin: 0;
             font-family: 'HelveticaNeue UltraLight', sans-serif; font-size: 24px; text-align: center;
              vertical-align: middle;"> Dear <span><?=$username?>,</span> </td>
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
     font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;">Your request #<b><?=$id?></b> with subject <b>"<?=$subject?>"</b> has been received and our specialists are working on the answer to your question.</td>
        <td width = "29" style="padding: 0; margin: 0;"></td>
    </tr>
    <tr>
        <td width = "29" style="padding: 0; margin: 0;"></td>
        <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;">You can check the status or reply to this request online at: <a href="<?=Yii::$app->params['en_site'] . Url::to(['/support/ticket?id=' . $id])?>">
                https://skynix.company/support/ticket?id=<?=$id?>.</a> Mail to: admin@skynix.co.</td>
        <td width = "29" style="padding: 0; margin: 0;"></td>
    </tr>
    <tr>
        <td width = "29" style="padding: 0; margin: 0;"></td>
        <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;">Please, let us know if you will need help again.</td>
        <td width = "29" style="padding: 0; margin: 0;"></td>
    </tr>
    <tr>
        <td colspan = "5"  height="35" style="padding: 8px 0 5px 0; margin: 0; background-color: #a3d8f0;
        font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px; text-align: center; color: #fffefe;">
            THANK YOU FOR YOUR COLLABORATION <br>WE APPRECIATE YOUR BUSINESS </td>


    </tr>

    <tr>
        <td colspan = "5"  height="13" style="padding: 0; margin: 0; background-color: #a3d8f0;"></td>
    </tr>



<?php else: ?>
    <h1>Your Skynix ticket #<a href="<?=Yii::$app->params['en_site'] . Url::toRoute(['support/login', 'email' => $email, 'id' => $id])?>"><?= $id ?></a></h1>
<?php endif;?>

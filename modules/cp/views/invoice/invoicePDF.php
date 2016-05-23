<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>&#9993;Skynix Invoice</title>
    <style>
        a,
        a:hover,
        a:active,
        a:focus{
            outline: 0;
        }

    </style>
    <!--style="border: solid 1px red"-->
</head>
<body style="background-color: #ffffff;">

<table border="0" cellpadding="0" cellspacing="0" width="570" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;">
    <tr>
        <td width = "33" height="17" style="padding: 0; margin: 0;"></td>
        <td width = "32" height="17" style="padding: 0; margin: 0;"></td>
        <td width = "83" height="17" style="padding: 0; margin: 0;"></td>
        <td width = "203" height="17" style="padding: 0; margin: 0;"></td>
        <td width = "33" height="17" style="padding: 0; margin: 0;"></td>
        <td width = "24" height="17" style="padding: 0; margin: 0;"></td>
        <td width = "110" height="17" style="padding: 0; margin: 0;"></td>
        <td width = "52" height="17" style="padding: 0; margin: 0;"></td>
    </tr>

    <tr>
        <td colspan = "8" width = "570"  valign="top" style="padding: 0; margin: 0;">
            <a href="http://skynix.solutions/" title="logo Skynix" target="_blank">
                <img src="http://cdn.skynix.co/skynix/logo_skynix.jpg" alt="Skynix" border="0" width="105" height="30" style="display: block; padding: 0px; margin: 0px; border: none;">
            </a>
        </td>
    </tr>

    <tr>
        <td colspan = "8"  height="27" width = "570" style="padding: 0; margin: 0;"></td>
    </tr>

    <tr>
        <td colspan = "8" width = "570" height="23" valign="top" style="padding: 0 0 23px 0; margin: 0; font-size: 23px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            The invoice # <span><?= $id?></span>
        </td>
    </tr>

    <tr>
        <td colspan = "8" width = "570" height="12" valign="top" style="padding: 4px 0 4px 0; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: center;">
            for paying completed work according to the contract #<span><?= $numberContract?></span>
        </td>
    </tr>

    <tr>
        <td colspan = "8" width = "570" height="12" valign="top" style="padding: 4px 0 4px 0; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: center;">
            from <span><?= $dataFromUkr?></span> and act of work #<span><?= $actWork?></span> of <span><?= $dataToUkr?></span>.
        </td>
    </tr>

    <tr>
        <td colspan = "8" width = "570" height="12" valign="top" style="padding: 4px 0 4px 0; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: center;">
            <?=nl2br($notes)?>
        </td>
    </tr>
   <tr>
        <td colspan = "8" width = "570" height="12" valign="top" style="padding: 4px 0 4px 0; margin: 0; font-size: 10px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: center;">
           <span> (The invoice has to be paid in 3 working days)</span>
        </td>
    </tr>



    <tr>
        <td colspan = "8" width = "570" height="12" valign="top" style="padding: 4px 0 13px 0; margin: 0; font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            Requisites/Реквізити
        </td>
    </tr>

    <?= $paymentMethod?>

    <tr>
        <td colspan = "8" width = "570" height="12" valign="top" style="padding: 35px 0 20px 0; margin: 0; font-size: 14px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: center;">
            Total (до сплати) <strong>$<?= $total?></strong> ​USD
        </td>
    </tr>

    <tr>
        <td colspan = "2" width = "65" height="12" valign="top" style="padding: 0 0 20px 0; margin: 0; font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif;font-weight: 600; text-align: left;">
            Contractor
        </td>
        <td colspan = "2" width = "286" height="12" valign="top" style="padding: 0 0 20px 5px; margin: 0; font-size: 14px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left;">
            Prozhoga O.Y.
        </td>
        <td colspan = "2" width = "57" height="12" valign="top" style="padding: 0 0 20px 0; margin: 0; font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif;font-weight: 600; text-align: left;">
            Customer
        </td>
        <td colspan = "2" width = "162" height="12" valign="top" style="padding: 0 0 20px 5px; margin: 0; font-size: 14px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left;">
            <?= $nameCustomer?>
        </td>
    </tr>

    <tr>
        <td colspan = "3" width = "148" valign="middle" align="right" style="padding: 0; margin: 0; vertical-align: middle;">
            <img src="../data/signatures1.gif" alt="signatures contractor" border="0" width="77" height="62" style="padding: 0px; margin: 0px; border: none; display: block;">
        </td>
        <td width = "203" height="75" style="padding: 0; margin: 0;"></td>
        <td colspan = "3" width = "167" valign="middle" align="right" style="padding: 0; margin: 0;">
            <?php if(file_exists ( "../data/signatureCustomerId" . $idCustomer . ".gif")):?>
            <img src="../data/signatureCustomerId<?= $idCustomer?>.gif" alt="signatures customer" border="0" width="96" height="46" style="padding: 0px; margin: 0px; border: none; display: block;">
            <?php endif;?>
        </td>
        <td width = "52" style="padding: 0; margin: 0;">
        </td>
    </tr>

    <tr>
        <td width = "33" height="12" valign="top" style="padding: 0; margin: 0; font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif;font-weight: 600; text-align: center;">
            Sign
        </td>
        <td colspan = "2" width = "115" height="12" valign="top" style="padding: 0; margin: 0; border-bottom: solid 2px #343434;"></td>
        <td width = "203" height="12" valign="top" style="padding: 0; margin: 0;"></td>
        <td width = "33" height="12" valign="top" style="padding: 0; margin: 0; font-size: 13px; font-family: 'HelveticaNeue UltraLight', sans-serif;font-weight: 600; text-align: center;">
            Sign
        </td>
        <td colspan = "2" width = "134" height="12" valign="top" style="padding: 0; margin: 0;  border-bottom: solid 2px #343434;"></td>
        <td width = "52" height="12" valign="top" style="padding: 0; margin: 0;"></td>
    </tr>


</table >

</body>
</html>

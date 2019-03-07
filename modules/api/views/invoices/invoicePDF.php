<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>&#9993;Skynix Invoice #<?=$id?></title>
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
        <td colspan = "2"  height="17" width = "570" style="padding: 0; margin: 0; font-size: 10px">
            Page <b>1</b>
        </td>
    </tr>
    <tr>
        <td width = "285" height="17" style="padding: 0; margin: 0;"></td>
        <td width = "285" height="17" style="padding: 0; margin: 0;"></td>
    </tr>

    <tr>
        <td colspan = "2" width = "570"  valign="top" style="padding: 0; margin: 0;">
            <a href="https://skynix.co" title="logo Skynix" target="_blank">
                <img src="<?=Yii::getAlias('@app') . '/web/img/logo_skynix_color_horizontal.png'?>" alt="Skynix" border="0" width="105" height="28" style="display: block; padding: 0px; margin: 0px; border: none; background-color: white;">
            </a>
        </td>
    </tr>

    <tr>
        <td colspan = "2"  height="30" width = "570" style="padding: 0; margin: 0;"></td>
    </tr>

    <tr>
        <td colspan = "2" width = "570" height="23" valign="top" style="padding: 0 0 23px 0; margin: 0; font-size: 23px; font-family: 'HelveticaNeue UltraLight', sans-serif; font-weight: 600; text-align: center;">
            <span style="font-weight: 600;">Invoice (offer) / Інвойс (оферта) # </span><?=$id?>
        </td>
    </tr>

    <tr>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Date: </span><?=$dateInvoiced?>
        </td>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Дата: </span><?=$dateInvoiced?>
        </td>
    </tr>
    <tr>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Supplier: </span><?=$supplierName?> <?=$supplierAddress?> Represented by the Director, <?=$supplierDirector?>, who acts according to articles of organization
        </td>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Виконавець: </span><?=$supplierNameUa?> <?=$supplierAddressUa?> У особі директора <?=$supplierDirectorUa?>, діючої на підставі Статуту
        </td>
    </tr>
    <tr>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Customer: </span><?=$customerCompany?>, <?=$customerAddress?> Represented by the Director, <?=$customerName?>
        </td>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Замовник: </span><?=$customerCompany?>, <?=$customerAddress?> Represented by the Director, <?=$customerName?>
        </td>
    </tr>
    <tr>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Subject matter: </span>Software Development
        </td>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Предмет: </span>Розробка програмного забезпечення
        </td>
    </tr>
    <tr>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Currency: </span><?=$currency?>
        </td>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Валюта: </span><?=$currency?>
        </td>
    </tr>
    <tr>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Price (amount) of the goods/services: </span><?=$priceTotal?> <?=$currency?>
        </td>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Ціна (загальна вартість) товарів/послуг: </span><?=$priceTotal?> <?=$currency?>
        </td>
    </tr>
    <tr>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Terms of payments and acceptation: </span>Postpayment of 100% upon the services delivery. The services being rendered at the location of the Supplier.
        </td>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb;">
            <span style="font-weight: 900;">Умови оплати та передачі: </span>100% післяплата за фактом виконання послуг. Послуги надаються за місцем реєстрації Виконавця.
        </td>
    </tr>
    <tr>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-bottom: none;">
            <span style="font-weight: 900;">SupplierBank information: </span>
        </td>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-bottom: none;">
            <span style="font-weight: 900;">Реквізити Виконавця: </span>
        </td>
    </tr>
    <tr>
        <td width = "285" valign="top" align="left" style="padding: 0; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-top: none;">
            <?=$supplierBank?>
        </td>
        <td width = "285" valign="top" align="left" style="padding: 0; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-top: none;">
            <?=$supplierBankUa?>
        </td>
    </tr>
    <tr>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-bottom: none;">
            <span style="font-weight: 900;">Customer Bank Information: </span>
        </td>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-bottom: none;">
            <span style="font-weight: 900;">Реквізити Замовника: </span>
        </td>
    </tr>
    <tr>
        <td width = "285" valign="top" align="left" style="padding: 0; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-top: none;">
            <?=$customerBank?>
        </td>
        <td width = "285" valign="top" align="left" style="padding: 0; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left; border: 1px solid #dbdbdb; border-top: none;">
            <?=$customerBankUa?>
        </td>
    </tr>
    <tr>
        <td colspan = "2"  height="17" width = "570" style="padding: 0; margin: 0;">

        </td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="570" style="font-size: 12px; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;">

    <tr>
        <td colspan = "2" width = "570" style="padding: 0; margin: 0;">
            <table border="0" cellpadding="0" cellspacing="0" width="570" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;">
                <tr>
                    <td colspan = "2"  height="17" width = "570" style="padding: 0; margin: 0; text-align: left; padding-bottom: 20px; font-size: 10px;">
                        Page <b>2</b>
                    </td>
                </tr>
                <tr>
                    <td width = "48" height="100" valign="top" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;">№</td>
                    <td width = "244" height="100" valign="top" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;"><div>Descripion /</div><div>Опис</div></td>
                    <td width = "72" height="100" valign="top" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;"><div>Quantity /</div><div>Кількість</div></td>
                    <td width = "105" height="100" valign="top" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;"><div>Price,<?=$currency?> /</div><div>Ціна, <?=$currency?></div></td>
                    <td width = "101" height="100" valign="top" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb; font-style: italic;"><div>Amount, <?=$currency?> /</div><div>Загальна</div><div>вартість,</div><div><?=$currency?></div></td>
                </tr>
                <tr>
                    <td height="17" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;">1</td>
                    <td height="17" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;">
                        Software Development from <?=$dataFrom?> to <?=$dataTo?><br>
                        /Розробка програмного забезпечення
                        від <?=$dataFromUkr?> до <?=$dataToUkr?>
                    </td>
                    <td height="17" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;">1</td>
                    <td height="17" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;"><?=$priceTotal?> <?=$currency?></td>
                    <td height="17" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;"><?=$priceTotal?> <?=$currency?></td>
                </tr>
                <tr>
                    <td height="17" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;"></td>
                    <td height="17" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;"></td>
                    <td height="17" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;"></td>
                    <td height="17" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;"><span style="font-weight: 900;">Total/Усього: </span></td>
                    <td height="17" style="padding: 4px 5px; margin: 0; border: 1px solid #dbdbdb;"><span style="font-weight: 900;"><?=$priceTotal?></span> <?=$currency?></td>
                </tr>
            </table >
        </td>
    </tr>
    <tr>
        <td colspan = "2"  height="17" width = "570" style="padding: 0; margin: 0; text-align: left">

        </td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="570" style="font-size: 12px; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;">
    <tr>
        <td width = "285" height="1" style="padding: 0; margin: 0;"></td>
        <td width = "285" height="1" style="padding: 0; margin: 0;"></td>
    </tr>
    <tr>
        <td colspan="2" width = "570"  valign="top" style="padding: 10px; margin: 0;">
            <a href="https://skynix.co" title="logo Skynix" target="_blank">
                <img src="<?=Yii::getAlias('@app') . '/web/img/logo_skynix_color_horizontal.png'?>" alt="Skynix" border="0" width="105" height="28" style="display: block; padding: 0px; margin: 0px; border: none; background-color: white;">
            </a>
        </td>
    </tr>
    <?php if ($notes) : ?>
        <tr>
            <td colspan = "2" width = "570" style="padding: 10px; margin: 0; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e; text-align: left; padding-bottom: 20px; font-size: 10px;">
                <?=$notes?>
            </td>
        </tr>
    <?php endif;?>
    <tr>
        <td colspan = "2" width = "570" style="padding: 0; margin: 0;">
            All charges of correspondent banks are at the Customer’s expenses. / Усі комісії банків-кореспондентів сплачує Замовник.
        </td>
    </tr>

    <tr>
        <td colspan = "2" width = "570" style="padding: 0; margin: 0;">
            This Invoice is an offer to enter into the agreement. Payment according hereto shall be deemed as an acceptation of the offer to enter into the agreement on the terms and conditions set out herein.
            Payment according hereto may be made not later than <span style="font-weight: 900;"><?=$dateToPay?></span>. / Цей Інвойс є пропозицією укласти договір.
            Оплата за цим Інвойсом є прийняттям пропозиції укласти договір на умовах, викладених в цьому Інвойсі. Оплата за цим інвойсом може бути здійснена не пізніше <span style="font-weight: 900;"><?=$dateToPay?></span>.
        </td>
    </tr>
    <tr>
        <td colspan = "2" height="17" width = "570" style="padding: 0; margin: 0;">
        </td>
    </tr>
    <tr>
        <td colspan = "2" width = "570" style="padding: 0; margin: 0;">
            Please note, that payment according hereto at the same time is the evidence of the work performance and the service delivery in full scope, acceptation thereof and the confirmation of final mutual installments between
            Parties. / Оплата згідно цього Інвойсу одночасно є свідченням виконання робіт та надання послуг в повному обсязі, їх прийняття, а також підтвердженням кінцевих розрахунків між Сторонами.
        </td>
    </tr>
    <tr>
        <td colspan = "2" height="17" width = "570" style="padding: 0; margin: 0;">
        </td>
    </tr>
    <tr>
        <td colspan = "2" width = "570" style="padding: 0; margin: 0;">
            Payment according hereto shall be also the confirmation that Parties have no claims to each other and have no intention to submit any claims. The agreement shall not include penalty and fine clauses. / Оплата згідно цього Інвойсу є підтвердженням того, що Сторони не мають взаємних претензій та не мають наміру направляти рекламації. Договір не передбачає штрафних санкцій.
        </td>
    </tr>
    <tr>
        <td colspan = "2" height="17" width = "570" style="padding: 0; margin: 0;">
        </td>
    </tr>
    <tr>
        <td colspan = "2" width = "570" style="padding: 0; margin: 0;">
            The Parties shall not be liable for non-performance or improper performance of the obligations under the agreement during the term of insuperable force circumstances. / Сторони звільняються від відповідальності за невиконання чи неналежне виконаннязобов’язань за договором на час дії форс-мажорних обставин.
        </td>
    </tr>
    <tr>
        <td colspan = "2" height="17" width = "570" style="padding: 0; margin: 0;">
        </td>
    </tr>
    <tr>
        <td colspan = "2" width = "570" style="padding: 0; margin: 0;">
            Any disputes arising out of the agreement between the Parties shall be settled by the competent court at the location of a defendant. / Всі спори, що виникнуть між Сторонами по договору будуть розглядатись компетентним судом за місцезнаходження відповідача.
        </td>
    </tr>
    <tr>
        <td colspan = "2" height="30" width = "570" style="padding: 0; margin: 0;">
        </td>
    </tr>
    <tr>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left;">
            <span style="font-weight: 900;">Supplier/Виконавець: </span>
        </td>
        <td width = "285" height="12" valign="top" style="padding: 4px 5px; margin: 0; font-size: 12px; font-family: 'HelveticaNeue Regular', sans-serif; font-weight: normal; text-align: left;">
            <span style="font-weight: 900;">Customer/Замовник: </span>
        </td>
    </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="570" style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto; background-color: #ffffff; color: #1e1e1e;">

    <tr>
        <td width="200" height="17" style="padding: 0; margin: 0;"></td>
        <td width="100" height="17" style="padding: 0; margin: 0;"></td>
        <td width="200" height="17" style="padding: 0; margin: 0;"></td>
        <td width="70" height="17" style="padding: 0; margin: 0;"></td>
    </tr>
    <tr>
        <td width = "200" valign="middle" align="right" style="padding: 0; margin: 0; vertical-align: middle;">
            <?php if(!empty($signatureContractor)): ?>
            <img src="<?=$signatureContractor?>" alt="signatures contractor" border="0"  style="padding: 0px; margin: 0px; border: none; display: block; max-width: 120px; ">
            <?endif; ?>
        </td>
        <td width="100" height="75" style="padding: 0; margin: 0;"></td>
        <td width="200" valign="middle" align="right" style="padding: 0; margin: 0;">
            <?php if(!empty($signatureCustomer)): ?>
            <img src="<?=$signatureCustomer?>" alt="signatures customer" border="0" style="padding: 0px; margin: 0px; border: none; display: block; max-width: 120px; ">
            <?endif; ?>
        </td>
        <td width = "70" style="padding: 0; margin: 0;">
        </td>
    </tr>
    <tr>
        <td width="200" height="12" valign="top" style="padding: 0; margin: 0; border-bottom: solid 2px #343434;"></td>
        <td width="100" height="12" valign="top" style="padding: 0; margin: 0;"></td>
        <td width="200" height="12" valign="top" style="padding: 0; margin: 0; border-bottom: solid 2px #343434;"></td>
        <td width="70" height="12" valign="top" style="padding: 0; margin: 0;"></td>
    </tr>
    <tr>
        <td width="200" height="12" valign="top" style="padding: 0; margin: 0;"><div><?=$supplierDirector?></div><div>Director of <?=$supplierName?></div></td>
        <td width="100" height="12" valign="top" style="padding: 0; margin: 0;"></td>
        <td width="200" height="12" valign="top" style="padding: 0; margin: 0;"><div><?=$customerName?></div><div>Director of <?=$customerCompany?></div></td>
        <td width="70" height="12" valign="top" style="padding: 0; margin: 0;"></td>
    </tr>
</table >


</body>
</html>

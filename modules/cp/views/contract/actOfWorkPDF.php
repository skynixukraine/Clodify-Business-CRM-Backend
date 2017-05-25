<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<!-- style="margin: 0;font-family:\'Times New Roman\';font-size:10px;" colspan = "3"-->
<body>
<table width="570"
       style="max-width: 570px; margin-left: auto; margin-right: auto; border-collapse: collapse;">

    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="left" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            <p>Виконавець (Contractor)</p>
            <!--ФОП Прожога О.Ю. (FLP Prozhoga O.Y.) -->
            <p><strong><?= $contractor->company ?></strong></p>
        </td>
        <td align="right" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            <p>Замовник (Customer)</p>
            <!--Colourways Limited -->
            <p><strong><?= $customer->company ?> </strong></p>
        </td>
    </tr>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="right" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            <br><br><span style="color: #ffffff;">.</span>
        </td>
    </tr>
</table>
<table width="570" style="max-width: 570px; margin-left: auto; margin-right: auto; border-collapse: collapse;">

    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            <strong>Акт (Act) № <?= $contract->act_number ?> </strong>
        </td>
    </tr>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            <strong>прийому-передачі виконаних робіт</strong>
        </td>
    </tr>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            <strong>(of accepting completed work)</strong>
        </td>
    </tr>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            <!-- contract _act date -->
            <strong><?= date_format(date_create($contract->act_date), 'd/m/Y' )?> р.</strong>
        </td>
    </tr>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            <br> <span style="color: #ffffff;">.</span>
        </td>
    </tr>

    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            Ми, хто нижче підписалися, представник Виконавця і представник Замовника,
            уклали акт про те, що Виконавець виконав роботи відповідно до договору № <?=$contract->contract_id?> від  <?=$contract->start_date?>,
            рахунок № <?= $invoice->id ?> від <?=$invoice->date_end ?> р.
            <br><span style="color: #ffffff;">.</span>
        </td>
    </tr>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            We who signed this act agree that Contractor has completed the work according
            to the contract № <?=$contract->contract_id?> from <?=$contract->start_date?>, bill  № <?= $invoice->id ?> from <?=$invoice->date_end ?>.
            <br><span style="color: #ffffff;">.</span>
        </td>
    </tr>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            Загальна вартість робіт <strong><?= $invoice->subtotal - $invoice->discount?></strong> USD (Total cost of the work <strong><?= $invoice->subtotal - $invoice->discount?></strong> USD)
            <br><span style="color: #ffffff;">.</span>
        </td>
    </tr>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            Роботи виконані повністю, сторони один до одного претензій не мають.
            <br><span style="color: #ffffff;">.</span>
        </td>
    </tr>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="justify" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            The work has been fully completed, the parties does not have any claims to each other.
            <br><br><br><span style="color: #ffffff;">.</span>
        </td>
    </tr>
</table>

<table width="570"
       style="max-width: 570px; margin-left: auto; margin-right: auto; border-collapse: collapse;">

    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td width="285" style ="width: 285px; vertical-align: top; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px; font-family:\'Times New Roman\';font-size:10px;">
            <p>Роботу здав (Work is done) </p>
            <!-- Прожога О.Ю. ( Prozhoga O.Y.) -->
            <p><strong><?= $contractor->company ?></strong></p>
            <p>від Виконавця (by Contractor) </p>

        </td>
        <td width="285" style ="width: 285px; vertical-align: top; border-collapse: collapse; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px; font-family:\'Times New Roman\';font-size:10px;">
            <p>Роботу прийняв (Work is accepted) </p>
            <p><strong><?= $customer->company ?></strong></p>
            <p>від Замовника (by Customer) </p>
        </td>
    </tr>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td width="285" style ="width: 285px; vertical-align: top; border-left: 1px solid black; border-right: 1px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px; font-family:\'Times New Roman\';font-size:10px;">
            <img src="<?=$signatureContractor?>" style="max-width: 120px;">

        </td>
        <td width="285" style ="width: 285px; vertical-align: top; border-collapse: collapse; border-left: 1px solid black; border-right: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px; font-family:\'Times New Roman\';font-size:10px;">
            <img src="<?=$signatureCustomer?>" style="max-width: 120px;">
        </td>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td width="285" style ="width: 285px; vertical-align: top; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px; font-family:\'Times New Roman\';font-size:10px;">
            <p>М.П./Підпис (Sign)</p>
        </td>
        <td width="285" style ="width: 285px; vertical-align: top; border-collapse: collapse; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px; font-family:\'Times New Roman\';font-size:10px;">
            <p>М.П./Підпис (Sign)</p>
        </td>
    </tr>

</table>
</body>
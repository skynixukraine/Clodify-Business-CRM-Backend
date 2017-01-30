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
       style=" margin-left: auto; margin-right: auto; border-collapse: collapse;">

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
<table width="570" style=" margin-left: auto; margin-right: auto; border-collapse: collapse;">

    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            <strong>Акт (Act) № <?= $contract->act_number ?> </strong>
        </td>
    </tr>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            <strong>прийому передачі виконаних робіт</strong>
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
            <strong><?= date_format(date_create($contract->act_date), '"d" m/Y' )?> г</strong>
        </td>
    </tr>
    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td align="center" style="margin: 0;font-family:\'Times New Roman\';font-size:10px;">
            <!-- contract _act date -->
            <strong> <?= date_format(date_create($contract->act_date), 'd F Y' ) ?>

                31 December  2016</strong>
            <br><br><span style="color: #ffffff;">.</span>
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
       style=" margin-left: auto; margin-right: auto; border-collapse: collapse;">

    <tr style = "height: 100%; box-sizing: border-box; border-collapse: collapse; ">
        <td style =" vertical-align: top; border: 1px solid black; height: 100%; box-sizing: border-box; border-collapse: collapse; padding: 5px; font-family:\'Times New Roman\';font-size:10px;">
            <p>Работу сдав (Work is done) </p>
            <!-- Прожога О.Ю. ( Prozhoga O.Y.) -->
            <p><strong><?= $contractor->company ?></strong></p>
            <p>від Виконавця (by Contractor) </p>
            <img src="<?=$contractor->getUserSingPath()?>"width="250px" height="150px">
            <p>М.П./Підпис (Sign)</p>
        </td>
        <td style =" vertical-align: top; border-collapse: collapse; border: 1px solid black; height: 100%; box-sizing: border-box; padding: 5px; font-family:\'Times New Roman\';font-size:10px;">
            <p>Работу прийняв (Work is accepted) </p>
            <p><strong><?= $customer->company ?></strong></p>
            <p>від Замовника (by Customer) </p>
            <img src="<?=$customer->getUserSingPath()?>"width="250px" height="150px">
            <p>М.П./Підпис (Sign)</p>
        </td>
    </tr>

</table>
</body>
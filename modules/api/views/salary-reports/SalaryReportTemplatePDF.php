<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Salary report</title>
</head>
<body style="background-color: #ffffff;">
<style type="text/css">
    h1 {
        text-align: center;
    }
    .tx  {border-collapse:collapse;border-spacing:0;border-color:#ccc;}
    .tx td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
    .tx th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
    .tx .tx-amwm{font-weight:bold;text-align:center;vertical-align:top}
    .tx .tx-yw4l{vertical-align:top}
</style>
<h1><?=$salaryReportDate?> - Salary Report</h1>
<table class="tx" style="undefined;table-layout: fixed; width: 344px">
    <colgroup>
        <col style="width: 191px">
        <col style="width: 153px">
    </colgroup>
    <tr>
        <th class="tx-amwm" colspan="2">Salary Summary</th>
    </tr>
    <tr>
        <td class="tx-yw4l">Total Salaries, USD</td>
        <td class="tx-yw4l"><?= $salaryReportData['subtotal']?></td>
    </tr>
    <tr>
        <td class="tx-yw4l">Currency Rate</td>
        <td class="tx-yw4l"><?=$salaryReportData['currency_rate']?></td>
    </tr>
    <tr>
        <td class="tx-yw4l">Total Salaries, UAH</td>
        <td class="tx-yw4l"><?=$salaryReportData['total_to_pay_uah']?></td>
    </tr>
    <tr>
        <td class="tx-yw4l">To Pay Salaries prepare cash, UAH</td>
        <td class="tx-yw4l"><?= $salaryReportData['total_to_payout_uah']?></td>
    </tr>

    <tr>
        <td class="tx-yw4l">Financial Report Status</td>
        <td class="tx-yw4l"><?=$salaryReportData['financial_report_status']?></td>
    </tr>
    <tr>
        <td class="tx-yw4l">Completion</td>
        <td class="tx-yw4l"><?=$completion?></td>
    </tr>
</table>
<style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;border-width:1px;border-style:solid;}
    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 8px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
    .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 8px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
    .tg .tg-i6eq{background-color:#ffccc9;vertical-align:top}
    .tg .tg-amwm{font-weight:bold;text-align:center;vertical-align:top}
    .tg .tg-yw4l{vertical-align:top}
</style>
<table class="tg" style="undefined;table-layout: fixed; width: 200px">
    <colgroup>
        <col style="width: 344px">
    </colgroup>
    <tr>
        <th class="tg-amwm">Salary Lists</th>
    </tr>
    <?php foreach ($salaryReportListData as $salaryList):?>
        <tr>
            <td class="tg-i6eq"><?=$salaryList['first_name']?> <?=$salaryList['last_name']?></td>
        </tr>
        <?php if ($salaryList['salary']):?>
            <tr>
                <td class="tg-yw4l">Salary: $<?=$salaryList['salary']?></td>
            </tr>
        <?php endif;?>
        <?php if ($salaryList['currency_rate']):?>
        <tr>
            <td class="tg-yw4l">Currency Rate: $<?=$salaryList['currency_rate']?>/UAH</td>
        </tr>
        <?php endif;?>
        <?php if (isset($salaryList['non_approved_hours'])):?>


            <tr>
                <td class="tg-yw4l">Non Approved Hours: <?=$salaryList['non_approved_hours'] . ' '?> h</td>
            </tr>
            <?php if (isset($salaryList['is_approving_hours_enabled']) && $salaryList['is_approving_hours_enabled'] === 1):?>
                <tr>
                    <td class="tg-yw4l">Non approved are not paid.</td>
                </tr>
            <?php else: ?>
                <tr>
                    <td class="tg-yw4l">Non approved are paid this time.</td>
                </tr>
            <?php endif;?>
        <?php endif;?>
        <?php if ($salaryList['bonuses']):?>
            <tr>
                <td class="tg-yw4l">Bonuses: <?=$salaryList['bonuses']?></td>
            </tr>
        <?php endif;?>
        <?php if ($salaryList['day_off']):?>
            <tr>
                <td class="tg-yw4l">Day Off: <?=$salaryList['day_off']?></td>
            </tr>
        <?php endif;?>
        <?php if ($salaryList['overtime_value']):?>
            <tr>
                <td class="tg-yw4l">Overtime: <?= ceil($salaryList['overtime_value']);?></td>
            </tr>
        <?php endif;?>
        <?php if ($salaryList['hospital_value']):?>
            <tr>
                <td class="tg-yw4l">Hospital: <?= ceil($salaryList['hospital_value']);?></td>
            </tr>
        <?php endif;?>
        <?php if ($salaryList['vacation_value'] && $salaryList['vacation_days'] > 0 ):?>
            <tr>
                <td class="tg-yw4l">Vacation Days: <?=$salaryList['vacation_days'];?></td>
            </tr>
            <tr>
                <td class="tg-yw4l">Vacation Compensation: <?=ceil($salaryList['vacation_value']);?></td>
            </tr>
        <?php endif;?>
        <?php if ($salaryList['subtotal']):?>
            <tr>
                <td class="tg-yw4l">Subtotal: $<?= ceil($salaryList['subtotal']);?></td>
            </tr>
        <?php endif;?>
        <?php if ($salaryList['official_salary']):?>
            <tr>
                <td class="tg-yw4l">Official Salary: <?=$salaryList['official_salary']?> UAH</td>
            </tr>
        <?php endif;?>
        <?php if ($salaryList['total_to_pay']):?>
            <tr>
                <td class="tg-yw4l">Total: <?= ceil($salaryList['total_to_pay']);?> UAH</td>
            </tr>
        <?php endif;?>
   <?php endforeach;?>
</table>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 22.02.16
 * Time: 11:18
 */
?>
<h2>This is the information about invoice # <?= $id?></h2>
<ul>
    <li>Invoice #        <?= $id?></li>
    <li>Customer Name:   <?= $nameCustomer?></li>
    <li>Customer Email:  <?= $emailCustomer?></li>
    <li>Start Date:      <?= $date_start?></li>
    <li>End Date:        <?= $date_end?></li>
    <li>Total hours:     <?= $totalHours?></li>
    <li>Sub total:       <?= $subtotal?></li>
    <li>Discount:        <?= $discount?></li>
    <li>Total:           <?= $total?></li>
    <li>Notes:           <?= $note?></li>
    <li>Create date:     <?= $date_created?></li>
    <li>Sent date:       <?= $date_sent?></li>
    <li>Paid date:       <?= $date_paid?></li>
    <li>Status:          <?= $status?></li>
</ul>

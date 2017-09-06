<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 04.09.17
 * Time: 16:02
 */
?>

<div class="jumbotron">
    <h2>Skynix Services Status</h2>
    <?php if ($f) {
        echo '<h1 class="check_active_notice" style="color: #00aa00">Active</h2>';
    } else {
        echo '<h1 style="color: blue">Maintenance</h2>';
    } ?>
</div>
<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/13/18
 * Time: 9:46 AM
 */
?>
<form method="POST" action="https://api.privatbank.ua/p24api/ishop">
    <input type="hidden" name="amt" value="0.5"/>
    <input type="hidden" name="ccy" value="UAH"/>
    <input type="hidden" name="merchant" value="140273"/>
    <input type="hidden" name="order" value="1"/>
    <input type="hidden" name="details" value="Order #1"/>
    <input type="hidden" name="ext_details" value="Services for November 2018"/>
    <input type="hidden" name="return_url" value="https://staging.core.api.skynix.co/core-api/payments/status"/>
    <input type="hidden" name="server_url" value="https://staging.core.api.skynix.co/core-api/payments"/>
    <input type="hidden" name="pay_way" value="privat24"/>
    <button type="submit">Pay Now</button>
</form>

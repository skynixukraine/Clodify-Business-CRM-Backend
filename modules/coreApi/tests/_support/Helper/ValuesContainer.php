<?php
/**
 * Created by Skynix Team
 * Date: 27.04.17
 * Time: 12:02
 */

namespace Helper;

class ValuesContainer
{
    public static $clientId = 1;
    public static $clientNotExistsId = 99999;
    public static $clientOrderId = 1;


    public static $clientData = [
        'name' => 'Skynix LLC',
        'email' => 'admin@skynix.co',
        'first_name' => 'Skynix',
        'last_name' => 'Admin'
    ];

    public static $coreClientOrderData = [
        'payment_id' => 2,
        'recurrent_id' => 3
    ];
}

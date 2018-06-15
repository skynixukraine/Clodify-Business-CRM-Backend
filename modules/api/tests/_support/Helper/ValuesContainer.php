<?php
/**
 * Created by Skynix Team
 * Date: 27.04.17
 * Time: 12:02
 */

namespace Helper;

class ValuesContainer
{
    public static $projectId = 1;

    public static $nonPaidProjectId = 2;

    public static $contractId = 2;
    public static $FinancialReportId;
    public static $FinancialReportDate; //This value will be set during fin reports cest
    public static $DelayedSalaryDate;
    public static $BusinessID = 1;
    public static $unix = 1522912941;
    public static $DevSalary = 5500;

    public static $userAdmin = [
        'id'        => 1,
        'email'     => 'crm-admin@skynix.co',
        'password'  => 'B19E$d4n$yc@Lu6fQIO#1d'
    ];

    public static $userFin = [
        'id'        => 2,
        'email'     => 'crm-fin@skynix.co',
        'password'  => 'Q3zvy#kc@RD'
    ];

    public static $userDev = [
        'id'        => 3,
        'email'     => 'crm-dev@skynix.co',
        'password'  => 'Q$zv#yk2cR4D'
    ];

    public static $userClient = [
        'id'        => 4,
        'email'     => 'crm-client@skynix.co',
        'password'  => 'Q$zR#yk2cR4D'
    ];

    public static $userSales = [
        'id'        => 5,
        'email'     => 'crm-sales@skynix.co',
        'password'  => 'Q$zR#yk2c4R4D'
    ];

    public static $userPm = [
        'id'        => 6,
        'email'     => 'crm-pm@skynix.co',
        'password'  => 'Q$zR3yk2c4R4D'
    ];
 }

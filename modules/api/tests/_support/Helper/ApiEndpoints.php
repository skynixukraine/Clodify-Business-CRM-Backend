<?php
/**
 * Created by Skynix Team
 * Date: 27.02.17
 * Time: 12:30
 */

namespace Helper;


class ApiEndpoints
{
    const CONTACT                 = '/api/contacts';
    const CONTACT_ATTACH          = self::CONTACT . '/attachment';
    const PASSWORD                = '/api/password';
    const REPORT                  = '/api/reports';
    const USERS                   = '/api/users';
    const PROJECT                 = '/api/projects';
    const ATTACH_SIGN             = '/api/users/sign';
    const ATTACH_PHOTO            = '/api/users/photo';
    const GET_DEFAULT_LOGO        = '/logo';
    const CAREERS_VIEW            = '/api/careers';
    const SURVEY                  = '/api/surveys';
    const PROFILES                = '/api/profiles';
    const CONTRACTS               = '/api/contracts';
    const USER                    = '/api/user';
    const FINANCIAL_REPORTS       = '/api/financial-reports';
    const SALARY_REPORTS          = '/api/salary-reports';
    const SETTINGS                = '/api/settings';
    const COUNTERPARTY            = '/api/counterparties';
    const OPERATION               = '/api/operations';
    const BUSINESS                = '/api/businesses';
    const EMAIL_TEMPLATE          = '/api/email-templates';
    const INVOICE_TEMPLATE        = '/api/invoice-templates';
    const OPERATION_TYPES         = '/api/operation-types';
    const REFERENCE_BOOK          = '/api/reference-book-items';
    const INVOICES                = '/api/invoices';
    const FETCH_FINANCIAL_REPORTS = self::FINANCIAL_REPORTS;
    const FETCH_FIXED_ASSETS      = '/api/fixed-assets';
    const FETCH_BALANCE           = '/api/balances';
    const RESOURCES               = '/api/resources';
    const EMERGENCY               = '/api/emergency';
    const DELAYED_SALARY          = '/api/delayed-salary';
    const SSO_CONFIG              = '/api/sso/config';
    const SSO_TOKEN_CHECK         = '/api/sso/check';
    const REVIEWS                 = '/api/reviews';
    const MONTHLY_REVIEWS         = '/api/monthly-reviews';
    const FINANCIAL_REPORTS_INCOME= '/income';
    const FINANCIAL_REPORTS_BONUSES= '/bonuses';
    const VACATION_HISTORY_ITEM  = '/api/vacation-history-items';

}
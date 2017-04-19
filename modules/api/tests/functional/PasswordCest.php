<?php
/**
 * Created by Skynix Team
 * Date: 03.04.17
 * Time: 12:37
 */

use Helper\ApiEndpoints;

class PasswordCest
{
    /**
     * @see    https://jira-v2.skynix.company/browse/SI-946
     * @param  FunctionalTester $I
     */
    public function testResetPassword(FunctionalTester $I)
    {
        define('CAPTCHA', '03AHJ_VuukcmH81vXLFx0_BgBdOqSZG6');
        define('EMAIL_PASS', substr(md5(rand(1, 1000)), 0, 5) .  '@gmail.com');

        $I->wantTo('Test reset password');
        $I->sendPOST(ApiEndpoints::PASSWORD, json_encode([
                'email' => EMAIL_PASS,
                'captcha' => CAPTCHA
            ])
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
            'errors' => [
                [
                    'param' => 'email',
                    'message' => 'Email cannot be blank.'
                ],
                [
                    'param' => 'captcha',
                    'message' => 'Captcha cannot be blank.'
                ],

            ],
        ]);

    }

    /**
     * @see    https://jira-v2.skynix.company/browse/SI-946
     * @param FunctionalTester $I
     */
    public function testChangePassword(FunctionalTester $I)
    {
        define('CODE', 'eXMvlNehB-sVxjaqarPYcwek6H9XW-Nq1491313868');

        $I->wantTo('Test change password');
        $I->sendPUT(ApiEndpoints::PASSWORD, json_encode([
                'code' => CODE
            ])
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => false,
            'errors' => [
                [
                    'param' => 'code',
                    'message' => 'Code is not valid or expired.'
                ],

            ],
        ]);
    }

}

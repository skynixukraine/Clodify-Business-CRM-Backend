<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 20.12.17
 * Time: 17:46
 */
namespace app\components;


class CrowdComponent
{
    public static function validateCrowdSession( $token )
    {
        $dataResponse = [
            'expand' => null,
            'success' => true,
            'reason' => false,
            'token' => null,
            'expiryDate' => null,
            'createdDate' => null
        ];
        if (!$token) {

            $dataResponse['success'] = false;
            $dataResponse['reason'] = "Undefined token";
            return $dataResponse;

        }
        if ( $token === 'D00000001230000123') {


            $dataResponse['token']  = $token;
            $dataResponse['user']   = [
                'name'         => 'crowd@skynix.co'
            ];

        } else if ( $token === 'D00000001230000124' ) {

            $dataResponse['token']  = $token;
            $dataResponse['user']   = [
                'name'         => 'crm-dev@skynix.co'
            ];

        } else {

            $dataResponse['success'] = false;

        }
        return $dataResponse;
    }

}
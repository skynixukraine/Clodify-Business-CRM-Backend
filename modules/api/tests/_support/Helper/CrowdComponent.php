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

    public function checkByAccessToken($accessToken, $checkAccess = true)
    {
        return true;
    }

    public function checkByEmailPassword($email, $password)
    {
        return true;
    }

}
<?php
/**
 * Created by Skynix Team
 * Date: 27.02.17
 * Time: 12:30
 */

namespace Helper;


class ApiEndpoints
{
    const CONTACT        = '/api/contacts';
    const CONTACT_ATTACH = self::CONTACT . '/attachment';
    const PASSWORD       = '/api/password';
    const REPORT         = '/api/reports';
    const USERS          = '/api/users';
    const PROJECT        = '/api/projects';
    const ATTACH_SIGN    = '/api/users/sign';
    const ATTACH_PHOTO   = '/api/users/photo';
    const CAREERS_VIEW   = '/api/careers';
    const SURVEY_DELETE  = '/api/surveys';
    const SURVEYS_FETCH  = '/api/surveys';
    const SURVEY_CREATE  = '/api/surveys';

}
<?php
$API = 'api';
return [

    'POST '     . $API . '/password'                                    => $API . '/password/reset',
    'PUT '      . $API . '/password'                                    => $API . '/password/change',
    'POST '     . $API . '/projects'                                    => $API . '/projects/create',
    'GET '      . $API . '/projects'                                    => $API . '/projects/fetch',
    'PUT '      . $API . '/projects/<id:\d+>/suspend'                   => $API . '/projects/suspend',
    'PUT '      . $API . '/projects/<id:\d+>'                           => $API . '/projects/edit',
    'PUT '      . $API . '/projects/<id:\d+>/activate'                  => $API . '/projects/activate',
    'DELETE '   . $API . '/projects/<id:\d+>'                           => $API . '/projects/delete',
    'DELETE '   . $API . '/reports/<id:\d+>'                            => $API . '/reports/delete',
    'PUT '      . $API . '/reports/<id:\d+>'                            => $API . '/reports/create-edit',
    'POST '     . $API . '/reports'                                     => $API . '/reports/create-edit',
    'PUT '      . $API . '/users/<id:\d+>/activate'                     => $API . '/users/activate',
    'PUT '      . $API . '/users/<id:\d+>/deactivate'                   => $API . '/users/deactivate',
    'GET '      . $API . '/users/<id:\d+>'                              => $API . '/users/view',
    'DELETE '   . $API . '/users/<id:\d+>'                              => $API . '/users/delete',
    'PUT '      . $API . '/users/<id:\d+>'                              => $API . '/users/edit',
    'POST '     . $API . '/users'                                       => $API . '/users/create',
    'DELETE '   . $API . '/surveys/<id:\d+>'                            => $API . '/surveys/delete',
    'GET '      . $API . '/surveys'                                     => $API . '/surveys/fetch',
    'POST '     . $API . '/surveys'                                     => $API . '/surveys/create',
    'GET '      . $API . '/surveys/<id:\d+>'                            => $API . '/surveys/view',
    'GET '      . $API . '/profiles'                                    => $API . '/profiles/fetch',
    'GET '      . $API . '/users/<slug:\w+(-\w+)*>/work-history'        => $API . '/users/work-history',
    'POST '     . $API . '/contracts'                                   => $API . '/contracts/create',
    'GET '      . $API . '/contracts'                                   => $API . '/contracts/fetch',
    'PUT '      . $API . '/contracts/<contract_id:\d+>'                 => $API . '/contracts/edit',
    'GET '      . $API . '/contracts/<id:\d+>'                          => $API . '/contracts/view',
    'DELETE '   . $API . '/contracts/<contract_id:\d+>'                 => $API . '/contracts/delete',
    'GET '      . $API . '/user/<id:\d+>/photo'                         => $API . '/users/view-photo',
    'GET '      . $API . '/contracts/<id:\d+>/invoices'                 => $API . '/invoices/fetch',
    'POST '     . $API . '/contracts/<id:\d+>/invoices'                 => $API . '/invoices/create',
    'DELETE '   . $API . '/contracts/<id:\d+>/invoices/<invoice_id:\d+>'=> $API . '/invoices/delete',

    // General rules
    $API . '/<controller>'              => $API . '/<controller>',
    $API . '/<controller>/<action>'     => $API . '/<controller>/<action>',
    // Error rule for unknown methods
    [
        'pattern'   => $API . '/<route:(.*)>',
        'route'     => $API . '/default/error'
    ]
];

<?php
$API = 'api';
return [
    'POST '     . $API . '/password'                  => $API . '/password/reset',
    'PUT '      . $API . '/password'                  => $API . '/password/change',
    'POST '     . $API . '/projects'                  => $API . '/projects/create',
    'DELETE '   . $API . '/reports/<id:\d+>'          => $API . '/reports/delete',
    'PUT '      . $API . '/reports/<id:\d+>'          => $API . '/reports/create-edit',
    'POST '     . $API . '/reports'                   => $API . '/reports/create-edit',
    'PUT '      . $API . '/users/<id:\d+>/activate'   => $API . '/users/activate',
    'PUT '      . $API . '/users/<id:\d+>/deactivate' => $API . '/users/deactivate',
    'GET '      . $API . '/users/<id:\d+>'            => $API . '/users/view',
    'DELETE '   . $API . '/users/<id:\d+>'            => $API . '/users/delete',
    'PUT '      . $API . '/users/<id:\d+>'            => $API . '/users/edit',
    'POST '     . $API . '/users'                     => $API . '/users/create',
    'GET '      . $API . '/surveys'                   => $API . '/surveys/fetch',
    'POST '     . $API . '/surveys'                   => $API . '/surveys/create',
    // General rules
    $API . '/<controller>'              => $API . '/<controller>',
    $API . '/<controller>/<action>'     => $API . '/<controller>/<action>',
    // Error rule for unknown methods
    [
        'pattern'   => $API . '/<route:(.*)>',
        'route'     => $API . '/default/error'
    ]
];

<?php
$API = 'api';
return [
    'DELETE '   . $API . '/reports/<id:\d+>'          => $API . '/reports/delete',
    'PUT '      . $API . '/reports/<id:\d+>'          => $API . '/reports/create-edit',
    'POST '     . $API . '/reports'                   => $API . '/reports/create-edit',
    'PUT '      . $API . '/users/<id:\d+>/activate'   => $API . '/users/activate',
    'PUT '      . $API . '/users/<id:\d+>/deactivate' => $API . '/users/deactivate',
    // General rules
    $API . '/<controller>'              => $API . '/<controller>',
    $API . '/<controller>/<action>'     => $API . '/<controller>/<action>',
    // Error rule for unknown methods
    [
        'pattern'   => $API . '/<route:(.*)>',
        'route'     => $API . '/default/error'
    ]
];

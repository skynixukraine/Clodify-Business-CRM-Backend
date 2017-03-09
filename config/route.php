<?php
$API = 'api';
return [
    'DELETE '   . $API . '/reports/<id:\d+>' => $API . '/reports/delete',
    'PUT '      . $API . '/reports/<id:\d+>' => $API . '/reports/create-edit',
    'POST '     . $API . '/reports'          => $API . '/reports/create-edit',
    // General rules
    $API . '/<controller>'              => $API . '/<controller>',
    $API . '/<controller>/<action>'     => $API . '/<controller>/<action>',
    // Error rule for unknown methods
    [
        'pattern'   => $API . '/<route:(.*)>',
        'route'     => $API . '/default/error'
    ]
];

<?php
$API = 'api';
return [
    'DELETE ' . $API . '/reports/<id:\d+>' => $API . '/reports/delete',
    'POST ' . $API . '/reports' => $API . '/reports/create',
    // General rules
    $API . '/<controller>'              => $API . '/<controller>',
    $API . '/<controller>/<action>'     => $API . '/<controller>/<action>',
    // Error rule for unknown methods
    [
        'pattern'   => $API . '/<route:(.*)>',
        'route'     => $API . '/default/error'
    ]
];

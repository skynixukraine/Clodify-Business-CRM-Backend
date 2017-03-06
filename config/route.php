<?php
$API = 'api';
return [
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

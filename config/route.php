<?php
$API = 'api';
return [
    $API . '/reports/<id:\d+>' => $API . '/reports/delete',
    // General rules
    $API . '/<controller>'              => $API . '/<controller>',
    $API . '/<controller>/<action>'     => $API . '/<controller>/<action>',

            // Error rule for unknown methods
    [
        'pattern'   => $API . '/<route:(.*)>',
        'route'     => $API . '/default/error'

    ],

];

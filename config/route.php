<?php
$API = 'api';
return [
    [
        'pattern'   => $API . '/reports/date_period',
        'route'     => $API . '/reports/date-period'
    ],
    // General rules
    $API . '/<controller>'              => $API . '/<controller>',
    $API . '/<controller>/<action>'     => $API . '/<controller>/<action>',

            // Error rule for unknown methods
    [
        'pattern'   => $API . '/<route:(.*)>',
        'route'     => $API . '/default/error'

    ],

];

<?php

return [

    'route_middlewares' => [],
    'route_prefix' => env('APIE_PREFIX', 'apie'),

    'documentation_route' => env('APIE_DOCUMENTATION', 'documentation'),
    'default_level' => env('APIE_DEFAULT_LEVEL', 's'),

    'models' => [
        'App\Models\Category',
        'App\Models\Subcategory',
        'App\Models\Course',
        'App\Models\Company',
    ],

    // 'search_driver' => env('APIE_SEARCH_DRIVER', 'bselastic');
];

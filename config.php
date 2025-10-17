<?php

declare(strict_types=1);

return [
    /*
    |---------------------------------------------------------------------------
    | Base cache path
    |---------------------------------------------------------------------------
    |
    | The path to store TerloquentID data.
    |
    */
    'base_cache_path' => App::storagePath(
        'framework/cache/terloquent-id'
    ),

    /*
    |---------------------------------------------------------------------------
    | Resources
    |---------------------------------------------------------------------------
    |
    | Configuration for TerloquentID resources.
    |
    */
    'resources' => [
        'csv' => [
            'git_url' => 'https://github.com/sensasi-delight/id-administrative-divisions.git',

            /**
             * Relative path to the CSV files.
             */
            'relative_path' => 'csv',
        ],
    ],
];

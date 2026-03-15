<?php

declare(strict_types=1);

use Illuminate\Support\Facades\App;

return [

    /**
     * The base directory where Terloquent caches its processed data.
     */
    'cache_directory' => App::storagePath('framework/cache/terloquent'),

    /**
     * Configuration for Terloquent data sources.
     */
    'sources' => [

        'csv' => [

            /**
             * Repository URL
             *
             * The Git repository that hosts the official CSV data
             * for Terloquent.
             */
            'repository_url' => 'https://github.com/dominosaurs/id-administrative-divisions.git',

            /**
             * Data Subdirectory
             *
             * Relative path inside the repository where the CSV files
             * are stored. Can be customized if your dataset uses a different structure.
             */
            'data_subdirectory' => 'csv',
        ],
    ],
];

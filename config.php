<?php

declare(strict_types=1);

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

return [

    /**
     * The base directory where Terloquent caches its processed data.
     */
    'cache_directory' => App::storagePath('framework/cache/terloquent'),

    /**
     * Enable Data Caching
     *
     * Determines whether the parsed data should be cached to disk.
     * By default, caching is enabled in production environments.
     */
    'cache_enabled' => env(
        'TERLOQUENT_CACHE_ENABLED',
        Config::string('app.env') === 'production'
    ),

    /**
     * Download Timeout
     *
     * The maximum number of seconds to wait for a CSV download to complete.
     */
    'timeout' => env('TERLOQUENT_DOWNLOAD_TIMEOUT'),

    /**
     * Remote Data Sources
     *
     * The full raw GitHub URLs for each administrative division CSV file.
     */
    'sources' => [
        'provinces' => 'https://raw.githubusercontent.com/dominosaurs/id-administrative-divisions/refs/tags/v0.0.1/csv/provinces.csv',
        'regencies' => 'https://raw.githubusercontent.com/dominosaurs/id-administrative-divisions/refs/tags/v0.0.1/csv/regencies.csv',
        'districts' => 'https://raw.githubusercontent.com/dominosaurs/id-administrative-divisions/refs/tags/v0.0.1/csv/districts.csv',
        'villages' => 'https://raw.githubusercontent.com/dominosaurs/id-administrative-divisions/refs/tags/v0.0.1/csv/villages.csv',
    ],
];

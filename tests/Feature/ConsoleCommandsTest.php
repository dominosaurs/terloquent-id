<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

test('terloquent-id:status command works', function () {
    Artisan::call('terloquent-id:status');
    $output = Artisan::output();

    expect($output)->toContain('Administrative division data is ready')
        ->and($output)->toContain('initialized')
        ->and($output)->toContain('path');
});

test('terloquent-id:clear command clears cache', function () {
    // Ensure it's initialized first
    Artisan::call('terloquent-id:status');

    $cacheDir = config('terloquent.cache_directory');

    // Check if directory exists
    expect(File::isDirectory($cacheDir))->toBeTrue();

    // Run clear
    Artisan::call('terloquent-id:clear');

    // Check if directory is removed
    expect(File::isDirectory($cacheDir))->toBeFalse();
});

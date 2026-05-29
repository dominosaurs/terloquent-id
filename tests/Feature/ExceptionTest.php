<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use TerloquentID\Exceptions\DataSourceUnavailableException;
use Tests\Fixtures\ExceptionModel;

test('it throws DataSourceUnavailableException when download fails', function () {
    // Config the source for this fake model
    Config::set('terloquent.sources.exception_test', 'https://example.com/fail.csv');

    // Mock failure
    Http::fake([
        'example.com/fail.csv' => Http::response('Error', 500),
    ]);

    expect(fn () => ExceptionModel::all())->toThrow(DataSourceUnavailableException::class);
});

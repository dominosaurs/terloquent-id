<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use TerloquentID\Concerns\TerloquentBase;
use TerloquentID\Exceptions\DataSourceUnavailableException;

class ExceptionModel extends Model
{
    use TerloquentBase;

    protected $table = 'exception_test';

    /**
     * @var array<string, string>
     */
    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
    ];
}

test('it throws DataSourceUnavailableException when download fails', function () {
    // Config the source for this fake model
    Config::set('terloquent.sources.exception_test', 'https://example.com/fail.csv');

    // Mock failure
    Http::fake([
        'example.com/fail.csv' => Http::response('Error', 500),
    ]);

    expect(fn () => ExceptionModel::all())->toThrow(DataSourceUnavailableException::class);
});

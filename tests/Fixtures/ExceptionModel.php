<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use TerloquentID\Concerns\TerloquentBase;

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

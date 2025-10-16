<?php

declare(strict_types=1);

namespace TerloquentID;

use TerloquentID\Etc\TerloquentBase;

/**
 * Eloquent model for Indonesia provinces.
 *
 * @property-read int $id
 * @property-read string $name
 * @property-read float $lat
 * @property-read float $long
 */
class Province extends TerloquentBase
{
    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
        'lat' => 'float',
        'long' => 'float',
    ];
}

<?php

declare(strict_types=1);

namespace TerloquentID;

use Illuminate\Database\Eloquent\Relations\HasMany;
use TerloquentID\Etc\TerloquentBase;

/**
 * Terloquent model for Indonesia provinces.
 *
 * @property-read int $id
 * @property-read string $name
 * @property-read float $lat
 * @property-read float $long
 * @property-read \Illuminate\Database\Eloquent\Collection<int, City> $cities
 */
class Province extends TerloquentBase
{
    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
        'lat' => 'float',
        'long' => 'float',
    ];

    /**
     * Get the cities for the province.
     *
     * @return HasMany<City, $this>
     */
    public function cities(): HasMany
    {
        return $this->hasMany(
            City::class
        );
    }
}

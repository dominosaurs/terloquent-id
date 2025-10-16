<?php

declare(strict_types=1);

namespace TerloquentID;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TerloquentID\Etc\TerloquentBase;

/**
 * Terloquent model for Indonesia districts.
 *
 * @property-read int $id
 * @property-read int $city_id
 * @property-read string $name
 * @property-read float $lat
 * @property-read float $long
 * @property-read City $city
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Village> $villages
 */
class District extends TerloquentBase
{
    protected array $schema = [
        'id' => 'integer',
        'city_id' => 'integer',
        'name' => 'string',
        'lat' => 'float',
        'long' => 'float',
    ];

    /**
     * Get the city that owns the district.
     *
     * @return BelongsTo<City, $this>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(
            City::class
        );
    }

    /**
     * Get the villages for the district.
     *
     * @return HasMany<Village, $this>
     */
    public function villages(): HasMany
    {
        return $this->hasMany(
            Village::class
        );
    }
}

<?php

declare(strict_types=1);

namespace TerloquentID;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TerloquentID\Etc\TerloquentBase;

/**
 * Terloquent model for Indonesia districts.
 *
 * @property-read int $id
 * @property-read int $city_id
 * @property-read string $name
 * @property-read float $lat
 * @property-read float $long
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
}

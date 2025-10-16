<?php

declare(strict_types=1);

namespace TerloquentID;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TerloquentID\Etc\TerloquentBase;

/**
 * Terloquent model for Indonesia cities.
 *
 * @property-read int $id
 * @property-read int $province_id
 * @property-read string $name
 * @property-read float $lat
 * @property-read float $long
 */
class City extends TerloquentBase
{
    protected array $schema = [
        'id' => 'integer',
        'province_id' => 'integer',
        'name' => 'string',
        'lat' => 'float',
        'long' => 'float',
    ];

    /**
     * Get the province that owns the city.
     *
     * @return BelongsTo<Province, $this>
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(
            Province::class
        );
    }
}

<?php

declare(strict_types=1);

namespace TerloquentID;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TerloquentID\Abstracts\TerloquentBase;

/**
 * Terloquent model for Indonesia regencies/cities.
 *
 * @property-read int $id
 * @property-read int $province_id
 * @property-read string $name
 * @property-read Collection<int, District> $districts
 * @property-read Province $province
 */
class Regency extends TerloquentBase
{
    protected array $schema = [
        'id' => 'integer',
        'province_id' => 'integer',
        'name' => 'string',
    ];

    /**
     * Get the province that owns the regency/city.
     *
     * @return BelongsTo<Province, $this>
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(
            Province::class
        );
    }

    /**
     * Get the districts for the regency/city.
     *
     * @return HasMany<District, $this>
     */
    public function districts(): HasMany
    {
        return $this->hasMany(
            District::class
        );
    }
}

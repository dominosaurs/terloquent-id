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
 * @property-read int $regency_id
 * @property-read string $name
 * @property-read Regency $regency
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Village> $villages
 */
class District extends TerloquentBase
{
    protected array $schema = [
        'id' => 'integer',
        'regency_id' => 'integer',
        'name' => 'string',
        'lat' => 'float',
        'long' => 'float',
    ];

    /**
     * Get the regency/city that owns the district.
     *
     * @return BelongsTo<Regency, $this>
     */
    public function regency(): BelongsTo
    {
        return $this->belongsTo(
            Regency::class
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

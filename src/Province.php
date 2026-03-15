<?php

declare(strict_types=1);

namespace TerloquentID;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TerloquentID\Concerns\Terloquent;
use TerloquentID\Concerns\TerloquentBase;

/**
 * Terloquent model for Indonesia provinces.
 *
 * @property-read int $id
 * @property-read string $name
 * @property-read Collection<int, Regency> $regencies
 */
class Province extends Model
{
    use TerloquentBase;

    /**
     * @var array<string, string>
     */
    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
    ];

    /**
     * Get the regencies/cities for the province.
     *
     * @return HasMany<Regency, $this>
     */
    public function regencies(): HasMany
    {
        return $this->hasMany(
            Regency::class
        );
    }
}

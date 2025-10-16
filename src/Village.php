<?php

declare(strict_types=1);

namespace TerloquentID;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TerloquentID\Etc\TerloquentBase;

/**
 * Terloquent model for Indonesia villages.
 *
 * @property-read int $id
 * @property-read int $district_id
 * @property-read string $name
 * @property-read float $lat
 * @property-read float $long
 */
class Village extends TerloquentBase
{
    protected array $schema = [
        'id' => 'integer',
        'district_id' => 'integer',
        'name' => 'string',
        'lat' => 'float',
        'long' => 'float',
    ];

    /**
     * Get the district that owns the village.
     *
     * @return BelongsTo<District, $this>
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(
            District::class
        );
    }
}

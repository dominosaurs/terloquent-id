<?php

declare(strict_types=1);

namespace TerloquentID\Abstracts;

use Illuminate\Database\Eloquent\Model;

abstract class TerloquentBase extends Model
{
    use \Sushi\Sushi;

    /**
     * @var array<string, string>
     */
    protected array $schema;

    public function __construct()
    {
        throw_if(
            ! isset($this->schema),
            'Schema must be set'
        );

        parent::__construct();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return TerloquentBaseHelper::getRows(
            $this->getTable(),
            array_keys($this->schema)
        );
    }

    protected function sushiShouldCache(): bool
    {
        return true;
    }

    protected function sushiCacheReferencePath(): string
    {
        return TerloquentBaseHelper::getCsvPath($this->getTable());
    }
}

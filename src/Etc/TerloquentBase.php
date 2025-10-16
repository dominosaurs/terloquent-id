<?php

declare(strict_types=1);

namespace TerloquentID\Etc;

use Illuminate\Database\Eloquent\Model;
use Src\Etc\CheckRequiredPropertiesTrait;

abstract class TerloquentBase extends Model
{
    use CheckRequiredPropertiesTrait, \Sushi\Sushi;

    /**
     * @var array<string, string>
     */
    protected array $schema;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return Helper::getRows(
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
        return Helper::getPath($this->getTable());
    }
}

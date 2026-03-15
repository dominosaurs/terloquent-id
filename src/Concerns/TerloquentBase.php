<?php

declare(strict_types=1);

namespace TerloquentID\Concerns;

use Illuminate\Support\Facades\Config;
use Sushi\Sushi;
use TerloquentID\Helpers\TerloquentBaseHelper;

trait TerloquentBase
{
    use Sushi;

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
        return Config::boolean(
            'cache_enabled',
            Config::string('app.env') === 'production'
        );
    }

    protected function sushiCacheReferencePath(): string
    {
        return TerloquentBaseHelper::getCsvPath($this->getTable());
    }
}

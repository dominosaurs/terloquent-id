<?php

declare(strict_types=1);

namespace TerloquentID\Etc;

trait CheckRequiredPropertiesTrait
{
    public function __construct()
    {
        $this->checkRequiredProperties();
        parent::__construct();
    }

    private function checkRequiredProperties(): void
    {
        throw_if(
            ! isset($this->schema),
            'Schema must be set'
        );
    }
}

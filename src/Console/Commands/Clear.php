<?php

declare(strict_types=1);

namespace TerloquentID\Console\Commands;

use Illuminate\Console\Command;
use TerloquentID\Helpers\AdministrativeDivisions;

class Clear extends Command
{
    protected $signature = 'terloquent-id:clear';

    protected $description = '🧹 Clear locally stored Indonesian administrative division data';

    public function handle(): int
    {
        $status = AdministrativeDivisions::status();

        if (! $status['initialized']) {
            $this->warn(
                '🏔️ Directory not found. Nothing to clear.'
            );

            return self::SUCCESS;
        }

        if (AdministrativeDivisions::clear() == false) {
            $this->error('🌋 Failed to clear data.');

            return self::FAILURE;
        }

        $this->info(
            '✅ Administrative division data cleared successfully!'
        );

        return self::SUCCESS;
    }
}

<?php

declare(strict_types=1);

namespace TerloquentID\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class Clear extends Command
{
    protected $signature = 'terloquent:clear
                            {--force : Skip confirmation prompt and clear immediately}';

    protected $description = 'Remove all cached or cloned Indonesian administrative divisions data.';

    public function handle(): int
    {
        $storagePath = App::storagePath(
            'framework/cache/terloquent-id/resources'
        );

        if (! is_dir($storagePath)) {
            $this->info('ℹ️ No data found to clear.');

            return self::SUCCESS;
        }

        if (
            ! $this->option('force') &&
            ! $this->confirm(
                '⚠️ This will permanently delete all data. Continue?'
            )
        ) {
            $this->info('🛑 Operation cancelled.');

            return self::SUCCESS;
        }

        File::deleteDirectory($storagePath);

        $this->info('🧹 Data directory cleared successfully.');

        return self::SUCCESS;
    }
}

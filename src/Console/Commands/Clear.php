<?php

declare(strict_types=1);

namespace TerloquentID\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
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

        if (
            ! $this->deleteBaseCachePath() ||
            ! $this->deleteSushiSqlite()
        ) {
            return self::FAILURE;
        }

        $this->info(
            '✅ Administrative division data cleared successfully!'
        );

        return self::SUCCESS;
    }

    private function deleteBaseCachePath(): bool
    {
        $basePath = Config::get('terloquent.cache_directory');

        if (! File::deleteDirectory($basePath)) {
            $this->error('🌋 Failed to clear data.');

            return false;
        }

        return true;
    }

    /**
     * Delete Sushi SQLite files.
     */
    private function deleteSushiSqlite(): bool
    {
        $cachePath = App::storagePath('framework/cache');
        $matchingFiles = File::glob("$cachePath/*terloquent*.sqlite");

        if (! File::delete($matchingFiles)) {
            $this->error('🌋 Failed to clear data.');

            return false;
        }

        return true;
    }
}

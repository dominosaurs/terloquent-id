<?php

declare(strict_types=1);

namespace TerloquentID\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Symfony\Component\Process\Process;

class Status extends Command
{
    protected $signature = 'terloquent:status';

    protected $description = 'Show the current status of Indonesian administrative divisions data.';

    public function handle(): int
    {
        $storagePath = App::storagePath(
            'framework/cache/terloquent-id/resources'
        );

        if (! is_dir($storagePath)) {
            $this->warn(
                '⚠️  No data found. Run `php artisan terloquent:sync` to fetch it.'
            );

            return self::SUCCESS;
        }

        $this->info("📁 Data directory: $storagePath");

        $lastModified = $this->getLastModified($storagePath);
        $this->line('🕒 Last modified: '.($lastModified ?? 'Unknown'));

        if (is_dir("$storagePath/.git")) {
            $branch = $this->runGitCommand(
                ['rev-parse', '--abbrev-ref', 'HEAD'], $storagePath
            );

            $commit = $this->runGitCommand(
                ['log', '-1', '--pretty=%h - %s (%ci)'], $storagePath
            );

            $this->line('🌿 Branch: '.trim($branch));
            $this->line('🔖 Latest commit: '.trim($commit));
        } else {
            $this->line('ℹ️ Not a Git directory (possibly copied or detached data).');
        }

        $this->info('✅ Status check complete.');

        return self::SUCCESS;
    }

    protected function runGitCommand(array $command, string $workingDir): ?string
    {
        $process = new Process(array_merge(['git', '-C', $workingDir], $command));
        $process->run();

        return $process->isSuccessful() ? trim($process->getOutput()) : null;
    }

    protected function getLastModified(string $path): ?string
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)
        );

        $latest = 0;
        foreach ($iterator as $file) {
            $latest = max($latest, $file->getMTime());
        }

        return $latest ? date('Y-m-d H:i:s', $latest) : null;
    }
}

<?php

declare(strict_types=1);

namespace TerloquentID\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

/**
 * Helper class for Indonesian administrative divisions.
 */
class AdministrativeDivisions
{
    /**
     * Path to store administrative divisions data.
     */
    final public static function path(): string
    {
        return App::storagePath(
            'framework/cache/terloquent-id/id-administrative-divisions'
        );
    }

    /**
     * Initialize Indonesian administrative divisions data.
     */
    final public static function init(): bool
    {
        $path = static::path();

        $process = new Process([
            'git',
            'clone',
            '--depth=1',
            'https://github.com/sensasi-delight/id-administrative-divisions.git',
            $path,
        ]);

        $process->run();

        return $process->isSuccessful();
    }

    /**
     * Clear locally stored data.
     */
    final public static function clear(): bool
    {
        return
            static::deleteSushiSqlite() &&
            File::deleteDirectory(
                static::path().'/..'
            );
    }

    /**
     * Delete Sushi SQLite files.
     */
    private static function deleteSushiSqlite(): bool
    {
        $cachePath = App::storagePath('framework/cache');
        $matchingFiles = File::glob("$cachePath/*terloquent*.sqlite");

        return File::delete($matchingFiles);
    }

    /**
     * Return current data status as array.
     *
     * @return array{
     *  branch: ?string,
     *  commit: ?string,
     *  initialized: bool,
     *  last_modified: ?string,
     *  message: ?string,
     *  path: string,
     * }
     */
    public static function status(): array
    {
        $path = static::path();

        if (! is_dir($path)) {
            return [
                'initialized' => false,
                'message' => 'Data not initialized.',
            ];
        }

        $status = [
            'initialized' => true,
            'path' => $path,
            'last_modified' => static::lastModified($path),
        ];

        if (is_dir("$path/.git")) {
            $status['branch'] = static::runGit(
                ['rev-parse', '--abbrev-ref', 'HEAD']
            );
            $status['commit'] = static::runGit(
                ['log', '-1', '--pretty=%h - %s (%ci)']
            );
        }

        return $status;
    }

    /**
     * Get last modified time of the directory.
     */
    private static function lastModified(string $path): ?string
    {
        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)
        );

        $latest = 0;
        foreach ($it as $file) {
            $latest = max($latest, $file->getMTime());
        }

        return $latest ? date('Y-m-d H:i:s', $latest) : null;
    }

    /**
     * Run git command in data directory.
     */
    private static function runGit(array $args): ?string
    {
        $path = static::path();
        $process = new Process(array_merge(['git', '-C', $path], $args));
        $process->run();

        return $process->isSuccessful() ? trim($process->getOutput()) : null;
    }
}

<?php

declare(strict_types=1);

namespace TerloquentID\Helpers;

use Illuminate\Support\Facades\Config;
use Symfony\Component\Process\Process;

/**
 * Helper class for Indonesian administrative divisions.
 */
class AdministrativeDivisions
{
    /**
     * Path to store administrative divisions repository files.
     */
    private static function rootPath(): string
    {
        return Config::get(
            'terloquent.base_cache_path'
        ).'/csv';
    }

    final public static function getCsvFilePath(
        string $tableName
    ): string {
        $rootPath = self::rootPath();
        $relativePath = Config::get(
            'terloquent.resources.csv.relative_path'
        );

        if (! is_dir($rootPath)) {
            self::init();
        }

        return "$rootPath/$relativePath/$tableName.csv";
    }

    /**
     * Initialize Indonesian administrative divisions data.
     */
    private static function init(): bool
    {
        $process = new Process([
            'git',
            'clone',
            '--depth=1',
            Config::get('terloquent.resources.csv.git_url'),
            self::rootPath(),
        ]);

        $process->run();

        return $process->isSuccessful();
    }

    /**
     * Return current data status as array.
     *
     * @return array{
     *  initialized: false,
     *  message: string,
     * }|array{
     *  initialized: true,
     *  path: string,
     *  last_modified: ?string,
     *  branch: ?string,
     *  commit: ?string,
     * }
     */
    public static function status(): array
    {
        $path = self::rootPath();

        if (! is_dir($path)) {
            return [
                'initialized' => false,
                'message' => 'Data not initialized.',
            ];
        }

        $status = [
            'initialized' => true,
            'path' => $path,
            'last_modified' => self::lastModified($path),
            'branch' => null,
            'commit' => null,
        ];

        if (is_dir("$path/.git")) {
            $status['branch'] = self::runGit(
                ['rev-parse', '--abbrev-ref', 'HEAD']
            );

            $status['commit'] = self::runGit(
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
     *
     * @param  string[]  $args
     */
    private static function runGit(array $args): ?string
    {
        $process = new Process(
            array_merge(
                ['git', '-C', self::rootPath()], $args
            )
        );

        $process->run();

        return $process->isSuccessful()
            ? trim($process->getOutput())
            : null;
    }
}

<?php

declare(strict_types=1);

namespace TerloquentID\Helpers;

use Illuminate\Support\Facades\Config;
use Symfony\Component\Process\Process;

/**
 * Helper class for Indonesian administrative divisions.
 *
 * @method static array<string, string|bool|null> status()
 * @method static string getCsvFilePath(string $tableName)
 */
final readonly class AdministrativeDivisions
{
    /**
     * Path to store administrative divisions repository files.
     */
    private function rootPath(): string
    {
        return Config::get(
            'terloquent.cache_directory'
        ).'/csv';
    }

    private function getCsvFilePath(
        string $tableName
    ): string {
        $rootPath = $this->rootPath();
        $relativePath = Config::get(
            'terloquent.sources.csv.data_subdirectory'
        );

        if (! is_dir($rootPath)) {
            $this->init();
        }

        return "$rootPath/$relativePath/$tableName.csv";
    }

    /**
     * Initialize Indonesian administrative divisions data.
     */
    private function init(): bool
    {
        $process = new Process([
            'git',
            'clone',
            '--depth=1',
            Config::get('terloquent.sources.csv.repository_url'),
            $this->rootPath(),
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
    private function status(): array
    {
        $path = $this->rootPath();

        if (! is_dir($path)) {
            return [
                'initialized' => false,
                'message' => 'Data not initialized.',
            ];
        }

        $status = [
            'initialized' => true,
            'path' => $path,
            'last_modified' => $this->lastModified($path),
            'branch' => null,
            'commit' => null,
        ];

        if (is_dir("$path/.git")) {
            $status['branch'] = $this->runGit(
                ['rev-parse', '--abbrev-ref', 'HEAD']
            );

            $status['commit'] = $this->runGit(
                ['log', '-1', '--pretty=%h - %s (%ci)']
            );
        }

        return $status;
    }

    /**
     * Get last modified time of the directory.
     */
    private function lastModified(string $path): ?string
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
    private function runGit(array $args): ?string
    {
        $process = new Process(
            array_merge(
                ['git', '-C', $this->rootPath()], $args
            )
        );

        $process->run();

        return $process->isSuccessful()
            ? trim($process->getOutput())
            : null;
    }

    /**
     * @param  array<int, mixed>  $arguments
     * @return string|array<string, string|bool|null>
     */
    public static function __callStatic(string $name, array $arguments): string|array
    {
        if (! \in_array(
            $name,
            ['getCsvFilePath', 'status'],
            true
        )) {
            throw new \BadMethodCallException(
                'Call to undefined method '.__CLASS__."::{$name}()"
            );
        }

        return (new self)->$name(...$arguments);
    }
}

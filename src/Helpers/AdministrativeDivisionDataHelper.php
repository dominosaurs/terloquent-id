<?php

declare(strict_types=1);

namespace TerloquentID\Helpers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use TerloquentID\Exceptions\DataSourceUnavailableException;

/**
 * Helper class for Indonesian administrative divisions.
 *
 * @phpstan-type StatusReturn array{
 *  initialized: bool,
 *  message: string,
 *  path: string,
 *  cached_files: array<int, string>,
 * }
 *
 * @method static StatusReturn status()
 * @method static string getCsvFilePath(string $tableName)
 */
final readonly class AdministrativeDivisionDataHelper
{
    /**
     * Path to store administrative divisions CSV files.
     */
    private function rootPath(): string
    {
        return Config::string(
            'terloquent.cache_directory'
        ).'/csv';
    }

    /**
     * Get the path to a specific CSV file, downloading it if necessary.
     */
    private function getCsvFilePath(string $tableName): string
    {
        $path = $this->rootPath()."/{$tableName}.csv";

        if (! File::exists($path)) {
            $this->download($tableName, $path);
        }

        return $path;
    }

    /**
     * Download a specific CSV file from GitHub.
     */
    private function download(string $tableName, string $path): void
    {
        $url = Config::string("terloquent.sources.{$tableName}");

        if (empty($url)) {
            throw new RuntimeException("Source URL for table '{$tableName}' is not configured.");
        }

        try {
            /**
             * @var string|null|int
             */
            $timeout = Config::get('terloquent.timeout');

            $response = $timeout
                ? Http::timeout((int) $timeout)->get($url)
                : Http::get($url);

            if ($response->failed()) {
                throw DataSourceUnavailableException::forTable(
                    $tableName,
                    $url,
                    "HTTP Status: {$response->status()}"
                );
            }
        } catch (ConnectionException $e) {
            throw DataSourceUnavailableException::forTable(
                $tableName,
                $url,
                "Connection timeout or failure ({$e->getMessage()})"
            );
        }

        File::ensureDirectoryExists($this->rootPath());
        File::put($path, $response->body());
    }

    /**
     * Return current data status as array.
     *
     * @return StatusReturn
     */
    private function status(): array
    {
        $path = $this->rootPath();
        $files = File::exists($path) ? File::files($path) : [];

        /**
         * @var array<int, string>
         */
        $cachedFiles = collect($files)->map(fn ($file): string => $file->getFilename())->toArray();

        return [
            'initialized' => ! empty($cachedFiles),
            'message' => empty($cachedFiles) ? 'Data not initialized.' : 'Data is ready.',
            'path' => $path,
            'cached_files' => $cachedFiles,
        ];
    }

    /**
     * @param  array<int, string>  $arguments
     * @return string|array<string, mixed>
     */
    public static function __callStatic(string $name, array $arguments): string|array
    {
        if (! \in_array($name, ['getCsvFilePath', 'status'], true)) {
            throw new \BadMethodCallException(
                'Call to undefined method '.__CLASS__."::{$name}()"
            );
        }

        return (new self)->$name(...$arguments);
    }
}

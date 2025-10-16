<?php

declare(strict_types=1);

namespace TerloquentID\Etc;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class Helper
{
    /**
     * Returns the path of a CSV file or CSV directory.
     *
     * @param  string  $tableName  The name of the table
     */
    public static function getPath(
        string $tableName,
    ): string {
        $paths = [
            'provinces' => 'vendor/laravolt/indonesia/resources/csv/provinces.csv',
            'cities' => 'vendor/laravolt/indonesia/resources/csv/cities.csv',
            'districts' => 'vendor/laravolt/indonesia/resources/csv/districts.csv',
            'villages' => 'vendor/laravolt/indonesia/resources/csv/villages',
        ];

        throw_if(
            (
                $path = $paths[$tableName] ?? null
            ) === null,
            'Path is not found'
        );

        return App::basePath($path);
    }

    /**
     * Returns the rows of a CSV file.
     *
     * @param  string  $tableName  The name of the table
     * @param  string[]  $header  The header of the CSV file
     * @return array<int, array<string, mixed>>
     */
    public static function getRows(
        string $tableName,
        array $header
    ): array {
        return self::csvPathToArray(
            self::getPath($tableName),
            $header
        );
    }

    /**
     * Converts a CSV file to an array.
     *
     * @param  string  $path  The path to the CSV file or CSV directory
     * @param  string[]  $header  The header of the CSV file
     * @return array<int, array<string, mixed>>
     */
    private static function csvPathToArray(
        string $path,
        array $header
    ): array {
        if (is_dir($path)) {
            /** @var \Illuminate\Support\Collection<int, \SplFileInfo> $files */
            $files = collect(File::files($path));

            return $files->flatMap(
                fn (
                    \SplFileInfo $file
                ) => Helper::csvToArray(
                    $file->getRealPath(),
                    $header
                )
            )->toArray();
        }

        return Helper::csvToArray(
            $path,
            $header
        );
    }

    /**
     * Converts a CSV file to an array.
     *
     * @param  string  $path  The path to the CSV file
     * @param  string[]  $header  The header of the CSV file
     * @return array<int, array<string, mixed>>
     */
    private static function csvToArray(
        string $path,
        array $header
    ): array {
        throw_if(
            ! file_exists($path) ||
                    ! is_readable($path),
            'File does not exist or is not readable'
        );

        $delimiter = ',';
        $data = [];

        $handle = fopen($path, 'r');

        if ($handle !== false) {
            while (
                (
                    $row = fgetcsv(
                        $handle,
                        1000,
                        $delimiter,
                        escape: '\\'
                    )
                ) !== false
            ) {
                $data[] = array_combine($header, $row);
            }

            fclose($handle);
        }

        return $data;
    }
}

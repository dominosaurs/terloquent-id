<?php

declare(strict_types=1);

namespace TerloquentID\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use RuntimeException;

/**
 * @method static string getCsvPath(string $tableName)
 * @method static array<int, array<string, mixed>> getRows(string $tableName, string[] $headers)
 */
final readonly class TerloquentBaseHelper
{
    /**
     * Returns the path of a CSV file or CSV directory.
     *
     * @param  string  $tableName  The name of the table
     * @return string The full path of the CSV file or CSV directory.
     */
    private function getCsvPath(
        string $tableName,
    ): string {
        return AdministrativeDivisions::getCsvFilePath(
            $tableName
        );
    }

    /**
     * Returns the rows of a CSV file.
     *
     * @param  string  $tableName  The name of the table
     * @param  string[]  $header  The header of the CSV file
     * @return array<int, array<string, mixed>>
     */
    private function getRows(
        string $tableName,
        array $header
    ): array {
        return $this->csvPathToArray(
            $this->getCsvPath($tableName),
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
    private function csvPathToArray(
        string $path,
        array $header
    ): array {
        if (is_dir($path)) {
            /** @var Collection<int, \SplFileInfo> $files */
            $files = collect(File::files($path));

            return $files->flatMap(
                fn (
                    \SplFileInfo $file
                ) => $this->csvToArray(
                    $file->getRealPath(),
                    $header
                )
            )->toArray();
        }

        return $this->csvToArray(
            $path,
            $header
        );
    }

    /**
     * Convert a CSV file to an array of associative rows.
     *
     * @param  string  $path  Path to the CSV file.
     * @param  string[]  $requiredHeaders  Expected header columns.
     * @return array<int, array<string, mixed>>
     *
     * @throws RuntimeException
     */
    private function csvToArray(
        string $path,
        array $requiredHeaders
    ): array {
        if (! is_readable($path)) {
            throw new RuntimeException(
                "CSV file '{$path}' does not exist or is not readable."
            );
        }

        $handle = fopen($path, 'r');
        if ($handle === false) {
            throw new RuntimeException(
                "Failed to open file '{$path}' for reading."
            );
        }

        $headerFromFile = $this->validateHeaders(
            $requiredHeaders,
            $this->readCsvRow($handle),
            $path
        );

        $data = [];

        while ($row = $this->readCsvRow($handle)) {
            $rowAssoc = array_combine(
                $headerFromFile,
                $row
            );

            $data[] = array_intersect_key(
                $rowAssoc,
                array_flip($requiredHeaders)
            );
        }

        fclose($handle);

        return $data;
    }

    /**
     * Read a single row from a CSV handle.
     *
     * @param  resource  $handle
     * @return array<int, string|null>|false
     */
    private function readCsvRow(
        $handle,
        string $delimiter = ',',
        string $escape = '\\'
    ): array|false {
        return fgetcsv(
            $handle,
            1000,
            $delimiter,
            escape: $escape
        );
    }

    /**
     * Validate that all required headers exist in the CSV file.
     *
     * @param  string[]  $required
     * @param  array<string|null>|false  $actual
     * @return string[]
     *
     * @throws RuntimeException
     */
    private function validateHeaders(
        array $required,
        array|false $actual,
        string $path
    ): array {
        if ($actual === false) {
            throw new RuntimeException(
                "Failed to read header row from '{$path}'."
            );
        }

        foreach ($actual as $item) {
            if ($item === null) {
                throw new RuntimeException(
                    "CSV file '{$path}' is missing a header."
                );
            }
        }

        $missing = array_diff($required, $actual);

        if (! empty($missing)) {
            $missingList = implode(', ', $missing);
            throw new RuntimeException(
                "Missing required header(s) in '{$path}': {$missingList}"
            );
        }

        /** @var string[] $actual */
        return $actual;
    }

    /**
     * @param  array<int, mixed>  $arguments
     * @return string|array<int, array<string, mixed>>
     */
    public static function __callStatic(string $name, array $arguments): string|array
    {
        if (! \in_array(
            $name,
            ['getRows', 'getCsvPath'],
            true
        )) {
            throw new \BadMethodCallException(
                'Call to undefined method '.__CLASS__."::{$name}()"
            );
        }

        return (new self)->$name(...$arguments);
    }
}

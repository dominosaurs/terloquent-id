<?php

declare(strict_types=1);

namespace TerloquentID\Exceptions;

use RuntimeException;

final class DataSourceUnavailableException extends RuntimeException
{
    public static function forTable(string $tableName, string $url, ?string $reason = null): self
    {
        $message = "🌐 Failed to download Indonesian administrative data for '{$tableName}' from {$url}.";

        if ($reason) {
            $message .= " Reason: {$reason}";
        }

        $message .= ' Please check your internet connection.';

        return new self($message);
    }
}

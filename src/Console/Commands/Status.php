<?php

declare(strict_types=1);

namespace TerloquentID\Console\Commands;

use Illuminate\Console\Command;
use TerloquentID\Helpers\AdministrativeDivisionDataHelper;

final class Status extends Command
{
    protected $signature = 'terloquent-id:status';

    protected $description = '📊 Show the status of Indonesian administrative division data';

    public function handle(): int
    {
        $status = AdministrativeDivisionDataHelper::status();

        if (! $status['initialized']) {
            $this->warn('🚫 '.$status['message']);

            return self::SUCCESS;
        }

        $this->info('🌏 Administrative division data is ready!');

        $this->table(
            ['🔑 Key', '📄 Value'],
            collect($status)->map(
                fn ($v, $k) => [
                    $k,
                    \is_scalar($v)
                        ? $v : json_encode($v),
                ]
            )->toArray()
        );

        return self::SUCCESS;
    }
}

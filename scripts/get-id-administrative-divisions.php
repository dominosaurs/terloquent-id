#!/usr/bin/env php
<?php

/**
 * Terloquent ID - Auto Fetch Administrative Divisions Data
 *
 * This script clones or updates the Indonesian administrative divisions dataset
 * from https://github.com/sensasi-delight/id-administrative-divisions
 * into the "data/id-administrative-divisions" directory.
 *
 * It runs automatically after composer install or update.
 */

declare(strict_types=1);

$targetDir = __DIR__.'/../resources';
$repoUrl = 'https://github.com/sensasi-delight/id-administrative-divisions.git';

echo PHP_EOL;
echo '📦 Checking Indonesian administrative divisions data...'.PHP_EOL;

if (! is_dir($targetDir)) {
    echo '➡️  Cloning repository from GitHub...'.PHP_EOL;

    $cloneCmd = sprintf(
        'git clone --depth=1 %s %s',
        escapeshellarg($repoUrl),
        escapeshellarg($targetDir)
    );

    runCommand($cloneCmd, 'Failed to clone repository.');
} else {
    echo '🔄 Updating existing data repository...'.PHP_EOL;

    $pullCmd = sprintf('git -C %s pull --quiet', escapeshellarg($targetDir));
    runCommand($pullCmd, 'Failed to update repository.');
}

echo '✅ id-administrative-divisions is ready.'.PHP_EOL.PHP_EOL;

/**
 * Run a shell command safely.
 */
function runCommand(string $command, string $errorMessage): void
{
    $result = null;
    system($command, $result);

    if ($result !== 0) {
        fwrite(STDERR, "❌ {$errorMessage}".PHP_EOL);
        exit(1);
    }
}

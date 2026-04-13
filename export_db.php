<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$filename = "EDocs_Backup_" . date('Y-m-d_H-i-s') . ".sql";
$filePath = __DIR__ . "/" . $filename;

echo "--- Starting Database Backup for: " . config('database.connections.mysql.database') . " ---\n";

try {
    $command = sprintf(
        "mysqldump -u %s %s %s > %s",
        config('database.connections.mysql.username'),
        config('database.connections.mysql.password') ? "-p" . config('database.connections.mysql.password') : '',
        config('database.connections.mysql.database'),
        $filePath
    );

    system($command);

    if (file_exists($filePath)) {
        echo "[SUCCESS] Backup Created: " . $filename . "\n";
        echo "You can now copy this file plus the project to any other device.\n";
    } else {
        echo "[ERROR] Backup failed. Make sure 'mysqldump' is installed and in your PATH.\n";
    }
} catch (Exception $e) {
    echo "[EXCEPTION] " . $e->getMessage() . "\n";
}

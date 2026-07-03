<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (isset($_GET['diagnose'])) {
    header('Content-Type: text/plain');
    echo "--- ENVIRONMENT DIAGNOSTICS ---\n";
    foreach (getenv() as $key => $value) {
        if (stripos($key, 'pass') !== false || stripos($key, 'key') !== false || stripos($key, 'secret') !== false) {
            $value = substr($value, 0, 3) . '***';
        }
        echo "$key=$value\n";
    }
    exit;
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());

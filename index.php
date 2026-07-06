<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// The Laravel application lives in the admin/ folder; this front controller at
// the web root lets Laravel serve the public website (and /admin) as one app.
$base = __DIR__ . '/admin';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $base . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $base . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $base . '/bootstrap/app.php';

$app->handleRequest(Request::capture());

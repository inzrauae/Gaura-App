<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$appRoot = realpath(__DIR__.'/../repo-name/backend');

if ($appRoot === false) {
    http_response_code(500);
    echo 'Application root not found.';
    exit;
}

$maintenance = $appRoot.'/storage/framework/maintenance.php';
if (file_exists($maintenance)) {
    require $maintenance;
}

require $appRoot.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $appRoot.'/bootstrap/app.php';

$app->handleRequest(Request::capture());

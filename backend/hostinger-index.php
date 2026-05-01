<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = '/home/u356242881/library-cms/storage/framework/maintenance.php')) {
    require $maintenance;
}

require '/home/u356242881/library-cms/vendor/autoload.php';

/** @var Application $app */
$app = require_once '/home/u356242881/library-cms/bootstrap/app.php';

$app->handleRequest(Request::capture());

<?php

declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

use App\core\Application;

$envPath = "../.env";
require "../LoadEnv.php";

$config = [
    // Define classes for authentication
    "class" => [
        "userClass" => \App\models\User::class,
        "adminClass" => \App\models\Admin::class,
    ],
    // Database Credentials
    "db" => [
        "dsn" => $data["DB_DSN"],
        "user" => $data["DB_USER"],
        "password" => $data["DB_PASSWORD"],
    ]
];

//set Application dependencies
include_once "../core/AppServiceProvider.php";

/**
 * Create new Application instance
 */
$app = new Application(dirname(__DIR__), $config);

// User routes
include_once "../routes/user.php";

// Admin routes
include_once "../routes/admin.php";

//runs the resolve method from Router.php after all requests are done
$app->run();

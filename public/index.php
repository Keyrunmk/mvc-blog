<?php

declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

use App\core\Application;
use App\core\AppResolver;

$envPath = "../.env";
require "../LoadEnv.php";

$config = [
    // Define classes for authentication
    "class" => [
        "userClass" => \App\models\User::class,
        "adminClass" => \App\models\Admin::class,
    ],
    // Database credentials
    "db" => [
        "dsn" => $data["DB_DSN"],
        "user" => $data["DB_USER"],
        "password" => $data["DB_PASSWORD"],
    ]
];

// Set Application dependencies
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
$appResolver = new AppResolver();

$appResolver->run();
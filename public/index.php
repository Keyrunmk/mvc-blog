<?php

require_once __DIR__ . "/../vendor/autoload.php";

use app\core\Application;

$envPath = "../.env";
require "../LoadEnv.php";

$config = [
    "class" => [
        "userClass" => \app\models\User::class,
        "adminClass" => \app\models\Admin::class,
    ],
    "db" => [
        "dsn" => $data["DB_DSN"],
        "user" => $data["DB_USER"],
        "password" => $data["DB_PASSWORD"],
    ]
];

//set application dependencies
include_once "../core/appServiceContainer.php";

/**
 * Create new application instance
 */
$app = new Application(dirname(__DIR__), $config);

include_once "../routes/user.php";

include_once "../routes/admin.php";

//runs the resolve method from Router.php after all requests are done
$app->run();
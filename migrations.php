<?php

require_once __DIR__.'/vendor/autoload.php';

use app\core\Application;

$envPath = ".env";
include 'LoadEnv.php';

$config = [
    'db' => [
        'dsn' => $data['DB_DSN'],
        'user' => $data['DB_USER'],
        'password' => $data['DB_PASSWORD'],
    ]
];

$app = new Application(__DIR__, $config);

$app->dbMigration->applyMigrations();
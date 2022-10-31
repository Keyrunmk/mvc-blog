<?php

declare(strict_types=1);

use App\core\controllers\admin\AdminController;
use App\core\controllers\admin\CategoryController;
use App\core\controllers\admin\LoginController;
use App\core\controllers\admin\PostController;

/**
 * ADMIN ROUTES
 * @param array e.g ("path", [Controller::class, "home"]);
 */
$app->router->group(["prefix" => "/admin"], function () use ($app) {
    $app->router->get("/login", [LoginController::class, "showLoginForm"]);
    $app->router->post("/login", [LoginController::class, "login"]);
    $app->router->get("/logout", [LoginController::class, "logout"]);
});

$app->router->group(["prefix" => "/admin", "middleware" => ["authAdmin"]], function () use ($app) {
    $app->router->get("", [AdminController::class, "index"]);

    $app->router->get("/dashboard", [AdminController::class, "dashboard"]);
    $app->router->get("/settings", [AdminController::class, "settings"]);

    $app->router->group(["prefix" => "category"], function () use ($app) {
        $app->router->get("", [CategoryController::class, "index"]);
        $app->router->get("/create", [CategoryController::class, "create"]);
        $app->router->post("/store", [CategoryController::class, "store"]);
        $app->router->get("/update", [CategoryController::class, "update"]);
        $app->router->post("/update", [CategoryController::class, "update"]);
        $app->router->get("/delete", [CategoryController::class, "delete"]);
    });

    $app->router->group(["prefix" => "posts"], function () use ($app) {
        $app->router->get("", [PostController::class, "index"]);
        $app->router->get("/create", [PostController::class, "create"]);
        $app->router->post("/store", [PostController::class, "store"]);
        $app->router->get("/update", [PostController::class, "update"]);
        $app->router->post("/update", [PostController::class, "update"]);
        $app->router->get("/delete", [PostController::class, "delete"]);
    });
});

<?php

declare(strict_types=1);

use App\core\controllers\admin\AdminController;
use App\core\controllers\admin\CategoryController;
use App\core\controllers\admin\LoginController;
use App\core\controllers\admin\PostController;
use App\core\Router;

/**
 * ADMIN ROUTES
 * @param array e.g ("path", [Controller::class, "home"]);
 */
Router::group(["prefix" => "/admin"], function () {
    Router::get("/login", [LoginController::class, "showLoginForm"]);
    Router::post("/login", [LoginController::class, "login"]);
    Router::get("/logout", [LoginController::class, "logout"]);
});

Router::group(["prefix" => "/admin", "middleware" => ["authAdmin"]], function () {
    Router::get("", [AdminController::class, "index"]);

    Router::get("/dashboard", [AdminController::class, "dashboard"]);
    Router::get("/settings", [AdminController::class, "settings"]);

    Router::group(["prefix" => "/category"], function () {
        Router::get("", [CategoryController::class, "index"]);
        Router::get("/create", [CategoryController::class, "create"]);
        Router::post("/store", [CategoryController::class, "store"]);
        Router::get("/update", [CategoryController::class, "update"]);
        Router::post("/update", [CategoryController::class, "update"]);
        Router::get("/delete", [CategoryController::class, "delete"]);
    });

    Router::group(["prefix" => "/posts"], function () {
        Router::get("", [PostController::class, "index"]);
        Router::get("/create", [PostController::class, "create"]);
        Router::post("/store", [PostController::class, "store"]);
        Router::get("/update", [PostController::class, "update"]);
        Router::post("/update", [PostController::class, "update"]);
        Router::get("/delete", [PostController::class, "delete"]);
    });
});

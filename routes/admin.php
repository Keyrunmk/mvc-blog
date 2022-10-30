<?php

declare(strict_types=1);

use App\controllers\admin\AdminController;
use App\controllers\admin\CategoryController;
use App\controllers\admin\LoginController;
use App\controllers\admin\PostController;

/**
 * ADMIN ROUTES
 * @param array e.g ("path", [Controller::class, "home"]);
 */
$app->router->group(["prefix" => "admin", "middleware" => "auth"], function () use ($app) {
    $app->router->get("", [AdminController::class, "index"]);

    $app->router->get("/login", [LoginController::class, "showLoginForm"]);
    $app->router->post("/login", [LoginController::class, "login"]);
    $app->router->get("/logout", [LoginController::class, "logout"]);

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
    // $app->router->get("category", [CategoryController::class, "index"]);
    // $app->router->get("category/create", [CategoryController::class, "create"]);
    // $app->router->post("category/store", [CategoryController::class, "store"]);
    // $app->router->get("category/update", [CategoryController::class, "update"]);
    // $app->router->post("category/update", [CategoryController::class, "update"]);
    // $app->router->get("category/delete", [CategoryController::class, "delete"]);

    $app->router->group(["prefix" => "posts"], function () use ($app){
        $app->router->get("", [PostController::class, "index"]);
        $app->router->get("/create", [PostController::class, "create"]);
        $app->router->post("/store", [PostController::class, "store"]);
        $app->router->get("/update", [PostController::class, "update"]);
        $app->router->post("/update", [PostController::class, "update"]);
        $app->router->get("/delete", [PostController::class, "delete"]);
    });

    // $app->router->get("posts", [PostController::class, "index"]);
    // $app->router->get("posts/create", [PostController::class, "create"]);
    // $app->router->post("posts/store", [PostController::class, "store"]);
    // $app->router->get("posts/update", [PostController::class, "update"]);
    // $app->router->post("posts/update", [PostController::class, "update"]);
    // $app->router->get("posts/delete", [PostController::class, "delete"]);
});

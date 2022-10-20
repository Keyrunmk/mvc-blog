<?php

declare(strict_types=1);

use app\controllers\admin\AdminController;
use app\controllers\admin\CategoryController;
use app\controllers\admin\LoginController;
use app\controllers\admin\PostController;

/**
 * ADMIN ROUTES
 * @param array e.g ("/", [Controller::class, "home"]);
 */
$app->router->get("/admin", [AdminController::class, "index"]);

//admin login
$app->router->get("/admin/login", [LoginController::class, "showLoginForm"]);
$app->router->post("/admin/login", [LoginController::class, "login"]);
$app->router->get("/admin/logout", [LoginController::class, "logout"]);

$app->router->get("/admin/category", [CategoryController::class, "index"]);
$app->router->get("/admin/category/create", [CategoryController::class, "create"]);
$app->router->post("/admin/category/store", [CategoryController::class, "store"]);
$app->router->get("/admin/category/update", [CategoryController::class, "update"]);
$app->router->post("/admin/category/update", [CategoryController::class, "update"]);
$app->router->get("/admin/category/delete", [CategoryController::class, "delete"]);

$app->router->get("/admin/posts", [PostController::class, "index"]);
$app->router->get("/admin/posts/create", [PostController::class, "create"]);
$app->router->post("/admin/posts/store", [PostController::class, "store"]);
$app->router->get("/admin/posts/update", [PostController::class, "update"]);
$app->router->post("/admin/posts/update", [PostController::class, "update"]);
$app->router->get("/admin/posts/delete", [PostController::class, "delete"]);
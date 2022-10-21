<?php

declare(strict_types=1);

use app\controllers\user\SiteController;
use app\controllers\user\UserLoginController;

/**
 * ROUTES
 * @param array e.g ("/", [Controller::class, "home"]);
 */
$app->router->get("/", [SiteController::class, "home"]);
$app->router->get("/posts", [SiteController::class, "showPosts"]);

//login routes
$app->router->get("/login", [UserLoginController::class, "login"]);
$app->router->post("/login", [UserLoginController::class, "login"]);

//register routes
$app->router->get("/register", [UserLoginController::class, "register"]);
$app->router->post("/register", [UserLoginController::class, "register"]);

//logout
$app->router->get("/logout", [UserLoginController::class, "logout"]);

//profile routes
$app->router->get("/profile", [UserLoginController::class, "profile"]);
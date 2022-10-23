<?php

declare(strict_types=1);

use App\controllers\user\SiteController;
use App\controllers\user\UserLoginController;

/**
 * ROUTES
 * @param array e.g ("path", [Controller::class, "home"]);
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

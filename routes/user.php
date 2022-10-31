<?php

declare(strict_types=1);

use App\core\controllers\user\SiteController;
use App\core\controllers\user\UserLoginController;

/**
 * ROUTES
 * @param array e.g ("path", [Controller::class, "home"]);
 */
$app->router->group(["prefix" => "/test", "middleware" => "authUser"], function () use ($app) {
    $app->router->get("/b", function(){
        var_dump("success from b");
        exit;
    });
    $app->router->get("/a", function () {
        var_dump("success from a");
        exit;
    });
});
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

<?php

declare(strict_types=1);

use App\core\controllers\user\SiteController;
use App\core\controllers\user\UserLoginController;
use App\core\Router;

/**
 * ROUTES
 * @param array e.g ("path", [Controller::class, "home"]);
 */
Router::group(["prefix" => "/test", "middleware" => "authUser"], function () {
    Router::get("/b", function () {
        var_dump("success from b");
        exit;
    });
    Router::get("/a", function () {
        var_dump("success from a");
        exit;
    });
});
Router::get("/", [SiteController::class, "home"]);
Router::get("/posts", [SiteController::class, "showPosts"]);

//login routes
Router::get("/login", [UserLoginController::class, "login"]);
Router::post("/login", [UserLoginController::class, "login"]);

//register routes
Router::get("/register", [UserLoginController::class, "register"]);
Router::post("/register", [UserLoginController::class, "register"]);

//logout
Router::get("/logout", [UserLoginController::class, "logout"]);

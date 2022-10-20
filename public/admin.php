<?php

use app\controllers\admin\AdminController;
use app\controllers\admin\LoginController;
use app\core\Application;

//admin routes
$app->router->get('/admin', [AdminController::class, '   ']);

//admin login
$app->router->get('/admin/login', [LoginController::class, 'showLoginForm']);
$app->router->post('/admin/login', [LoginController::class, 'login']);
$app->router->get('/admin/logout', [LoginController::class, 'logout']);

<?php

declare(strict_types=1);

namespace App\controllers\admin;

use App\core\Application;
use App\core\Controller;
use App\core\middlewares\AdminAuthenticationMiddleware;
use App\core\middlewares\RoleMiddleware;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->layout = "admin/app";
        $this->registerMiddleware(new AdminAuthenticationMiddleware("admin", []));
        $this->registerMiddleware(new RoleMiddleware(Application::$app->admin, ["page-admin"]));
    }

    public function dashboard()
    {
        echo("hello from dashboard");
    }

    public function index(): string
    {
        // $admin = Application::$app->admin;
        // var_dump($admin->hasRole("page-admin"));
        // var_dump($admin->hasPermission("manage-page"));
        // exit;
        return $this->render("admin/dashboard/index");
    }

    public function settings()
    {
        echo("hello from settings");
    }
}

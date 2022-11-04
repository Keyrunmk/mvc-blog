<?php

declare(strict_types=1);

namespace App\core\controllers\admin;

use App\core\Application;
use App\core\Controller;
use App\core\middlewares\AdminAuthenticationMiddleware;
use App\core\middlewares\RoleMiddleware;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->layout = "admin/app";
        $this->registerMiddleware(new RoleMiddleware(Application::$app->admin, ["page-admin"]));
    }

    public function dashboard(): void
    {
        echo("hello from dashboard");
    }

    public function index(): string
    {
        return $this->render("admin/dashboard/index");
    }

    public function settings(): void
    {
        echo("hello from settings");
    }
}

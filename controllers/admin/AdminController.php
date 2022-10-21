<?php

declare(strict_types=1);

namespace app\controllers\admin;

use app\core\Controller;
use app\core\middlewares\AdminAuthenticationMiddleware;
use app\core\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->layout = "admin/app";
        $this->registerMiddleware(new AdminAuthenticationMiddleware("admin", []));
    }

    public function index(): string
    {
        return $this->render("admin/dashboard/index");
    }
}
<?php

declare(strict_types=1);

namespace App\controllers\admin;

use App\core\Controller;
use App\core\middlewares\AdminAuthenticationMiddleware;

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

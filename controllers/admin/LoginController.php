<?php

declare(strict_types=1);

namespace App\controllers\admin;

use App\core\Controller;
use App\core\LoginHelper;
use App\core\Request;
use App\core\Response;
use App\core\traits\ValidationTrait;
use App\models\Admin;

class LoginController extends Controller
{
    use ValidationTrait;

    protected Admin $model;

    public function __construct()
    {
        $this->model = new Admin();
    }

    public function showLoginForm(): void
    {
        $this->renderView("admin/auth/login");
    }

    public function login(Request $request, Response $response): string
    {
        $this->model->loadData($request->getBody());

        if ($this->validate([
            "email" => ["required", "email"],
            "password" => ["required", ["min" => 8]],
        ]) && LoginHelper::login($this->model, "admin")) {
            $response->redirect("/admin");
        }

        return $this->renderView("admin/auth/login", [
            "model" => $this->model,
            "errors" => "Fail",
        ]);
    }

    public function logout(Request $request, Response $response): void
    {
        LoginHelper::logout("admin");
        $response->redirect("/admin/login");
    }
}

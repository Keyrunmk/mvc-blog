<?php

namespace App\core\middlewares;

use App\core\Application;
use App\core\LoginHelper;

class AdminAuthenticationMiddleware extends BaseMiddleware
{
    public function __construct(string $model, array|string $actions = [])
    {
        $this->model = $model;
        $this->actions = $actions;
    }

    public function execute()
    {
        if (LoginHelper::isAdminGuest($this->model)) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                return $this->route()->redirect('/admin/login');
            }
        }
    }

    public function route()
    {
        return Application::$app->response;
    }
}

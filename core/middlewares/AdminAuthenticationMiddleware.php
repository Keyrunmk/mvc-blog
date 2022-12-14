<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\LoginHelper;

class AdminAuthenticationMiddleware extends BaseMiddleware
{
    public function __construct(string $model, array|string|null $actions = [])
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

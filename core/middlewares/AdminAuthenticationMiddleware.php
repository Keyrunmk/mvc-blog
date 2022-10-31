<?php

namespace App\core\middlewares;

use App\core\Application;
use App\core\LoginHelper;
use App\models\Admin;

class AdminAuthenticationMiddleware extends BaseMiddleware
{
    public Admin $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function execute()
    {
        if (LoginHelper::isAdminGuest("admin")) {
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

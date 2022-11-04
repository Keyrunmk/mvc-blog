<?php

namespace App\core\middlewares;

use App\core\Application;
use App\core\LoginHelper;
use App\core\Response;
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
        if (LoginHelper::isGuest("admin")) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                return Response::redirect('/admin/login');
            }
        }
    }
}

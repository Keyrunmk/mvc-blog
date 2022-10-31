<?php

namespace App\core\middlewares;

use App\core\Application;
use App\core\exception\ForbiddenException;
use App\core\LoginHelper;
use App\models\User;

class UserAuthenticationMiddleware extends BaseMiddleware
{
    public array $actions = [];

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function execute()
    {
        if (LoginHelper::isGuest("user")) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}

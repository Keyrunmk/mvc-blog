<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exception\ForbiddenException;
use app\core\LoginHelper;

class UserAuthenticationMiddleware extends BaseMiddleware
{
    public array $actions = [];

    public string $model;

    public function __construct(string $model, array $actions = [])
    {
        $this->model = $model;
        $this->actions = $actions;
    }

    public function execute()
    {
        if (LoginHelper::isGuest($this->model)) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }
}

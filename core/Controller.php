<?php

declare(strict_types=1);

namespace app\core;

use app\core\Application;
use app\core\middlewares\BaseMiddleware;

class Controller
{
    public string $layout = "layouts/main";
    public string $action = '';

    /**
     * @var \app\core\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function setLayout(String $layout)
    {
        $this->layout = $layout;
    }

    public function render(string $view, array|Object $params = []): String
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function renderView(string $view, Array $params = []): mixed
    {
        return Application::$app->view->renderSingleView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return \app\core\middlewares\BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}

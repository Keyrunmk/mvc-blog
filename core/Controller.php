<?php

declare(strict_types=1);

namespace App\core;

use App\core\Application;
use App\core\middlewares\BaseMiddleware;
use App\core\traits\ValidationTrait;

class Controller
{
    use ValidationTrait;

    public string $layout = "layouts/main";
    public string $action = '';

    /**
     * @var \App\core\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function setLayout(String $layout)
    {
        $this->layout = $layout;
    }

    public function render(string $view, array $params = []): String
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function renderView(string $view, array $params = []): mixed
    {
        return Application::$app->view->renderSingleView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return \App\core\middlewares\BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}

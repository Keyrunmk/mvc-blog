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

    protected array $middlewares = [];

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function render(string $view, array $params = []): string
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function renderView(string $view, array $params = []): mixed
    {
        return Application::$app->view->renderSingleView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}

<?php

declare(strict_types=1);

namespace App\core;

use App\core\exception\NotFoundException;
use App\core\Request;
use App\core\singletons\Container;
use Closure;

class Router
{
    protected Request $request;
    protected Response $response;
    private Container $container;

    protected array $routes = [];

    public function __construct(Request $request, Response $response, Container  $container)
    {
        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
    }

    public function get(string $path, array|Closure|string $callback): void
    {
        $this->routes["get"][$path] = $callback;
    }

    public function post(string $path, array $callback): void
    {
        $this->routes["post"][$path] = $callback;
    }

    public function resolve(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            throw new NotFoundException();
        }

        // if callback is just a stirng....this will assume it a view file name and render that
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        if (is_array($callback)) {
            $controller = $this->container->get($callback[0]);

            Application::$app->controller = $controller;
            $controller->action = $callback[1];

            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);
    }
}

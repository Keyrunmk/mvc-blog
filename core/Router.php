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
    protected Container $container;
    protected array $prefix = [];

    protected array $routes = [];

    protected array $routeMiddlewares = [];

    public function __construct(Request $request, Response $response, Container  $container)
    {
        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
    }

    public function group(array $data, Closure $closure): mixed
    {
        if (in_array("prefix", array_keys($data))) {
            $this->prefix[] = $data["prefix"];
            if (in_array("middleware", array_keys($data))) {
                $this->routeMiddlewares[] = $data["middleware"];
            }
            call_user_func($closure);
            array_pop($this->prefix);
            array_pop($this->routeMiddlewares);
            return true;
        }
        return call_user_func($closure);
    }

    public function get(string $path, array|Closure|string $callback): void
    {
        if ($this->prefix) {
            $this->routes["get"][implode("/", $this->prefix) . "$path"] = $this->addCallback($callback);
        } else {
            $this->routes["get"][$path] = $this->addCallback($callback);
        }
    }

    public function post(string $path, array $callback): void
    {
        if ($this->prefix) {
            $this->routes["post"][implode("/", $this->prefix) . "$path"] = $this->addCallback($callback);
        } else {
            $this->routes["post"][$path] = $this->addCallback($callback);
        }
    }

    private function addCallback($callback): array
    {
        if ($this->routeMiddlewares) {
            return [
                "callback" => $callback,
                "middleware" => $this->routeMiddlewares,
            ];
        }
        return $callback;
    }

    public function resolve(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->checkForMiddleware($this->routes[$method][$path] ?? false);

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

    protected function checkForMiddleware(array|bool $data): mixed
    {
        if (isset($data["middleware"][0])) {
            $middlewares = $data["middleware"][0];
            if (is_string($middlewares)) {
                $this->container->get($middlewares)->execute();
                return $data["callback"];
            }
            foreach ($middlewares as $middleware) {
                $this->container->get($middleware)->execute();
            }
            return $data["callback"];
        }
        return $data;
    }
}

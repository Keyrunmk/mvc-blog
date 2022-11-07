<?php

declare(strict_types=1);

namespace App\core;

use App\core\exception\NotFoundException;
use App\core\Router;
use App\core\singletons\Dependency;

class RouteResolver extends Router
{
    private Request $request;
    private Dependency $dependency;
    private Response $response;

    public function __construct(Request $request, Response $response, Dependency $dependency)
    {
        $this->request = $request;
        $this->response = $response;
        $this->dependency = $dependency;
    }

    public function resolve(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->checkForMiddleware(self::$routes[$method][$path] ?? false);

        if ($callback === false) {
            throw new NotFoundException();
        }

        // if callback is just a stirng....this will assume it a view file name and render that
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        if (is_array($callback)) {
            $controller = $this->dependency->get($callback[0]);

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
                $this->dependency->get($middlewares)->execute();
                return $data["callback"];
            }
            foreach ($middlewares as $middleware) {
                $this->dependency->get($middleware)->execute();
            }
            return $data["callback"];
        }
        return $data;
    }
}

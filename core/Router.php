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
    private static array $prefix = [];

    protected static array $routes = [];

    public function __construct(Request $request, Response $response, Container  $container)
    {
        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
    }

    public static function group(array $data, Closure $callback)
    {
        if (in_array("prefix", array_keys($data))) {
            if (count(self::$prefix)>1) {
                self::$prefix = [self::$prefix[0]];
            }
            self::$prefix[] = $data["prefix"];
            return call_user_func($callback);
            // if (in_array("middleware", array_keys($data))) {
            //     var_dump($data["middleware"]);
            //     exit;
            // }
        }
    }

    public static function get(string $path, array|Closure|string $callback): void
    {
        if (self::$prefix) {
            self::$routes["get"]["/" . implode("/", self::$prefix) . "$path"] = $callback;
        } else {
            self::$routes["get"][$path] = $callback;
        }
    }

    public static function post(string $path, array $callback): void
    {
        if (self::$prefix) {
            self::$routes["post"]["/" . implode("/", self::$prefix) . "$path"] = $callback;
        } else {
            self::$routes["post"][$path] = $callback;
        }
    }

    public function resolve(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = self::$routes[$method][$path] ?? false;
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

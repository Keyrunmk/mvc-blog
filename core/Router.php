<?php

declare(strict_types=1);

namespace app\core;

use app\core\exception\NotFoundException;
use app\core\Request;
use app\core\singletons\Container;
use Closure;

class Router
{
    public Request $request;

    public Response $response;

    protected array $routes = [];

    public function __construct(Request $request, Response $response, private Container  $container)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Returns the function passed from index.php, e.g. [SiteController::class,"contact"]
     */
    public function get(string $path,array|Closure|string $callback)
    {
        $this->routes["get"][$path] = $callback;
    }

    /**
     * Returns the same as get but with post as it"s first associative array content
     */
    public function post(string $path,array $callback)
    {
        $this->routes["post"][$path] = $callback;
    }

    public function resolve()
    {
        //returns the pathname as string without requests
        $path = $this->request->getPath();

        //returns the request method in lowercase
        $method = $this->request->method();

        //returns the path and method as array contents, if there is no method it returns false
        $callback = $this->routes[$method][$path] ?? false;

        //if the $callback returns false, set response to 404 error and load 404 error page
        if ($callback === false) {
            throw new NotFoundException();
        }

        // if callback is just a stirng....this will assume view file name and render that  
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        //if the callback is an array, replace the first array content with the mentioned class instance
        //e.g. ["SiteController::class","contact"] in this case the "SiteController::class" is replaced with new SiteController class instace
        if (is_array($callback)) {
            $controller = $this->container->get($callback[0]);

            Application::$app->controller = $controller;
            $controller->action = $callback[1];

            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }

        //this will call the SiteController class from the array and take the second argument i.e. contact is the case as the argument 
        return call_user_func($callback, $this->request, $this->response);
    }
}
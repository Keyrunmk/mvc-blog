<?php

declare(strict_types=1);

namespace App\core;

use App\core\singletons\Dependency;
use Throwable;

class AppResolver
{
    public Request $request;
    public Response $response;
    public Dependency $dependency;
    public RouteResolver $routeResolver;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->dependency = Dependency::getInstance();
        $this->routeResolver = new RouteResolver($this->request, $this->response, $this->dependency);
    }

    public function run()
    {
        try {
            echo $this->routeResolver->resolve();
        } catch (\Exception | Throwable $e) {
            Response::setStatusCode((int) $e->getCode());
            echo Application::$app->view->renderView("_error", [
                "exception" => $e
            ]);
        }
    }
}

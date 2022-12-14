<?php

declare(strict_types=1);

namespace app\core;

use app\core\db\Database;
use app\core\db\DBMigrations;
use app\core\Request;
use app\core\singletons\Container;

class Application
{
    public static string $ROOT_DIR;

    public static Application $app;
    public string $layout = "layouts/main";
    public string $userClass;
    public string $adminClass;

    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public DBMigrations $dbMigration;
    public Session $session;
    public View $view;
    public Container $container;

    public ?Model $model;
    public ?Controller $controller = null;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->container = Container::getInstance();
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response, $this->container);
        $this->view = new View();

        $this->db = new Database($config["db"]);
        $this->dbMigration = new DBMigrations($config["db"]);

        if (isset($config["class"])) {
            $this->setClass($config["class"]);
            $this->setModel("user", $this->userClass);
            $this->setModel("admin", $this->adminClass);
        }
    }

    private function setClass(Array $class): void
    {
        foreach ($class as $key => $value) {
            $this->$key = $value;
        }
    }

    private function setModel(string $model, $class): void
    {
        $primaryValue = $this->session->get($model);
        if ($primaryValue) {
            $primaryKey = $class::primaryKey();
            $this->$model = $class::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->$model = null;
        }
    }

    /**
     * @return \app\core\Controller $controller
     */
    public function getController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return \app\core\controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    //this runs after all requests are done
    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode((int) $e->getCode());
            echo $this->view->renderView("_error", [
                "exception" => $e
            ]);
        }
    }
}
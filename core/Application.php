<?php

declare(strict_types=1);

namespace App\core;

use App\core\db\Database;
use App\core\db\DBMigrations;

class Application
{
    //static props
    public static string $ROOT_DIR;
    public static Application $app;

    //props
    public string $layout = "layouts/main";
    public string $userClass;
    public string $adminClass;

    //class props
    public Database $db;
    public DBMigrations $dbMigration;
    public Session $session;
    public View $view;

    //nullable props
    public ?Model $model = null;
    public ?Controller $controller = null;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->session = new Session();
        $this->view = new View();

        // $this->db = new Database($config["db"]);
        $this->db = Database::getInstance($config["db"]);
        $this->dbMigration = new DBMigrations($this->db);

        if (isset($config["class"])) {
            $this->setClass($config["class"]);
            $this->setModel("user", $this->userClass);
            $this->setModel("admin", $this->adminClass);
        }
    }

    private function setClass(array $class): void
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
     * @return \App\core\Controller $controller
     */
    public function getController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return \App\core\controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }
}

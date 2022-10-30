<?php

declare(strict_types=1);

namespace App\controllers\user;

use App\core\Controller;
use App\core\db\DBModel;
use App\core\exception\ValidationException;
use App\core\LoginHelper;
use App\core\middlewares\UserAuthenticationMiddleware;
use App\core\Request;
use App\core\Response;
use App\core\traits\ValidationTrait;
use App\models\User;

class UserLoginController extends Controller
{
    use ValidationTrait;

    protected DBModel $model;

    public function __construct()
    {
        $this->registerMiddleware(new UserAuthenticationMiddleware("user", ["profile"]));
        $this->model = new User();
    }

    public function login(Request $request, Response $response): string
    {
        if ($request->isPost()) {
            $this->model->loadData($request->getBody());
            $validate = $this->validate([
                "email" => ["required", "email",],
                "password" => ["required", ["min" => 8]],
            ]);
            if ($validate && LoginHelper::login($this->model, "user")) {
                var_dump($this->errors);
                $response->redirect("/");
            }
            throw new ValidationException($this->errors);
        }
        return $this->render("login", [
            "model" => $this->model,
        ]);
    }

    public function register(Request $request, Response $response): mixed
    {
        //check if the key of request matches the properties defined in the model class
        if ($request->method() === "post") {
            $this->model->loadData($request->getBody());

            //send the reqeusts for validation and if the the request is registered return success
            if ($this->validate([
                "firstname" => ["required"],
                "lastname" => ["required"],
                "email" => ["required", "email"],
                "password" => ["required", ["min" => 8]],
            ])) {
                // $this->hashPassword();
                if ($this->model->save($request->getBody())) {
                    $response->message("Thank you for registering");
                    $response->redirect("/");
                }
            }
            var_dump($this->errors);
        }

        return $this->render("register", [
            "model" => $this->model,
        ]);
    }

    public function logout(Request $request, Response $response): void
    {
        LoginHelper::logout("user");
        $response->redirect("/");
    }

    public function profile(): string
    {
        return $this->render("profile");
    }
}

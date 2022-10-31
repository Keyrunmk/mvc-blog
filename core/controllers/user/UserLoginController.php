<?php

declare(strict_types=1);

namespace App\core\controllers\user;

use App\core\Controller;
use App\core\exception\ValidationException;
use App\core\LoginHelper;
use App\core\Request;
use App\core\Response;
use App\models\User;

class UserLoginController extends Controller
{
    //store model in $model variable for validation purpose
    protected User $model;

    public function __construct()
    {
        $this->model = new User();
        $this->layout = "layouts/auth";
    }

    public function login(Request $request, Response $response): string
    {
        if ($request->isPost()) {
            $this->model->loadData($request->getBody());
            $validate = $this->validate([
                "email" => ["required", "email",],
                "password" => ["required", ["min" => 8]],
            ]);
            $login = LoginHelper::login($this->model, "user");
            if ($validate && $login) {
                return $response->redirect("/");
            }
            throw new ValidationException($this->errors);
        }
        return $this->render("login");
    }

    public function register(Request $request, Response $response): mixed
    {
        //check if the key of request matches the properties defined in the model class
        if ($request->method() === "post") {
            $this->model->loadData($request->getBody());

            //send the reqeusts for validation and if the the request is registered return success
            $validate = $this->validate([
                "firstname" => ["required"],
                "lastname" => ["required"],
                "email" => ["required", "email"],
                "password" => ["required", ["min" => 8]],
            ]);

            if ($validate) {
                // $this->hashPassword();
                $save = $this->model->save($request->getBody());

                if ($save) {
                    return $response->redirect("/");
                }
            }
            throw new ValidationException($this->errors);
        }

        return $this->render("register");
    }

    public function logout(Request $request, Response $response): void
    {
        LoginHelper::logout("user");
        $response->redirect("/");
    }
}

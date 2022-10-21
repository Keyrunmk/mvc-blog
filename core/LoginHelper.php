<?php

declare(strict_types=1);

namespace app\core;

use app\core\Application;
use app\core\db\DBModel;
use app\core\exception\ValidationException;

class LoginHelper
{
    public static string $email = '';
    public static string $password = '';

    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function isGuest(string $model): bool
    {
        return !Application::$app->$model;
    }

    public static function isAdminGuest(): bool
    {
        return !Application::$app->admin;
    }

    public static function logout($model)
    {
        $app = Application::$app;
        $app->$model = null;
        $app->session->remove($model);
    }

    public static function login(DBModel $model, string $class): bool
    {
        $app = Application::$app;

        self::$email = $model->email;
        self::$password = password_hash($model->password, PASSWORD_DEFAULT);

        $model = $model::findOne(['email' => self::$email]);
        if (!$model) {
            $error = ['email' => "$class does not exits with this email address"];
            throw new ValidationException($error);
        }
        if (!password_verify($model->password, self::$password)) {
            $error = ['password' => "Password is incorrect"];
            throw new ValidationException($error);
        }

        $app->$class = $model;
        $primaryKey = $model->primaryKey();
        $primaryValue = $model->$primaryKey;
        
        $app->session->set($class, $primaryValue);
        return true;
    }
}

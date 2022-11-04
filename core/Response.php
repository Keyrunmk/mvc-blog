<?php

declare(strict_types=1);

namespace App\core;

class Response
{
    public string $message = "";

    public static function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public static function redirect(string $url): void
    {
        header("Location: $url");
    }
}

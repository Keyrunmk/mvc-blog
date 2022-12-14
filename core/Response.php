<?php

namespace app\core;

class Response
{
    public string $message = "";

    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function message(string $msg): void
    {
        $this->message = $msg;
    }

    public function redirect(string $url): void
    {
        header("Location: $url");
    }
}

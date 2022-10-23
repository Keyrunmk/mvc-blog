<?php

declare(strict_types=1);

namespace App\core\exception;

use App\core\Response;
use Exception;

class ValidationException extends Exception
{
    protected array $errors;
    protected Response $response;

    public function __construct(array $errors)
    {
        $this->response = new Response();
        $this->response->setStatusCode(400);
        $this->errors = $errors;
        $this->dump();
    }

    public function dump()
    {
        var_dump("<pre>");
        foreach ($this->errors as $key => $error) {
            var_dump($key);
            if (!is_array($error)) {
                var_dump($error);
            } else {
                foreach ($error as $e) {
                    var_dump($e);
                }
            }
            var_dump("<br>");
        }
        var_dump("</pre>");
        exit;
    }
}

<?php

namespace app\core\exception;

use Exception;

class ValidationException extends Exception
{
    protected array $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
        $this->dump();
    }

    public function dump()
    {
        var_dump("<pre>");
        foreach ($this->errors as $error) {
            var_dump($error);
        }
        var_dump("</pre>");
        exit;
    }
}

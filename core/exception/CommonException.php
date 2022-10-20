<?php

namespace app\core\exception;

use Exception;

class CommonException extends Exception
{
    public function dump()
    {
        var_dump("<pre>");
        var_dump($this->code);
        var_dump($this->message);
        var_dump("</pre>");
    }
}
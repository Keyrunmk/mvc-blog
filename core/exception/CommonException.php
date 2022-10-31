<?php

declare(strict_types=1);

namespace App\core\exception;

class CommonException extends \Exception
{
    public function dump(): void
    {
        var_dump("<pre>");
        var_dump($this->code);
        var_dump($this->message);
        var_dump("</pre>");
    }
}

<?php

declare(strict_types=1);

namespace app\core\exception;

class NotFoundException extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;
}
<?php

namespace App\Exceptions;

use Exception;

class ApiExecption extends Exception
{
    public function report()
    {
        
    }

    public function render($request)
    {
        return parent::render($request, $exception);
    }
}

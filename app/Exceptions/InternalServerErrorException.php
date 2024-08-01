<?php

namespace App\Exceptions;

use Exception;

class InternalServerErrorException extends Exception
{
    public function __construct($message = 'Internal Server Error', $code = 500)
    {
        parent::__construct($message, $code);
    }

    public function render($request)
    {
        return response()->json([
            'code' => $this->getCode(),
            'status' => 'INTERNAL SERVER ERROR',
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}

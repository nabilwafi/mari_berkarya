<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public function __construct($message = 'Resource not found', $code = 404)
    {
        parent::__construct($message, $code);
    }

    public function render($request)
    {
        return response()->json([
            'code' => 404,
            'status' => 'NOT FOUND',
            'message' => $this->getMessage()
        ], 404);
    }
}

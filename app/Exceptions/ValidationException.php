<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException as LaravelValidationException;

class ValidationException extends LaravelValidationException
{
    public function __construct(Validator $validator)
    {
        parent::__construct($validator);
    }

    public function render($request)
    {
        return response()->json([
            'code' => 400,
            'status' => 'BAD REQUEST',
            'errors' => $this->validator->errors()
        ], 400);
    }
}

<?php

namespace App\Exceptions;

use Exception;

class AuthenticationException extends Exception
{
   
    protected $statusCode;
    public function __construct($message = "Unauthorized", $statusCode = 401)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => false,
                'response_code' => $this->statusCode,
                'message' => $this->getMessage(),
                'data' => null
            ], $this->statusCode);
        }

        return redirect()->route('login');
    }
}

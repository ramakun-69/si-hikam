<?php

namespace App\Exceptions;

use Exception;

class AuthenticationException extends Exception
{

    protected $statusCode, $data;
    public function __construct($data, $statusCode = 401)
    {
        parent::__construct();
        $this->data= $data;
        $this->statusCode = $statusCode;
    }

    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => false,
                'response_code' => $this->statusCode,
                'message' => __("Failed"),
                'data' => $this->data
            ], $this->statusCode);
        }

        return redirect()->route('login');
    }
}

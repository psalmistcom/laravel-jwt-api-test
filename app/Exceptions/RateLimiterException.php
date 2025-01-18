<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RateLimiterException extends Exception
{
    public function __construct($message = 'Too Many requests', $code = Response::HTTP_EXPECTATION_FAILED)
    {
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->message,
        ], $this->code);
    }
}

<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class FetchingFailureException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Query returned no results'
        ], 404);
    }
}

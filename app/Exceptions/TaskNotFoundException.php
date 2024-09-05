<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class TaskNotFoundException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Task not found'
        ], 404);
    }
}

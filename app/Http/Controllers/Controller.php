<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Send result with code 200
     */
    public function ok(mixed $data = null): JsonResponse
    {
        return response()->json($data, 200);
    }

    /**
     * Send error
     */
    public function error(?array $errors = [], ?int $status = null): JsonResponse
    {
        return response()
            ->json(
                [
                    'errors' => empty($errors) && ! empty($this->validationErrors) ? $this->validationErrors : $errors,
                ],
                $status ?? 400
            );
    }
}

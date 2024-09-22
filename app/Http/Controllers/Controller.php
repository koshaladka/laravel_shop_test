<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Send result with code 200
     */
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="OpenApi Documentation",
     *      description="ATOL LKP api documentation<br/>Перед тестированием роутов нужна авторизация через keycloak (АТОЛ ID), после чего необходимо ввести Bearer token в зону Authorize",
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="ATOL LKP DOC"
     * )
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

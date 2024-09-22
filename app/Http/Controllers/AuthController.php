<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthRequest;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Вход пользователя",
     *     description="Вход пользователя с использованием email и password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="user@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     example="password123"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный вход",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="token",
     *                 type="string",
     *                 example="1|234567890abcdefghijklmnopqrstuvwxyz"
     *             ),
     *             @OA\Property(
     *                 property="token_type",
     *                 type="string",
     *                 example="Bearer"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неверные учетные данные"
     *     )
     * )
     */
    public function login(AuthRequest $request, AuthService $service): JsonResponse
    {
        try {
            $data = $service->execute($request);

            return $this->ok($data);
        } catch (Exception $e) {
            return $this->error(['message' => [$e->getMessage()]], 401);
        }
    }
}

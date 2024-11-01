<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserStoreRequest;
use App\Services\User\UserIndexService;
use App\Services\User\UserStoreService;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    /**
     * Создание нового пользователя
     *
     * @OA\Post(
     *     path="/api/user",
     *     tags={"User"},
     *     summary="Создание нового пользователя",
     *     description="Создание нового пользователя с указанным email и городом",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="user@example.com",
     *                     description="Email пользователя"
     *                 ),
     *                 @OA\Property(
     *                     property="city",
     *                     type="string",
     *                     example="New York",
     *                     description="Город пользователя"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="user_id",
     *                 type="integer",
     *                 example=1,
     *                 description="ID пользователя"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Внутренняя ошибка сервера"
     *     )
     * )
     */
    public function store(UserStoreRequest $request, UserStoreService $service): JsonResponse
    {
        try {
            return $this->ok($service->execute($request));
        } catch (Exception $e) {
            return $this->error(['message' => [$e->getMessage()]]);
        }
    }

    /**
     * Получение списка пользователей
     *
     * @OA\Get(
     *     path="/api/users",
     *     tags={"User"},
     *     summary="Получение списка пользователей",
     *     description="Возвращает список пользователей в формате JSON",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="example1@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="city",
     *                     type="string",
     *                     example="Москва"
     *                 ),
     *                 @OA\Property(
     *                     property="date",
     *                     type="string",
     *                     example="2023-10-01 12:00:00"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Внутренняя ошибка сервера"
     *     )
     * )
     */
    public function index(UserIndexService $service): JsonResponse
    {
        try {
            return $this->ok($service->execute());
        } catch (Exception $e) {
            return $this->error(['message' => [$e->getMessage()]]);
        }
    }
}

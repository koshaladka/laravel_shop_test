<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;

class CityController extends Controller
{

    /**
     * Получение списка городов
     *
     * @OA\Get(
     *     path="/api/cities",
     *     tags={"City"},
     *     summary="Получение списка городов",
     *     description="Возвращает список городов в формате JSON",
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(type="string", example="California")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Внутренняя ошибка сервера"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
            return $this->ok(['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']);
    }
}

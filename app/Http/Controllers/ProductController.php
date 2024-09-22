<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductCheckRequest;
use App\Http\Requests\Product\ProductRentRequest;
use App\Services\Products\ProductBuyService;
use App\Services\Products\ProductCheckService;
use App\Services\Products\ProductRentMoreService;
use App\Services\Products\ProductRentService;
use Exception;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{

    /**
     * Проверка статутса товара клиентом
     *
     * @OA\Post(
     *     path="/product/check",
     *     tags={"Product"},
     *     summary="Проверка доступности продукта",
     *     description="Проверка доступности продукта и создание заказа, если его нет",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1,
     *                     description="ID продукта"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешная проверка",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="unique_code",
     *                 type="string",
     *                 example="abcdefghij"
     *             ),
     *             @OA\Property(
     *                 property="available",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Product is available for rent or sale"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Неверные данные запроса"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     )
     * )
     */
    public function check(ProductCheckRequest $request, ProductCheckService $service): JsonResponse
    {
        try {
            return $this->ok($service->execute($request));
        } catch (Exception $e) {
            return $this->error(['message' => [$e->getMessage()]]);
        }
    }

    /**
     * Покупка товара
     *
     * @OA\Post(
     *     path="/product/buy",
     *     tags={"Product"},
     *     summary="Покупка продукта",
     *     description="Покупка продукта с проверкой доступности, созданием заказа и обработкой платежа",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1,
     *                     description="ID продукта"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешная покупка",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Product purchased successfully"
     *             ),
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Неверные данные запроса"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Продукт не найден или недоступен"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка платежа"
     *     )
     * )
     */
    public function buy(ProductCheckRequest $request, ProductBuyService $service): JsonResponse
    {
        try {
            return $this->ok($service->execute($request));
        } catch (Exception $e) {
            return $this->error(['message' => [$e->getMessage()]]);
        }
    }

    /**
     * Аренда товара
     *
     * @OA\Post(
     *     path="/product/rent",
     *     tags={"Product"},
     *     summary="Аренда продукта",
     *     description="Аренда продукта с проверкой доступности, созданием заказа и обработкой платежа",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1,
     *                     description="ID продукта"
     *                 ),
     *                 @OA\Property(
     *                     property="duration",
     *                     type="integer",
     *                     example=4,
     *                     description="Продолжительность аренды в часах (4, 8, 12, 24)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешная аренда",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Product rent successfully"
     *             ),
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Неверные данные запроса"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Продукт не найден или недоступен"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка платежа"
     *     )
     * )
     */
    public function rent(ProductRentRequest $request, ProductRentService $service): JsonResponse
    {
        try {
            return $this->ok($service->execute($request));
        } catch (Exception $e) {
            return $this->error(['message' => [$e->getMessage()]]);
        }
    }

    /**
     * Продление аренды товара
     *
     * @OA\Post(
     *     path="/product/rent_more",
     *     tags={"Product"},
     *     summary="Продление аренды продукта",
     *     description="Продление аренды продукта с проверкой наличия заказа, проверкой текущего времени аренды, обработкой платежа и обновлением времени возврата",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1,
     *                     description="ID продукта"
     *                 ),
     *                 @OA\Property(
     *                     property="duration",
     *                     type="integer",
     *                     example=4,
     *                     description="Продолжительность аренды в часах (4, 8, 12, 24)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешное продление аренды",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Product rent more successfully"
     *             ),
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Неверные данные запроса"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизованный доступ"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Продукт не найден или недоступен"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка платежа"
     *     )
     * )
     */
    public function rentMore(ProductRentRequest $request, ProductRentMoreService $service): JsonResponse
    {
        try {
            return $this->ok($service->execute($request));
        } catch (Exception $e) {
            return $this->error(['message' => [$e->getMessage()]]);
        }
    }
}

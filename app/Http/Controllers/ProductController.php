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
     * @param ProductCheckRequest $request
     * @param ProductCheckService $service
     * @return JsonResponse
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
     * @param ProductCheckRequest $request
     * @param ProductBuyService $service
     * @return JsonResponse
     */
    public function buy(ProductCheckRequest $request, ProductBuyService $service): JsonResponse
    {
        try {
            return $this->ok($service->execute($request));
        } catch (Exception $e) {
            return $this->error(['message' => [$e->getMessage()]]);
        }
    }

    public function rent(ProductRentRequest $request, ProductRentService $service): JsonResponse
    {
        try {
            return $this->ok($service->execute($request));
        } catch (Exception $e) {
            return $this->error(['message' => [$e->getMessage()]]);
        }
    }

    public function rentMore(ProductRentRequest $request, ProductRentMoreService $service): JsonResponse
    {
        try {
            return $this->ok($service->execute($request));
        } catch (Exception $e) {
            return $this->error(['message' => [$e->getMessage()]]);
        }
    }
}

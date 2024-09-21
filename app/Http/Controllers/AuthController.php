<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthRequest;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * @param AuthRequest $request
     * @param AuthService $service
     * @return JsonResponse
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

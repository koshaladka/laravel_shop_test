<?php

namespace App\Services\Products;

use App\Models\Order;
use Illuminate\Support\Str;

class ProductCheckService extends ProductService
{
    /**
     * @param $request
     * @return array
     */
    public function execute($request): array
    {
        $user = auth()->user();

        $order = Order::where('user_id', $user->id)
            ->where('product_id', $request->id)
            ->first();

        if (!$order) {
            $uniqueCode = Str::random(10);
            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $request->id,
                'status' => 'check',
                'unique_code' => $uniqueCode,
            ]);
        }

        $available = $this->checkAvailability($request->id);

        return [
            'unique_code' => $order->unique_code,
            'available' => $available,
        ];
    }

}

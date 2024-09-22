<?php

namespace App\Services\Products;

use App\Models\Order;

class ProductService
{
    public function checkAvailability($productId): array
    {
        $order = Order::where('product_id', $productId)
            ->whereIn('status', ['rent', 'sale'])
            ->first();

        if (!$order) {
            return [
                'message' => 'Product is available for rent or sale',
                'available' => true,
            ];
        }

        return match (true) {
            $order->status === 'sale' => [
                'message' => 'Product has been sold',
                'available' => false,
            ],
            $order->status === 'rent' && $order->return_at > now() => [
                'message' => 'Product is currently rented',
                'available' => false,
            ],
            default => [
                'message' => 'Product is available for rent or sale',
                'available' => true,
            ],
        };
    }

}

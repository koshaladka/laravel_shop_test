<?php

namespace App\Services\Products;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProductService
{
    public function checkAvailability($productId)
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

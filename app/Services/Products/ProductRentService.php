<?php

namespace App\Services\Products;

use App\Contracts\PaymentServiceInterface;
use App\Models\Order;
use App\Models\Product;

class ProductRentService extends ProductService
{
    protected $paymentService;

    public function __construct(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    public function execute($request): array
    {
        $user = auth()->user();

        // проверка доступности товара
        $available = $this->checkAvailability($request->id);

        if (!$available['available']) {
            return [
                'message' => $available['message'],
                'success' => false,
            ];
        }

        // проверка наличия заказа
        $order = Order::where('user_id', $user->id)
            ->where('product_id', $request->id)
            ->where('status', 'check')
            ->first();

        if (!$order) {
            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $request->id,
                'status' => 'check',
            ]);
        }

        // вызов платежного сервиса
        $product = Product::find($request->id);
        $paymentSuccess = $this->paymentService->processPayment($product->rental_price_per_hour * $request->duration, $order->id);

        if (!$paymentSuccess) {
            return [
                'message' => 'Payment failed',
                'success' => false,
            ];
        }

        $order->status = 'rent';
        $order->rented_at = now();
        $order->return_at = now()->addHours((int)$request->duration);
        $order->save();

        return [
            'message' => 'Product rent successfully',
            'success' => true,
        ];
    }

}

<?php

namespace App\Services\Products;

use App\Contracts\PaymentServiceInterface;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;

class ProductRentMoreService extends ProductService
{
    protected $paymentService;

    public function __construct(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    public function execute($request): array
    {
        $user = auth()->user();

        // Проверка наличия заказа со статусом rent
        $order = Order::where('user_id', $user->id)
            ->where('product_id', $request->id)
            ->where('status', 'rent')
            ->first();

        if (!$order) {
            return [
                'message' => 'There is no suitable product to extend the lease',
                'success' => false,
            ];
        }

        // Проверка текущего времени аренды

        $rentedAt = Carbon::parse($order->rented_at);
        $returnAt = Carbon::parse($order->return_at);

        $currentRentDuration = $rentedAt->diffInHours($returnAt);
        $newRentDuration = $currentRentDuration + (int) $request->duration;;

        if ($newRentDuration > 24) {
            return [
                'message' => 'Rental duration exceeds 24 hours',
                'success' => false,
            ];
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

        // Обновление времени возврата
        $order->return_at = $returnAt->addHours((int) $request->duration);
        $order->save();

        return [
            'message' => 'Product rent more successfully',
            'success' => true,
        ];
    }

}

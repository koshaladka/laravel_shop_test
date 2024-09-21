<?php

namespace App\Services\Payment;

use App\Contracts\PaymentServiceInterface;

class PaymentService implements PaymentServiceInterface
{
    public function processPayment($amount, $orderId): bool
    {
        return true;
    }
}

<?php
namespace App\Contracts;

interface PaymentServiceInterface
{
    public function processPayment($amount, $orderId): bool;
}

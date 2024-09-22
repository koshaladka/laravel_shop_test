<?php

namespace App\Constants;

final class OrderStatus
{
    public const CHECK = 'check';
    public const RENT = 'rent';
    public const SALE = 'sale';

    const ALL = [
        self::CHECK,
        self::RENT,
        self::SALE,
    ];

    const ALL_NAMES = [
        self::CHECK => 'Проверка',
        self::RENT => 'Аренда',
        self::SALE => 'Продажа',
    ];
}

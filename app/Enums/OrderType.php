<?php

namespace App\Enums;

enum OrderType: string
{
    case DineIn = 'dine_in';
    case Pickup = 'pickup';
    case Delivery = 'delivery';

    public static function fromOrderMode(OrderMode $mode): self
    {
        return match ($mode) {
            OrderMode::DineIn => self::DineIn,
            OrderMode::Takeaway => self::Pickup,
            OrderMode::Delivery => self::Delivery,
        };
    }
}

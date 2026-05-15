<?php

namespace App\Enums;

enum OrderMode: string
{
    case DineIn = 'dine_in';
    case Takeaway = 'takeaway';
    case Delivery = 'delivery';
}

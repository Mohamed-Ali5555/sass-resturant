<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PendingPayment = 'pending_payment';
    case New = 'new';
    case Preparing = 'preparing';
    case Ready = 'ready';
    case Completed = 'completed';
    case Canceled = 'canceled';
}

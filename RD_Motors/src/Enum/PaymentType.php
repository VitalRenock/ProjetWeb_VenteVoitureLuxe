<?php

namespace App\Enum;

enum PaymentType
{
    case CASH;
    case VISA;
    case MASTERCARD;
}
<?php

namespace App\Enum;

enum PaymentType : string
{
    case CASH = 'CASH';
    case VISA = 'VISA';
    case MASTERCARD = 'MASTERCARD';
}
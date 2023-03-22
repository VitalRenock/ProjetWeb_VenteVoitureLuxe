<?php

namespace App\Enum;

enum PaymentType : string
{
    case CASH = 'CASH';
    case VISA = 'VISA';
    case MASTERCARD = 'MASTERCARD';
    public function toAString(): string
    {
        return $this->value;
    }
    public function toEnum(string $string) : PaymentType
    {

    }
}
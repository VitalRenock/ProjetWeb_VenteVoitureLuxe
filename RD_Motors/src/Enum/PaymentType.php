<?php

namespace App\Enum;

enum PaymentType : string
{
    case CASH = 'CASH';
    case VISA = 'VISA';
    case MASTERCARD = 'MASTERCARD';
    case TRANSFER = 'TRANSFER';

    public function translateFR(): string
    {
        return match($this) {
            PaymentType::CASH => 'Espèce',
            PaymentType::VISA => 'Carte VISA',
            PaymentType::MASTERCARD => 'Carte MASTERCARD',
            PaymentType::TRANSFER => 'Virement bancaire'
        };
    }
}
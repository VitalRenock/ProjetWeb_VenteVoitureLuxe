<?php

namespace App\Enum;

enum AddressType : string
{
    case HOME = 'HOME';
    case DELIVERY = 'DELIVERY';
    case BILLING = 'BILLING';

    public function translateFR(): string
    {
        return match($this) {
            AddressType::HOME => 'Espèce',
            AddressType::DELIVERY => 'Carte VISA',
            AddressType::BILLING => 'Carte MASTERCARD'
        };
    }
}
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
            AddressType::HOME => 'Domicile',
            AddressType::DELIVERY => 'Adresse de livraison',
            AddressType::BILLING => 'Adresse de facturation'
        };
    }
}
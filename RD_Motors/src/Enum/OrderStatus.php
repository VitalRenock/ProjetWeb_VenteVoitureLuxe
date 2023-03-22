<?php

namespace App\Enum;

enum OrderStatus : string
{
    case CREATED = 'CREATED';
    case PAID = "PAID";
    case INVOICED = "INVOICED";
    case DELIVERED = "DELIVERED";
    case CANCELLED = "CANCELLED";

    public function translateFR(): string
    {
        return match($this) {
            OrderStatus::CREATED => 'Créé',
            OrderStatus::PAID => 'Payé',
            OrderStatus::INVOICED => 'Facturé',
            OrderStatus::DELIVERED => 'Livré',
            OrderStatus::CANCELLED => 'Annulé'
        };
    }
}

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
    public static function toEnum(string $str) : ?OrderStatus
    {
        switch ($str)
        {
            CASE 'CREATED':
                return OrderStatus::CREATED;
            CASE 'PAID':
                return OrderStatus::PAID;
            CASE 'INVOICED':
                return OrderStatus::INVOICED;
            CASE 'DELIVERED':
                return OrderStatus::DELIVERED;
            CASE 'CANCELLED':
                return OrderStatus::CANCELLED;

        }
        return null;
    }
}

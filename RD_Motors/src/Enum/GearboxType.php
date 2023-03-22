<?php
namespace App\Enum;

enum GearboxType : string
{
    case MANUAL = 'MANUAL';
    case AUTOMATIC = 'AUTOMATIC';
    case CVT ='CVT';
    public function translateFR(): string
    {
        return match($this) {
            GearboxType::MANUAL => 'Manuelle',
            GearboxType::AUTOMATIC =>'Manuelle',
            GearboxType::CVT=>'Séquentielle'
        };
    }
}

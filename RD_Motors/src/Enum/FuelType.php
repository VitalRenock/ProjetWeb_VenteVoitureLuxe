<?php
namespace App\Enum;

enum FuelType : string
{
    case PETROL = 'PETROL';
    case DIESEL = 'DIESEL';
    case ELECTRIC ='ELECTRIC';
    case HYBRID = 'HYBRID';
    case PLUG_IN_HYBRID = 'PLUG_IN_HYBRID';
    public function translateFR(): string
    {
        return match($this) {
            FuelType::PETROL => 'Essence',
            FuelType::DIESEL =>'Diesel',
            FuelType::ELECTRIC=>'Electrique',
            FuelType::HYBRID =>'Hybrid',
            FuelType::PLUG_IN_HYBRID =>'Plug In Hybrid'
        };
    }
    public static function toEnum(string $str) : ?FuelType
    {
        switch ($str)
        {
            CASE 'PETROL':
                return FuelType::PETROL;
            CASE 'DIESEL':
                return FuelType::DIESEL;
            CASE 'ELECTRIC':
                return FuelType::ELECTRIC;
            CASE 'HYBRID':
                return FuelType::HYBRID;
            CASE 'PLUG_IN_HYBRID':
                return FuelType::PLUG_IN_HYBRID;

        }
        return null;
    }
}

<?php
namespace App\Enum;

enum TransmissionType : string
{
    case FRONT = 'FRONT';
    case REAR = 'REAR';
    case FOURBYFOUR ='FOURBYFOUR';
    public function translateFR(): string
    {
        return match($this) {
            TransmissionType::FRONT => 'Avant',
            TransmissionType::REAR =>'Arrière',
            TransmissionType::FOURBYFOUR=>'4x4'
        };
    }
}

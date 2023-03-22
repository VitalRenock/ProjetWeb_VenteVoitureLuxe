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
    public static function toEnum(string $str) : ?TransmissionType
    {
        switch ($str)
        {
            CASE 'FRONT':
                return TransmissionType::FRONT;
            CASE 'REAR':
                return TransmissionType::REAR;
            CASE 'FOURBYFOUR':
                return TransmissionType::FOURBYFOUR;

        }
        return null;
    }
}

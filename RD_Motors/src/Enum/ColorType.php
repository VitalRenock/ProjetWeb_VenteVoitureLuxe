<?php

namespace App\Enum;

enum ColorType : string
{
    case NORMAL = 'NORMAL';
    case METALLIC = 'METALLIC';
    case MAT = 'MAT';

    public function translateFR(): string
    {
        return match($this) {
            ColorType::NORMAL => 'Normal',
            ColorType::METALLIC => 'Métalissé',
            ColorType::MAT => 'Mate'
        };
    }
    public static function toEnum(string $str) : ?ColorType
    {
        switch ($str)
        {
            CASE 'NORMAL':
                return ColorType::NORMAL;
            CASE 'METALLIC':
                return ColorType::METALLIC;
            CASE 'MAT':
                return ColorType::MAT;

        }
        return null;
    }
}
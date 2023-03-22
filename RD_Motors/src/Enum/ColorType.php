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
}
<?php
namespace App\Enum;

enum CarState : string
{
    case SECOND_HAND = 'SECOND_HAND';
    case NEW = 'NEW';
    public function translateFR(): string
    {
        return match($this) {
            CarState::NEW => 'Neuf',
            CarState::SECOND_HAND =>'Occasion'
        };
    }
}

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
    public static function toEnum(string $str) : ?CarState
    {
        switch ($str)
        {
            CASE 'SECOND_HAND':
                return CarState::SECOND_HAND;
            CASE 'NEW':
                return CarState::NEW;

        }
        return null;
    }
}

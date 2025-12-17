<?php

namespace App\Enums;

enum VehicleClass: string
{
    case PASSENGER = 'PASSENGER';
    case CARGO = 'CARGO';

    public function getLabel(): string
    {
        return match ($this) {
            self::PASSENGER => 'Passenger Vehicle',
            self::CARGO => 'Cargo Vehicle',
        };
    }
}

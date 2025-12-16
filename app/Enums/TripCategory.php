<?php

namespace App\Enums;

enum TripCategory: string
{
    case DEPARTURE = 'DEPARTURE';
    case ARRIVAL = 'ARRIVAL';

    public function getLabel(): string
    {
        return match ($this) {
            self::DEPARTURE => 'Departure',
            self::ARRIVAL => 'Arrival',
        };
    }
}

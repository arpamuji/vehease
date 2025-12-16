<?php

namespace App\Enums;

enum FuelCategory: string
{
    case DIESEL = 'DIESEL';
    case GASOLINE = 'GASOLINE';
    case ELECTRIC = 'ELECTRIC';

    public function getLabel(): string
    {
        return match ($this) {
            self::DIESEL => 'Diesel',
            self::GASOLINE => 'Gasoline',
            self::ELECTRIC => 'Electric',
        };
    }
}

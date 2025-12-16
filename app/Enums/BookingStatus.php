<?php

namespace App\Enums;

enum BookingStatus: string
{
    case PENDING = 'PENDING';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case ON_TRIP = 'ON_TRIP';
    case COMPLETED = 'COMPLETED';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::ON_TRIP => 'On Trip',
            self::COMPLETED => 'Completed',
        };
    }
}

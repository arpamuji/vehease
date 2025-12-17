<?php

namespace App\Enums;

enum RoleType: string
{
    case ROOT = 'ROOT';
    case ADMIN = 'ADMIN';
    case MANAGER = 'MANAGER';
    case STAFF = 'STAFF';

    public function getLabel(): string
    {
        return match ($this) {
            self::ROOT => 'Root',
            self::ADMIN => 'Administrator',
            self::MANAGER => 'Manager',
            self::STAFF => 'Staff',
        };
    }
}

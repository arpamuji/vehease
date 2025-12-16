<?php

namespace App\Enums;

enum LocationType: string
{
    case MAIN_OFFICE = 'MAIN_OFFICE';
    case BRANCH_OFFICE = 'BRANCH_OFFICE';
    case MINING_SITE = 'MINING_SITE';

    public function getLabel(): string
    {
        return match ($this) {
            self::MAIN_OFFICE => 'Main Office',
            self::BRANCH_OFFICE => 'Branch Office',
            self::MINING_SITE => 'Mining Site',
        };
    }
}

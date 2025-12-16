<?php

namespace Helpers;

use Visus\Cuid2\Cuid2;

class Generator
{
    public static function cuid(): string
    {
        return (new Cuid2())->toString();
    }
}

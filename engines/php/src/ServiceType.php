<?php

declare(strict_types=1);

namespace WindowCleaning;

enum ServiceType: string
{
    case InteriorOnly = 'interior_only';
    case ExteriorOnly = 'exterior_only';
    case Both = 'both';

    public function multiplier(): float
    {
        return match ($this) {
            self::InteriorOnly => 0.45,
            self::ExteriorOnly => 0.55,
            self::Both => 1.0,
        };
    }
}

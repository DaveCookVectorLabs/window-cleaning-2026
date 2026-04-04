<?php

declare(strict_types=1);

namespace WindowCleaning;

/**
 * Window types and their base cleaning time in minutes.
 */
enum WindowType: string
{
    case StandardSinglePane = 'standard_single_pane';
    case DoublePane = 'double_pane';
    case FloorToCeiling = 'floor_to_ceiling';
    case Storefront = 'storefront';
    case Specialty = 'specialty';

    public function baseMinutes(): float
    {
        return match ($this) {
            self::StandardSinglePane => 4.0,
            self::DoublePane => 5.0,
            self::FloorToCeiling => 8.0,
            self::Storefront => 6.0,
            self::Specialty => 12.0,
        };
    }
}

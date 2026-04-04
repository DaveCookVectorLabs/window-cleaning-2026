<?php

declare(strict_types=1);

namespace WindowCleaning;

enum CleaningFrequency: string
{
    case OneTime = 'one_time';
    case Quarterly = 'quarterly';
    case Monthly = 'monthly';
    case Weekly = 'weekly';

    public function discount(): float
    {
        return match ($this) {
            self::OneTime => 1.0,
            self::Quarterly => 0.90,
            self::Monthly => 0.80,
            self::Weekly => 0.70,
        };
    }
}

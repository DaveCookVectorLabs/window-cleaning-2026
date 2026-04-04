<?php

declare(strict_types=1);

namespace WindowCleaning;

enum AccessMethod: string
{
    case GroundLevel = 'ground_level';
    case Ladder = 'ladder';
    case BoomLift = 'boom_lift';
    case RopeAccess = 'rope_access';
    case SwingStage = 'swing_stage';

    public function multiplier(): float
    {
        return match ($this) {
            self::GroundLevel => 1.0,
            self::Ladder => 1.4,
            self::BoomLift => 2.2,
            self::RopeAccess => 3.0,
            self::SwingStage => 3.5,
        };
    }
}

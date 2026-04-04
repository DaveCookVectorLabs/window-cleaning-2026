<?php

declare(strict_types=1);

namespace WindowCleaning\Tests;

use PHPUnit\Framework\TestCase;
use WindowCleaning\Calculator;
use WindowCleaning\WindowType;
use WindowCleaning\AccessMethod;
use WindowCleaning\ServiceType;
use WindowCleaning\CleaningFrequency;

final class CalculatorTest extends TestCase
{
    public function testStandardGroundLevelBothOneTime(): void
    {
        $est = Calculator::calculate(
            windowCount: 10,
            windowType: WindowType::StandardSinglePane,
            accessMethod: AccessMethod::GroundLevel,
            serviceType: ServiceType::Both,
            frequency: CleaningFrequency::OneTime,
            labourRate: 30.0,
            marginPct: 20.0,
        );

        $this->assertSame(20.0, $est->labourCost);
        $this->assertSame(1.6, $est->materialsCost);
        $this->assertSame(21.6, $est->subtotal);
        $this->assertSame(4.32, $est->marginAmount);
        $this->assertSame(25.92, $est->finalPrice);
        $this->assertSame(2.59, $est->perWindowCost);
    }

    public function testDoublePaneBoomLiftQuarterly(): void
    {
        $est = Calculator::calculate(
            windowCount: 120,
            windowType: WindowType::DoublePane,
            accessMethod: AccessMethod::BoomLift,
            serviceType: ServiceType::Both,
            frequency: CleaningFrequency::Quarterly,
            labourRate: 32.50,
            marginPct: 25.0,
        );

        $this->assertSame(643.5, $est->labourCost);
        $this->assertSame(51.48, $est->materialsCost);
        $this->assertSame(694.98, $est->subtotal);
        $this->assertSame(173.75, $est->marginAmount);
        $this->assertSame(868.73, $est->finalPrice);
    }

    public function testExteriorOnlyRopeAccessWeekly(): void
    {
        $est = Calculator::calculate(
            windowCount: 50,
            windowType: WindowType::FloorToCeiling,
            accessMethod: AccessMethod::RopeAccess,
            serviceType: ServiceType::ExteriorOnly,
            frequency: CleaningFrequency::Weekly,
            labourRate: 40.0,
            marginPct: 30.0,
        );

        $this->assertSame(308.0, $est->labourCost);
        $this->assertSame(24.64, $est->materialsCost);
        $this->assertSame(332.64, $est->subtotal);
        $this->assertSame(99.79, $est->marginAmount);
        $this->assertSame(432.43, $est->finalPrice);
    }

    public function testInvalidWindowCountThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Calculator::calculate(
            windowCount: 0,
            windowType: WindowType::StandardSinglePane,
            accessMethod: AccessMethod::GroundLevel,
            serviceType: ServiceType::Both,
            frequency: CleaningFrequency::OneTime,
            labourRate: 30.0,
            marginPct: 20.0,
        );
    }

    public function testInvalidMarginThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Calculator::calculate(
            windowCount: 10,
            windowType: WindowType::StandardSinglePane,
            accessMethod: AccessMethod::GroundLevel,
            serviceType: ServiceType::Both,
            frequency: CleaningFrequency::OneTime,
            labourRate: 30.0,
            marginPct: 101.0,
        );
    }
}

<?php

declare(strict_types=1);

namespace WindowCleaning;

/**
 * Commercial window cleaning cost calculator.
 *
 * Estimates cleaning costs based on window type, access method, service scope,
 * cleaning frequency, labour rate, and target profit margin. Uses the same
 * pricing model across all language implementations (Python, Rust, Java,
 * Ruby, Elixir, PHP).
 *
 * Usage:
 *
 *     $estimate = Calculator::calculate(
 *         windowCount: 120,
 *         windowType: WindowType::DoublePane,
 *         accessMethod: AccessMethod::BoomLift,
 *         serviceType: ServiceType::Both,
 *         frequency: CleaningFrequency::Quarterly,
 *         labourRate: 32.50,
 *         marginPct: 25.0,
 *     );
 *     echo $estimate->finalPrice; // 868.73
 */
final class Calculator
{
    private const MATERIALS_RATE = 0.08;

    public static function calculate(
        int $windowCount,
        WindowType $windowType,
        AccessMethod $accessMethod,
        ServiceType $serviceType,
        CleaningFrequency $frequency,
        float $labourRate,
        float $marginPct,
    ): CleaningEstimate {
        if ($windowCount <= 0) {
            throw new \InvalidArgumentException('windowCount must be positive');
        }
        if ($labourRate <= 0) {
            throw new \InvalidArgumentException('labourRate must be positive');
        }
        if ($marginPct < 0 || $marginPct > 100) {
            throw new \InvalidArgumentException('marginPct must be 0-100');
        }

        $timePerWindow = $windowType->baseMinutes()
            * $serviceType->multiplier()
            * $accessMethod->multiplier();

        $totalMinutes = $timePerWindow * $windowCount;
        $labourCost = ($totalMinutes / 60.0) * $labourRate * $frequency->discount();
        $materialsCost = $labourCost * self::MATERIALS_RATE;
        $subtotal = $labourCost + $materialsCost;
        $marginAmount = $subtotal * ($marginPct / 100.0);
        $finalPrice = $subtotal + $marginAmount;
        $perWindowCost = $finalPrice / $windowCount;

        return new CleaningEstimate(
            labourCost: round($labourCost, 2),
            materialsCost: round($materialsCost, 2),
            subtotal: round($subtotal, 2),
            marginAmount: round($marginAmount, 2),
            finalPrice: round($finalPrice, 2),
            perWindowCost: round($perWindowCost, 2),
        );
    }
}

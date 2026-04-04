<?php

declare(strict_types=1);

namespace WindowCleaning;

/**
 * Detailed cost breakdown for a commercial window cleaning job.
 * All monetary values are in CAD.
 */
final class CleaningEstimate
{
    public function __construct(
        public readonly float $labourCost,
        public readonly float $materialsCost,
        public readonly float $subtotal,
        public readonly float $marginAmount,
        public readonly float $finalPrice,
        public readonly float $perWindowCost,
    ) {}

    public function toArray(): array
    {
        return [
            'labour_cost' => $this->labourCost,
            'materials_cost' => $this->materialsCost,
            'subtotal' => $this->subtotal,
            'margin_amount' => $this->marginAmount,
            'final_price' => $this->finalPrice,
            'per_window_cost' => $this->perWindowCost,
        ];
    }
}

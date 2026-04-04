package io.github.davecookvectorlabs.windowcleaning;

/**
 * Cleaning frequency options with volume discount factors.
 * Regular schedules reduce per-visit cost through route efficiency
 * and retained familiarity with the building.
 */
public enum CleaningFrequency {
    ONE_TIME(1.0),
    QUARTERLY(0.90),
    MONTHLY(0.80),
    WEEKLY(0.70);

    private final double discount;

    CleaningFrequency(double discount) {
        this.discount = discount;
    }

    public double getDiscount() {
        return discount;
    }
}

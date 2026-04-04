package io.github.davecookvectorlabs.windowcleaning;

/**
 * Access methods for reaching windows on commercial buildings.
 * Each method carries a cost multiplier reflecting equipment, safety,
 * and labour overhead for Northern Ontario conditions.
 */
public enum AccessMethod {
    GROUND_LEVEL(1.0),
    LADDER(1.4),
    BOOM_LIFT(2.2),
    ROPE_ACCESS(3.0),
    SWING_STAGE(3.5);

    private final double multiplier;

    AccessMethod(double multiplier) {
        this.multiplier = multiplier;
    }

    public double getMultiplier() {
        return multiplier;
    }
}

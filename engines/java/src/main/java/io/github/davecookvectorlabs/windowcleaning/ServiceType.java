package io.github.davecookvectorlabs.windowcleaning;

/**
 * Service type — interior only, exterior only, or both.
 * The multiplier reflects the relative labour share of each service scope.
 */
public enum ServiceType {
    INTERIOR_ONLY(0.45),
    EXTERIOR_ONLY(0.55),
    BOTH(1.0);

    private final double multiplier;

    ServiceType(double multiplier) {
        this.multiplier = multiplier;
    }

    public double getMultiplier() {
        return multiplier;
    }
}

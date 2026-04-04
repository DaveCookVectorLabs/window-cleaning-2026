package io.github.davecookvectorlabs.windowcleaning;

/**
 * Window types and their base cleaning time in minutes per window.
 * Values reflect typical commercial window cleaning durations for
 * Northern Ontario commercial facilities.
 */
public enum WindowType {
    STANDARD_SINGLE_PANE(4.0),
    DOUBLE_PANE(5.0),
    FLOOR_TO_CEILING(8.0),
    STOREFRONT(6.0),
    SPECIALTY(12.0);

    private final double baseMinutes;

    WindowType(double baseMinutes) {
        this.baseMinutes = baseMinutes;
    }

    public double getBaseMinutes() {
        return baseMinutes;
    }
}

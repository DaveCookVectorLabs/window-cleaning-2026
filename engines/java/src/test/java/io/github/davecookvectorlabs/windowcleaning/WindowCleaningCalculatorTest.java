package io.github.davecookvectorlabs.windowcleaning;

import org.junit.jupiter.api.Test;
import static org.junit.jupiter.api.Assertions.*;

class WindowCleaningCalculatorTest {

    @Test
    void standardGroundLevelBothOneTime() {
        CleaningRequest req = new CleaningRequest(
                10, WindowType.STANDARD_SINGLE_PANE, AccessMethod.GROUND_LEVEL,
                ServiceType.BOTH, CleaningFrequency.ONE_TIME, 30.0, 20.0);
        CleaningEstimate est = WindowCleaningCalculator.calculate(req);

        // 4 min * 1.0 * 1.0 = 4 min/window, 40 min total
        // labour = (40/60) * 30 * 1.0 = 20.0
        // materials = 20 * 0.08 = 1.60
        // subtotal = 21.60
        // margin = 21.60 * 0.20 = 4.32
        // total = 25.92
        assertEquals(20.0, est.getLabourCost(), 0.01);
        assertEquals(1.60, est.getMaterialsCost(), 0.01);
        assertEquals(21.60, est.getSubtotal(), 0.01);
        assertEquals(4.32, est.getMarginAmount(), 0.01);
        assertEquals(25.92, est.getFinalPrice(), 0.01);
        assertEquals(2.59, est.getPerWindowCost(), 0.01);
    }

    @Test
    void doublePaneBoomLiftQuarterly() {
        CleaningRequest req = new CleaningRequest(
                120, WindowType.DOUBLE_PANE, AccessMethod.BOOM_LIFT,
                ServiceType.BOTH, CleaningFrequency.QUARTERLY, 32.50, 25.0);
        CleaningEstimate est = WindowCleaningCalculator.calculate(req);

        // 5 * 1.0 * 2.2 = 11 min/window, 1320 min total
        // labour = (1320/60) * 32.50 * 0.90 = 643.50
        // materials = 643.50 * 0.08 = 51.48
        // subtotal = 694.98
        // margin = 694.98 * 0.25 = 173.745 -> 173.75
        // total = 868.73
        assertEquals(643.50, est.getLabourCost(), 0.01);
        assertEquals(51.48, est.getMaterialsCost(), 0.01);
        assertEquals(694.98, est.getSubtotal(), 0.01);
        assertEquals(173.75, est.getMarginAmount(), 0.01);
        assertEquals(868.73, est.getFinalPrice(), 0.01);
    }

    @Test
    void exteriorOnlyRopeAccessWeekly() {
        CleaningRequest req = new CleaningRequest(
                50, WindowType.FLOOR_TO_CEILING, AccessMethod.ROPE_ACCESS,
                ServiceType.EXTERIOR_ONLY, CleaningFrequency.WEEKLY, 40.0, 30.0);
        CleaningEstimate est = WindowCleaningCalculator.calculate(req);

        // 8 * 0.55 * 3.0 = 13.2 min/window, 660 min total
        // labour = (660/60) * 40 * 0.70 = 308.0
        // materials = 308 * 0.08 = 24.64
        // subtotal = 332.64
        // margin = 332.64 * 0.30 = 99.792 -> 99.79
        // total = 432.43
        assertEquals(308.0, est.getLabourCost(), 0.01);
        assertEquals(24.64, est.getMaterialsCost(), 0.01);
        assertEquals(332.64, est.getSubtotal(), 0.01);
        assertEquals(99.79, est.getMarginAmount(), 0.01);
        assertEquals(432.43, est.getFinalPrice(), 0.01);
    }

    @Test
    void invalidWindowCountThrows() {
        assertThrows(IllegalArgumentException.class, () ->
                new CleaningRequest(0, WindowType.STANDARD_SINGLE_PANE, AccessMethod.GROUND_LEVEL,
                        ServiceType.BOTH, CleaningFrequency.ONE_TIME, 30.0, 20.0));
    }

    @Test
    void invalidMarginThrows() {
        assertThrows(IllegalArgumentException.class, () ->
                new CleaningRequest(10, WindowType.STANDARD_SINGLE_PANE, AccessMethod.GROUND_LEVEL,
                        ServiceType.BOTH, CleaningFrequency.ONE_TIME, 30.0, 101.0));
    }
}

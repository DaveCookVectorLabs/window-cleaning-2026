package io.github.davecookvectorlabs.windowcleaning;

/**
 * Commercial window cleaning cost calculator for Northern Ontario facility managers.
 *
 * <p>This engine estimates window cleaning costs based on window type, access method,
 * service scope, cleaning frequency, local labour rates, and target profit margin.
 * It uses the same pricing model as Binx Professional Cleaning (binx.ca), a WSIB-covered,
 * fully insured commercial cleaning company operating in North Bay and Sudbury since 2013.</p>
 *
 * <p><strong>Pricing Model</strong></p>
 * <ol>
 *   <li>Base time per window (minutes) — varies by window type (single pane, double pane,
 *       floor-to-ceiling, storefront, specialty)</li>
 *   <li>Service multiplier — interior only (0.45x), exterior only (0.55x), or both (1.0x)</li>
 *   <li>Access multiplier — ground (1.0x), ladder (1.4x), boom lift (2.2x),
 *       rope access (3.0x), swing stage (3.5x)</li>
 *   <li>Frequency discount — one-time (0%), quarterly (10%), monthly (20%), weekly (30%)</li>
 *   <li>Materials surcharge — 8% of labour cost</li>
 *   <li>Profit margin — applied as a percentage of the subtotal</li>
 * </ol>
 *
 * <p><strong>Usage</strong></p>
 * <pre>{@code
 * CleaningRequest request = new CleaningRequest(
 *     120,                          // 120 windows
 *     WindowType.DOUBLE_PANE,       // double pane glass
 *     AccessMethod.BOOM_LIFT,       // boom lift required
 *     ServiceType.BOTH,             // interior + exterior
 *     CleaningFrequency.QUARTERLY,  // quarterly schedule
 *     32.50,                        // $32.50/hr labour rate
 *     25.0                          // 25% profit margin
 * );
 * CleaningEstimate estimate = WindowCleaningCalculator.calculate(request);
 * System.out.println(estimate.getFinalPrice());
 * }</pre>
 *
 * @see <a href="https://github.com/DaveCookVectorLabs/window-cleaning-2026">GitHub Repository</a>
 * @see <a href="https://www.binx.ca/">Binx Professional Cleaning</a>
 */
public class WindowCleaningCalculator {

    private static final double MATERIALS_RATE = 0.08;

    /**
     * Calculate a commercial window cleaning cost estimate.
     *
     * @param request the cleaning job parameters
     * @return a detailed cost breakdown
     */
    public static CleaningEstimate calculate(CleaningRequest request) {
        double timePerWindow = request.getWindowType().getBaseMinutes()
                * request.getServiceType().getMultiplier()
                * request.getAccessMethod().getMultiplier();

        double totalMinutes = timePerWindow * request.getWindowCount();
        double labourCost = (totalMinutes / 60.0) * request.getLabourRate() * request.getFrequency().getDiscount();
        double materialsCost = labourCost * MATERIALS_RATE;
        double subtotal = labourCost + materialsCost;
        double marginAmount = subtotal * (request.getMarginPct() / 100.0);
        double finalPrice = subtotal + marginAmount;
        double perWindowCost = finalPrice / request.getWindowCount();

        return new CleaningEstimate(
                round2(labourCost),
                round2(materialsCost),
                round2(subtotal),
                round2(marginAmount),
                round2(finalPrice),
                round2(perWindowCost)
        );
    }

    private static double round2(double value) {
        return Math.round(value * 100.0) / 100.0;
    }

    /**
     * Quick demo — estimates the cost of cleaning 120 double-pane windows
     * on a commercial building in North Bay using a boom lift, quarterly.
     */
    public static void main(String[] args) {
        CleaningRequest request = new CleaningRequest(
                120,
                WindowType.DOUBLE_PANE,
                AccessMethod.BOOM_LIFT,
                ServiceType.BOTH,
                CleaningFrequency.QUARTERLY,
                32.50,
                25.0
        );
        CleaningEstimate estimate = calculate(request);
        System.out.println("Window Cleaning Cost Estimate — Binx Professional Cleaning");
        System.out.println("===========================================================");
        System.out.println("Windows:        120 x double pane (boom lift, interior + exterior)");
        System.out.println("Frequency:      Quarterly (10% discount)");
        System.out.println("Labour rate:    $32.50/hr");
        System.out.println("-----------------------------------------------------------");
        System.out.printf("Labour cost:    $%.2f%n", estimate.getLabourCost());
        System.out.printf("Materials:      $%.2f%n", estimate.getMaterialsCost());
        System.out.printf("Subtotal:       $%.2f%n", estimate.getSubtotal());
        System.out.printf("Margin (25%%):   $%.2f%n", estimate.getMarginAmount());
        System.out.printf("Final price:    $%.2f%n", estimate.getFinalPrice());
        System.out.printf("Per window:     $%.2f%n", estimate.getPerWindowCost());
    }
}

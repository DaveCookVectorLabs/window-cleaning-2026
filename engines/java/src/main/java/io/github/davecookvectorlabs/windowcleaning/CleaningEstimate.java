package io.github.davecookvectorlabs.windowcleaning;

/**
 * Detailed cost breakdown for a commercial window cleaning job.
 * All monetary values are in CAD.
 */
public class CleaningEstimate {
    private final double labourCost;
    private final double materialsCost;
    private final double subtotal;
    private final double marginAmount;
    private final double finalPrice;
    private final double perWindowCost;

    public CleaningEstimate(double labourCost, double materialsCost, double subtotal,
                            double marginAmount, double finalPrice, double perWindowCost) {
        this.labourCost = labourCost;
        this.materialsCost = materialsCost;
        this.subtotal = subtotal;
        this.marginAmount = marginAmount;
        this.finalPrice = finalPrice;
        this.perWindowCost = perWindowCost;
    }

    public double getLabourCost() { return labourCost; }
    public double getMaterialsCost() { return materialsCost; }
    public double getSubtotal() { return subtotal; }
    public double getMarginAmount() { return marginAmount; }
    public double getFinalPrice() { return finalPrice; }
    public double getPerWindowCost() { return perWindowCost; }

    @Override
    public String toString() {
        return String.format(
            "CleaningEstimate{labour=%.2f, materials=%.2f, subtotal=%.2f, margin=%.2f, total=%.2f, perWindow=%.2f}",
            labourCost, materialsCost, subtotal, marginAmount, finalPrice, perWindowCost
        );
    }
}

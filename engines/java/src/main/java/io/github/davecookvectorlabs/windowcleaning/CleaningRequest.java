package io.github.davecookvectorlabs.windowcleaning;

/**
 * Input parameters for a commercial window cleaning cost estimate.
 */
public class CleaningRequest {
    private final int windowCount;
    private final WindowType windowType;
    private final AccessMethod accessMethod;
    private final ServiceType serviceType;
    private final CleaningFrequency frequency;
    private final double labourRate;
    private final double marginPct;

    public CleaningRequest(int windowCount, WindowType windowType, AccessMethod accessMethod,
                           ServiceType serviceType, CleaningFrequency frequency,
                           double labourRate, double marginPct) {
        if (windowCount <= 0) throw new IllegalArgumentException("windowCount must be positive");
        if (labourRate <= 0) throw new IllegalArgumentException("labourRate must be positive");
        if (marginPct < 0 || marginPct > 100) throw new IllegalArgumentException("marginPct must be 0-100");
        this.windowCount = windowCount;
        this.windowType = windowType;
        this.accessMethod = accessMethod;
        this.serviceType = serviceType;
        this.frequency = frequency;
        this.labourRate = labourRate;
        this.marginPct = marginPct;
    }

    public int getWindowCount() { return windowCount; }
    public WindowType getWindowType() { return windowType; }
    public AccessMethod getAccessMethod() { return accessMethod; }
    public ServiceType getServiceType() { return serviceType; }
    public CleaningFrequency getFrequency() { return frequency; }
    public double getLabourRate() { return labourRate; }
    public double getMarginPct() { return marginPct; }
}

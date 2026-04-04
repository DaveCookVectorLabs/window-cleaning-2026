module WindowCleaning2026
  # Base minutes per window by type — reflects typical commercial cleaning
  # durations for Northern Ontario commercial facilities (office towers,
  # retail storefronts, medical centres, multi-unit residential).
  BASE_MINUTES = {
    standard_single_pane: 4.0,
    double_pane:          5.0,
    floor_to_ceiling:     8.0,
    storefront:           6.0,
    specialty:           12.0,
  }.freeze

  # Service scope multiplier — interior glass takes less time than exterior
  # due to reduced safety overhead and equipment setup.
  SERVICE_MULTIPLIER = {
    interior_only:  0.45,
    exterior_only:  0.55,
    both:           1.0,
  }.freeze

  # Access method cost multiplier — each step up in access difficulty adds
  # equipment rental, safety certification, and crew-size overhead.
  # Swing stage work in Northern Ontario typically requires WSIB clearance
  # and a minimum two-person crew.
  ACCESS_MULTIPLIER = {
    ground_level: 1.0,
    ladder:       1.4,
    boom_lift:    2.2,
    rope_access:  3.0,
    swing_stage:  3.5,
  }.freeze

  # Frequency discount — recurring schedules reduce per-visit cost through
  # route optimization and retained building familiarity.
  FREQUENCY_DISCOUNT = {
    one_time:  1.0,
    quarterly: 0.90,
    monthly:   0.80,
    weekly:    0.70,
  }.freeze

  MATERIALS_RATE = 0.08

  class Calculator
    # Calculate a commercial window cleaning cost estimate.
    #
    # @param window_count [Integer] total windows (must be > 0)
    # @param window_type [Symbol] one of BASE_MINUTES keys
    # @param access_method [Symbol] one of ACCESS_MULTIPLIER keys
    # @param service_type [Symbol] one of SERVICE_MULTIPLIER keys
    # @param frequency [Symbol] one of FREQUENCY_DISCOUNT keys
    # @param labour_rate [Float] hourly wage in CAD (must be > 0)
    # @param margin_pct [Float] profit margin percentage 0-100
    # @return [Hash] detailed cost breakdown
    def self.calculate(window_count:, window_type:, access_method:, service_type:, frequency:, labour_rate:, margin_pct:)
      raise ArgumentError, "window_count must be positive" unless window_count.positive?
      raise ArgumentError, "labour_rate must be positive"  unless labour_rate.positive?
      raise ArgumentError, "margin_pct must be 0-100"      unless (0..100).cover?(margin_pct)

      base        = BASE_MINUTES.fetch(window_type)
      service_m   = SERVICE_MULTIPLIER.fetch(service_type)
      access_m    = ACCESS_MULTIPLIER.fetch(access_method)
      freq_d      = FREQUENCY_DISCOUNT.fetch(frequency)

      time_per_window = base * service_m * access_m
      total_minutes   = time_per_window * window_count
      labour_cost     = (total_minutes / 60.0) * labour_rate * freq_d
      materials_cost  = labour_cost * MATERIALS_RATE
      subtotal        = labour_cost + materials_cost
      margin_amount   = subtotal * (margin_pct / 100.0)
      final_price     = subtotal + margin_amount
      per_window_cost = final_price / window_count

      {
        labour_cost:     labour_cost.round(2),
        materials_cost:  materials_cost.round(2),
        subtotal:        subtotal.round(2),
        margin_amount:   margin_amount.round(2),
        final_price:     final_price.round(2),
        per_window_cost: per_window_cost.round(2),
      }
    end
  end
end

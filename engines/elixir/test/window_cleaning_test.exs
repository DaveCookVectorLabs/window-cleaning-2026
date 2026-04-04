defmodule WindowCleaningTest do
  use ExUnit.Case

  test "standard ground level both one-time" do
    est = WindowCleaning.calculate(
      window_count: 10, window_type: :standard_single_pane, access_method: :ground_level,
      service_type: :both, frequency: :one_time, labour_rate: 30.0, margin_pct: 20.0
    )
    assert est.labour_cost == 20.0
    assert est.materials_cost == 1.6
    assert est.subtotal == 21.6
    assert est.margin_amount == 4.32
    assert est.final_price == 25.92
    assert est.per_window_cost == 2.59
  end

  test "double pane boom lift quarterly" do
    est = WindowCleaning.calculate(
      window_count: 120, window_type: :double_pane, access_method: :boom_lift,
      service_type: :both, frequency: :quarterly, labour_rate: 32.50, margin_pct: 25.0
    )
    assert est.labour_cost == 643.5
    assert est.materials_cost == 51.48
    assert est.subtotal == 694.98
    assert est.margin_amount == 173.75
    assert est.final_price == 868.73
  end

  test "exterior only rope access weekly" do
    est = WindowCleaning.calculate(
      window_count: 50, window_type: :floor_to_ceiling, access_method: :rope_access,
      service_type: :exterior_only, frequency: :weekly, labour_rate: 40.0, margin_pct: 30.0
    )
    assert est.labour_cost == 308.0
    assert est.materials_cost == 24.64
    assert est.subtotal == 332.64
    assert est.margin_amount == 99.79
    assert est.final_price == 432.43
  end

  test "invalid window count raises" do
    assert_raise ArgumentError, fn ->
      WindowCleaning.calculate(
        window_count: 0, window_type: :standard_single_pane, access_method: :ground_level,
        service_type: :both, frequency: :one_time, labour_rate: 30.0, margin_pct: 20.0
      )
    end
  end

  test "invalid margin raises" do
    assert_raise ArgumentError, fn ->
      WindowCleaning.calculate(
        window_count: 10, window_type: :standard_single_pane, access_method: :ground_level,
        service_type: :both, frequency: :one_time, labour_rate: 30.0, margin_pct: 101.0
      )
    end
  end
end

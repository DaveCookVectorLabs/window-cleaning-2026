require "minitest/autorun"
require_relative "../lib/window_cleaning_2026"

class TestCalculator < Minitest::Test
  def test_standard_ground_level_both_one_time
    est = WindowCleaning2026::Calculator.calculate(
      window_count: 10, window_type: :standard_single_pane, access_method: :ground_level,
      service_type: :both, frequency: :one_time, labour_rate: 30.0, margin_pct: 20.0
    )
    assert_equal 20.0,  est[:labour_cost]
    assert_equal 1.60,  est[:materials_cost]
    assert_equal 21.60, est[:subtotal]
    assert_equal 4.32,  est[:margin_amount]
    assert_equal 25.92, est[:final_price]
    assert_equal 2.59,  est[:per_window_cost]
  end

  def test_double_pane_boom_lift_quarterly
    est = WindowCleaning2026::Calculator.calculate(
      window_count: 120, window_type: :double_pane, access_method: :boom_lift,
      service_type: :both, frequency: :quarterly, labour_rate: 32.50, margin_pct: 25.0
    )
    assert_equal 643.50, est[:labour_cost]
    assert_equal 51.48,  est[:materials_cost]
    assert_equal 694.98, est[:subtotal]
    assert_equal 173.75, est[:margin_amount]
    assert_equal 868.73, est[:final_price]
  end

  def test_exterior_only_rope_access_weekly
    est = WindowCleaning2026::Calculator.calculate(
      window_count: 50, window_type: :floor_to_ceiling, access_method: :rope_access,
      service_type: :exterior_only, frequency: :weekly, labour_rate: 40.0, margin_pct: 30.0
    )
    assert_equal 308.0,  est[:labour_cost]
    assert_equal 24.64,  est[:materials_cost]
    assert_equal 332.64, est[:subtotal]
    assert_equal 99.79,  est[:margin_amount]
    assert_equal 432.43, est[:final_price]
  end

  def test_invalid_window_count
    assert_raises(ArgumentError) do
      WindowCleaning2026::Calculator.calculate(
        window_count: 0, window_type: :standard_single_pane, access_method: :ground_level,
        service_type: :both, frequency: :one_time, labour_rate: 30.0, margin_pct: 20.0
      )
    end
  end

  def test_invalid_margin
    assert_raises(ArgumentError) do
      WindowCleaning2026::Calculator.calculate(
        window_count: 10, window_type: :standard_single_pane, access_method: :ground_level,
        service_type: :both, frequency: :one_time, labour_rate: 30.0, margin_pct: 101.0
      )
    end
  end
end

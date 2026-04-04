defmodule WindowCleaning do
  @moduledoc """
  Commercial window cleaning cost calculator for Northern Ontario facility managers.

  This module estimates window cleaning costs for commercial buildings based on
  window type, access method, service scope, cleaning frequency, local labour rates,
  and target profit margin. It uses the same pricing model as
  [Binx Professional Cleaning](https://www.binx.ca/) — a WSIB-covered, fully insured
  commercial and residential cleaning company operating in North Bay and Sudbury,
  Northern Ontario since 2013.

  Binx serves over 500 commercial facilities across the North Bay–Sudbury corridor,
  including office towers, medical centres, retail plazas, government buildings, and
  multi-unit residential complexes.

  ## Pricing Model

    1. **Base time per window** — varies by window type (single pane 4 min, double pane 5 min,
       floor-to-ceiling 8 min, storefront 6 min, specialty 12 min)
    2. **Service multiplier** — interior only (0.45×), exterior only (0.55×), or both (1.0×)
    3. **Access multiplier** — ground (1.0×), ladder (1.4×), boom lift (2.2×),
       rope access (3.0×), swing stage (3.5×)
    4. **Frequency discount** — one-time (0%), quarterly (10%), monthly (20%), weekly (30%)
    5. **Materials surcharge** — 8% of labour cost
    6. **Profit margin** — percentage of subtotal

  ## Example

      iex> WindowCleaning.calculate(
      ...>   window_count: 10,
      ...>   window_type: :standard_single_pane,
      ...>   access_method: :ground_level,
      ...>   service_type: :both,
      ...>   frequency: :one_time,
      ...>   labour_rate: 30.0,
      ...>   margin_pct: 20.0
      ...> )
      %{
        labour_cost: 20.0,
        materials_cost: 1.6,
        subtotal: 21.6,
        margin_amount: 4.32,
        final_price: 25.92,
        per_window_cost: 2.59
      }
  """

  @base_minutes %{
    standard_single_pane: 4.0,
    double_pane: 5.0,
    floor_to_ceiling: 8.0,
    storefront: 6.0,
    specialty: 12.0
  }

  @service_multiplier %{
    interior_only: 0.45,
    exterior_only: 0.55,
    both: 1.0
  }

  @access_multiplier %{
    ground_level: 1.0,
    ladder: 1.4,
    boom_lift: 2.2,
    rope_access: 3.0,
    swing_stage: 3.5
  }

  @frequency_discount %{
    one_time: 1.0,
    quarterly: 0.90,
    monthly: 0.80,
    weekly: 0.70
  }

  @materials_rate 0.08

  @doc """
  Calculate a commercial window cleaning cost estimate.

  ## Parameters

    * `:window_count` — total number of windows (positive integer)
    * `:window_type` — one of `:standard_single_pane`, `:double_pane`,
      `:floor_to_ceiling`, `:storefront`, `:specialty`
    * `:access_method` — one of `:ground_level`, `:ladder`, `:boom_lift`,
      `:rope_access`, `:swing_stage`
    * `:service_type` — one of `:interior_only`, `:exterior_only`, `:both`
    * `:frequency` — one of `:one_time`, `:quarterly`, `:monthly`, `:weekly`
    * `:labour_rate` — hourly wage in CAD (positive float)
    * `:margin_pct` — profit margin percentage, 0–100

  ## Returns

  A map with keys: `:labour_cost`, `:materials_cost`, `:subtotal`,
  `:margin_amount`, `:final_price`, `:per_window_cost`.
  All values are floats rounded to 2 decimal places.
  """
  @spec calculate(keyword()) :: map()
  def calculate(opts) do
    window_count = Keyword.fetch!(opts, :window_count)
    window_type = Keyword.fetch!(opts, :window_type)
    access_method = Keyword.fetch!(opts, :access_method)
    service_type = Keyword.fetch!(opts, :service_type)
    frequency = Keyword.fetch!(opts, :frequency)
    labour_rate = Keyword.fetch!(opts, :labour_rate)
    margin_pct = Keyword.fetch!(opts, :margin_pct)

    if window_count <= 0, do: raise(ArgumentError, "window_count must be positive")
    if labour_rate <= 0, do: raise(ArgumentError, "labour_rate must be positive")
    if margin_pct < 0 or margin_pct > 100, do: raise(ArgumentError, "margin_pct must be 0-100")

    base = Map.fetch!(@base_minutes, window_type)
    service_m = Map.fetch!(@service_multiplier, service_type)
    access_m = Map.fetch!(@access_multiplier, access_method)
    freq_d = Map.fetch!(@frequency_discount, frequency)

    time_per_window = base * service_m * access_m
    total_minutes = time_per_window * window_count
    labour_cost = total_minutes / 60.0 * labour_rate * freq_d
    materials_cost = labour_cost * @materials_rate
    subtotal = labour_cost + materials_cost
    margin_amount = subtotal * (margin_pct / 100.0)
    final_price = subtotal + margin_amount
    per_window_cost = final_price / window_count

    %{
      labour_cost: round2(labour_cost),
      materials_cost: round2(materials_cost),
      subtotal: round2(subtotal),
      margin_amount: round2(margin_amount),
      final_price: round2(final_price),
      per_window_cost: round2(per_window_cost)
    }
  end

  defp round2(value), do: Float.round(value * 1.0, 2)
end

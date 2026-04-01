Calculation Model
=================

The calculation engine models the same variables any legitimate commercial window cleaning company uses to build a quote. The logic is identical in both the Python (FastAPI) and Rust (Actix-web) engines.

Base Minutes per Window
-----------------------

Time-per-window varies significantly by glass type. Specialty installations like skylights and atriums — common in medical facilities and office towers across Northern Ontario — take roughly three times longer than standard single-pane windows.

.. list-table::
   :header-rows: 1
   :widths: 50 20 30

   * - Window Type
     - Base Minutes
     - Common In
   * - Standard single pane
     - 4 min
     - Office buildings, residential units
   * - Double pane
     - 5 min
     - Modern office towers, medical clinics
   * - Floor-to-ceiling
     - 8 min
     - Retail storefronts, hotel lobbies
   * - Storefront
     - 6 min
     - Street-level retail, restaurants
   * - Specialty (skylights/atriums)
     - 12 min
     - Atriums, medical centres, industrial skylights

Service Type Multipliers
------------------------

.. list-table::
   :header-rows: 1

   * - Service Type
     - Multiplier
   * - Interior only
     - 0.45
   * - Exterior only
     - 0.55
   * - Both interior and exterior
     - 1.0

Access Method Multipliers
-------------------------

Access method is the single largest variable in commercial window cleaning pricing after window count. A 50-window office building in downtown North Bay that can be cleaned entirely from ground level with extension poles costs a fraction of the same building requiring boom lift or rope access for upper floors.

.. list-table::
   :header-rows: 1
   :widths: 40 15 45

   * - Access Method
     - Multiplier
     - Typical Use
   * - Ground level / extension pole
     - 1.0×
     - Single-storey retail, ground-floor offices
   * - Ladder (second storey)
     - 1.4×
     - Two-storey commercial buildings
   * - Boom lift / aerial platform
     - 2.2×
     - Mid-rise office buildings (3–6 floors)
   * - Rope access (SPRAT/IRATA certified)
     - 3.0×
     - High-rise buildings, difficult access points
   * - Swing stage
     - 3.5×
     - High-rise towers, full-facade cleaning

Frequency Discounts
-------------------

.. list-table::
   :header-rows: 1

   * - Frequency
     - Discount Factor
     - Effective Discount
   * - One-time
     - 1.00
     - 0%
   * - Quarterly
     - 0.90
     - 10%
   * - Monthly
     - 0.80
     - 20%
   * - Weekly
     - 0.70
     - 30%

Calculation Formula
-------------------

.. code-block:: text

   1. time_per_window = base_minutes × service_multiplier × access_multiplier
   2. total_minutes = time_per_window × window_count
   3. labour_cost = (total_minutes / 60) × labour_rate × frequency_discount
   4. materials_cost = labour_cost × 0.08
   5. subtotal = labour_cost + materials_cost
   6. margin_amount = subtotal × (margin_pct / 100)
   7. final_price = subtotal + margin_amount
   8. per_window_cost = final_price / window_count

All monetary values are in Canadian dollars (CAD). The default labour rate of $22.00/hr reflects the Northern Ontario average for experienced commercial cleaning technicians as of 2026.

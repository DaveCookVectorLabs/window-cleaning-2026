API Reference
=============

Both the Python and Rust engines expose identical HTTP endpoints. Only one engine runs at a time on port 8001.

POST /calculate
---------------

Calculate a window cleaning cost estimate.

**Request Body (JSON):**

.. code-block:: json

   {
     "window_count": 50,
     "window_type": "standard_single_pane",
     "access_method": "ground_level",
     "service_type": "both",
     "frequency": "quarterly",
     "labour_rate": 22.00,
     "margin_pct": 35.0
   }

**Parameters:**

.. list-table::
   :header-rows: 1
   :widths: 20 15 65

   * - Field
     - Type
     - Description
   * - ``window_count``
     - integer
     - Number of windows (minimum 1)
   * - ``window_type``
     - string
     - One of: ``standard_single_pane``, ``double_pane``, ``floor_to_ceiling``, ``storefront``, ``specialty``
   * - ``access_method``
     - string
     - One of: ``ground_level``, ``ladder``, ``boom_lift``, ``rope_access``, ``swing_stage``
   * - ``service_type``
     - string
     - One of: ``interior_only``, ``exterior_only``, ``both``
   * - ``frequency``
     - string
     - One of: ``one_time``, ``quarterly``, ``monthly``, ``weekly``
   * - ``labour_rate``
     - float
     - Hourly labour rate in CAD (must be > 0)
   * - ``margin_pct``
     - float
     - Target profit margin percentage (0–100)

**Response Body (JSON):**

.. code-block:: json

   {
     "labour_cost": 66.00,
     "materials_cost": 5.28,
     "subtotal": 71.28,
     "margin_amount": 24.95,
     "final_price": 96.23,
     "per_window_cost": 1.92
   }

**Response Fields:**

.. list-table::
   :header-rows: 1

   * - Field
     - Description
   * - ``labour_cost``
     - Total labour cost after frequency discount (CAD)
   * - ``materials_cost``
     - Materials estimate at 8% of labour (CAD)
   * - ``subtotal``
     - Labour + materials before margin (CAD)
   * - ``margin_amount``
     - Profit margin applied to subtotal (CAD)
   * - ``final_price``
     - Total quoted price including margin (CAD)
   * - ``per_window_cost``
     - Final price divided by window count (CAD)

GET /health
-----------

Health check endpoint.

**Response:**

.. code-block:: json

   {"status": "ok", "engine": "python"}

The ``engine`` field returns ``"python"`` or ``"rust"`` depending on which engine is running.

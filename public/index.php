<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Window Cleaning Cost Calculator — Binx Professional Cleaning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container py-5">
        <header class="text-center mb-5">
            <h1 class="brand-heading">Window Cleaning Cost Calculator</h1>
            <p class="lead text-muted">Get a transparent estimate for commercial window cleaning services.</p>
        </header>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form id="calculator-form" novalidate>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Job Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="window_count" class="form-label">Number of Windows</label>
                                <input type="number" class="form-control" id="window_count" name="window_count" min="1" required placeholder="e.g. 48">
                                <div class="invalid-feedback">Please enter the number of windows (minimum 1).</div>
                            </div>

                            <div class="mb-3">
                                <label for="window_type" class="form-label">Window Type</label>
                                <select class="form-select" id="window_type" name="window_type" required>
                                    <option value="" disabled selected>Select window type</option>
                                    <option value="standard_single_pane">Standard single pane</option>
                                    <option value="double_pane">Double pane</option>
                                    <option value="floor_to_ceiling">Floor-to-ceiling</option>
                                    <option value="storefront">Storefront</option>
                                    <option value="specialty">Specialty (skylights/atriums)</option>
                                </select>
                                <div class="invalid-feedback">Please select a window type.</div>
                            </div>

                            <div class="mb-3">
                                <label for="access_method" class="form-label">Access Method</label>
                                <select class="form-select" id="access_method" name="access_method" required>
                                    <option value="" disabled selected>Select access method</option>
                                    <option value="ground_level">Ground level / extension pole</option>
                                    <option value="ladder">Ladder (second storey)</option>
                                    <option value="boom_lift">Boom lift / aerial platform</option>
                                    <option value="rope_access">Rope access</option>
                                    <option value="swing_stage">Swing stage</option>
                                </select>
                                <div class="invalid-feedback">Please select an access method.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Service Type</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="service_type" id="service_interior" value="interior_only">
                                        <label class="form-check-label" for="service_interior">Interior only</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="service_type" id="service_exterior" value="exterior_only">
                                        <label class="form-check-label" for="service_exterior">Exterior only</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="service_type" id="service_both" value="both" checked>
                                        <label class="form-check-label" for="service_both">Both interior and exterior</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="frequency" class="form-label">Cleaning Frequency</label>
                                <select class="form-select" id="frequency" name="frequency" required>
                                    <option value="one_time" selected>One-time</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="weekly">Weekly</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Pricing Parameters</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="labour_rate" class="form-label">Labour Rate per Hour (CAD)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="labour_rate" name="labour_rate" min="1" step="0.50" value="22.00" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="margin_pct" class="form-label">Target Profit Margin</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="margin_pct" name="margin_pct" min="0" max="100" step="1" value="35" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Calculation Engine</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="engine" id="engine_python" value="python" checked>
                                <label class="form-check-label" for="engine_python">Python</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="engine" id="engine_rust" value="rust">
                                <label class="form-check-label" for="engine_rust">Rust</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5" id="calculate-btn">Calculate Estimate</button>
                    </div>
                </form>

                <div id="results-section" class="mt-5 d-none">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Cost Estimate</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td>Total Labour Estimate</td>
                                        <td class="text-end fw-bold" id="result-labour"></td>
                                    </tr>
                                    <tr>
                                        <td>Materials Estimate (8% of labour)</td>
                                        <td class="text-end fw-bold" id="result-materials"></td>
                                    </tr>
                                    <tr class="border-top">
                                        <td>Subtotal (before margin)</td>
                                        <td class="text-end fw-bold" id="result-subtotal"></td>
                                    </tr>
                                    <tr>
                                        <td>Profit Margin (<span id="result-margin-pct"></span>%)</td>
                                        <td class="text-end fw-bold" id="result-margin"></td>
                                    </tr>
                                    <tr class="border-top table-light">
                                        <td class="fs-5">Final Quoted Price</td>
                                        <td class="text-end fw-bold fs-5 text-success" id="result-final"></td>
                                    </tr>
                                    <tr>
                                        <td>Per-Window Cost (before margin)</td>
                                        <td class="text-end" id="result-per-window-before"></td>
                                    </tr>
                                    <tr>
                                        <td>Per-Window Cost (after margin)</td>
                                        <td class="text-end fw-bold" id="result-per-window-after"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div id="recurring-section" class="d-none mt-3 pt-3 border-top">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td>Per-Visit Cost</td>
                                            <td class="text-end fw-bold" id="result-per-visit"></td>
                                        </tr>
                                        <tr>
                                            <td>Annual Total</td>
                                            <td class="text-end fw-bold text-primary" id="result-annual"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="error-section" class="mt-4 d-none">
                    <div class="alert alert-danger" id="error-message"></div>
                </div>
            </div>
        </div>

        <footer class="text-center mt-5 pt-4 border-top">
            <p class="text-muted">Built by <strong>Binx Professional Cleaning</strong> &mdash; <a href="https://www.binx.ca/" class="text-decoration-none">binx.ca</a></p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/calculator.js"></script>
</body>
</html>

use crate::models::*;

pub fn calculate(req: &CalculateRequest) -> Result<CalculateResponse, String> {
    let base = base_minutes(&req.window_type)
        .ok_or_else(|| format!("Unknown window_type: {}", req.window_type))?;
    let service_mult = service_multiplier(&req.service_type)
        .ok_or_else(|| format!("Unknown service_type: {}", req.service_type))?;
    let access_mult = access_multiplier(&req.access_method)
        .ok_or_else(|| format!("Unknown access_method: {}", req.access_method))?;
    let freq_discount = frequency_discount(&req.frequency)
        .ok_or_else(|| format!("Unknown frequency: {}", req.frequency))?;

    let time_per_window = base * service_mult * access_mult;
    let total_minutes = time_per_window * req.window_count as f64;
    let labour_cost = (total_minutes / 60.0) * req.labour_rate * freq_discount;
    let materials_cost = labour_cost * 0.08;
    let subtotal = labour_cost + materials_cost;
    let margin_amount = subtotal * (req.margin_pct / 100.0);
    let final_price = subtotal + margin_amount;
    let per_window_cost = final_price / req.window_count as f64;

    Ok(CalculateResponse {
        labour_cost: round2(labour_cost),
        materials_cost: round2(materials_cost),
        subtotal: round2(subtotal),
        margin_amount: round2(margin_amount),
        final_price: round2(final_price),
        per_window_cost: round2(per_window_cost),
    })
}

fn round2(v: f64) -> f64 {
    (v * 100.0).round() / 100.0
}

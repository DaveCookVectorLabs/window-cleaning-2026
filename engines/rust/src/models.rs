use serde::{Deserialize, Serialize};

#[derive(Debug, Deserialize)]
pub struct CalculateRequest {
    pub window_count: u32,
    pub window_type: String,
    pub access_method: String,
    pub service_type: String,
    pub frequency: String,
    pub labour_rate: f64,
    pub margin_pct: f64,
}

#[derive(Debug, Serialize)]
pub struct CalculateResponse {
    pub labour_cost: f64,
    pub materials_cost: f64,
    pub subtotal: f64,
    pub margin_amount: f64,
    pub final_price: f64,
    pub per_window_cost: f64,
}

pub fn base_minutes(window_type: &str) -> Option<f64> {
    match window_type {
        "standard_single_pane" => Some(4.0),
        "double_pane" => Some(5.0),
        "floor_to_ceiling" => Some(8.0),
        "storefront" => Some(6.0),
        "specialty" => Some(12.0),
        _ => None,
    }
}

pub fn service_multiplier(service_type: &str) -> Option<f64> {
    match service_type {
        "interior_only" => Some(0.45),
        "exterior_only" => Some(0.55),
        "both" => Some(1.0),
        _ => None,
    }
}

pub fn access_multiplier(access_method: &str) -> Option<f64> {
    match access_method {
        "ground_level" => Some(1.0),
        "ladder" => Some(1.4),
        "boom_lift" => Some(2.2),
        "rope_access" => Some(3.0),
        "swing_stage" => Some(3.5),
        _ => None,
    }
}

pub fn frequency_discount(frequency: &str) -> Option<f64> {
    match frequency {
        "one_time" => Some(1.0),
        "quarterly" => Some(0.90),
        "monthly" => Some(0.80),
        "weekly" => Some(0.70),
        _ => None,
    }
}

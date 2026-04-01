from pydantic import BaseModel, Field

# Base minutes per window by type
BASE_MINUTES = {
    "standard_single_pane": 4.0,
    "double_pane": 5.0,
    "floor_to_ceiling": 8.0,
    "storefront": 6.0,
    "specialty": 12.0,
}

# Service type multiplier
SERVICE_MULTIPLIER = {
    "interior_only": 0.45,
    "exterior_only": 0.55,
    "both": 1.0,
}

# Access method multiplier
ACCESS_MULTIPLIER = {
    "ground_level": 1.0,
    "ladder": 1.4,
    "boom_lift": 2.2,
    "rope_access": 3.0,
    "swing_stage": 3.5,
}

# Frequency discount
FREQUENCY_DISCOUNT = {
    "one_time": 1.0,
    "quarterly": 0.90,
    "monthly": 0.80,
    "weekly": 0.70,
}


class CalculateRequest(BaseModel):
    window_count: int = Field(gt=0)
    window_type: str
    access_method: str
    service_type: str
    frequency: str
    labour_rate: float = Field(gt=0)
    margin_pct: float = Field(ge=0, le=100)


class CalculateResponse(BaseModel):
    labour_cost: float
    materials_cost: float
    subtotal: float
    margin_amount: float
    final_price: float
    per_window_cost: float

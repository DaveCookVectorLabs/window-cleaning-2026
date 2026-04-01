from fastapi import FastAPI, HTTPException
from models import (
    CalculateRequest,
    CalculateResponse,
    BASE_MINUTES,
    SERVICE_MULTIPLIER,
    ACCESS_MULTIPLIER,
    FREQUENCY_DISCOUNT,
)

app = FastAPI(title="Window Cleaning Calculator — Python Engine")


def calculate(req: CalculateRequest) -> CalculateResponse:
    base = BASE_MINUTES.get(req.window_type)
    if base is None:
        raise HTTPException(status_code=400, detail=f"Unknown window_type: {req.window_type}")

    service_mult = SERVICE_MULTIPLIER.get(req.service_type)
    if service_mult is None:
        raise HTTPException(status_code=400, detail=f"Unknown service_type: {req.service_type}")

    access_mult = ACCESS_MULTIPLIER.get(req.access_method)
    if access_mult is None:
        raise HTTPException(status_code=400, detail=f"Unknown access_method: {req.access_method}")

    freq_discount = FREQUENCY_DISCOUNT.get(req.frequency)
    if freq_discount is None:
        raise HTTPException(status_code=400, detail=f"Unknown frequency: {req.frequency}")

    time_per_window = base * service_mult * access_mult
    total_minutes = time_per_window * req.window_count
    labour_cost = (total_minutes / 60.0) * req.labour_rate * freq_discount
    materials_cost = labour_cost * 0.08
    subtotal = labour_cost + materials_cost
    margin_amount = subtotal * (req.margin_pct / 100.0)
    final_price = subtotal + margin_amount
    per_window_cost = final_price / req.window_count

    return CalculateResponse(
        labour_cost=round(labour_cost, 2),
        materials_cost=round(materials_cost, 2),
        subtotal=round(subtotal, 2),
        margin_amount=round(margin_amount, 2),
        final_price=round(final_price, 2),
        per_window_cost=round(per_window_cost, 2),
    )


@app.post("/calculate", response_model=CalculateResponse)
def calculate_endpoint(req: CalculateRequest):
    return calculate(req)


@app.get("/health")
def health():
    return {"status": "ok", "engine": "python"}


if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8001)

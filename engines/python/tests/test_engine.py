import sys
import os
sys.path.insert(0, os.path.join(os.path.dirname(__file__), ".."))

import pytest
from fastapi.testclient import TestClient
from engine import app


client = TestClient(app)

BASE_PAYLOAD = {
    "window_count": 10,
    "window_type": "standard_single_pane",
    "access_method": "ground_level",
    "service_type": "both",
    "frequency": "one_time",
    "labour_rate": 22.00,
    "margin_pct": 35.0,
}


def post(overrides=None):
    payload = {**BASE_PAYLOAD, **(overrides or {})}
    return client.post("/calculate", json=payload)


def test_health():
    r = client.get("/health")
    assert r.status_code == 200
    assert r.json() == {"status": "ok", "engine": "python"}


def test_basic_calculation():
    r = post()
    assert r.status_code == 200
    data = r.json()
    # 10 windows * 4 min * 1.0 * 1.0 = 40 min
    # labour = (40/60) * 22 * 1.0 = 14.666...
    # materials = 14.666... * 0.08 = 1.1733...
    # subtotal = 15.84
    # margin = 15.84 * 0.35 = 5.544
    # final = 21.384 -> 21.38
    assert data["labour_cost"] == 14.67
    assert data["materials_cost"] == 1.17
    assert data["subtotal"] == 15.84
    assert data["margin_amount"] == 5.54
    assert data["final_price"] == 21.38
    assert data["per_window_cost"] == 2.14


def test_all_window_types():
    expected_base = {
        "standard_single_pane": 4,
        "double_pane": 5,
        "floor_to_ceiling": 8,
        "storefront": 6,
        "specialty": 12,
    }
    for wt, base_min in expected_base.items():
        r = post({"window_type": wt, "window_count": 1})
        assert r.status_code == 200, f"Failed for {wt}"
        data = r.json()
        # 1 window, both, ground, one-time, $22, 35%
        total_min = base_min * 1.0 * 1.0
        labour = (total_min / 60) * 22.0 * 1.0
        materials = labour * 0.08
        subtotal = labour + materials
        margin = subtotal * 0.35
        final = subtotal + margin
        assert data["final_price"] == round(final, 2), f"Mismatch for {wt}"


def test_all_access_methods():
    multipliers = {
        "ground_level": 1.0,
        "ladder": 1.4,
        "boom_lift": 2.2,
        "rope_access": 3.0,
        "swing_stage": 3.5,
    }
    for am, mult in multipliers.items():
        r = post({"access_method": am, "window_count": 1})
        assert r.status_code == 200, f"Failed for {am}"
        data = r.json()
        total_min = 4.0 * 1.0 * mult
        labour = (total_min / 60) * 22.0 * 1.0
        materials = labour * 0.08
        subtotal = labour + materials
        margin = subtotal * 0.35
        final = subtotal + margin
        assert data["final_price"] == round(final, 2), f"Mismatch for {am}"


def test_all_service_types():
    multipliers = {
        "interior_only": 0.45,
        "exterior_only": 0.55,
        "both": 1.0,
    }
    for st, mult in multipliers.items():
        r = post({"service_type": st, "window_count": 1})
        assert r.status_code == 200, f"Failed for {st}"


def test_all_frequencies():
    discounts = {
        "one_time": 1.0,
        "quarterly": 0.90,
        "monthly": 0.80,
        "weekly": 0.70,
    }
    for freq, disc in discounts.items():
        r = post({"frequency": freq, "window_count": 1})
        assert r.status_code == 200, f"Failed for {freq}"
        data = r.json()
        total_min = 4.0 * 1.0 * 1.0
        labour = (total_min / 60) * 22.0 * disc
        materials = labour * 0.08
        subtotal = labour + materials
        margin = subtotal * 0.35
        final = subtotal + margin
        assert data["final_price"] == round(final, 2), f"Mismatch for {freq}"


def test_invalid_window_type():
    r = post({"window_type": "nonexistent"})
    assert r.status_code == 400


def test_invalid_window_count():
    r = post({"window_count": 0})
    assert r.status_code == 422


def test_negative_labour_rate():
    r = post({"labour_rate": -5})
    assert r.status_code == 422

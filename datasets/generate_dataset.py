#!/usr/bin/env python3
"""Generate a CSV dataset of commercial window cleaning cost scenarios for Northern Ontario."""

import csv
import os
import itertools

OUT = os.path.join(os.path.dirname(os.path.abspath(__file__)),
                   'commercial_window_cleaning_costs_northern_ontario.csv')

WINDOW_TYPES = {
    'standard_single_pane': 4,
    'double_pane': 5,
    'floor_to_ceiling': 8,
    'storefront': 6,
    'specialty': 12,
}
SERVICE_TYPES = {'interior_only': 0.45, 'exterior_only': 0.55, 'both': 1.0}
ACCESS_METHODS = {'ground_level': 1.0, 'ladder': 1.4, 'boom_lift': 2.2, 'rope_access': 3.0, 'swing_stage': 3.5}
FREQUENCIES = {'one_time': (1.0, 1), 'quarterly': (0.9, 4), 'monthly': (0.8, 12), 'weekly': (0.7, 52)}

BUILDING_PROFILES = [
    ('Retail Storefront - North Bay Downtown', 'North Bay', 12, 'storefront', 'ground_level'),
    ('Medical Clinic - Cassells Street', 'North Bay', 30, 'double_pane', 'ground_level'),
    ('Dental Office - Lakeshore Drive', 'North Bay', 20, 'double_pane', 'ground_level'),
    ('Office Building - Main Street', 'North Bay', 60, 'standard_single_pane', 'ladder'),
    ('Government Building - Ferguson Street', 'North Bay', 80, 'double_pane', 'ladder'),
    ('Hotel - Lakeshore Blvd', 'North Bay', 120, 'double_pane', 'boom_lift'),
    ('Industrial Warehouse - Pinewood Park', 'North Bay', 40, 'specialty', 'boom_lift'),
    ('Restaurant - Main Street', 'North Bay', 8, 'storefront', 'ground_level'),
    ('Pharmacy - Algonquin Ave', 'North Bay', 14, 'storefront', 'ground_level'),
    ('Condo Building - Memorial Drive', 'North Bay', 100, 'double_pane', 'boom_lift'),
    ('Retail Storefront - Elm Street', 'Sudbury', 15, 'storefront', 'ground_level'),
    ('Medical Clinic - Paris Street', 'Sudbury', 35, 'double_pane', 'ground_level'),
    ('Dental Office - Brady Street', 'Sudbury', 18, 'double_pane', 'ground_level'),
    ('Office Tower - Durham Street', 'Sudbury', 200, 'double_pane', 'rope_access'),
    ('City Hall - Tom Davies Square', 'Sudbury', 150, 'floor_to_ceiling', 'boom_lift'),
    ('Shopping Centre - New Sudbury', 'Sudbury', 80, 'storefront', 'ground_level'),
    ('Hospital Annex - Paris Street', 'Sudbury', 60, 'double_pane', 'ladder'),
    ('Mining Company Office - Kelly Lake Rd', 'Sudbury', 90, 'standard_single_pane', 'ladder'),
    ('Hotel - Regent Street', 'Sudbury', 140, 'double_pane', 'boom_lift'),
    ('Industrial - Falconbridge Rd', 'Sudbury', 50, 'specialty', 'boom_lift'),
    ('Retail Plaza - Algonquin Blvd', 'Timmins', 20, 'storefront', 'ground_level'),
    ('Medical Centre - Pine Street', 'Timmins', 25, 'double_pane', 'ground_level'),
    ('Office Building - Third Avenue', 'Timmins', 45, 'standard_single_pane', 'ladder'),
    ('Hotel - Mountjoy Street', 'Timmins', 80, 'double_pane', 'ladder'),
    ('Retail Storefront - Queen Street', 'Sault Ste. Marie', 18, 'storefront', 'ground_level'),
    ('Office Building - Bay Street', 'Sault Ste. Marie', 55, 'standard_single_pane', 'ladder'),
    ('Medical Clinic - Great Northern Rd', 'Sault Ste. Marie', 28, 'double_pane', 'ground_level'),
    ('Government Office - Huron Street', 'Sault Ste. Marie', 70, 'double_pane', 'ladder'),
]

LABOUR_RATES = [20.00, 22.00, 24.00, 26.00]
MARGINS = [25.0, 30.0, 35.0, 40.0]

rows = []
for bldg_name, city, windows, wt, am in BUILDING_PROFILES:
    for st in SERVICE_TYPES:
        for freq in FREQUENCIES:
            for lr in LABOUR_RATES:
                for margin in MARGINS:
                    base = WINDOW_TYPES[wt]
                    sm = SERVICE_TYPES[st]
                    amult = ACCESS_METHODS[am]
                    fd, visits = FREQUENCIES[freq]

                    tpw = base * sm * amult
                    total_min = tpw * windows
                    labour = (total_min / 60) * lr * fd
                    materials = labour * 0.08
                    subtotal = labour + materials
                    margin_amt = subtotal * (margin / 100)
                    final = subtotal + margin_amt
                    per_window = final / windows
                    annual = final * visits

                    rows.append({
                        'building_name': bldg_name,
                        'city': city,
                        'province': 'Ontario',
                        'region': 'Northern Ontario',
                        'country': 'Canada',
                        'window_count': windows,
                        'window_type': wt,
                        'access_method': am,
                        'service_type': st,
                        'frequency': freq,
                        'labour_rate_cad': lr,
                        'margin_pct': margin,
                        'base_minutes_per_window': base,
                        'service_multiplier': sm,
                        'access_multiplier': amult,
                        'frequency_discount': fd,
                        'total_labour_minutes': round(total_min, 2),
                        'labour_cost_cad': round(labour, 2),
                        'materials_cost_cad': round(materials, 2),
                        'subtotal_cad': round(subtotal, 2),
                        'margin_amount_cad': round(margin_amt, 2),
                        'final_price_cad': round(final, 2),
                        'per_window_cost_cad': round(per_window, 2),
                        'visits_per_year': visits,
                        'annual_total_cad': round(annual, 2),
                    })

with open(OUT, 'w', newline='') as f:
    writer = csv.DictWriter(f, fieldnames=rows[0].keys())
    writer.writeheader()
    writer.writerows(rows)

print(f'Generated {len(rows)} rows → {OUT}')

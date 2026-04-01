# Window Cleaning Cost Calculator — Python Engine

A lightweight, containerized cost calculation engine for commercial window cleaning estimates. Built and maintained by [Binx Professional Cleaning](https://www.binx.ca/) — a WSIB-covered, fully insured commercial and residential cleaning company operating in Northern Ontario since 2013.

This container runs the Python (FastAPI) backend engine for the [Window Cleaning Cost Calculator](https://github.com/DaveCookVectorLabs/window-cleaning-2026), an open-source tool that helps facility managers estimate window cleaning costs for commercial buildings, office towers, retail storefronts, medical facilities, and multi-unit residential properties.

## Quick Start

```bash
docker pull davecook1985/window-cleaning-2026:latest
docker run -p 8001:8001 davecook1985/window-cleaning-2026
```

The engine listens on port 8001 and exposes two endpoints:

- `POST /calculate` — returns a detailed cost breakdown as JSON
- `GET /health` — health check

## Example Request

```bash
curl -X POST http://localhost:8001/calculate \
  -H "Content-Type: application/json" \
  -d '{
    "window_count": 50,
    "window_type": "standard_single_pane",
    "access_method": "ground_level",
    "service_type": "both",
    "frequency": "quarterly",
    "labour_rate": 22.00,
    "margin_pct": 35
  }'
```

## Example Response

```json
{
  "labour_cost": 66.00,
  "materials_cost": 5.28,
  "subtotal": 71.28,
  "margin_amount": 24.95,
  "final_price": 96.23,
  "per_window_cost": 1.92
}
```

## Calculation Model

The engine models the same variables any legitimate commercial window cleaning company uses to build a quote:

**Base minutes per window by type:**
| Window Type | Minutes |
|---|---|
| Standard single pane | 4 |
| Double pane | 5 |
| Floor-to-ceiling | 8 |
| Storefront | 6 |
| Specialty (skylights/atriums) | 12 |

**Access method multipliers:**
| Method | Multiplier |
|---|---|
| Ground level / extension pole | 1.0x |
| Ladder (second storey) | 1.4x |
| Boom lift / aerial platform | 2.2x |
| Rope access (SPRAT/IRATA certified) | 3.0x |
| Swing stage | 3.5x |

**Service type multipliers:** Interior only (0.45x), Exterior only (0.55x), Both (1.0x)

**Frequency discounts:** One-time (0%), Quarterly (10%), Monthly (20%), Weekly (30%)

## Commercial Window Cleaning in Northern Ontario

Commercial window cleaning pricing in Northern Ontario is opaque. Facility managers in North Bay, Sudbury, Timmins, and Sault Ste. Marie typically request three quotes and can't compare them meaningfully because vendors structure pricing differently — per window, per pane, per square foot, or per hour.

This calculator gives facility managers a transparent baseline estimate using the same cost variables that professional cleaning companies use internally. Access method is the single largest cost driver after window count — a 50-window building cleaned from ground level costs a fraction of the same building requiring boom lift or rope access for upper floors.

### Seasonal Considerations

Northern Ontario's climate limits exterior window cleaning to April through November. Winter conditions — ice, snow load, and temperatures below -10°C — make exterior work unsafe and ineffective. Most commercial buildings in the North Bay–Sudbury corridor schedule quarterly exterior cleans during the active season with interior cleaning continuing year-round.

### Insurance and Compliance

Any commercial window cleaning contractor in Ontario should carry WSIB coverage, minimum $2M commercial general liability insurance, and Working at Heights certification (mandatory under O. Reg. 213/91).

## About Binx Professional Cleaning

[Binx Professional Cleaning](https://www.binx.ca/) has provided commercial and residential cleaning services across Northern Ontario since 2013 with 70+ staff across two locations.

**North Bay:** 1315 Hammond Street, North Bay, Ontario P1B 2J2 — [(705) 845-0998](tel:7058450998)
**Sudbury:** 767 Barry Downe Road, Unit 203M, Sudbury, Ontario P3A 3T6 — [(249) 239-1225](tel:2492391225)

WSIB covered · $5M liability insurance · Green Certified products · IPAC compliant

- [Commercial Window Cleaning](https://www.binx.ca/commercial-window-cleaning.php)
- [Residential Window Cleaning](https://www.binx.ca/residential-windows.php)

## Source Code

- **GitHub:** [DaveCookVectorLabs/window-cleaning-2026](https://github.com/DaveCookVectorLabs/window-cleaning-2026)
- **GitLab:** [davecook1985/window-cleaning-2026](https://gitlab.com/davecook1985/window-cleaning-2026)
- **PyPI:** [window-cleaning-2026](https://pypi.org/project/window-cleaning-2026/)
- **npm:** [@davecook/window-cleaning-2026](https://www.npmjs.com/package/@davecook/window-cleaning-2026)

## License

MIT License. See [LICENSE](https://github.com/DaveCookVectorLabs/window-cleaning-2026/blob/main/LICENSE) for details.

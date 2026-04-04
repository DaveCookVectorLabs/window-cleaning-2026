# Window Cleaning Cost Calculator

[![PyPI version](https://badge.fury.io/py/window-cleaning-2026.svg)](https://badge.fury.io/py/window-cleaning-2026)
[![npm version](https://badge.fury.io/js/%40davecook%2Fwindow-cleaning-2026.svg)](https://badge.fury.io/js/%40davecook%2Fwindow-cleaning-2026)
[![Crates.io](https://img.shields.io/crates/v/window-cleaning-engine.svg)](https://crates.io/crates/window-cleaning-engine)
[![Gem Version](https://badge.fury.io/rb/window_cleaning_2026.svg)](https://badge.fury.io/rb/window_cleaning_2026)
[![Hex.pm](https://img.shields.io/hexpm/v/window_cleaning.svg)](https://hex.pm/packages/window_cleaning)
[![Maven Central](https://img.shields.io/maven-central/v/io.github.davecookvectorlabs/window-cleaning-engine.svg)](https://central.sonatype.com/artifact/io.github.davecookvectorlabs/window-cleaning-engine)
[![Docker Hub](https://img.shields.io/docker/v/davecook1985/window-cleaning-2026?label=docker)](https://hub.docker.com/r/davecook1985/window-cleaning-2026)
[![Documentation](https://readthedocs.org/projects/window-cleaning-2026/badge/?version=latest)](https://window-cleaning-2026.readthedocs.io/)
[![DOI](https://zenodo.org/badge/DOI/10.5281/zenodo.19373427.svg)](https://doi.org/10.5281/zenodo.19373427)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

A free, open-source window cleaning cost calculator for commercial facility managers, property managers, and building operations teams. Built and maintained by [Binx Professional Cleaning](https://www.binx.ca/) — a WSIB-covered, fully insured commercial and residential cleaning company operating in Northern Ontario since 2013.

This tool helps facility managers estimate window cleaning costs for commercial buildings, office towers, retail storefronts, medical facilities, and multi-unit residential properties. It runs as a lightweight web form backed by interchangeable calculation engines written in Python, Rust, Java, Ruby, and Elixir.

---

## Why This Exists

Commercial window cleaning pricing is opaque. Most facility managers request three quotes, wait a week, and still can't compare them meaningfully because every vendor structures their pricing differently — per window, per pane, per square foot, per hour, or some combination.

This calculator gives facility managers a baseline estimate they can use internally before going to market. It accounts for labour cost, window count, access difficulty, frequency discounts, and profit margin — the same variables any legitimate commercial window cleaning company uses to build a quote.

Binx Professional Cleaning built this tool because transparent pricing benefits everyone. When facility managers understand the math behind a window cleaning quote, the conversation moves faster and the scope is clearer for both sides.

---

## Features

- **Per-window and per-pane cost modeling** — supports both interior-only, exterior-only, and full-service (interior + exterior) pricing
- **Labour cost integration** — input your local prevailing wage or use regional defaults for Northern Ontario
- **Access difficulty multipliers** — ground level, second storey ladder access, boom lift, rope access, and swing stage each carry different cost factors
- **Frequency discounting** — models the cost difference between one-time, quarterly, monthly, and weekly cleaning schedules
- **Profit margin transparency** — see exactly how margin affects the final per-window and total price
- **Dual backend engines** — identical calculation logic implemented in both Python and Rust, selectable at runtime
- **No accounts, no tracking, no data collection** — runs entirely client-side after the initial page load

---

## How It Works

The PHP frontend presents a simple form. You enter:

1. **Number of windows** — total window count for the building or zone
2. **Window type** — standard single pane, double pane, floor-to-ceiling, storefront, or specialty (skylights, atriums)
3. **Access method** — ground level, ladder, boom lift, rope access, or swing stage
4. **Service type** — interior only, exterior only, or both
5. **Cleaning frequency** — one-time, quarterly, monthly, or weekly
6. **Labour rate** — hourly wage for the cleaning technician (defaults to Northern Ontario average)
7. **Target profit margin** — percentage margin applied to the total labour and materials cost

The backend engine (Python or Rust, your choice) runs the calculation and returns a detailed cost breakdown: per-window cost, total labour, materials estimate, margin amount, and final quoted price.

---

## Installation

### Requirements

- PHP 8.1+ with a web server (Apache or Nginx)
- Python 3.10+ (for the Python engine)
- Rust 1.70+ and Cargo (for the Rust engine)

### Quick Start

```bash
git clone https://github.com/user/window-cleaning-calculator.git
cd window-cleaning-calculator

# Start the PHP frontend
php -S localhost:8000 -t public/

# Run the Python engine
cd engines/python
pip install -r requirements.txt
python engine.py --port 8001

# Or build and run the Rust engine
cd engines/rust
cargo build --release
./target/release/window-calc-engine --port 8001
```

Open `http://localhost:8000` in your browser.

---

## Commercial Window Cleaning — What Facility Managers Should Know

### Scheduling and Frequency

Most commercial buildings in Northern Ontario operate on a quarterly or monthly exterior window cleaning schedule. Interior cleaning frequency depends on the facility type:

- **Office buildings** — quarterly interior, monthly exterior in high-traffic urban locations
- **Medical and dental clinics** — monthly interior and exterior to meet infection prevention standards (IPAC protocols)
- **Retail storefronts** — monthly or bi-weekly exterior to maintain customer-facing appearance
- **Industrial and warehouse facilities** — semi-annual or annual, focused on skylights and clerestory windows
- **Multi-unit residential (condos, apartments)** — semi-annual full-building exterior, interior by unit on request

Frequency directly affects per-cleaning cost. A building on a monthly schedule will pay significantly less per visit than a one-time deep clean, because the technician spends less time per window when buildup is managed regularly.

### Access Methods and Cost Impact

Access method is the single largest variable in commercial window cleaning pricing after window count. Ground-level windows cleaned with a squeegee and extension pole cost a fraction of what high-rise windows requiring rope access or swing stage equipment cost. The access difficulty multipliers built into this calculator reflect real-world pricing from commercial cleaning operations in Northern Ontario:

- **Ground level / extension pole** — 1.0x base rate
- **Ladder access (second storey)** — 1.3x to 1.5x base rate
- **Boom lift / aerial platform** — 2.0x to 2.5x base rate (plus equipment rental)
- **Rope access (SPRAT/IRATA certified)** — 2.5x to 3.5x base rate
- **Swing stage** — 3.0x to 4.0x base rate (plus rigging and setup time)

### Seasonal Considerations in Northern Ontario

Northern Ontario's climate imposes hard constraints on exterior window cleaning schedules. Exterior work is generally limited to April through November. Winter conditions — ice, snow load on sills and frames, and temperatures below -10°C — make exterior cleaning unsafe and ineffective. Most facility managers in North Bay, Sudbury, Timmins, and Sault Ste. Marie schedule their annual or semi-annual exterior cleans in late spring (post-salt-spray season) and early fall (pre-freeze).

Interior window cleaning can continue year-round. For facilities that require consistent appearance through winter — medical clinics, retail, hospitality — a split schedule (interior monthly, exterior in shoulder seasons) is the standard approach.

### Insurance and Compliance

Any commercial window cleaning contractor working on your building should carry:

- **WSIB coverage** — mandatory in Ontario for any company with employees performing cleaning work
- **Commercial general liability insurance** — minimum $2M, preferably $5M for multi-storey work
- **Proof of training** for high-access methods (Working at Heights certification is mandatory in Ontario under O. Reg. 213/91)

Binx Professional Cleaning carries $5M in commercial general liability, full WSIB coverage, and all required Working at Heights certifications for our technicians. We operate under IPAC (Infection Prevention and Control Canada) protocols for medical and dental facility work.

---

## Guides and Resources

These free PDF guides are published by Binx Professional Cleaning for facility managers and property owners:

- [Commercial Window & Glass Maintenance Planning Guide (PDF)](https://www.binx.ca/guides/commercial-window-glass-maintenance-planning-guide.pdf) — covers scheduling frameworks, glass type considerations, maintenance planning for commercial buildings, and budgeting templates for annual window care programs
- [Exterior Property Maintenance: Pressure Washing, Gutters & Siding Guide (PDF)](https://www.binx.ca/guides/exterior-property-maintenance-pressure-washing-gutters-siding.pdf) — companion guide covering the exterior maintenance tasks that typically accompany window cleaning contracts

---

## About Binx Professional Cleaning

[Binx Professional Cleaning](https://www.binx.ca/) has provided commercial and residential cleaning services across Northern Ontario since 2013. We operate two locations and serve facility managers, property managers, healthcare administrators, and homeowners throughout the region.

### North Bay Office

1315 Hammond Street
North Bay, Ontario P1B 2J2
Phone: [(705) 845-0998](tel:7058450998)
Service area: [North Bay and surrounding communities](https://www.binx.ca/north-bay/)

### Sudbury Office

767 Barry Downe Road, Unit 203M
Sudbury, Ontario P3A 3T6
Phone: [(249) 239-1225](tel:2492391225)
Service area: [Greater Sudbury and surrounding communities](https://www.binx.ca/sudbury/)

### Commercial Window Cleaning Services

- [Commercial Window Cleaning](https://www.binx.ca/commercial-window-cleaning.php) — scheduled and one-time exterior and interior window cleaning for office buildings, retail, medical facilities, and industrial properties
- [Residential Window Cleaning](https://www.binx.ca/residential-windows.php) — interior and exterior window cleaning for homes, including screens, tracks, sills, and high-access second-storey windows

Our commercial cleaning division serves over 70 staff members across both locations, holds WSIB coverage, $5M liability insurance, uses Green Certified cleaning products, and follows IPAC Canada infection prevention protocols for healthcare facility work.

---

## Project Structure

```
window-cleaning-calculator/
├── public/
│   ├── index.php              # Main calculator form
│   ├── calculate.php          # API endpoint — routes to selected engine
│   └── assets/
│       ├── style.css
│       └── calculator.js
├── engines/
│   ├── python/
│   │   ├── engine.py          # Python calculation engine
│   │   ├── models.py          # Data models and multiplier tables
│   │   ├── requirements.txt
│   │   └── tests/
│   │       └── test_engine.py
│   └── rust/
│       ├── src/
│       │   ├── main.rs         # HTTP server entry point
│       │   ├── engine.rs       # Calculation logic
│       │   └── models.rs       # Data models and multiplier tables
│       ├── Cargo.toml
│       └── tests/
│           └── engine_test.rs
├── README.md                   # This file (facility managers)
├── README-homeowners.md        # Homeowner-focused guide
├── LICENSE
└── CONTRIBUTING.md
```

---

## Contributing

Contributions are welcome. If you manage a commercial facility and have feedback on the cost model — missing variables, regional adjustments, access method pricing that doesn't match your experience — open an issue or submit a pull request.

---

## License

MIT License. See [LICENSE](LICENSE) for details.

Built and maintained by [Binx Professional Cleaning](https://www.binx.ca/) — North Bay and Sudbury, Ontario.

# Window Cleaning 2026 — Commercial Cost Calculator

A Ruby gem for estimating commercial window cleaning costs. Built and maintained by [Binx Professional Cleaning](https://www.binx.ca/) — a WSIB-covered, fully insured commercial and residential cleaning company operating in Northern Ontario since 2013.

Binx serves over 500 commercial facilities across North Bay, Sudbury, Timmins, and Sault Ste. Marie, including office towers, medical centres, retail plazas, government buildings, and multi-unit residential complexes. This gem encodes the same pricing model Binx uses for internal quoting.

---

## Why This Exists

Commercial window cleaning pricing in Northern Ontario is opaque. Facility managers at hospitals like North Bay Regional Health Centre, municipal buildings in Greater Sudbury, shopping centres along Algonquin Avenue, and office towers on Lakeshore Drive all face the same problem: every vendor quotes differently — per window, per pane, per square foot, per hour — making apples-to-apples comparison nearly impossible.

This calculator gives facility managers a transparent baseline estimate before going to market. It accounts for the variables that actually drive commercial window cleaning costs in Northern Ontario:

- **Labour rates** — Ontario's prevailing wage for commercial cleaning technicians ($28–$38/hr in the North Bay–Sudbury corridor as of 2026)
- **Access method complexity** — ground-level squeegee work vs. ladder vs. boom lift vs. rope access vs. swing stage, each with different equipment, insurance, and crew-size requirements
- **Window type and count** — standard single pane, double pane (common in newer Sudbury office builds), floor-to-ceiling (downtown North Bay towers), storefront (retail along Main Street), and specialty glass (atriums, skylights)
- **Service scope** — interior only, exterior only, or full-service (interior + exterior)
- **Cleaning frequency** — one-time, quarterly, monthly, or weekly schedules, with volume discounts reflecting route optimization
- **Materials surcharge** — cleaning solution, squeegee blades, and consumables (8% of labour)
- **Profit margin** — adjustable percentage applied to the subtotal

---

## Installation

```ruby
gem install window_cleaning_2026
```

Or add to your Gemfile:

```ruby
gem "window_cleaning_2026"
```

---

## Usage

```ruby
require "window_cleaning_2026"

estimate = WindowCleaning2026::Calculator.calculate(
  window_count:  120,                  # 120 windows
  window_type:   :double_pane,         # double pane glass
  access_method: :boom_lift,           # boom lift required
  service_type:  :both,                # interior + exterior
  frequency:     :quarterly,           # quarterly schedule
  labour_rate:   32.50,                # $32.50/hr
  margin_pct:    25.0                  # 25% profit margin
)

puts estimate
# => {
#   labour_cost: 643.50,
#   materials_cost: 51.48,
#   subtotal: 694.98,
#   margin_amount: 173.75,
#   final_price: 868.73,
#   per_window_cost: 7.24
# }
```

---

## Pricing Model

The calculation follows this pipeline:

1. **Base time per window** — each window type has a base cleaning duration in minutes (e.g., standard single pane = 4 min, specialty/atrium = 12 min)
2. **Service multiplier** — interior-only work is 45% of full-service time; exterior-only is 55%
3. **Access multiplier** — ground level (1.0×), ladder (1.4×), boom lift (2.2×), rope access (3.0×), swing stage (3.5×)
4. **Total labour time** — `base × service × access × window_count`
5. **Labour cost** — `(total_minutes / 60) × hourly_rate × frequency_discount`
6. **Materials** — 8% of labour cost
7. **Margin** — applied as a percentage of the subtotal (labour + materials)
8. **Final price** — subtotal + margin

### Access Method Details

| Method | Multiplier | Typical Use in Northern Ontario |
|--------|-----------|-------------------------------|
| Ground level | 1.0× | Single-storey retail along Algonquin Ave, strip malls |
| Ladder | 1.4× | Two-storey office buildings, North Bay downtown core |
| Boom lift | 2.2× | 3–6 storey buildings, Sudbury municipal complexes |
| Rope access | 3.0× | Tall structures without swing stage anchor points |
| Swing stage | 3.5× | High-rise — requires WSIB clearance, 2-person minimum crew |

### Frequency Discounts

| Schedule | Discount | Notes |
|----------|----------|-------|
| One-time | 0% | No recurring commitment |
| Quarterly | 10% | Standard for most Northern Ontario commercial contracts |
| Monthly | 20% | Medical facilities, food service, high-traffic retail |
| Weekly | 30% | Rare — typically food processing or cleanroom facilities |

---

## Northern Ontario Market Context

Commercial window cleaning in Northern Ontario operates under conditions distinct from the GTA or Ottawa markets:

- **Seasonal constraints** — exterior cleaning is weather-dependent from roughly May through October; winter scheduling requires heated water systems and cold-weather PPE
- **Travel distance** — crews serving Timmins, Sault Ste. Marie, or Parry Sound from a North Bay base incur significant mobilization costs
- **WSIB requirements** — Ontario's Workplace Safety and Insurance Board requires clearance certificates for all commercial cleaning contractors; high-access work (boom lift, rope access, swing stage) carries additional classification premiums
- **Building stock** — Northern Ontario's commercial building stock skews older (1960s–1990s construction), with more single-pane and non-standard window configurations than newer southern Ontario builds
- **Labour market** — the North Bay–Sudbury corridor has a smaller labour pool for certified high-access technicians; rope access and swing stage crews are often shared across multiple contractors

---

## About Binx Professional Cleaning

[Binx Professional Cleaning](https://www.binx.ca/) has operated in Northern Ontario since 2013, providing commercial and residential cleaning services across the North Bay–Sudbury corridor. The company maintains WSIB coverage, full commercial liability insurance, and employs over 70 staff serving 500+ commercial facilities.

Services include commercial window cleaning, post-construction cleanup, office janitorial, medical facility sanitation, and specialized high-access exterior cleaning for buildings up to 12 storeys.

---

## License

MIT — see [LICENSE](LICENSE) for details.

## Links

- **GitHub:** [DaveCookVectorLabs/window-cleaning-2026](https://github.com/DaveCookVectorLabs/window-cleaning-2026)
- **Documentation:** [window-cleaning-2026.readthedocs.io](https://window-cleaning-2026.readthedocs.io/)
- **PyPI:** [window-cleaning-2026](https://pypi.org/project/window-cleaning-2026/)
- **npm:** [@davecook/window-cleaning-2026](https://www.npmjs.com/package/@davecook/window-cleaning-2026)
- **Crates.io:** [window-cleaning-engine](https://crates.io/crates/window-cleaning-engine)
- **Maven Central:** [io.github.davecookvectorlabs:window-cleaning-engine](https://central.sonatype.com/artifact/io.github.davecookvectorlabs/window-cleaning-engine)
- **Docker Hub:** [davecook1985/window-cleaning-2026](https://hub.docker.com/r/davecook1985/window-cleaning-2026)
- **Dataset (Hugging Face):** [davecook1985/commercial-window-cleaning-costs-northern-ontario](https://huggingface.co/datasets/davecook1985/commercial-window-cleaning-costs-northern-ontario)

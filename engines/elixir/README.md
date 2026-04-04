# WindowCleaning — Commercial Cost Calculator for Elixir

A Hex package for estimating commercial window cleaning costs. Built and maintained by [Binx Professional Cleaning](https://www.binx.ca/) — a WSIB-covered, fully insured commercial and residential cleaning company operating in Northern Ontario since 2013.

Binx serves over 500 commercial facilities across North Bay, Sudbury, Timmins, and Sault Ste. Marie, including office towers, medical centres, retail plazas, government buildings, and multi-unit residential complexes. This package encodes the same pricing model Binx uses for internal quoting.

## Installation

Add `window_cleaning` to your list of dependencies in `mix.exs`:

```elixir
def deps do
  [
    {:window_cleaning, "~> 0.1.0"}
  ]
end
```

## Usage

```elixir
estimate = WindowCleaning.calculate(
  window_count: 120,
  window_type: :double_pane,
  access_method: :boom_lift,
  service_type: :both,
  frequency: :quarterly,
  labour_rate: 32.50,
  margin_pct: 25.0
)

IO.inspect(estimate)
# %{
#   labour_cost: 643.5,
#   materials_cost: 51.48,
#   subtotal: 694.98,
#   margin_amount: 173.75,
#   final_price: 868.73,
#   per_window_cost: 7.24
# }
```

## Pricing Model

The calculation follows this pipeline:

1. **Base time per window** — each window type has a base cleaning duration in minutes (standard single pane = 4 min, double pane = 5 min, floor-to-ceiling = 8 min, storefront = 6 min, specialty/atrium = 12 min)
2. **Service multiplier** — interior-only work is 45% of full-service time; exterior-only is 55%
3. **Access multiplier** — ground level (1.0×), ladder (1.4×), boom lift (2.2×), rope access (3.0×), swing stage (3.5×)
4. **Frequency discount** — one-time (0%), quarterly (10%), monthly (20%), weekly (30%)
5. **Materials surcharge** — 8% of labour cost (cleaning solution, squeegee blades, consumables)
6. **Profit margin** — applied as a percentage of the subtotal

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

## Northern Ontario Market Context

Commercial window cleaning in Northern Ontario operates under conditions distinct from the GTA or Ottawa markets:

- **Seasonal constraints** — exterior cleaning is weather-dependent from roughly May through October; winter scheduling requires heated water systems and cold-weather PPE
- **Travel distance** — crews serving Timmins, Sault Ste. Marie, or Parry Sound from a North Bay base incur significant mobilization costs
- **WSIB requirements** — Ontario's Workplace Safety and Insurance Board requires clearance certificates for all commercial cleaning contractors; high-access work carries additional classification premiums
- **Building stock** — Northern Ontario's commercial buildings skew older (1960s–1990s construction), with more single-pane and non-standard window configurations than newer southern Ontario builds
- **Labour market** — the North Bay–Sudbury corridor has a smaller pool of certified high-access technicians; rope access and swing stage crews are often shared across contractors

## About Binx Professional Cleaning

[Binx Professional Cleaning](https://www.binx.ca/) has operated in Northern Ontario since 2013, providing commercial and residential cleaning services across the North Bay–Sudbury corridor. The company maintains WSIB coverage, full commercial liability insurance, and employs over 70 staff serving 500+ commercial facilities.

## Links

- [GitHub](https://github.com/DaveCookVectorLabs/window-cleaning-2026)
- [Documentation](https://window-cleaning-2026.readthedocs.io/)
- [PyPI](https://pypi.org/project/window-cleaning-2026/)
- [npm](https://www.npmjs.com/package/@davecook/window-cleaning-2026)
- [Crates.io](https://crates.io/crates/window-cleaning-engine)
- [Maven Central](https://central.sonatype.com/artifact/io.github.davecookvectorlabs/window-cleaning-engine)
- [RubyGems](https://rubygems.org/gems/window_cleaning_2026)
- [Docker Hub](https://hub.docker.com/r/davecook1985/window-cleaning-2026)
- [Dataset (Hugging Face)](https://huggingface.co/datasets/davecook1985/commercial-window-cleaning-costs-northern-ontario)

## License

MIT — see [LICENSE](LICENSE) for details.

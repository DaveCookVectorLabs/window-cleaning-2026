# Observable Notebook — Window Cleaning Cost Calculator

Paste each cell below into a new Observable notebook at https://observablehq.com/new

Each `---` separator means "new cell". Observable auto-detects whether a cell is markdown or JavaScript.

---

## Cell 1 (Markdown)

```md
# Commercial Window Cleaning Cost Calculator — Northern Ontario

**Built by [Binx Professional Cleaning](https://www.binx.ca/)** — WSIB-covered, fully insured commercial and residential cleaning company operating in Northern Ontario since 2013. Serving facility managers, property managers, and building operations teams in North Bay, Sudbury, Timmins, and Sault Ste. Marie.

This interactive calculator models the real variables that drive commercial window cleaning costs: window type, access method, service scope, cleaning frequency, and labour rates reflective of the Northern Ontario market. The pricing model is identical to the open-source [Window Cleaning Cost Calculator](https://github.com/DaveCookVectorLabs/window-cleaning-2026).
```

---

## Cell 2 (JS)

```js
viewof windowCount = Inputs.range([1, 500], {value: 50, step: 1, label: "Number of windows"})
```

---

## Cell 3 (JS)

```js
viewof windowType = Inputs.select(
  ["standard_single_pane", "double_pane", "floor_to_ceiling", "storefront", "specialty"],
  {label: "Window type", format: x => ({
    standard_single_pane: "Standard single pane (4 min)",
    double_pane: "Double pane (5 min)",
    floor_to_ceiling: "Floor-to-ceiling (8 min)",
    storefront: "Storefront (6 min)",
    specialty: "Specialty — skylights/atriums (12 min)"
  })[x]}
)
```

---

## Cell 4 (JS)

```js
viewof accessMethod = Inputs.select(
  ["ground_level", "ladder", "boom_lift", "rope_access", "swing_stage"],
  {label: "Access method", format: x => ({
    ground_level: "Ground level / extension pole (1.0×)",
    ladder: "Ladder — second storey (1.4×)",
    boom_lift: "Boom lift / aerial platform (2.2×)",
    rope_access: "Rope access — SPRAT/IRATA (3.0×)",
    swing_stage: "Swing stage (3.5×)"
  })[x]}
)
```

---

## Cell 5 (JS)

```js
viewof serviceType = Inputs.radio(
  ["interior_only", "exterior_only", "both"],
  {label: "Service type", value: "both", format: x => ({
    interior_only: "Interior only (0.45×)",
    exterior_only: "Exterior only (0.55×)",
    both: "Both interior and exterior (1.0×)"
  })[x]}
)
```

---

## Cell 6 (JS)

```js
viewof frequency = Inputs.select(
  ["one_time", "quarterly", "monthly", "weekly"],
  {label: "Cleaning frequency", format: x => ({
    one_time: "One-time (no discount)",
    quarterly: "Quarterly (10% discount)",
    monthly: "Monthly (20% discount)",
    weekly: "Weekly (30% discount)"
  })[x]}
)
```

---

## Cell 7 (JS)

```js
viewof labourRate = Inputs.range([15, 50], {value: 22, step: 0.5, label: "Labour rate (CAD/hr)"})
```

---

## Cell 8 (JS)

```js
viewof marginPct = Inputs.range([0, 60], {value: 35, step: 1, label: "Profit margin %"})
```

---

## Cell 9 (JS)

```js
baseMinutes = ({
  standard_single_pane: 4, double_pane: 5, floor_to_ceiling: 8, storefront: 6, specialty: 12
})

serviceMult = ({interior_only: 0.45, exterior_only: 0.55, both: 1.0})

accessMult = ({ground_level: 1.0, ladder: 1.4, boom_lift: 2.2, rope_access: 3.0, swing_stage: 3.5})

freqDiscount = ({one_time: 1.0, quarterly: 0.90, monthly: 0.80, weekly: 0.70})

visitsPerYear = ({one_time: 1, quarterly: 4, monthly: 12, weekly: 52})
```

---

## Cell 10 (JS)

```js
result = {
  const base = baseMinutes[windowType];
  const sm = serviceMult[serviceType];
  const am = accessMult[accessMethod];
  const fd = freqDiscount[frequency];

  const timePerWindow = base * sm * am;
  const totalMinutes = timePerWindow * windowCount;
  const labourCost = (totalMinutes / 60) * labourRate * fd;
  const materialsCost = labourCost * 0.08;
  const subtotal = labourCost + materialsCost;
  const marginAmount = subtotal * (marginPct / 100);
  const finalPrice = subtotal + marginAmount;
  const perWindowCost = finalPrice / windowCount;
  const annualTotal = finalPrice * visitsPerYear[frequency];

  return {
    labourCost: Math.round(labourCost * 100) / 100,
    materialsCost: Math.round(materialsCost * 100) / 100,
    subtotal: Math.round(subtotal * 100) / 100,
    marginAmount: Math.round(marginAmount * 100) / 100,
    finalPrice: Math.round(finalPrice * 100) / 100,
    perWindowCost: Math.round(perWindowCost * 100) / 100,
    annualTotal: Math.round(annualTotal * 100) / 100
  };
}
```

---

## Cell 11 (Markdown)

```md
## Cost Estimate
```

---

## Cell 12 (JS)

```js
html`<table style="font-size:15px; border-collapse:collapse; width:100%; max-width:500px;">
  <tr><td style="padding:6px 12px;">Labour Estimate</td><td style="padding:6px 12px; text-align:right; font-weight:bold;">$${result.labourCost.toFixed(2)} CAD</td></tr>
  <tr><td style="padding:6px 12px;">Materials (8% of labour)</td><td style="padding:6px 12px; text-align:right; font-weight:bold;">$${result.materialsCost.toFixed(2)} CAD</td></tr>
  <tr style="border-top:2px solid #ccc;"><td style="padding:6px 12px;">Subtotal</td><td style="padding:6px 12px; text-align:right; font-weight:bold;">$${result.subtotal.toFixed(2)} CAD</td></tr>
  <tr><td style="padding:6px 12px;">Profit Margin (${marginPct}%)</td><td style="padding:6px 12px; text-align:right; font-weight:bold;">$${result.marginAmount.toFixed(2)} CAD</td></tr>
  <tr style="border-top:2px solid #1B3A5C; background:#f8f9fa;"><td style="padding:8px 12px; font-size:17px;">Final Quoted Price</td><td style="padding:8px 12px; text-align:right; font-weight:bold; font-size:17px; color:#1B3A5C;">$${result.finalPrice.toFixed(2)} CAD</td></tr>
  <tr><td style="padding:6px 12px;">Per Window</td><td style="padding:6px 12px; text-align:right;">$${result.perWindowCost.toFixed(2)} CAD</td></tr>
  ${frequency !== "one_time" ? `<tr style="border-top:1px solid #ccc;"><td style="padding:6px 12px;">Annual Total (${visitsPerYear[frequency]} visits)</td><td style="padding:6px 12px; text-align:right; font-weight:bold; color:#1B3A5C;">$${result.annualTotal.toFixed(2)} CAD</td></tr>` : ""}
</table>`
```

---

## Cell 13 (Markdown)

```md
## Access Method Cost Comparison
```

---

## Cell 14 (JS)

```js
accessComparison = {
  const methods = ["ground_level", "ladder", "boom_lift", "rope_access", "swing_stage"];
  const labels = ["Ground Level", "Ladder", "Boom Lift", "Rope Access", "Swing Stage"];
  return methods.map((m, i) => {
    const t = baseMinutes[windowType] * serviceMult[serviceType] * accessMult[m];
    const totalMin = t * windowCount;
    const labour = (totalMin / 60) * labourRate * freqDiscount[frequency];
    const materials = labour * 0.08;
    const subtotal = labour + materials;
    const margin = subtotal * (marginPct / 100);
    return {method: labels[i], price: Math.round((subtotal + margin) * 100) / 100};
  });
}
```

---

## Cell 15 (JS)

```js
Plot.plot({
  marginLeft: 140,
  width: 700,
  x: {label: "Total Quoted Price (CAD)", tickFormat: d => `$${d}`},
  y: {label: null},
  color: {range: ["#1B3A5C"]},
  marks: [
    Plot.barX(accessComparison, {x: "price", y: "method", fill: "#1B3A5C", sort: {y: "x"}}),
    Plot.text(accessComparison, {x: "price", y: "method", text: d => `$${d.price.toFixed(2)}`, dx: 35, fontSize: 12})
  ]
})
```

---

## Cell 16 (Markdown)

```md
---

## About This Calculator

This interactive notebook accompanies the open-source [Window Cleaning Cost Calculator](https://github.com/DaveCookVectorLabs/window-cleaning-2026) — a free tool for commercial facility managers, property managers, and building operations teams.

**[Binx Professional Cleaning](https://www.binx.ca/)** has provided commercial and residential cleaning services across Northern Ontario since 2013 with 70+ staff across two locations:

- **North Bay:** 1315 Hammond Street, P1B 2J2 — [(705) 845-0998](tel:7058450998)
- **Sudbury:** 767 Barry Downe Road, Unit 203M, P3A 3T6 — [(249) 239-1225](tel:2492391225)

WSIB covered · $5M liability insurance · Green Certified products · IPAC compliant

[Commercial Window Cleaning](https://www.binx.ca/commercial-window-cleaning.php) · [Residential Window Cleaning](https://www.binx.ca/residential-windows.php)

Also available on: [GitHub](https://github.com/DaveCookVectorLabs/window-cleaning-2026) · [PyPI](https://pypi.org/project/window-cleaning-2026/) · [npm](https://www.npmjs.com/package/@davecook/window-cleaning-2026) · [Docker Hub](https://hub.docker.com/r/davecook1985/window-cleaning-2026) · [Kaggle](https://www.kaggle.com/code/davecook1985/window-cleaning-cost-analysis-n-ontario)
```

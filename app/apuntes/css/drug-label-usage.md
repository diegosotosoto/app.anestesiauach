# Standardized Drug Label Component

Based on `dilucion_farmacos.php` - Unified drug labeling for all apuntes.

## Color Reference (ISO Anesthesia Standard)

| Category | Class | Color |
|----------|-------|-------|
| Opioids | `.drug-opioid` | Light blue `#8fd3ff` |
| Local anesthetics | `.drug-local` | Gray `#d1d5db` |
| Induction agents | `.drug-inductor` | Yellow `#facc15` |
| Muscle relaxants | `.drug-neuromuscular` | Red `#ef4444` |
| Vasopressors | `.drug-vasoactive` | Purple `#c4b5fd` |
| Anticholinergics | `.drug-atropine` | Green `#86efac` |
| Benzodiazepines | `.drug-benzo` | Orange `#f59e0b` |
| Reversal agents | `.drug-reversal-*` | Category color + stripes |

## Component Structure

### Basic Drug Label (inline)
```html
<div class="drug-label drug-opioid">
  <div class="drug-label-content">
    <div class="drug-label-title">Fentanilo</div>
    <div class="drug-label-subtitle">Opioide · 50 µg/mL</div>
  </div>
</div>
```

### Drug Card (block-level)
```html
<div class="drug-card drug-neuromuscular">
  <div class="drug-label-content">
    <div class="drug-label-title">Rocuronio</div>
    <div class="drug-label-subtitle">Bloqueante neuromuscular</div>
  </div>
</div>
```

### With Prefix Icon/Abbreviation
```html
<div class="drug-label drug-vasoactive">
  <span class="drug-label-prefix">EF</span>
  <div class="drug-label-content">
    <div class="drug-label-title">Efedrina</div>
    <div class="drug-label-subtitle">6 mg/mL</div>
  </div>
</div>
```

### Reversal Agent (with striped pattern)
```html
<div class="drug-label drug-reversal-opioid">
  <div class="drug-label-content">
    <div class="drug-label-title">Naloxona</div>
    <div class="drug-label-subtitle">Antagonista opioide · 40 µg/mL</div>
  </div>
</div>
```

## Size Variants

- `.drug-label-sm` - Compact size
- `.drug-label` - Default size
- `.drug-label-lg` - Large size

## Key Features

1. **Background color always present** - The drug category color is always visible
2. **90% white contrast box** - `.drug-label-content` has `rgba(255,255,255,0.90)` background
3. **Black text for title** - `.drug-label-title` is always `#111827`
4. **Optional subtitle** - `.drug-label-subtitle` for drug class or dilution info
5. **Night mode compatible** - The contrast box stays white in all modes for readability

## CSS Variables

```css
--drug-opioid: #8fd3ff;
--drug-local: #d1d5db;
--drug-inductor: #facc15;
--drug-neuromuscular: #ef4444;
--drug-vasoactive: #c4b5fd;
--drug-atropine: #86efac;
--drug-benzo: #f59e0b;
--drug-reversal: #ff6b7a;
--drug-other: #ffffff;
```

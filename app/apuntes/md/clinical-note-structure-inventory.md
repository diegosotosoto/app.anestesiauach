# Clinical note system inventory

## Canonical base
Use `analgesia_ped.php` as the canonical structure.

## Canonical PHP/HTML section order
1. metadata / references / navbar variables
2. `require("head.php")`
3. shell wrapper
4. hero
5. info block
6. input card
7. note-specific selection card(s)
8. summary card
9. result card
10. warnings / safety card
11. teaching card
12. footer note
13. script
14. `require("footer.php")`

## Canonical wrapper hierarchy
```html
<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="note-shell">
        <div class="note-hero">...</div>
        <div class="note-info-card">...</div>
        <div class="note-card"><div class="note-card-body">...</div></div>
      </div>
    </div>
  </div>
</div>
```

## Canonical classes to keep
- `note-shell`
- `note-hero`
- `note-hero-subtle`
- `note-badge`
- `note-info-card`
- `note-info-header`
- `note-info-title`
- `note-info-toggle`
- `note-info-content`
- `note-card`
- `note-card-body`
- `note-card-title`
- `note-section-label`
- `note-grid`
- `note-input-group`
- `note-label`
- `note-choice-grid`
- `note-choice-grid-3`
- `note-choice-grid-4`
- `note-check`
- `note-trigger`
- `note-option`
- `note-option-age`
- `note-option-group`
- `note-option-mode`
- `note-summary`
- `note-summary-label`
- `note-summary-text`
- `note-results`
- `note-result-row`
- `note-result-main`
- `note-result-secondary`
- `note-result-value`
- `note-interpretation`
- `note-interpretation-label`
- `note-interpretation-main`
- `note-interpretation-soft`
- `note-warning`
- `note-danger`
- `note-success`
- `note-hidden`
- `note-teaching-wrap`
- `note-teaching-title`
- `note-teaching-main`
- `note-tips`
- `note-footer`

## Drug color classes to standardize
- `drug-opioid`
- `drug-local`
- `drug-inductor`
- `drug-neuromuscular`
- `drug-vasoactive`
- `drug-atropine`
- `drug-other`
- `drug-reversal-opioid`
- `drug-reversal-local`
- `drug-reversal-inductor`
- `drug-reversal-neuromuscular`
- `drug-reversal-vasoactive`
- `drug-reversal-atropine`
- `drug-reversal-other`

## Transition aliases found in old notes
These can be temporarily supported by the master CSS, but should converge to the canonical `note-*` system.

- `info-box` -> `note-info-card`
- `info-box-header` -> `note-info-header`
- `info-box-title` -> `note-info-title`
- `info-toggle-btn` -> `note-info-toggle`
- `info-box-content` -> `note-info-content`
- `section-card` -> `note-card`
- `section-title` -> `note-section-label`
- `summary-grid` / `summary-card` / `summary-label` / `summary-value` -> `note-summary-grid` / `note-summary-item` / `note-summary-k` / `note-summary-v`
- `result-row` / `result-name` / `result-note` / `result-value` -> `note-result-row` / `note-result-main` / `note-result-secondary` / `note-result-value`
- `good-box` -> `note-success`
- `warn-box` -> `note-warning`
- `mint-box` -> `note-mint`
- `choice-check` / `choice-radio` / `factor-check` / `factor-radio` / `caprini-radio` -> `note-check`
- `choice-btn` / `factor-btn` -> `note-option`
- `choice-grid-*` / `factor-grid-*` -> `note-choice-grid-*`

## JS helpers that belong in the master file
- `toggleInfo()`
- `getSelected()`
- `normalizeDecimalString()`
- `parseDecimal()`
- `formatNumber()`
- `formatPercent()`
- `safeSetText()`
- `safeSetHTML()`
- `showValidityWarning()`
- `hideValidityWarning()`
- `applySelectionBorder()`
- `bindSelectionSync()`
- `drugClassToCss()`
- `createDrugOption()`

## JS that must remain local to each note
- note-specific formulas
- data tables
- score definitions
- interpretation rules
- contraindication rules specific to a calculation
- UI changes tied to a note-specific clinical workflow

## Immediate refactor target
1. include master CSS
2. include master JS
3. remove duplicated local CSS already covered by the master
4. keep only note-specific CSS overrides locally
5. replace old classes with canonical `note-*` classes gradually
6. keep formulas and clinical logic inside each note

## Reusable component patterns to add to the master file

### Score domain selector
Purpose:
Reusable block for scales composed of repeated domains with mutually exclusive score options.

Recommended structure:
- `.score-domain`
- `.score-domain-header`
- `.score-domain-icon`
- `.score-domain-title`
- `.score-domain-help`
- `.score-domain-grid`
- `.score-option-input`
- `.score-option`
- `.score-option-score`
- `.score-option-text`

Behavior:
- each domain uses radio inputs
- only one option can be active per domain
- selected state is shown primarily by thick blue border
- the selected state must not depend on changing the base semantic color
- component should work for repeated scored domains such as Aldrete and similar scales

Notes:
- keep the domain structure identical across repeated scale sections
- reuse the same wrapper hierarchy in all notes implementing repeated score domains
- use icons only when they improve scan speed

## CSS components that belong in the master file
- `.score-domain`
- `.score-domain-header`
- `.score-domain-icon`
- `.score-domain-title`
- `.score-domain-help`
- `.score-domain-grid`
- `.score-option-input`
- `.score-option`
- `.score-option-score`
- `.score-option-text`

## JS helpers that belong in the master file
- `bindScoreDomainSelection()`

## JS that must remain local to each note
- score calculation logic
- domain definitions
- interpretation of total score
- note-specific warnings tied to the scale

## Reusable component patterns to add to the master file

### Search / finder pattern
Purpose:
Reusable pattern for notes that need real-time filtering and item selection before showing a detailed result.

Recommended structure:
- `.note-search-box`
- `.note-search-input`
- `.note-search-help`
- `.note-search-results`
- `.note-search-item`
- `.note-search-item-title`
- `.note-search-item-meta`

Behavior:
- input updates results dynamically
- selected state should be shown primarily by thick blue border
- result cards should remain compact and highly scannable
- suitable for drug lookup, protocol lookup, and categorized quick-reference notes

### Detail table with mobile fallback
Purpose:
Reusable pattern for notes that present dense reference data in desktop table format with a mobile-friendly stacked fallback.

Recommended structure:
- `.note-detail-table-wrap`
- `.note-detail-table`
- `.note-mobile-detail`
- `.note-mobile-detail-card`
- `.note-mobile-detail-row`
- `.note-mobile-detail-label`
- `.note-mobile-detail-value`

Behavior:
- desktop uses tabular format when comparison matters
- mobile uses stacked cards when horizontal scan becomes uncomfortable
- same content should remain available in both layouts

## CSS components that belong in the master file
- `.note-search-box`
- `.note-search-input`
- `.note-search-help`
- `.note-search-results`
- `.note-search-item`
- `.note-search-item-title`
- `.note-search-item-meta`
- `.note-detail-table-wrap`
- `.note-detail-table`
- `.note-mobile-detail`
- `.note-mobile-detail-card`
- `.note-mobile-detail-row`
- `.note-mobile-detail-label`
- `.note-mobile-detail-value`

## JS that must remain local to each note
- search dataset
- filtering rules
- result rendering specific to the note content
- table column definitions
- domain-specific interpretation and warnings

## Reusable component patterns to add to the master file

### Reference classification card list
Purpose:
Reusable pattern for notes that present structured clinical classifications without requiring a numeric calculation.

Recommended structure:
- `.note-class-grid`
- `.note-class-card`
- `.note-class-head`
- `.note-class-title`
- `.note-class-summary`
- `.note-class-sub`
- `.note-class-mini`
- `.note-class-badge`

Behavior:
- each card represents one classification level
- badge + title + short summary + example/context
- suitable for ASA and similar reference classifications

## CSS components that belong in the master file
- `.note-class-grid`
- `.note-class-card`
- `.note-class-head`
- `.note-class-title`
- `.note-class-summary`
- `.note-class-sub`
- `.note-class-mini`
- `.note-class-badge`
- `.note-summary-grid-3`

## JS that must remain local to each note
- none for purely reference classification notes using shared info-box behavior

## Reusable component patterns to add to the master file

### Visual formula box
Purpose:
Reusable pattern for notes that need to display a clinical calculation formula in a more readable and teaching-oriented way.

Recommended structure:
- `.note-formula-box`
- `.note-formula-label`
- `.note-formula-wrap`
- `.note-formula-left`
- `.note-formula-equals`
- `.note-formula-fraction`
- `.note-formula-num`
- `.note-formula-line`
- `.note-formula-den`
- `.note-formula-note`

Behavior:
- suitable for fraction-style formulas
- supports numerator / denominator display
- should remain readable on mobile
- use when formula visualization improves understanding, not as decoration

## CSS components that belong in the master file
- `.note-formula-box`
- `.note-formula-label`
- `.note-formula-wrap`
- `.note-formula-left`
- `.note-formula-equals`
- `.note-formula-fraction`
- `.note-formula-num`
- `.note-formula-line`
- `.note-formula-den`
- `.note-formula-note`

## JS that must remain local to each note
- formula-specific calculations
- variable substitution logic
- note-specific interpretation of the displayed formula

## Reusable component patterns to add to the master file

### Multi-section risk factor selector
Purpose:
Reusable pattern for long clinical scores composed of multiple thematic sections with additive factors and/or mutually exclusive factor groups.

Recommended structure:
- `.note-factor-section`
- `.note-factor-section-head`
- `.note-factor-section-title`
- `.note-factor-section-help`
- `.note-factor-grid`
- `.note-factor-grid-3`
- `.note-factor-option`
- `.note-factor-points`
- `.note-factor-inline-total`

Behavior:
- supports additive checkbox factors and mutually exclusive radio factors
- uses the shared selectable card pattern for each factor
- should remain scannable even when the score contains many items
- section grouping should reduce cognitive load and improve navigation through long scales

Notes:
- use section grouping when a long score becomes visually noisy as one undifferentiated list
- preserve the same selectable-card structure already used by the note system

## CSS components that belong in the master file
- `.note-factor-section`
- `.note-factor-section-head`
- `.note-factor-section-title`
- `.note-factor-section-help`
- `.note-factor-grid`
- `.note-factor-grid-3`
- `.note-factor-option`
- `.note-factor-points`
- `.note-factor-inline-total`

## JS that must remain local to each note
- factor definitions
- additive score calculation
- mutually exclusive subgroup logic
- interpretation thresholds
- note-specific prophylaxis or management recommendations


## Reusable component patterns to add to the master file

### Emergency hero variant
Purpose:
Reusable hero variant for urgent, crisis-oriented, or time-critical clinical notes.

Recommended structure:
- `.note-hero`
- `.note-hero-emergency`
- `.note-hero-kicker`
- `h2`
- `.note-hero-subtitle`

Behavior:
- use the same hero structure as the standard note system
- switch only the visual tone to the emergency variant
- suitable for malignant hyperthermia, anaphylaxis, hemorrhage, airway crisis, and similar emergency notes

### Emergency checklist pattern
Purpose:
Reusable pattern for interactive emergency checklists with progress tracking, collapsible sections, completed-task state, and rapid exportable event record.

Recommended structure:
- `.note-checklist-toolbar`
- `.note-checklist-toolbar-grid`
- `.note-checklist-progress`
- `.note-checklist-actions`
- `.note-checklist-btn`
- `.note-checklist-section`
- `.note-checklist-section-head`
- `.note-checklist-section-title`
- `.note-checklist-section-help`
- `.note-checklist-section-body`
- `.note-checklist-list`
- `.note-checklist-item`
- `.note-checklist-item-input`
- `.note-checklist-item-mark`
- `.note-checklist-item-copy`
- `.note-checklist-item-title`
- `.note-checklist-item-note`
- `.note-checklist-record`
- `.note-checklist-record-box`

Behavior:
- checklist items can be marked done
- progress can be calculated automatically
- sections can be expanded and collapsed
- the note can generate a compact text record of the event
- suitable for crisis checklists and emergency workflows


## CSS components that belong in the master file
- `.note-hero-emergency`
- `.note-checklist-toolbar`
- `.note-checklist-toolbar-grid`
- `.note-checklist-progress`
- `.note-checklist-progress-label`
- `.note-checklist-progress-value`
- `.note-checklist-actions`
- `.note-checklist-btn`
- `.note-checklist-section`
- `.note-checklist-section-head`
- `.note-checklist-section-title`
- `.note-checklist-section-help`
- `.note-checklist-section-meta`
- `.note-checklist-section-body`
- `.note-checklist-list`
- `.note-checklist-item`
- `.note-checklist-item-input`
- `.note-checklist-item-mark`
- `.note-checklist-item-copy`
- `.note-checklist-item-title`
- `.note-checklist-item-note`
- `.note-checklist-record`
- `.note-checklist-record-box`

## JS helpers that belong in the master file
- `bindChecklistItems()`
- `bindChecklistSections()`
- `expandAllChecklistSections()`
- `collapseAllChecklistSections()`
- `getChecklistProgress()`
- `bindChecklistProgress()`
- `buildChecklistText()`
- `bindChecklistExport()`

## JS that must remain local to each note
- crisis-specific action lists
- note-specific calculator logic
- event-specific interpretation and warning rules
- crisis-specific export formatting when the default checklist text is insufficient


## Reusable component patterns to add to the master file

### Binary clinical question pattern
Purpose:
Reusable pattern for questionnaire items with mutually exclusive Yes / No answers.

Recommended structure:
- `.note-question-block`
- `.note-question-text`
- `.note-binary-grid`
- `.note-binary-option`
- `.note-binary-yes`
- `.note-binary-no`
- `.note-binary-label`
- `.note-binary-icon`
- `.note-binary-copy`
- `.note-binary-title`

Behavior:
- question text should remain visually prominent
- yes / no options should be compact and highly scannable
- yes should use green confirmation iconography
- no should use red negative iconography
- selected state should still rely on the shared selectable-card system
- suitable for DASI and other binary perioperative questionnaires


## CSS components that belong in the master file
- `.note-question-block`
- `.note-question-text`
- `.note-binary-grid`
- `.note-binary-option`
- `.note-binary-icon`
- `.note-binary-label`
- `.note-binary-copy`
- `.note-binary-title`
- `.note-binary-yes`
- `.note-binary-no`

## JS that must remain local to each note
- item weights
- score summation
- threshold interpretation
- note-specific recommendations




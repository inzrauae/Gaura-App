# Design System Strategy: Structural Authority

## 1. Overview & Creative North Star
**Creative North Star: "Precision Tectonics"**

This design system rejects the "cluttered dashboard" trope of legacy construction software. Instead, it adopts the philosophy of **Precision Tectonics**: a visual language that mirrors the physical act of building—solid, stacked, and structural. We move beyond "standard" UI by treating the screen as a site plan. 

The aesthetic is "High-End Industrial." It leverages high-contrast typography and intentional asymmetry to guide the eye through dense data without causing fatigue. By utilizing a sophisticated layering system and a "No-Line" architecture, we ensure the app feels like a premium tool, not just another spreadsheet. It is designed for speed, high-touch frequency, and the demanding environment of a construction site.

## 2. Colors: Tonal Depth & Functional Utility
Our palette is anchored in **Structural Navy (`primary`)** and **Safety Gold (`secondary`)**. This isn't just branding; it’s a functional hierarchy.

### The "No-Line" Rule
**Borders are prohibited for sectioning.** To define boundaries, you must use background color shifts. 
- Use `surface` (#faf8ff) as your base.
- Use `surface_container_low` (#f2f3ff) for secondary modules.
- Use `surface_container_high` (#e2e7ff) for active or focused content areas.
By eliminating 1px borders, we reduce visual noise and allow the content to breathe, even when density is high.

### Surface Hierarchy & Nesting
Treat the UI as stacked sheets of material.
- **Base Level:** `surface`
- **In-Page Modules:** `surface_container`
- **Interactive Elements (Cards/Modals):** `surface_container_lowest` (#ffffff) to provide a "pop" against the tinted backgrounds.

### The "Glass & Gradient" Rule
For floating action buttons or high-priority construction alerts, use **Glassmorphism**: 
- Apply `surface_variant` with 70% opacity and a `backdrop-blur` of 12px.
- For primary CTAs, use a subtle linear gradient from `primary` (#003d9b) to `primary_container` (#0052cc) at a 135-degree angle. This adds "soul" and depth, making the button feel tactile and pressable.

### Status Indicators: Financial Clarity
- **Company Paid:** Defined by `primary` (#003d9b) accents or icons.
- **Director Paid:** Defined by `secondary` (#785a00) accents. 
Avoid using red/green for payment types to prevent confusion with "Error/Success" states. Use these structural colors to denote *ownership*, not *status*.

## 3. Typography: The Editorial Blueprint
We use a dual-sans-serif approach to balance authority with utility.

- **Display & Headlines (Manrope):** This is our "Architectural" face. It’s geometric and modern. Use `display-md` for project titles to create a strong editorial anchor.
- **Body & Labels (Inter):** This is our "Utility" face. Inter is chosen for its high legibility in dense data environments.
- **Intentional Scale:** Use `label-md` for metadata. Despite its small size, its 0.75rem scale paired with `on_surface_variant` (#434654) ensures it remains legible on mobile devices in high-glare environments.

## 4. Elevation & Depth: Tonal Layering
Traditional shadows are too "soft" for a construction app. We use Tonal Layering to imply height.

### The Layering Principle
To create focus, stack containers. A `surface_container_lowest` card placed on a `surface_dim` background creates an immediate, sharp hierarchy without a single shadow pixel.

### Ambient Shadows
If an element must "float" (e.g., a mobile navigation drawer), use a tinted shadow:
- **Shadow:** 0px 8px 24px rgba(19, 27, 46, 0.06).
Using the `on_surface` color for the shadow instead of pure black ensures the depth feels natural to the "Structural Navy" environment.

### The "Ghost Border" Fallback
If accessibility requires a border (e.g., in high-glare outdoor use), use a **Ghost Border**: `outline_variant` (#c3c6d6) at 20% opacity. It should be felt, not seen.

## 5. Components: Rugged Utility

### Buttons: High-Velocity Targets
- **Primary:** Gradient fill (`primary` to `primary_container`). Border radius `md` (0.375rem). Minimum touch target: 48px height.
- **Tertiary:** No background, `primary` text. Use for low-emphasis actions like "Cancel" or "View Details."

### Cards & Lists: The Density Engine
- **Forbid Dividers:** Use the Spacing Scale `4` (0.9rem) or `5` (1.1rem) to separate list items. 
- **The "Site-Ready" List:** Each list item should have a 12px vertical padding minimum to accommodate gloved or moving hands.

### Input Fields: Structural Input
- **State:** Active inputs use a `primary` 2px bottom-bar only, rather than a full box stroke. This maintains the "No-Line" rule while providing clear focus.
- **Background:** `surface_container_low`.

### Specialized Components
- **The "Punch List" Chip:** Use `secondary_container` (#fdc425) with `on_secondary_container` (#6d5200) text for high-priority site issues. It mimics the look of high-visibility safety gear.
- **The Payment Toggle:** A segmented control using `primary_fixed` for "Company" and `secondary_fixed` for "Director," allowing for instant cognitive switching.

## 6. Do’s and Don’ts

### Do:
- **Do** use `spacing-12` (2.75rem) for major section breathing room. Construction data is dense; the whitespace is the "ventilation."
- **Do** use `on_surface_variant` for secondary text to maintain a high-contrast ratio of at least 4.5:1.
- **Do** use the `xl` (0.75rem) roundedness for large modal containers to soften the "industrial" edges.

### Don’t:
- **Don’t** use pure black (#000000). Use `on_background` (#131b2e) for all text to maintain tonal richness.
- **Don’t** use 1px solid dividers between table rows. Use alternating `surface` and `surface_container_low` background stripes.
- **Don’t** shrink touch targets below 44px, even on desktop. Speed of use is a requirement, and precise clicking is a bottleneck.
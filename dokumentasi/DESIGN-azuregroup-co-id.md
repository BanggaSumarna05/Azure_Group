# Design System Inspired by Azure Group

> Auto-extracted from `https://azuregroup.co.id/` on 2026-06-24

## 1. Visual Theme & Atmosphere

Friendly, approachable design with rounded shapes and generous whitespace.

The hero section leads with "AZURE GROUP".

**Key Characteristics:**
- Saira as the heading font (custom web font loaded via @font-face)
- Saira as the body font for all running text
- Heading weight 600, letter-spacing -0.72px
- Light/white background (#f2f3f5) as the primary canvas
- Primary accent `#f15a29` used for CTAs and brand highlights
- 1 shadow level(s) detected — tinted shadows
- Rounded corners (4px+) creating a friendly, approachable feel
- Tags: light, rounded, colorful, monospace, sans-serif

## 2. Color Palette & Roles

### Primary
- **Primary Accent** (`#f15a29`) · `--color-primary`: Brand color, CTA backgrounds, link text, interactive highlights.
- **Secondary Accent** (`#f15f33`) · `--color-secondary`: Secondary brand, hover states, complementary highlights.
- **Background** (`#f2f3f5`) · `--color-bg`: Page background, primary canvas.
- **Background Secondary** (`#ffffff`) · `--color-bg-secondary`: Cards, surfaces, alternating sections.

### Text
- **Text Primary** (`#141617`) · `--color-text`: Headings and body text.
- **Text Secondary** (`#666666`) · `--color-text-secondary`: Muted text, captions, placeholders.

### Borders & Surfaces
- **Border** (`#141617`) · `--color-border`: Dividers, outlines, input borders.

### Full Extracted Palette

| # | Hex | CSS Variable | Role | Area | Contrast |
|---|---|---|---|---|---|
| 1 | `#141617` | `--palette-1` | block | large | text-light |
| 2 | `#ffffff` | `--palette-2` | badge | large | text-dark |
| 3 | `#dddddd` | `--palette-3` | block | medium | text-dark |
| 4 | `#f4f4f4` | `--palette-4` | badge | small | text-dark |
| 5 | `#f15a29` | `--palette-5` | text-accent | small | text-dark |
| 6 | `#0078a8` | `--palette-6` | text-accent | small | text-light |

## 3. Typography Rules

- **Heading Font:** `Saira` (web font)
- **Body Font:** `Saira` (web font)

### Type Hierarchy

| Role | Font | Size | Weight | Line Height | Letter Spacing |
|---|---|---|---|---|---|
| H1 | Saira | 48px | 600 | 57.6px | -0.72px |
| H4 | Saira | 24px | 600 | 28.8px | -0.36px |
| Body | Saira | 16px | 400 | 27.52px | 0.24px |

### Type Scale

| Token | Size | Suggested Usage |
|---|---|---|
| Display | `48px` | headings |
| H1 | `32px` | headings |
| H2 | `24px` | headings |
| H3 | `22px` | headings |
| H4 | `20px` | headings |
| Body L | `18px` | body / supporting text |
| Body | `17px` | body / supporting text |
| Small | `16px` | body / supporting text |
| XS | `14px` | body / supporting text |
| Caption | `13.3333px` | body / supporting text |

## 4. Component Stylings

### Primary Button

```css
.btn-primary {
  background: #f2f3f5;
  color: #141617;
  border-radius: 0px;
  padding: 0px 0px;
  font-size: 16px;
  font-weight: 400;
  border: none;
  cursor: pointer;
}
```

### Ghost Button

```css
.btn-ghost {
  background: transparent;
  color: #ffffff;
  border-radius: 4px;
  padding: 13px 0px;
  font-size: 14px;
  font-weight: 400;
  border: none;
  cursor: pointer;
}
```

### Ghost Button 2

```css
.btn-ghost-2 {
  background: transparent;
  color: #141617;
  border-radius: 0px;
  padding: 10px 12px;
  font-size: 16px;
  font-weight: 400;
  border: none;
  cursor: pointer;
}
```

### Filled Button

```css
.btn-filled {
  background: #f4f4f4;
  color: #bbbbbb;
  border-radius: 2px;
  padding: 0px 0px;
  font-size: 22px;
  font-weight: 700;
  border: none;
  cursor: pointer;
}
```

### Filled Button 2

```css
.btn-filled-2 {
  background: #ffffff;
  color: #000000;
  border-radius: 0px;
  padding: 0px 0px;
  font-size: 22px;
  font-weight: 700;
  border: none;
  cursor: pointer;
}
```

### Filled Button 3

```css
.btn-filled-3 {
  background: #141617;
  color: #141617;
  border-radius: 6px;
  padding: 0px 0px;
  font-size: 16px;
  font-weight: 400;
  border: none;
  cursor: pointer;
}
```

## 5. Layout Principles

- **Base spacing unit:** `10px` — use multiples (20px, 30px, 40px, etc.)

### Spacing Scale (extracted from real elements)

| Token | Value | Role |
|---|---|---|
| spacing-1 | `10px` | element |
| spacing-2 | `13px` | element |
| spacing-3 | `16px` | element |
| spacing-4 | `11px` | element |
| spacing-5 | `12px` | element |
| spacing-6 | `80px` | section |

### Border Radius Scale

| Token | Value | Element |
|---|---|---|
| radius-subtle | `4px` | subtle |
| radius-card | `50px` | card |
| radius-subtle | `2px` | subtle |
| radius-button | `6px` | button |
| radius-button | `15px` | button |

## 6. Depth & Elevation

| Level | Shadow | Usage |
|---|---|---|
| Deep | `rgba(19, 21, 22, 0.1) 10px 10px 25px 5px` | Hero sections, deep layers |

> **Note:** This site uses chromatic (color-tinted) shadows rather than pure black — this is a deliberate brand choice that adds warmth to elevation.

## 7. Do's and Don'ts

### Do
- Use `#f2f3f5` as the primary background color
- Use `Saira` for all headings and `Saira` for body text
- Use `#f15a29` as the single dominant accent/CTA color
- Maintain `10px` as the base spacing unit — all gaps should be multiples
- Use rounded corners (`4px`+) consistently for all interactive elements
- Embrace bold color combinations — playful energy is the point
- Apply the shadow system for elevation — use the extracted shadow values
- Use weight 600 for headings to match the brand's typographic voice

### Don't
- Don't use colors outside the extracted palette without justification
- Don't substitute Saira/Saira with generic alternatives
- Don't use irregular spacing — stick to 10px grid
- Don't use dark/black backgrounds — this is a light-themed design
- Don't use sharp corners — they feel hostile in this rounded design language
- Don't use pure black (#000000) for text — use `#141617` instead
- Don't add decorative elements not present in the original design — no badges, ribbons, banners, or ornaments unless the source site uses them
- Don't invent UI patterns the source site doesn't have — if the original has no NEW badge, don't add one just because a red is in the palette

## 8. Responsive Behavior

| Breakpoint | Width | Notes |
|---|---|---|
| Mobile | < 640px | Single column, stack sections, reduce font sizes ~80% |
| Tablet | 640–1024px | 2-column where appropriate, maintain spacing ratios |
| Desktop | 1024–1440px | Full layout as designed |
| Wide | > 1440px | Max-width container, center content |

- Touch targets: minimum 44×44px on mobile
- Maintain 10px base unit across breakpoints — only scale multipliers

## 9. Agent Prompt Guide

### Quick Color Reference

```
Background:  #f2f3f5
Text:        #141617
Accent:      #f15a29
Secondary:   #f15f33
Border:      #141617
```

### Example Prompts

1. "Build a hero section with a `#f2f3f5` background, `Saira` heading in `#141617`, and a `#f15a29` CTA button with 0px radius."
2. "Create a pricing card using background `#ffffff`, border `#141617`, `Saira` for text, and 30px padding."
3. "Design a navigation bar — `#f2f3f5` background, `#141617` links, `#f15a29` for active state."
4. "Build a feature grid with 3 columns, 30px gap, each card using the card component style."
5. "Create a footer with `#141617` background, `#f2f3f5` text, and 20px padding."

### Iteration Guide

1. Start with layout structure (sections, grid, spacing)
2. Apply colors from the palette — background first, then text, then accents
3. Set typography — font families, sizes from the type scale, weights
4. Add components — buttons, cards, inputs using the specs above
5. Apply border-radius consistently across all elements
6. Add shadows for depth — use the extracted shadow values, not defaults
7. Check responsive behavior — test mobile and tablet layouts
8. Final pass — verify all colors match, spacing is consistent, fonts are correct

## 10. CSS Custom Properties

> 618 custom properties extracted from `:root` / `html` stylesheets.

### Color Variables

| Variable | Value |
|---|---|
| `--wp-block-synced-color` | `#7a00df` |
| `--wp-editor-canvas-background` | `#ddd` |
| `--wp-admin-theme-color` | `#007cba` |
| `--wp-admin-theme-color-darker-10` | `#006ba1` |
| `--wp-admin-theme-color-darker-20` | `#005a87` |
| `--wp--preset--color--black` | `#000000` |
| `--wp--preset--color--cyan-bluish-gray` | `#abb8c3` |
| `--wp--preset--color--white` | `#ffffff` |
| `--wp--preset--color--pale-pink` | `#f78da7` |
| `--wp--preset--color--vivid-red` | `#cf2e2e` |
| `--wp--preset--color--luminous-vivid-orange` | `#ff6900` |
| `--wp--preset--color--luminous-vivid-amber` | `#fcb900` |
| `--wp--preset--color--light-green-cyan` | `#7bdcb5` |
| `--wp--preset--color--vivid-green-cyan` | `#00d084` |
| `--wp--preset--color--pale-cyan-blue` | `#8ed1fc` |
| `--wp--preset--color--vivid-cyan-blue` | `#0693e3` |
| `--wp--preset--color--vivid-purple` | `#9b51e0` |
| `--wp--preset--color--awb-color-1` | `#ffffff` |
| `--wp--preset--color--awb-color-2` | `#f9f9fb` |
| `--wp--preset--color--awb-color-3` | `#f2f3f5` |
| `--wp--preset--color--awb-color-4` | `#65bd7d` |
| `--wp--preset--color--awb-color-5` | `#808080` |
| `--wp--preset--color--awb-color-6` | `#434549` |
| `--wp--preset--color--awb-color-7` | `#212326` |
| `--wp--preset--color--awb-color-8` | `#141617` |
| `--wp--preset--color--awb-color-custom-1` | `#f15a29` |
| `--wp--preset--color--awb-color-custom-2` | `#ffffff` |
| `--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple` | `linear-gradient(135deg,rgb(6,147,227) 0%,rgb(155,81,224) 100%)` |
| `--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan` | `linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%)` |
| `--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange` | `linear-gradient(135deg,rgb(252,185,0) 0%,rgb(255,105,0) 100%)` |
| ... | *(71 more)* |

### Spacing Variables

| Variable | Value |
|---|---|
| `--wp-admin-border-width-focus` | `2px` |
| `--wp--preset--aspect-ratio--square` | `1` |
| `--wp--preset--spacing--20` | `0.44rem` |
| `--wp--preset--spacing--30` | `0.67rem` |
| `--wp--preset--spacing--40` | `1rem` |
| `--wp--preset--spacing--50` | `1.5rem` |
| `--wp--preset--spacing--60` | `2.25rem` |
| `--wp--preset--spacing--70` | `3.38rem` |
| `--wp--preset--spacing--80` | `5.06rem` |
| `--adminbar-height` | `0px` |
| `--awb-color1-h` | `0` |
| `--awb-color1-s` | `0%` |
| `--awb-color1-l` | `100%` |
| `--awb-color1-a` | `100%` |
| `--awb-color2-h` | `240` |
| `--awb-color2-s` | `20%` |
| `--awb-color2-l` | `98%` |
| `--awb-color2-a` | `100%` |
| `--awb-color3-h` | `220` |
| `--awb-color3-s` | `13%` |
| ... | *(181 more)* |

### Typography Variables

| Variable | Value |
|---|---|
| `--wp--preset--font-size--normal` | `16px` |
| `--wp--preset--font-size--huge` | `42px` |
| `--wp--preset--font-size--small` | `12px` |
| `--wp--preset--font-size--medium` | `20px` |
| `--wp--preset--font-size--large` | `24px` |
| `--wp--preset--font-size--x-large` | `42px` |
| `--wp--preset--font-size--xlarge` | `32px` |
| `--awb-typography1-font-family` | `Saira, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif` |
| `--awb-typography1-font-size` | `48px` |
| `--awb-typography1-font-weight` | `600` |
| `--awb-typography1-font-style` | `normal` |
| `--awb-typography1-line-height` | `1.2` |
| `--awb-typography1-letter-spacing` | `-0.015em` |
| `--awb-typography1-text-transform` | `none` |
| `--awb-typography2-font-family` | `Saira, Arial, Helvetica, sans-serif` |
| `--awb-typography2-font-size` | `24px` |
| `--awb-typography2-font-weight` | `600` |
| `--awb-typography2-font-style` | `normal` |
| `--awb-typography2-line-height` | `1.1` |
| `--awb-typography2-letter-spacing` | `0px` |
| ... | *(155 more)* |

### Other Variables

| Variable | Value |
|---|---|
| `--wp-block-synced-color--rgb` | `122,0,223` |
| `--wp-bound-block-color` | `var(--wp-block-synced-color)` |
| `--wp-admin-theme-color--rgb` | `0,124,186` |
| `--wp-admin-theme-color-darker-10--rgb` | `0,107,160.5` |
| `--wp-admin-theme-color-darker-20--rgb` | `0,90,135` |
| `--wp--preset--aspect-ratio--4-3` | `4/3` |
| `--wp--preset--aspect-ratio--3-4` | `3/4` |
| `--wp--preset--aspect-ratio--3-2` | `3/2` |
| `--wp--preset--aspect-ratio--2-3` | `2/3` |
| `--wp--preset--aspect-ratio--16-9` | `16/9` |
| `--wp--preset--aspect-ratio--9-16` | `9/16` |
| `--button_padding` | `11px 23px` |
| `--header_bg_repeat` | `no-repeat` |
| `--menu_highlight_background` | `var(--awb-color4)` |
| `--menu_sub_bg_color` | `var(--awb-color1)` |
| ... | *(126 more)* |

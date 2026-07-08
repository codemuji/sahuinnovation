---
name: Solar Editorial System
colors:
  surface: '#f9f9ff'
  surface-dim: '#cfdaf1'
  surface-bright: '#f9f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f0f3ff'
  surface-container: '#e7eeff'
  surface-container-high: '#dee8ff'
  surface-container-highest: '#d8e3fa'
  on-surface: '#111c2c'
  on-surface-variant: '#44474d'
  inverse-surface: '#263142'
  inverse-on-surface: '#ebf1ff'
  outline: '#75777e'
  outline-variant: '#c4c6ce'
  surface-tint: '#4d5f7d'
  primary: '#000615'
  on-primary: '#ffffff'
  primary-container: '#0b1f3a'
  on-primary-container: '#7587a7'
  inverse-primary: '#b5c7ea'
  secondary: '#815500'
  on-secondary: '#ffffff'
  secondary-container: '#feb234'
  on-secondary-container: '#6d4700'
  tertiary: '#080603'
  on-tertiary: '#ffffff'
  tertiary-container: '#211f19'
  on-tertiary-container: '#8b867e'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#d6e3ff'
  primary-fixed-dim: '#b5c7ea'
  on-primary-fixed: '#071c36'
  on-primary-fixed-variant: '#364764'
  secondary-fixed: '#ffddb2'
  secondary-fixed-dim: '#ffb94c'
  on-secondary-fixed: '#291800'
  on-secondary-fixed-variant: '#624000'
  tertiary-fixed: '#e8e2d8'
  tertiary-fixed-dim: '#ccc6bc'
  on-tertiary-fixed: '#1e1b16'
  on-tertiary-fixed-variant: '#4a463f'
  background: '#f9f9ff'
  on-background: '#111c2c'
  surface-variant: '#d8e3fa'
typography:
  display:
    fontFamily: Playfair Display
    fontSize: 72px
    fontWeight: '700'
    lineHeight: '1.1'
    letterSpacing: -0.02em
  headline-h1:
    fontFamily: Playfair Display
    fontSize: 48px
    fontWeight: '700'
    lineHeight: '1.2'
  headline-h2:
    fontFamily: Playfair Display
    fontSize: 32px
    fontWeight: '600'
    lineHeight: '1.3'
  headline-h3:
    fontFamily: Playfair Display
    fontSize: 24px
    fontWeight: '600'
    lineHeight: '1.4'
  body-lg:
    fontFamily: DM Sans
    fontSize: 18px
    fontWeight: '400'
    lineHeight: '1.6'
  body-md:
    fontFamily: DM Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.6'
  label-caps:
    fontFamily: DM Sans
    fontSize: 12px
    fontWeight: '700'
    lineHeight: '1'
    letterSpacing: 0.1em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  unit: 8px
  container-max: 1280px
  gutter: 32px
  margin-page: 64px
  section-padding: 120px
---

## Brand & Style

This design system is built upon the intersection of sustainable technology and high-end editorial aesthetics. It moves away from the "tech-heavy" look of the renewable energy sector, instead positioning solar power as a sophisticated lifestyle choice for the discerning client. 

The brand personality is authoritative yet approachable—think of a premium architectural or fashion magazine. The visual language utilizes a minimalist philosophy, where every element has room to breathe. High-quality imagery, vast negative space, and disciplined typography evoke a sense of quiet confidence, reliability, and long-term value.

## Colors

The palette is centered on a high-contrast relationship between Deep Navy and a warm Off-White. 

- **Deep Navy (#0B1F3A):** Used for primary text and high-authority containers to signal depth, trust, and night-sky reliability.
- **Solar Gold (#E8A020):** Reserved strictly for strategic accents, primary calls-to-action, and data highlights. It represents the energy of the sun without appearing neon or artificial.
- **Off-White/Cream (#FFF8EE):** The foundational canvas. It provides a warmer, more organic feel than pure white, softening the minimalist structure and feeling more "premium paper" than "digital screen."

## Typography

The typographic hierarchy relies on a classic serif-sans pairing. **Playfair Display** provides the editorial "voice," used for headlines and pull-quotes to convey heritage and expertise. **DM Sans** handles the functional heavy lifting, ensuring high legibility for technical specifications and body copy. 

Generous line heights and intentional letter spacing for labels are required to maintain the airy, premium feel. Use the "label-caps" style for overlines and small UI indicators to provide a modern, structured contrast to the fluid serif headlines.

## Layout & Spacing

This design system employs a **Fixed Grid** model to maintain editorial control over content density. On desktop, a 12-column grid with wide 32px gutters ensures that content blocks never feel crowded. 

Layouts should prioritize vertical rhythm, using large section padding (120px+) to separate distinct narratives. Grouped elements should follow an 8px baseline grid, but large-scale components (like cards or image blocks) should be separated by significantly more whitespace than standard web templates to emphasize the "magazine" aesthetic.

## Elevation & Depth

Depth is achieved through **Low-Contrast Outlines** and **Ambient Shadows** rather than heavy gradients. 

- **Borders:** Use a consistent 1px solid border in a slightly darkened version of the background cream or a very low-opacity Navy (10-15%). 
- **Shadows:** Avoid standard drop shadows. Instead, use "ambient glow" shadows—wide-spread, low-opacity (5%) Navy tints that make cards appear as if they are resting lightly on a paper surface.
- **Layering:** Content should feel flat and printed. Use the Cream background as the base, and use pure White only for specific elevated interactive elements to create a subtle "lift."

## Shapes

The shape language is defined by "Organic Precision." While the grid is rigid, the elements themselves feature large-radius corners to feel approachable and modern.

- **Small Components (Buttons, Tags):** Use a 12px radius.
- **Medium Components (Cards, Input Fields):** Use a 16px radius.
- **Large Components (Hero Sections, Image Containers):** Use a 24px radius.

This progression ensures that as elements grow in visual weight, their softness scales proportionally, maintaining a harmonious, high-end look.

## Components

### Buttons
- **Primary:** Deep Navy background with Off-White text. No shadow, 12px radius. High-contrast and bold.
- **Secondary:** Transparent background with a 1px Navy border. 
- **Tertiary/Ghost:** Solar Gold text, no border, with a subtle underline or right-arrow icon for "editorial" movement.

### Cards
Cards should be "floating" on the Cream background using a 1px border (#E5DED4) and the 16px radius. Avoid excessive ornamentation. Imagery inside cards should always be top-aligned with no internal padding, allowing the photo to meet the card edge.

### Input Fields
Minimalist 1px Navy bottom-border only or a full 1px light border with 16px radius. Label text should use the "label-caps" typography style, positioned above the field.

### Editorial Accents
Introduce a "Technical Detail" component: a small, Solar Gold circle or line used to highlight specific data points in solar panel diagrams or energy charts, acting as a visual anchor.
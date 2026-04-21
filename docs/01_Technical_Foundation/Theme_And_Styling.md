# Theme and Styling

**Last Updated:** November 22, 2024  
**Theme:** Kadence (Free Version)  
**Status:** Production Ready

---

## Current State

### Theme Information
**Active Theme:** Kadence  
**Version:** (Document current version)  
**License:** Free  
**Child Theme:** No (using customizer and custom CSS)

### Custom Files Location
```
/wp-content/
├── themes/kadence/
│   └── fonts/
│       ├── armalite_rifle.ttf
│       ├── UglyQua.ttf
│       └── UglyQuaItalic.ttf
└── uploads/2024/09/
    └── LexAlarmBanner8.svg
```

---

## Brand Specifications

### Official Colors
Defined in SVG banner and used throughout site:

```css
/* Primary Colors */
--la-blue: #044f9d;      /* Primary Blue - headers, backgrounds */
--la-red: #c3202e;       /* Primary Red - accents, buttons */
--la-white: #ffffff;     /* White - backgrounds, text on dark */

/* Usage */
Blue: Headers, button backgrounds, footer, section backgrounds
Red: Headlines, borders, button text, accent elements
White: Button borders, text on dark backgrounds, clean sections
```

### Typography Hierarchy

**Font Stack:**
```css
/* Display Font - All Caps Headers */
H1, H2, H3: ArmaliteRifle
- Color: Red (#c3202e)
- Transform: Uppercase
- Usage: Major section headers, page titles

/* Secondary Display - Regular Headers */
H4, H5, H6: UglyQua
- Color: Red (#c3202e)
- Usage: Subheadings, card titles

/* Body Text */
Body, Paragraphs: Work Sans
- Color: Black
- Weight: 400 (normal), 600 (semi-bold for emphasis)
- Usage: All body content, descriptions

/* Navigation & Buttons */
Navigation, Buttons: UglyQua
- Usage: Menu items, button text, calls-to-action
```

**Font Weights Available:**
- ArmaliteRifle: Regular (400)
- UglyQua: Regular (400), Italic (400)
- Work Sans: 300, 400, 500, 600, 700 (Google Fonts)

### Logo/Banner
**File:** LexAlarmBanner8.svg  
**Location:** `/wp-content/uploads/2024/09/`  
**Dimensions:** Responsive (scales based on viewport)  
**Elements:**
- "LEXINGTON ALARM" text (white on blue)
- "1775 ★ 2025" (white on red)
- American flag graphic
- Red border frame

---

## Responsive Design System

### Breakpoints
```css
/* Desktop - Default */
Full width banner and navigation

/* Large Tablet Landscape (1024px and below) */
Navigation adjustments, reduced spacing

/* Tablet Portrait (768px - 1024px) */
Banner max-width: 500px
Two-column layouts stack

/* Mobile/Phone (<768px) */
Banner max-width: 280px (portrait)
Hamburger menu active
Single column layouts

/* Phone Landscape */
Banner max-width: 350px
Compact spacing maintained
```

### Mobile Navigation
**Trigger:** < 768px viewport width  
**Style:** Hamburger menu (☰)  
**Colors:** White icon on blue background  
**Behavior:** Slide-in menu from side  
**Configuration:** Kadence theme mobile settings

---

## CSS Framework

### Custom CSS Location
**Primary Location:** WordPress Customizer → Additional CSS  
**Backup:** Should be in theme stylesheet or custom plugin  
**Lines of Code:** ~600 lines  
**Organization:** Sectioned by component type

### CSS Structure
```
1. Custom Properties/Variables
2. Font Definitions (@font-face rules)
3. WordPress/Kadence Overrides
4. Typography (H1-H6, body text)
5. Header & Banner
6. Navigation (desktop and mobile)
7. Buttons (primary and secondary styles)
8. Content Boxes (standard and highlight)
9. Layout Components (sections, columns)
10. Footer
11. Mobile Responsive (consolidated media queries)
12. Utility Classes
13. WordPress Specific Overrides
```

### Available Utility Classes

**Buttons:**
```css
.la-button              /* Red background, white text, white border */
.la-button-secondary    /* Blue background, white text */
```

**Content Containers:**
```css
.la-text-box           /* Standard bordered box with padding */
.la-highlight-box      /* Blue border, red accent bar at top */
```

**Layout:**
```css
.la-two-column         /* Flex-based two-column layout */
.la-section            /* Standard section with consistent padding */
```

**Text Alignment:**
```css
.la-text-center        /* Center-aligned text */
.la-text-left          /* Left-aligned text */
.la-text-right         /* Right-aligned text */
```

**Background Colors:**
```css
.la-bg-blue            /* Blue background (#044f9d) */
.la-bg-red             /* Red background (#c3202e) */
.la-bg-white           /* White background */
```

**Spacing Utilities:**
```css
/* Margin Top */
.la-mt-1               /* Margin-top: 1rem */
.la-mt-2               /* Margin-top: 2rem */
.la-mt-3               /* Margin-top: 3rem */

/* Margin Bottom */
.la-mb-1               /* Margin-bottom: 1rem */
.la-mb-2               /* Margin-bottom: 2rem */
.la-mb-3               /* Margin-bottom: 3rem */

/* Padding */
.la-p-1                /* Padding: 1rem */
.la-p-2                /* Padding: 2rem */
.la-p-3                /* Padding: 3rem */
```

---

## Header Configuration

### Header Layout
**Type:** Transparent with banner image  
**Height:** Variable based on banner image  
**Sticky Header:** (Document: Yes/No)  
**Logo Position:** Centered  

### Banner Implementation
```html
<!-- Banner is set in Kadence Customizer -->
<!-- Custom Header → Logo/Banner area -->
<!-- Image: LexAlarmBanner8.svg -->
```

**Responsive Behavior:**
- Desktop: Full width, centered
- Tablet: Max 500px width
- Mobile: Max 280px width (portrait), 350px (landscape)

---

## Navigation System

### Primary Navigation
**Location:** Below banner  
**Style:** Horizontal bar (desktop)  
**Font:** UglyQua  
**Colors:**
- Background: Blue (#044f9d)
- Text: White
- Hover: Red accent or underline

### Mobile Navigation
**Trigger:** Hamburger icon (white on blue)  
**Menu Style:** Slide-in panel  
**Configuration:** Kadence → Mobile Settings  
**Separately Configured:** Mobile header settings independent from desktop

### Menu Structure
```
- Home
- Events
- News
- Order Signs/Shop
- Join Us
- About
```

**Implementation Note:** All menu items use WordPress page references, not hardcoded URLs. This ensures links automatically update if pages are renamed or moved.

---

## Footer Configuration

### Footer Style
**Background:** Blue (#044f9d)  
**Text Color:** White  
**Layout:** (Document current footer layout)

**Typical Content:**
- Copyright notice
- Contact information
- Social media links
- (Document actual footer content)

---

## Kadence Theme Settings

### Active Kadence Features
- [ ] Header Builder (Document: In use or not)
- [ ] Footer Builder (Document: In use or not)
- [ ] Custom Layouts
- [ ] Elements (Document which elements if any)

### Kadence Blocks in Use
(Document any Kadence blocks actively used on site)
- Row Layout
- Advanced Heading
- Icon List
- (Others)

### Typography Settings
**Global Settings Location:** Kadence → Typography  
**Body Font:** Work Sans (Google Fonts)  
**Heading Font:** Custom fonts override (ArmaliteRifle, UglyQua)

---

## Page Builder Usage

### Content Creation Method
**Primary:** WordPress Block Editor (Gutenberg)  
**Secondary:** Kadence blocks for advanced layouts  
**Custom Layouts:** CSS classes applied to blocks

### Common Content Patterns

**Hero Section:**
```html
<div class="la-section la-bg-blue la-text-center">
    <h1>Headline Here</h1>
    <p>Subheading or description</p>
    <a href="#" class="la-button">Call to Action</a>
</div>
```

**Two-Column Layout:**
```html
<div class="la-two-column">
    <div>
        <!-- Left column content -->
    </div>
    <div>
        <!-- Right column content -->
    </div>
</div>
```

**Highlighted Information:**
```html
<div class="la-highlight-box">
    <h3>Important Information</h3>
    <p>Content here...</p>
</div>
```

---

## Maintenance & Updates

### Font Management
**Custom Fonts Location:** `/wp-content/themes/kadence/fonts/`  
**Font Loading:** CSS @font-face declarations in Additional CSS  
**Fallback Fonts:** Sans-serif system fonts

**Important:** Font paths should NOT include `/website_97a098b6/` (this was from staging and has been removed)

### CSS Maintenance Strategy
1. All custom CSS in one location (Customizer → Additional CSS)
2. Organized by sections with comments
3. Mobile responsive rules at end of stylesheet
4. Backup CSS before major changes
5. Test on multiple devices after CSS updates

### Theme Update Protocol
**Risk Assessment:** Low - using free version with custom CSS only  
**Before Updating:**
1. Full site backup
2. Export custom CSS from customizer
3. Screenshot current site appearance
4. Test in staging if available

**After Updating:**
1. Verify custom CSS still applies
2. Check all font loading
3. Test responsive breakpoints
4. Verify navigation functionality

---

## Known Issues

### Current
- None documented

### Resolved
- ✅ Font paths included `/website_97a098b6/` from staging (removed during migration)
- ✅ Mobile menu configuration separate from desktop (properly configured in Kadence)

---

## Performance Optimization

### Image Optimization
**Banner SVG:** Vector format, minimal file size  
**Logo/Images:** (Document optimization strategy)

### CSS Optimization
- Consolidated rules where possible
- Minimized use of heavy selectors
- Mobile rules grouped at end for efficiency

### Font Loading
- Custom fonts loaded via @font-face
- Google Fonts (Work Sans) loaded via Kadence typography settings
- Consider font-display: swap for better performance

---

## Future Enhancements

### Potential Improvements
- [ ] Add more utility classes as needed
- [ ] Consider CSS custom properties for easier color management
- [ ] Implement dark mode (if desired)
- [ ] Add animation/transition utilities
- [ ] Expand responsive breakpoints if needed

### Under Consideration
- Child theme creation (if extensive PHP customizations needed)
- Page builder upgrade (if more complex layouts needed)
- Additional custom fonts (if brand expands)

---

## Change History

### 2024 Q4 - Migration
- Removed `/website_97a098b6/` from all font paths
- Verified all custom CSS working on production domain
- Confirmed responsive behavior across devices

### 2024 Q3 - Initial Development
- Custom CSS framework created (~600 lines)
- Custom fonts (ArmaliteRifle, UglyQua) implemented
- Banner design finalized (LexAlarmBanner8.svg)
- Responsive breakpoints established
- Mobile navigation configured

---

**Related Documentation:**
- `06_Code_Snippets/Custom_CSS.md` - Full CSS code with annotations
- `08_Quick_References/Brand_Assets.md` - Quick color/font reference
- `01_Technical_Foundation/Site_Configuration.md` - File system locations

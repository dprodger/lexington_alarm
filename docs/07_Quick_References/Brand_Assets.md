# Brand Assets - Quick Reference

**Last Updated:** November 22, 2024  
**For:** Instant reference during design and content work

---

## Colors

### Primary Palette
```
Blue (Primary)
Hex: #044f9d
RGB: 4, 79, 157
Use: Headers, backgrounds, buttons, footer

Red (Accent)
Hex: #c3202e
RGB: 195, 32, 46
Use: Headlines, borders, accents, emphasis

White
Hex: #ffffff
RGB: 255, 255, 255
Use: Text on dark backgrounds, button borders, clean sections
```

### CSS Variables
```css
--la-blue: #044f9d;
--la-red: #c3202e;
--la-white: #ffffff;
```

---

## Typography

### Font Families

**Display Font (All Caps Headers):**
```
Font: ArmaliteRifle
File: armalite_rifle.ttf
Use: H1, H2, H3 - major headings
Style: Uppercase, Red (#c3202e)
```

**Secondary Display:**
```
Font: UglyQua
Files: UglyQua.ttf, UglyQuaItalic.ttf
Use: H4, H5, H6, Navigation, Buttons
Style: Red headings, White on blue for navigation
```

**Body Text:**
```
Font: Work Sans (Google Fonts)
Weights: 300, 400, 500, 600, 700
Use: All body text, paragraphs, descriptions
Style: Black text, weight 400 for normal, 600 for emphasis
```

### CSS Font Stack
```css
/* Display Headers */
h1, h2, h3 {
  font-family: 'ArmaliteRifle', sans-serif;
  color: #c3202e;
  text-transform: uppercase;
}

/* Secondary Headers & Navigation */
h4, h5, h6, nav {
  font-family: 'UglyQua', sans-serif;
  color: #c3202e;
}

/* Body Text */
body, p {
  font-family: 'Work Sans', sans-serif;
  color: #000000;
}
```

---

## Logo & Banner

### Primary Banner
**File:** LexAlarmBanner8.svg  
**Location:** `/wp-content/uploads/2024/09/`  
**Full URL:** https://lexingtonalarm.org/wp-content/uploads/2024/09/LexAlarmBanner8.svg

**Elements:**
- "LEXINGTON ALARM" (white on blue, ArmaliteRifle font)
- "1775 ★ 2025" (white on red bar)
- American flag graphic
- Red border frame

**Dimensions:** Scalable (SVG), responsive sizing:
- Desktop: Full width
- Tablet: Max 500px
- Mobile Portrait: Max 280px
- Mobile Landscape: Max 350px

### Logo Usage
**Primary Mark:** The banner/logo combination  
**Minimum Size:** 200px width for readability  
**Clear Space:** Maintain breathing room around logo  
**Don'ts:** 
- Don't alter colors
- Don't distort proportions
- Don't add effects/shadows
- Don't place on busy backgrounds

---

## Messaging

### Brand Tagline
"1775 ★ 2025"

### Core Message
Defending constitutional rights and rule of law through grassroots organizing, connecting modern activism to Revolutionary War resistance.

### Voice & Tone
- **Principled:** Grounded in constitutional values
- **Historical:** Connected to 1775 Lexington/Concord legacy
- **Community-focused:** Grassroots, local action
- **Firm but respectful:** Strong convictions, civil discourse
- **Action-oriented:** Clear calls to action, empowering

### Key Themes
1. Constitutional rights and rule of law
2. Historical continuity (1775-2025)
3. Community organizing and local action
4. Resistance to tyranny/overreach
5. Inclusive vision of American values

---

## Buttons & Calls-to-Action

### Primary Button
```css
.la-button {
  background: #c3202e; /* Red */
  color: #ffffff; /* White text */
  border: 2px solid #ffffff; /* White border */
  padding: 12px 30px;
  font-family: 'UglyQua', sans-serif;
  font-size: 18px;
}
```

**Use for:** Primary actions (Sign Up, Order Now, Join Us)

### Secondary Button
```css
.la-button-secondary {
  background: #044f9d; /* Blue */
  color: #ffffff; /* White text */
  border: none;
  padding: 12px 30px;
  font-family: 'UglyQua', sans-serif;
}
```

**Use for:** Secondary actions (Learn More, Read More)

### Button Text Examples
- "Join the Alarm"
- "Order Your Sign"
- "Take Action"
- "Learn More"
- "Get Involved"
- "Support the Mission"

---

## Photography & Imagery

### Photography Style
- Authentic, documentary-style images
- Community events and actions
- Local Lexington historical sites
- Rally and organizing activities
- Avoid stock photos where possible

### Image Treatment
- No heavy filters
- Maintain color accuracy
- High contrast acceptable
- Black and white OK for historical context
- Overlay text with caution (ensure readability)

### Historical Imagery
- Revolutionary War era illustrations
- Lexington Green historical markers
- Battle of Lexington commemorations
- Connect past to present visually

---

## Content Boxes

### Standard Text Box
```css
.la-text-box {
  border: 2px solid #044f9d; /* Blue border */
  padding: 2rem;
  margin: 1rem 0;
  background: #ffffff;
}
```

### Highlight Box
```css
.la-highlight-box {
  border: 3px solid #044f9d; /* Blue border */
  border-top: 8px solid #c3202e; /* Red accent */
  padding: 2rem;
  background: #ffffff;
}
```

**Use for:** Important announcements, featured content, calls-to-action

---

## Layout Guidelines

### Spacing
```css
/* Standard spacing units */
Small: 0.5rem (8px)
Medium: 1rem (16px)
Large: 2rem (32px)
Extra Large: 3rem (48px)
```

### Section Padding
```css
.la-section {
  padding: 3rem 1rem; /* Desktop */
  padding: 2rem 1rem; /* Mobile */
}
```

### Content Width
- **Maximum Content Width:** 1200px
- **Comfortable Reading Width:** 600-700px for body text
- **Full Width:** Allowed for banners, images, backgrounds

---

## Social Media

### Profile Images
- Use primary banner/logo
- Maintain 1:1 aspect ratio for profile photos
- Ensure legibility at small sizes

### Cover Images
- Feature banner with 1775-2025 prominently
- Include calls-to-action where appropriate
- Update seasonally or for major campaigns

### Hashtags
```
Primary: #LexingtonAlarm
Campaign-specific: #EndDeportationFlights, #BattleGreenFlag
Historical: #1775to2025, #AmericanRevolution250
```

### Platform-Specific Sizes
- Instagram: 1080x1080 (square), 1080x1350 (portrait)
- Facebook: 1200x630 (shared links), 1200x1200 (posts)
- Twitter/Bluesky: 1200x675 (shared links)

---

## Print Materials

### Yard Signs
**Sizes:** 2' x 3' and 18" x 24"  
**Design:** Uses banner/logo design  
**Materials:** Corrugated plastic, weather-resistant  
**Colors:** Full color (blue, red, white)

### Buttons
**Size:** 2.25" or 3" diameter  
**Design:** (Document button designs)  
**Colors:** Match brand palette

### Flyers/Handouts
**Color Printing:** Blue and red spot colors acceptable  
**Black & White:** High contrast, bold headlines  
**Paper:** Standard letter size (8.5" x 11")

---

## Dos and Don'ts

### Do:
✅ Use official brand colors  
✅ Maintain consistent typography  
✅ Connect to 1775-2025 messaging  
✅ Include clear calls-to-action  
✅ Use high-quality images  
✅ Test on mobile devices  

### Don't:
❌ Alter logo colors or proportions  
❌ Use rainbow effects or gradients  
❌ Mix too many fonts  
❌ Use low-resolution images  
❌ Overcomplicate designs  
❌ Stray from core messaging  

---

## Quick Copy/Paste

### Color Codes
```
Blue: #044f9d
Red: #c3202e
White: #ffffff
```

### Font Names
```
ArmaliteRifle
UglyQua
Work Sans
```

### Image Path
```
/wp-content/uploads/2024/09/LexAlarmBanner8.svg
```

### CSS Classes
```
.la-button
.la-button-secondary
.la-text-box
.la-highlight-box
.la-section
.la-two-column
```

---

## Resources

### Font Files Location
`/wp-content/themes/kadence/fonts/`

### Full CSS Framework
See: `06_Code_Snippets/Custom_CSS.md`

### Detailed Styling Guide
See: `01_Technical_Foundation/Theme_And_Styling.md`

---

**This is a quick reference. For complete implementation details, see the full documentation in other sections.**

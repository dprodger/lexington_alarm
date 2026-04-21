# Rhode Island Campaign Documentation

## Quick Navigation

- [Overview](#overview)
- [File Locations](#file-locations)
- [WordPress Components](#wordpress-components)
- [Key Differences from Massachusetts Campaign](#key-differences-from-massachusetts-campaign)
- [Form IDs](#form-ids)
- [Testing & Launch](#testing--launch)

---

## Overview

The Rhode Island campaign is an adaptation of the Massachusetts Massport campaign, targeting Rhode Island residents affected by ICE deportation flights from Hanscom Field. The campaign emphasizes that over 1,000 Rhode Island residents have been affected and frames the issue around New England regional impact.

**Campaign URL:** `https://lexingtonalarm.org/rhode-island-stop-massport-ice-flights/`

**Date Created:** December 12, 2025
**Last Updated:** December 13, 2025 - Proofreading corrections (Phillip Eng replaces Tibbits-Nutt, removed RE: prefix)

---

## File Locations

### Local Reference Files (This Folder)

| File | Purpose |
|------|---------|
| `rhode-island-campaign-template.php` | Full page template code - reference copy |
| `rhode_island_pdf.php` | PDF generator code - reference copy |
| `Rhode_Island_Letter_Texts.md` | Short and long letter text versions |
| `README.md` | This documentation file |

### WordPress Code Snippets (Live Code)

| Snippet Name | Description |
|--------------|-------------|
| Rhode Island Campaign Template | Page template - renders the full campaign page |
| Rhode Island PDF Generator | Generates 8-page PDF with 7 board member letters |

### WordPress Media Library

| File | URL |
|------|-----|
| Sample Letter PDF | `/wp-content/uploads/2025/12/RI_Massport_Sample_Letter.pdf` |

---

## WordPress Components

### Page
- **Title:** Rhode Island: Stop Massport ICE Flights
- **Template:** Rhode Island Campaign (No Theme Styles)
- **Slug:** `rhode-island-stop-massport-ice-flights`

### WPForms

| Form ID | Form Name | Purpose |
|---------|-----------|---------|
| 1654 | RI Massport Email Tracking | Tracks short email, long email, and Governor actions |
| 1657 | RI Board Letters Request | Collects address info, triggers PDF generation |

**Note:** Form 1654 is used for all three action types (short, long, governor) via the hidden Action Type field.

### Form Confirmations

Form 1657 has a custom confirmation message with Rhode Island-specific letter text. This was manually updated in WPForms → Settings → Confirmations.

---

## Key Differences from Massachusetts Campaign

### Letter Content Changes

| Element | Massachusetts | Rhode Island |
|---------|---------------|--------------|
| Residents affected | "Over 2,000 Massachusetts residents" | "Over 1,000 Rhode Island residents" |
| State references | "Massachusetts residents" | "Rhode Islanders" / "Rhode Island residents" |
| Regional framing | Massachusetts-focused | "New England area" / regional emphasis |
| Immigration judges | "Massachusetts immigration judges" | "Rhode Island immigration judges" |
| Signature line | "[City], MA [ZIP]" | "[City/Town], RI [ZIP]" |

### Code Changes

| Component | Change |
|-----------|--------|
| Template class names | `.massport-action-page` → `.ri-action-page` |
| Function names | `massport_*` → `rhode_island_*` |
| Global variable | `$TEST_MODE` → `$RI_TEST_MODE` |
| Field IDs | `user_name_massport` → `user_name_ri` |
| JavaScript functions | `sendTrackedEmail()` → `sendTrackedEmailRI()` |
| PDF class | `Massport_PDF_Generator` → `Rhode_Island_PDF_Generator` |
| PDF filename prefix | `massport-letters-` → `ri-massport-letters-` |

---

## Form IDs

### Email Tracking Form (1654)

**Fields:**
- Field 1: Name
- Field 2: Email  
- Field 3: Action Type (hidden - values: "short", "long", "governor")

**Used by:**
- Short email button
- Long email button
- Governor Healey contact button

### Board Letters Form (1657)

**Fields:**
- Field 1: Name
- Field 2: Email
- Field 5: Street Address
- Field 6: Apt/Unit (optional)
- Field 7: City
- Field 9: ZIP Code
- Field 10: Organization (optional)

**Triggers:** Rhode Island PDF Generator on submission

---

## Testing & Launch

### Test Mode

The template includes a test mode controlled by:

```php
global $RI_TEST_MODE;
$RI_TEST_MODE = false;  // Set to true for testing
```

When `true`:
- Red banner displays at top of page
- Emails route to test addresses only
- Name/email fields appear in yellow test box

### Production Mode

Set `$RI_TEST_MODE = false` for live operation:
- No test banner
- Emails route to `WrittenPublicComments@massport.com`
- Blue input box with tracking integration

### Checklist Before Launch

- [x] Template code in Code Snippets (activated)
- [x] PDF generator in Code Snippets (activated)
- [x] Form 1654 created and configured
- [x] Form 1657 created with RI confirmation message
- [x] WordPress page created with correct template
- [x] Sample letter PDF uploaded
- [x] Test mode disabled (`$RI_TEST_MODE = false`)
- [x] Form field IDs verified (1, 2, 5, 6, 7, 9, 10)

---

## Related Documentation

See also:
- `/05_Active_Campaigns/Massport_campaign/Massport_Campaign.md` - Original MA campaign docs
- `/05_Active_Campaigns/Massport_campaign/` - MA campaign files for reference

---

*Last Updated: December 12, 2025*

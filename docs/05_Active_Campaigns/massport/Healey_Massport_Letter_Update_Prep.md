# Healey/Massport Letter Update - Prep Document

**Created:** January 10, 2026  
**Target:** Live by Monday, January 12, 2026  
**Session:** Sunday, January 11 (2-3 hours)

---

## Overview

Two systems need updating:
1. **Massport Board PDF Generator** - 7 letters to board members (PHP/TCPDF)
2. **Governor Healey Contact** - Copy/paste message for web form (JavaScript)

---

## System 1: Massport Board PDF Letters

### File Location
```
/wp-content/plugins/massport-pdf/massport_pdf.php
```

### What Toby Provides (Content)
- [ ] New letter body text (the demands, legal arguments, closing)
- [ ] Any changes to board members (names, titles, who's new/removed)
- [ ] Updated instructions page text (if needed)
- [ ] Any changes to email confirmation text

### What Claude Updates (Code)

**A. Board Members Array** (line ~108-116)
Current members:
1. Patricia A. Jacobs - Chair
2. Sean M. O'Brien - Vice Chair
3. Lewis Evangelidis - Board Member
4. Pamela Everhart - Board Member
5. Warren Fields - Board Member
6. John Nucci - Board Member
7. Phillip Eng - Secretary/Ex Officio (MassDOT)

*Any changes? New appointments? Departures?*

**B. Letter Body Content** (function `write_letter_body`, line ~239-280)
Current structure:
- Opening paragraphs (3)
- Bulleted demands (5)
- Closing paragraphs (4)

*This is where new research content goes.*

**C. Instructions Page** (function `add_instructions_page`, line ~148-195)
- May need minor updates if letter structure changes

**D. Email Confirmation** (function `send_email`, line ~291-315)
- Update if the campaign messaging changes

---

## System 2: Governor Healey Contact

### Location
Campaign page template in Code Snippets (not the plugin)

### What Toby Provides
- [ ] Updated message text for Governor
- [ ] Any new demands/points to include

### What Claude Updates
- `governorMessage` constant in JavaScript
- Any changes to the copy/paste instructions

---

## Code Update Workflow (Sunday)

### Step 1: Content Review
- Toby shares new letter content (paste or document)
- Claude identifies what maps to which code sections

### Step 2: Update PHP (Massport Board Letters)
1. Update `write_letter_body()` function with new paragraphs/bullets
2. Update board members array if needed
3. Test locally (generate test PDF)

### Step 3: Update JavaScript (Governor Contact)
1. Update `governorMessage` constant
2. Test copy/paste functionality

### Step 4: Test on Local
- Submit test form
- Verify PDF generates correctly
- Check all 7 letters render properly
- Test Governor copy/paste

### Step 5: Deploy to Live
- Copy updated plugin file to live site
- Update Code Snippet on live site
- Test on live
- Verify email delivery

---

## Quick Reference: Code Sections to Modify

| Content Change | File | Function/Line |
|----------------|------|---------------|
| Letter body text | massport_pdf.php | `write_letter_body()` ~239 |
| Board members | massport_pdf.php | `$board_members` array ~108 |
| Instructions page | massport_pdf.php | `add_instructions_page()` ~148 |
| Email confirmation | massport_pdf.php | `send_email()` ~291 |
| Governor message | Code Snippet | `governorMessage` constant |

---

## Form IDs (Don't Change)
- WPForms Form ID: **1401** (Massport board letters)
- Form fields map to: name(1), email(2), street(5), apt(6), city(7), zip(9), org(10)

---

## Testing Checklist

### PDF Generation
- [ ] PDF generates without errors
- [ ] All 7 letters present
- [ ] New content appears correctly
- [ ] Sender info populates
- [ ] Date is correct
- [ ] Formatting looks good (no overflow, proper spacing)

### Email Delivery
- [ ] Email sends successfully
- [ ] PDF attachment included
- [ ] Email content is correct

### Governor Contact
- [ ] Message copies to clipboard
- [ ] Form opens in new tab
- [ ] Instructions popup displays
- [ ] Pasted message looks correct

---

## Rollback Plan

If issues arise:
1. Plugin file has previous version in `/updraft/plugins-old/massport-pdf/`
2. Can quickly swap back
3. Code Snippets has version history

---

## Ready to Start

**When Toby is ready:**
1. Share the new letter content (text or document)
2. Note any board member changes
3. Note any Governor message changes

**Claude will:**
1. Map content to code locations
2. Make the edits
3. Provide updated files for testing
4. Guide deployment

---

*This document saved to: `/LexingtonAlarm_Docs/Obsidian_Schedule_Templates/` for reference*

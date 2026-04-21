# Massport Campaign - Gmail Users Update

**Date:** December 22, 2025  
**Purpose:** Add Gmail-friendly email option for users whose native email client doesn't open

---

## Overview

The existing mailto: links work well for users with native email clients (Apple Mail, Outlook), but Gmail web users often find the buttons don't work. This update adds:

1. A **"Gmail Users Click Here"** button on the campaign page
2. A **Gmail helper page** where users can easily copy/paste all email content

---

## PART 1: Add the Gmail Button to Campaign Page

### Where to Add It

In the **Massport Campaign Template** code snippet, find the section with the existing email buttons (Short Email and Long Email). Add this code **after** those buttons:

```html
<!-- GMAIL USERS BUTTON -->
<div style="text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px dashed #ccc;">
    <p style="color: #666; font-size: 14px; margin-bottom: 12px;">
        <em>Email button not working? Using Gmail in your browser?</em>
    </p>
    <a href="<?php echo esc_url( home_url('/massport-gmail-helper/') ); ?>" 
       class="gmail-helper-button" 
       style="display: inline-block; 
              background: #EA4335; 
              color: white; 
              padding: 14px 28px; 
              font-size: 16px; 
              font-weight: bold; 
              border: none; 
              border-radius: 5px; 
              cursor: pointer; 
              text-decoration: none; 
              text-align: center;
              transition: background 0.2s;">
        📧 GMAIL USERS CLICK HERE
    </a>
</div>
```

---

## PART 2: Create the Gmail Helper Page

### Step 1: Create the Code Snippet

1. Go to **Snippets → Add New** (or WPCode → Add Snippet)
2. **Title:** "Massport Gmail Helper Template"
3. **Code Type:** PHP
4. **Paste** the complete code from `massport_gmail_helper_template.php`
5. **Activate** the snippet

### Step 2: Create the WordPress Page

1. Go to **Pages → Add New**
2. **Title:** "Massport Gmail Helper"
3. **Permalink:** Set slug to `massport-gmail-helper`
4. **Template:** Select "Massport Gmail Helper" from Page Attributes
5. **Publish** (leave content empty - the template handles everything)

---

## What the Gmail Helper Page Shows

The page displays:

1. **Instructions** - Step-by-step guide for Gmail users
2. **To: Address** - `WrittenPublicComments@massport.com` with copy button
3. **CC: Addresses** - All 4 state officials with copy button
4. **Subject Line** - With copy button
5. **Letter Options** - Tabs to switch between Short and Long letter
6. **Signature Reminder** - Prompts user to add their name and town
7. **Back Link** - Returns to campaign page

Each section has a **Copy** button that provides visual feedback when clicked.

---

## Installation Checklist

- [ ] Add Gmail button code to Massport Campaign Template snippet
- [ ] Create new snippet with Gmail Helper Template code
- [ ] Activate the Gmail Helper Template snippet
- [ ] Create WordPress page with slug `massport-gmail-helper`
- [ ] Set page template to "Massport Gmail Helper"
- [ ] Publish page
- [ ] Test Gmail button on campaign page
- [ ] Test all copy buttons on Gmail helper page
- [ ] Test on mobile devices

---

## Files Included

| File | Description |
|------|-------------|
| `massport_gmail_helper_template.php` | Complete PHP template for Gmail helper page |
| `gmail_button_code.html` | Just the button HTML to add to campaign page |

---

## Technical Notes

- Uses same Lexington Alarm blue (#044f9d) as main campaign page
- Gmail red (#EA4335) for the button to indicate Gmail-specific
- Responsive design for mobile users
- Copy buttons use modern clipboard API with fallback for older browsers
- Tab interface lets users choose between short and long letters

---

**Status:** Ready for installation

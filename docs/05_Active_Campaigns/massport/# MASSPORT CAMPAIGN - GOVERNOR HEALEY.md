# MASSPORT CAMPAIGN - GOVERNOR HEALEY FORM INTEGRATION
## Implementation Guide

**Date:** November 26, 2025  
**Issue:** Governor Healey doesn't accept direct email - requires web form submission  
**Solution:** "Copy & Open" button that copies message and opens Governor's form

---

## SUMMARY OF CHANGES

### 1. Remove Governor from Email CC
The current email CC includes `governor.healey@mass.gov`, which doesn't work. Remove it.

### 2. Add New Governor Contact Button
Add a separate button that:
- Copies a Governor-specific message to the clipboard
- Opens the Governor's form in a new tab
- Shows instructions for the user

---

## STEP-BY-STEP IMPLEMENTATION

### Step 1: Update the Email CC Recipients

**Current code in your Code Snippet:**
```javascript
var ccRecipients = 'governor.healey@mass.gov,ago@mass.gov,karen.spilka@masenate.gov,ronald.mariano@mahouse.gov';
```

**Change to:**
```javascript
var ccRecipients = 'ago@mass.gov,karen.spilka@masenate.gov,ronald.mariano@mahouse.gov';
```

This keeps:
- ✅ Attorney General Andrea Campbell (ago@mass.gov)
- ✅ Senate President Karen Spilka (karen.spilka@masenate.gov)
- ✅ Speaker Ronald Mariano (ronald.mariano@mahouse.gov)

And removes:
- ❌ Governor Healey (governor.healey@mass.gov) - doesn't accept email

---

### Step 2: Add the Governor Contact Section HTML

Find this section in your template (after the email button):
```html
<div class="info-box" style="margin-top: 20px;">
    <p><strong>💡 Tip:</strong> Your email client will open...
```

**ADD THIS NEW SECTION before that info-box:**

```html
<!-- GOVERNOR HEALEY CONTACT SECTION -->
<div class="info-box" style="background: #fff3cd; border-left: 4px solid #ffc107; margin-top: 25px;">
    <p style="margin-bottom: 15px;">
        <strong>📣 Contact Governor Healey Separately:</strong><br>
        Governor Healey's office requires contact through their official web form (they don't accept direct email).
    </p>
    
    <div style="text-align: center;">
        <button onclick="contactGovernor()" class="action-button" style="background: #8b4513; min-width: 280px;">
            📝 Contact Governor Healey
        </button>
    </div>
    
    <p style="font-size: 14px; margin-top: 15px; color: #666;">
        <em>This will copy your message to clipboard and open the Governor's contact form in a new tab. 
        You'll need to paste the message and complete the verification.</em>
    </p>
</div>
```

---

### Step 3: Add the JavaScript Functions

Add this JavaScript to your existing `<script>` section at the bottom of the template:

```javascript
// Governor Healey message text
const governorMessage = `Dear Governor Healey,

I am writing to urge your administration to take action regarding Massport's cooperation with ICE deportation operations at Hanscom Field.

Over 2,000 Massachusetts residents have been forcibly removed from our state using ICE charter flights from Hanscom Field. Their constitutional rights of due process have been recklessly disregarded.

When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens entitled to hearings before Massachusetts immigration judges are flown out of state without access to counsel or family support, their due-process rights are violated. Committee for Public Counsel Services v. ICE (D. Mass. 2020) and Lunn v. Commonwealth confirm that state officials have no authority to facilitate removals based solely on civil immigration detainers.

I urge you to:

1. Direct Massport to publish all ICE-related agreements and flight records
2. Require Massport to adopt a Lunn-Compliance and Custody-Transfer Transparency Directive
3. Ensure State Police Troop F activities at Hanscom Field fully comply with Lunn and AG guidelines
4. Use your authority to protect Massachusetts residents' constitutional due process rights

Massachusetts residents deserve transparency about how our public transportation infrastructure is being used. Please prioritize our state residents' constitutional protections.

Sincerely,
[YOUR NAME]
[YOUR CITY/TOWN], MA`;

// Copy message to clipboard and open Governor's form
function contactGovernor() {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(governorMessage).then(function() {
            openGovernorForm();
        }).catch(function(err) {
            copyTextFallbackGov(governorMessage);
            openGovernorForm();
        });
    } else {
        copyTextFallbackGov(governorMessage);
        openGovernorForm();
    }
}

// Fallback copy method
function copyTextFallbackGov(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-9999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
    } catch (err) {
        console.error('Copy failed:', err);
    }
    document.body.removeChild(textArea);
}

// Open Governor's form with instructions
function openGovernorForm() {
    alert(`✅ MESSAGE COPIED TO CLIPBOARD!

The Governor's contact form will now open in a new tab.

NEXT STEPS:
1. Fill in your name and contact information
2. For "Topic" select: Other
3. In the message box, PASTE your message (Ctrl+V or Cmd+V)
4. Complete the "I am not a robot" verification
5. Click Submit

Your message is ready to paste!`);
    
    window.open('https://www.mass.gov/forms/email-the-governors-office', '_blank');
}
```

---

## VISUAL PLACEMENT

After implementation, the Option 1 section should look like:

```
📧 Option 1: Submit Written Public Comment to Massport
├── [Send Email Comment] button → Opens email to Massport + 3 state officials
├── [Copy & Email Full Letter] button → Opens email with full letter
│
├── 🟨 Governor Healey Contact Box (NEW)
│   └── [Contact Governor Healey] button → Copies message + opens form
│
└── 💡 Tip: Your email client will open...
```

---

## TESTING CHECKLIST

- [ ] "Send Email Comment" button opens email WITHOUT governor.healey@mass.gov in CC
- [ ] CC still includes: ago@mass.gov, karen.spilka@masenate.gov, ronald.mariano@mahouse.gov
- [ ] "Contact Governor Healey" button shows instructions popup
- [ ] Governor's form opens in new tab
- [ ] Message is copied to clipboard (test by pasting in Notepad/TextEdit)
- [ ] Message pastes correctly into Governor's form message field
- [ ] Works on mobile (iOS and Android)

---

## WHY THIS APPROACH?

We cannot directly pre-fill the Governor's form because:
1. **Cross-origin security** - Browsers prevent websites from filling forms on other domains
2. **No URL parameters** - Mass.gov forms don't accept pre-fill parameters
3. **reCAPTCHA protection** - Automated form filling would be blocked

The "Copy & Open" approach is the industry-standard solution used by many advocacy campaigns. It:
- Works reliably across all browsers and devices
- Respects the Governor's form security
- Provides clear user instructions
- Keeps the user experience simple (copy → paste → submit)

---

## FILES DELIVERED

1. `governor-section-html.html` - Complete HTML and JavaScript to add
2. `governor-form-integration.js` - Standalone JavaScript file (if preferred)
3. `IMPLEMENTATION-GUIDE.md` - This file

---

## QUESTIONS?

If you encounter any issues during implementation, start a new chat with:
- This implementation guide
- The specific error or issue you're seeing
- A screenshot if helpful

---

**Last Updated:** November 26, 2025
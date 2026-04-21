# Massport Campaign Page - Email Action Tracking Implementation

**Date:** November 22, 2025  
**Status:** ✅ WORKING ON LOCAL SITE  
**Live Deployment:** NOT YET DEPLOYED  
**Campaign Page URL (Live):** https://lexingtonalarm.org/stop-massport-ice-flights-campaign/

---

## Executive Summary

Implemented tracking system for email campaign actions on the Massport Campaign page. Users who click email action buttons now have their contact information captured in WPForms #1472, enabling follow-up outreach and campaign metrics tracking.

**What Gets Tracked:**
- User name and email address
- Whether they sent the short email (3 min) or full letter (5 min)
- Timestamp of action

**Why This Matters:**
- Build activist database for future campaigns
- Measure campaign effectiveness (short vs. long email usage)
- Send follow-up communications about DE-ICE campaign
- Invite participants to join Action Network mailing list

---

## Current Status

### ✅ Completed on Local Site:
- WPForms #1472 "Massport Email Action Tracker" created
- Blue box UI with name/email fields implemented
- Two tracked action buttons working (short email, full letter)
- JavaScript tracking function operational
- Admin notification emails working
- User confirmation emails sending

### ⚠️ Needs Work:
- User confirmation email text (currently default text, needs customization)
- Tracking for "Copy Letter" button
- Tracking for "Download PDF" button
- Deployment to live site

### 🚫 Not Yet on Live Site:
- Live site currently has NO tracking
- Live site only has basic email buttons without data capture
- Users on live site are NOT being tracked

---

## Critical Bug Fix (November 22, 2025)

### Problem Discovered:
Form #1401 (PDF Board Letters form) was not submitting on live site. Last successful entry was November 20, 2025 at 12:36 PM. Multiple users attempted submissions with no entries recorded.

### Root Cause:
Massport Campaign Template was missing `<?php wp_footer(); ?>` before closing `</body>` tag. This prevented WPForms JavaScript from loading, breaking all form submissions.

### Fix Applied to Live Site:
Added `<?php wp_footer(); ?>` immediately before `</body></html>` in Massport Campaign Template.

### Result:
Live site Form #1401 now works correctly. Users can submit PDF letter requests again.

---

## Technical Architecture

### Component 1: WPForms #1472 - Massport Email Action Tracker

**Form Name:** Massport Email Action Tracker  
**Form ID:** 1472  
**Location:** WPForms → All Forms

**Field Structure:**

| Field # | Field Name | Type | Required | Purpose |
|---------|------------|------|----------|---------|
| 1 | Name | Single Line Text | Yes | User's full name |
| 2 | Email | Email | Yes | User's email for follow-up |
| 3 | Action Type | Hidden Field | No | "short" or "long" |

**Notifications Configured:**

**Notification 1: Admin Alert**
- **To:** info@lexingtonalarm.org
- **Subject:** New Massport Email Action: {field_id="3"}
- **Purpose:** Alert organizers when someone takes action
- **Status:** ✅ Working

**Notification 2: User Confirmation**
- **To:** {field_id="2"} (user's email)
- **Subject:** Thank you for demanding Massport end ICE flights
- **From:** DE-ICE Hanscom Campaign <info@lexingtonalarm.org>
- **Purpose:** Confirm action, invite to Action Network
- **Status:** ⚠️ Needs content update

---

### Component 2: Massport Campaign Template Updates

**File Location:** Code Snippets plugin → "Massport Campaign Template"  
**Snippet ID:** #1397 (local), #1397 (live - but tracking not deployed yet)

**Test Mode Toggle:**
```php
global $TEST_MODE;
$TEST_MODE = false;  // SET TO false FOR PRODUCTION
```

**Changes Made (Lines ~650-770):**

#### 1. Blue Box UI with Input Fields (Production Mode Only)

**Visual Design:**
- Background: Light Lexington blue (#e6f2ff)
- Border: 3px solid Lexington blue (#044f9d)
- Rounded corners (8px)
- 30px padding

**Input Fields:**
- Name input: Full width, blue border, required
- Email input: Full width, blue border, required validation

#### 2. Two Action Buttons Inside Blue Box

**Button 1: Send Short Email**
- **Color:** Lexington Blue (#044f9d)
- **Text:** "📧 SEND SHORT EMAIL"
- **Subtext:** "(3 minutes)"
- **Action:** Tracks as "short", opens short email

**Button 2: Send Full Letter**
- **Color:** Lexington Red (#c3202e)
- **Text:** "📧 SEND FULL LETTER"
- **Subtext:** "(5 minutes)"
- **Action:** Tracks as "long", opens full letter

**Layout:**
- Two-column grid on desktop
- Stacked on mobile
- 15px gap between buttons

#### 3. Hidden WPForms Integration

```html
<div style="display: none;">
    <?php echo do_shortcode('[wpforms id="1472"]'); ?>
</div>
```

**Why Hidden:**
- WPForms needs to be on page for submission to work
- We use custom UI instead of standard form appearance
- JavaScript programmatically fills and submits this hidden form

#### 4. JavaScript Tracking Function

**Function Name:** `sendTrackedEmail(actionType)`

**Parameters:**
- `actionType`: String, either "short" or "long"

**Process Flow:**
1. Validate name and email fields are filled
2. Validate email format with regex
3. Find hidden WPForms #1472 fields by name attribute:
   - `wpforms[fields][1]` = Name
   - `wpforms[fields][2]` = Email  
   - `wpforms[fields][3]` = Action Type
4. Populate hidden form fields with user data
5. Find and click submit button `#wpforms-submit-1472`
6. WPForms handles submission with all security tokens
7. Immediately call appropriate email function:
   - If "short" → `sendProductionEmail()`
   - If "long" → `openFullLetterEmail()`

**Key Technical Decision:**
We do NOT manually POST to admin-ajax.php. Instead, we programmatically fill and submit the actual WPForms form, which includes all necessary security nonces and CSRF tokens. This approach avoids WPForms security validation errors.

---

## User Experience Flow

### Scenario 1: User Sends Short Email

1. **User arrives** at Massport Campaign page
2. **User sees** blue box with name/email fields and two button options
3. **User enters** their name: "Jane Smith"
4. **User enters** their email: "jane@example.com"
5. **User clicks** "SEND SHORT EMAIL (3 minutes)" button
6. **JavaScript executes:**
   - Validates inputs
   - Fills hidden WPForms #1472
   - Submits form (creates entry with action_type="short")
7. **WPForms triggers:**
   - Admin notification sent to info@lexingtonalarm.org
   - User confirmation email sent to jane@example.com
8. **Email client opens** with pre-filled short letter to Massport officials
9. **User adds** their name and city to email
10. **User sends** email from their own email client

### Scenario 2: User Sends Full Letter

Same flow as above, but:
- Entry recorded with action_type="long"
- Email client opens with longer, more detailed letter
- Takes approximately 5 minutes instead of 3

---

## Data Captured & Usage

### Data Collected per Action:

**Entry in WPForms #1472:**
- Entry ID (auto-increment)
- Date/time of submission
- User's name
- User's email address
- Action type ("short" or "long")
- IP address (WPForms default)
- User agent (WPForms default)

### Intended Use Cases:

1. **Follow-up Outreach**
   - Email participants about campaign updates
   - Invite to future actions
   - Share results and progress

2. **Action Network Integration** (planned)
   - Add participants to DE-ICE Hanscom campaign list
   - Enable email updates about deportation flights
   - Mobilize for future actions

3. **Campaign Metrics**
   - Track total actions taken
   - Compare short vs. long email usage
   - Measure campaign momentum over time
   - Identify peak engagement periods

4. **Coalition Building**
   - Share aggregate data with partner organizations
   - Demonstrate community opposition to ICE flights
   - Support policy advocacy with concrete numbers

---

## Email Content

### Short Email (3 minutes)

**Recipients:**
- **To:** WrittenPublicComments@massport.com
- **CC:** karen.spilka@masenate.gov, ronald.mariano@mahouse.gov

**Subject:** Massport Must Halt ICE Operations that Violate Due Process Rights at Hanscom Field

**Body Overview:**
- Direct statement of problem (2,000+ residents removed via ICE flights)
- Constitutional due process violation claim
- Reference to Lunn v. Commonwealth and CPCS v. ICE
- Five specific demands for Massport action
- User adds their own name and city before sending

**Length:** ~300 words

### Full Letter (5 minutes)

**Recipients:**
- **To:** WrittenPublicComments@massport.com
- **CC:** karen.spilka@masenate.gov, ronald.mariano@mahouse.gov

**Subject:** Halt ICE Operations and Due Process Violations at Hanscom Field

**Body Overview:**
- Expanded constitutional argument
- Detailed explanation of due process violations
- Six specific demands (includes safety certification requirement)
- Anti-commandeering doctrine explanation
- Federal funding protection details
- User adds their name, full address, city/state/zip before sending

**Length:** ~800 words

**Key Difference:** Full letter provides more legal detail and context for users who want to make a stronger written statement.

---

## Testing Results (Local Site)

### Test Date: November 22, 2025

**Test Environment:**
- Local WordPress installation
- URL: http://la-wordpress-local.local
- Test mode: OFF (production mode)

**Test Cases Executed:**

✅ **TC1: Blue Box Visibility**
- Expected: Blue box with name/email fields visible in production mode
- Result: PASS

✅ **TC2: Input Validation - Empty Fields**
- Action: Click button without filling fields
- Expected: Alert "Please enter your name and email"
- Result: PASS

✅ **TC3: Input Validation - Invalid Email**
- Action: Enter "notanemail" in email field
- Expected: Alert "Please enter a valid email address"
- Result: PASS

✅ **TC4: Short Email Tracking**
- Action: Fill valid name/email, click "SEND SHORT EMAIL"
- Expected: Entry created in WPForms #1472 with action_type="short"
- Result: PASS - Entry ID visible in WPForms → Entries

✅ **TC5: Long Email Tracking**
- Action: Fill valid name/email, click "SEND FULL LETTER"
- Expected: Entry created in WPForms #1472 with action_type="long"
- Result: PASS - Entry ID visible in WPForms → Entries

✅ **TC6: Admin Notification**
- Expected: Email to info@lexingtonalarm.org with action type
- Result: PASS - Email received with correct action type in subject

✅ **TC7: User Confirmation Email**
- Expected: Email to user's address
- Result: PASS - Email received
- Note: ⚠️ Content needs updating (currently default text)

✅ **TC8: Email Client Launch - Short**
- Expected: Gmail/Outlook opens with pre-filled short letter
- Result: PASS - Email client opened with correct recipients and content

✅ **TC9: Email Client Launch - Long**
- Expected: Gmail/Outlook opens with pre-filled long letter
- Result: PASS - Email client opened with correct recipients and content

✅ **TC10: Console Errors**
- Expected: No JavaScript errors in browser console
- Result: PASS - Clean console output with debug logs

### Known Issues:

⚠️ **Issue 1: User Confirmation Email Content**
- **Problem:** Generic "Thank you for contacting us" message
- **Impact:** Users don't get clear next steps or Action Network invitation
- **Priority:** HIGH
- **Fix Required:** Update notification in WPForms #1472

---

## Buttons NOT Yet Tracked

These interactive elements on the Massport Campaign page currently have NO tracking:

### 1. "Copy Full Letter to Clipboard" Button
**Location:** Below the full letter text display  
**Current Behavior:** Copies letter to clipboard, shows alert  
**Missing:** No record of who copied the letter  
**Recommended Tracking:** Add to WPForms #1472 with action_type="copy_letter"

### 2. "Download Letter to Massport Board" PDF Button
**Location:** Below the full letter text display  
**Current Behavior:** Downloads static PDF sample letter  
**Missing:** No record of who downloaded  
**Recommended Tracking:** Add to WPForms #1472 with action_type="download_pdf"

### 3. Form #1401 - Mail Individual Letters (PDF Generation)
**Location:** "Option 2" section  
**Current Behavior:** Generates personalized 15-page PDF with 7 letters  
**Tracking Status:** Form entries are tracked by WPForms #1401  
**Note:** This is a separate form with different tracking mechanism (already working)

### 4. External Resource Links
**Location:** "Additional Resources" section at bottom  
**Current Links:**
- Lunn v. Commonwealth Decision (mass.gov)
- Board Member Contact Information (internal link - placeholder)
- Share This Campaign (placeholder)
**Tracking Status:** No tracking currently  
**Priority:** LOW (nice to have but not essential)

---

## Deployment Checklist

### Pre-Deployment Verification (Local Site):

- [x] WPForms #1472 created and configured
- [x] Blue box UI displays correctly
- [x] Name/email validation working
- [x] Short email button creates entries with action_type="short"
- [x] Long email button creates entries with action_type="long"
- [x] Admin notifications sending
- [x] User confirmation emails sending
- [ ] User confirmation email content updated (IN PROGRESS)
- [ ] Test on multiple browsers (Chrome, Firefox, Safari)
- [ ] Test on mobile devices (iOS, Android)

### Pre-Deployment Tasks (Live Site):

- [ ] Verify WPForms #1472 exists on live site
- [ ] Verify form field IDs match (1=Name, 2=Email, 3=ActionType)
- [ ] Update WPForms #1472 notification content on live
- [ ] Backup current Massport Campaign Template snippet
- [ ] Update Massport Campaign Template with tracking code
- [ ] Set $TEST_MODE = false
- [ ] Clear all caches (Bluehost, plugins, browser)

### Deployment Steps:

1. **Create/Verify WPForms #1472 on Live**
   - Log into live WordPress admin
   - Go to WPForms → Add New
   - Create form with same fields as local
   - Configure notifications
   - Note the form ID (should be 1472, but verify)

2. **Update Massport Campaign Template on Live**
   - Go to Snippets → All Snippets
   - Find "Massport Campaign Template"
   - Copy full updated code from local site
   - Paste into live site snippet
   - Verify $TEST_MODE = false
   - Save

3. **Clear All Caches**
   - Bluehost cache
   - Any WordPress cache plugins
   - CDN cache if applicable

4. **Test on Live Site**
   - Visit campaign page in incognito/private browser
   - Verify blue box appears
   - Submit test entry using personal email
   - Verify entry appears in WPForms #1472
   - Verify admin notification received
   - Verify user confirmation received
   - Verify email client opens correctly

### Post-Deployment Monitoring:

- [ ] Check WPForms #1472 entries daily for first week
- [ ] Monitor for any user-reported issues
- [ ] Track short vs. long email usage ratio
- [ ] Verify email deliverability (check spam folders)
- [ ] Export entries weekly for Action Network import

---

## Next Development Priorities

### Priority 1: Update User Confirmation Email ⚠️ HIGH

**Current State:**
Generic WPForms confirmation text that doesn't explain next steps or invite to Action Network.

**Required Content:**
- Thank them for taking action
- Explain what happens next (email goes to Massport + state legislators)
- Provide link to Action Network signup page
- Mention they'll receive campaign updates
- Include social sharing links (optional)
- Clear opt-out instructions

**Deliverable:**
Updated notification text in WPForms #1472 settings on both local and live.

---

### Priority 2: Add Tracking to Remaining Buttons 🔵 MEDIUM

**Buttons to Add:**

**2A: "Copy Full Letter" Button**
- Add onclick handler
- Call tracking function with action_type="copy_letter"
- Submit to WPForms #1472
- Keep existing copy-to-clipboard functionality

**2B: "Download PDF" Button**
- Add onclick handler  
- Call tracking function with action_type="download_pdf"
- Submit to WPForms #1472
- Keep existing download functionality

**Implementation Method:**
Similar to email buttons - capture click, validate/get name+email if needed, submit to tracking form, then proceed with original action.

**Decision Needed:**
Should these buttons ALSO require name/email entry? Or track anonymously with just action type and timestamp?

---

### Priority 3: Deploy to Live Site 🔴 HIGH

Once user confirmation email is updated and tested locally, deploy entire tracking system to live site following deployment checklist above.

**Target Date:** TBD  
**Dependencies:** Priority 1 complete

---

### Priority 4: Action Network Integration 🔵 MEDIUM

**Goal:** Automatically add email action participants to Action Network mailing list.

**Options:**
1. **Manual Export/Import** (current plan)
   - Export WPForms entries weekly
   - Import to Action Network manually
   - Low tech, but reliable

2. **Zapier Integration** (recommended)
   - Trigger: New WPForms #1472 entry
   - Action: Add contact to Action Network
   - Requires Zapier account and WPForms Zapier addon

3. **Direct API Integration** (most complex)
   - Custom PHP code to POST to Action Network API
   - Runs on form submission
   - Requires API credentials and error handling

**Recommendation:** Start with manual export/import, move to Zapier if volume justifies automation cost.

---

## Success Metrics & Reporting

### Key Performance Indicators:

**Participation Metrics:**
- Total email actions taken (short + long)
- Short email count
- Long email count  
- Short vs. long ratio
- Actions per day/week
- Peak engagement times

**Engagement Metrics:**
- Campaign page views (via Plausible.io)
- Page view to action conversion rate
- Bounce rate on campaign page
- Average time on page

**List Building Metrics:**
- Total unique email addresses collected
- Email deliverability rate (confirmation emails)
- Action Network signup conversion rate
- Geographic distribution (if location added later)

### Reporting Cadence:

**Weekly:** 
- Total actions taken this week
- Cumulative actions to date
- Short vs. long breakdown

**Monthly:**
- Trend analysis (are actions increasing?)
- Comparison to previous month
- Action Network list growth

**Campaign End:**
- Final participation numbers
- Success stories (if any Massport policy changes)
- Lessons learned for future campaigns

### Data Export:

**From WPForms:**
1. Go to WPForms → Entries
2. Select form #1472
3. Click "Export" button
4. Choose date range
5. Download CSV

**CSV Contains:**
- Entry ID
- Date/Time
- Name
- Email  
- Action Type
- IP Address
- User Agent

**Use Cases:**
- Import to Action Network
- Share with coalition partners (aggregated data only)
- Present to Massport board (volume of opposition)
- Grant reporting (demonstrate community engagement)

---

## Code Reference

### JavaScript Function (Complete)

```javascript
function sendTrackedEmail(actionType) {
    console.log('=== sendTrackedEmail called ===');
    console.log('Action type:', actionType);
    
    var userName = document.getElementById('user_name_massport').value.trim();
    var userEmail = document.getElementById('user_email_massport').value.trim();
    
    console.log('User name:', userName);
    console.log('User email:', userEmail);
    
    if (!userName || !userEmail) {
        alert('Please enter your name and email');
        return;
    }
    
    // Validate email format
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(userEmail)) {
        alert('Please enter a valid email address');
        return;
    }
    
    console.log('Validation passed, filling hidden form...');
    
    // Find the hidden WPForms form and fill it
    var nameField = document.querySelector('input[name="wpforms[fields][1]"]');
    var emailField = document.querySelector('input[name="wpforms[fields][2]"]');
    var actionField = document.querySelector('input[name="wpforms[fields][3]"]');
    
    if (nameField && emailField && actionField) {
        nameField.value = userName;
        emailField.value = userEmail;
        actionField.value = actionType;
        
        console.log('Hidden form fields populated');
        
        // Find and click the submit button
        var submitButton = document.querySelector('#wpforms-submit-1472');
        if (submitButton) {
            console.log('Clicking hidden form submit button');
            submitButton.click();
        } else {
            console.error('Submit button not found');
        }
    } else {
        console.error('Hidden form fields not found');
    }
    
    console.log('Opening email client...');
    
    // Immediately call email function based on action type
    if (actionType === 'short') {
        sendProductionEmail();
    } else {
        openFullLetterEmail();
    }
}
```

### WPForms Field Name Attributes

```html
<!-- Name Field -->
<input name="wpforms[fields][1]" type="text">

<!-- Email Field -->
<input name="wpforms[fields][2]" type="email">

<!-- Action Type (Hidden) -->
<input name="wpforms[fields][3]" type="hidden">
```

---

## Troubleshooting Guide

### Issue: No Entries Appearing in WPForms #1472

**Possible Causes:**
1. Form ID mismatch (not actually 1472)
2. Field IDs don't match (not 1, 2, 3)
3. JavaScript errors preventing submission
4. WPForms plugin deactivated

**Debugging Steps:**
1. Open browser console (F12)
2. Click action button
3. Look for console errors
4. Verify "Hidden form fields populated" message
5. Check WPForms → Entries for form #1472
6. Verify WPForms plugin is active

**Solution:**
If form ID or field IDs are different, update the JavaScript to use correct IDs.

---

### Issue: Email Client Not Opening

**Possible Causes:**
1. Browser blocked popup
2. No default email client configured
3. JavaScript error before email function called

**Debugging Steps:**
1. Check browser console for errors
2. Look for "Opening email client..." log message
3. Try different browser
4. Verify mailto: links work elsewhere on site

**Solution:**
Email client opening is browser/system dependent. Users can manually copy email if automatic opening fails. Provide clear instructions.

---

### Issue: User Not Receiving Confirmation Email

**Possible Causes:**
1. Email went to spam folder
2. WPForms notification not configured correctly
3. Email address typo
4. Server email sending issues

**Debugging Steps:**
1. Check WPForms → Entries - was entry created?
2. Check spam folder
3. Check WPForms #1472 → Settings → Notifications
4. Verify "To" field is {field_id="2"}
5. Test with different email address

**Solution:**
If emails not sending at all, check WordPress email sending (WP Mail SMTP plugin may be needed).

---

### Issue: Tracking Only Works on Desktop, Not Mobile

**Possible Causes:**
1. Mobile browser not supporting fetch API
2. Touch event issues
3. CSS hiding form elements

**Debugging Steps:**
1. Test on multiple mobile devices
2. Check mobile browser console (use remote debugging)
3. Verify buttons are clickable (not covered by other elements)

**Solution:**
Add fallback for older browsers, ensure touch events trigger onclick handlers.

---

## Privacy & Data Handling

### Data Collection Notice

**What We Collect:**
- Name and email address (provided voluntarily)
- Action type (short or long email)
- Date and time of action
- IP address (automatic, via WPForms)
- Browser information (automatic, via WPForms)

**How We Use It:**
- Send confirmation emails
- Invite to join DE-ICE Hanscom campaign updates
- Track campaign effectiveness
- Share aggregate statistics with coalition partners

**Data Retention:**
- Stored indefinitely in WPForms database
- Can be exported by user on request
- Can be deleted by user on request

**Third Party Sharing:**
- May be imported to Action Network for mailing list
- Aggregate statistics only shared with partners
- Individual data never sold or shared publicly

**User Rights:**
- Opt out of emails at any time
- Request data export (GDPR/CCPA compliance)
- Request data deletion

### Required Disclosure Language

**Recommended Text for Page:**

> By submitting this form, you agree to receive follow-up emails from Lexington Alarm and coalition partners about the DE-ICE Hanscom campaign. Your information will not be shared publicly or sold to third parties. You can opt out at any time. [Privacy Policy](link)

**Location:** Add below email input fields in blue box.

---

## Version History

### v1.0 - November 22, 2025
- Initial implementation on local site
- WPForms #1472 created
- Blue box UI with name/email tracking
- Two action buttons (short/long)
- JavaScript submission handling
- Admin and user notifications configured
- Testing completed on local site
- Status: WORKING ON LOCAL, NOT YET DEPLOYED TO LIVE

### Future Versions (Planned)

**v1.1 - TBD**
- Updated user confirmation email content
- Added tracking to "Copy Letter" button
- Added tracking to "Download PDF" button
- Deployed to live site

**v1.2 - TBD**
- Action Network integration (Zapier or API)
- Automated list building
- Enhanced reporting dashboard

**v2.0 - TBD**
- A/B testing of button text and placement
- Additional fields (zip code for targeting)
- Social sharing with tracking
- Thank you page instead of email confirmation

---

## Contact & Support

**Technical Questions:**
- Toby Sackton (technical lead)
- Claude AI (development assistant)

**Campaign Questions:**
- Steve (executive committee)
- Karin (executive committee)
- Jonina (executive committee)

**Email Issues:**
- info@lexingtonalarm.org

**WPForms Support:**
- WPForms documentation: https://wpforms.com/docs/
- WPForms support (if needed): https://wpforms.com/account/support/

---

## Related Documentation

- **Website_Stage_1-_Lexington_Alarm_WordPress_Development.md** - Overall site structure
- **Events_Page_documentation.txt** - Tockify calendar integration
- **PDF Generator Documentation** (separate file) - Form #1401 board letters system

---

**Document End**

**Last Updated:** November 22, 2025  
**Next Update:** After user confirmation email content is finalized
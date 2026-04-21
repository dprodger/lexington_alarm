# Wix-Mailchimp Integration History & Documentation
**Created:** September 9, 2025  
**Status:** Partial integration - Manual workaround in place

---

## Current Situation

### Wix Store Setup
- **Platform:** Wix eCommerce for yard sign sales
- **URL:** lexingtonalarm-sandbox.com (and main site)
- **Products:** Lexington Alarm yard signs
- **Customers:** 14 total (13 existing + 1 test)

### Mailchimp Integration Status
- **Basic Integration:** Connected (customers flow to Mailchimp)
- **Newsletter Opt-in:** Partially working
- **Automation Trigger:** Not working with custom checkbox

---

## The Newsletter Subscription Issue

### Problem
1. Wix checkout has generic text: "Email me with news and offers"
2. Cannot edit this default text in Wix
3. Created custom checkbox field with better text:
   - "Subscribe to Lexington Alarm's bi-monthly newsletter..."
4. Custom checkbox records in Wix but doesn't sync to Mailchimp

### Current Stats
- 14 total customers
- 4 subscribed to newsletter (29% opt-in rate)
- 10 customers without newsletter subscription
- 1 customer (re-subscriber) needed manual intervention

---

## Integration Attempts

### What Works
- ✅ Customer emails flow from Wix to Mailchimp
- ✅ Basic subscriber status syncs (for default checkbox)
- ✅ Customers appear in Mailchimp audience

### What Doesn't Work
- ❌ Custom checkbox field doesn't trigger Mailchimp tags
- ❌ No "new-subscriber" tag applied automatically
- ❌ Custom field data doesn't sync to Mailchimp
- ❌ Welcome automation doesn't trigger from Wix purchases

### Attempted Solutions
1. **Custom Checkbox Field**
   - Added to Wix checkout
   - Shows as "Checkbox: Yes" in Wix customer profile
   - Doesn't sync to Mailchimp

2. **Wix Automation**
   - Trigger: Order placed + Custom checkbox = Yes
   - Action: No direct Mailchimp action available
   - Velo code option explored but too complex for now

3. **Velo Code Integration**
   - Would require Mailchimp API key
   - Security concerns with API key storage
   - Time investment not worth it given pending migration

---

## Workaround Solution (Current)

### Manual Process
1. Monitor Wix orders
2. Check custom checkbox status in Wix customer profile
3. Manually add to Mailchimp with "new-subscriber" tag
4. Welcome automation runs normally from there

### For Existing Customers
- Export from Wix (filter for newsletter consent)
- Import to Mailchimp with appropriate tags
- Handle re-subscribers case-by-case

---

## Mailchimp Configuration

### Audience Details
- **Server:** us17
- **List ID:** a8348d1caf
- **Automation:** New subscriber welcome series active

### Tags in Use
- `new-subscriber` - Triggers welcome series
- `general-member` - Established subscribers
- `volunteer` - For volunteer signups (future)
- `once-a-week-club` - Weekly activities (planned)

---

## Migration Plan

### Timeline
- **Current:** Manual workaround for Wix → Mailchimp
- **Near Future:** Complete WordPress/WooCommerce setup
- **Migration:** Move away from Wix entirely
- **Post-Migration:** Full control over checkout text and integration

### Why Not Fix Now
1. WordPress migration imminent
2. WooCommerce will provide full control
3. Time investment in Wix integration not worthwhile
4. Manual process manageable for current volume
5. Focus resources on new site development

---

## Technical Notes for Future

### If Attempting Wix-Mailchimp Fix
1. Need Mailchimp API key from Account → Extras → API keys
2. Wix Velo code needs secure secrets management
3. Consider Zapier as middleware (extra cost)
4. Webhook approach might be simpler than direct API

### For WooCommerce Setup (Future)
- Use MC4WP plugin for direct integration
- Full control over checkbox text
- Can map custom fields easily
- Automatic tagging capabilities
- Better automation triggers

---

## Lessons Learned

1. **Wix Limitations**
   - Cannot edit default marketing consent text
   - Custom fields don't auto-sync to email platforms
   - Automation actions limited without coding

2. **Integration Complexity**
   - Direct API integration requires significant setup
   - Security concerns with API keys in client-side code
   - Webhook/middleware approach adds complexity

3. **Decision Point**
   - Manual process acceptable for low volume
   - Full fix not worth investment given migration timeline
   - Focus on WordPress/WooCommerce implementation

---

## Action Items

### Immediate
- [x] Document current state
- [x] Set up manual monitoring process
- [x] Continue with welcome email automation for manual adds

### Future (Post-Migration)
- [ ] Implement proper WooCommerce-Mailchimp integration
- [ ] Custom checkout fields with clear messaging
- [ ] Automatic tagging system
- [ ] Full automation of customer → subscriber flow

---

**Recommendation:** Continue manual process until WordPress migration. Time investment in fixing Wix integration not justified given imminent platform change.
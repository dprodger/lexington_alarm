# Plugins and Integrations

**Last Updated:** December 4, 2025  
**Total Active Plugins:** (Document current count)  
**Auto-Updates:** (Enabled/Selective/Disabled)

---

## Current State

### Critical Plugins (Core Functionality)

#### WooCommerce
**Purpose:** E-commerce platform for yard signs, merchandise, donations  
**Version:** (Current version)  
**Status:** Active  
**License:** Free  
**Configuration:** See `02_Store_System/WooCommerce_Setup.md`

**Key Features in Use:**
- Product catalog with variations
- Shipping classes (Local Pickup, Nationwide, Printful)
- Stripe payment processing
- Order management and notifications
- Cart validation

#### Payment Plugins for Stripe WooCommerce
**Purpose:** Stripe payment gateway integration  
**Version:** (Current version)  
**Status:** Active  
**License:** (Free/Pro - Document)  
**Configuration:** Connected to Stripe account

**Features Used:**
- Credit/Debit card processing
- Apple Pay support (enabled but simplified)
- Google Pay (intentionally NOT configured due to complexity)
- Payment intent API

#### WPForms Pro
**Purpose:** Form builder for submissions, contact, volunteer signup  
**Version:** (Current version)  
**Status:** Active  
**License:** Pro  
**License Key:** (Stored securely)

**Forms in Use:**
- Volunteer signup form
- Contact form
- Newsletter signup
- (Other active forms)

**Features Used:**
- Conditional logic
- Email notifications
- File uploads
- Form analytics

**CAPTCHA Protection (Added December 2025):**
- **Type:** Cloudflare Turnstile
- **Mode:** Invisible (no user interaction required)
- **Purpose:** Block spam bot submissions flagged by SendLayer
- **Settings:** WPForms → Settings → CAPTCHA tab
- **Keys:** Site Key and Secret Key from Cloudflare dashboard

**Cloudflare Turnstile Setup:**
1. Account: dash.cloudflare.com → Turnstile
2. Widget Name: Lexington Alarm
3. Domain: lexingtonalarm.org
4. Widget Mode: Invisible
5. Pre-Clearance: Off

**Additional Spam Protection (per form):**
- Anti-spam honeypot: Enabled
- Minimum time to submit: 2-3 seconds
- Store spam entries: Enabled (for review)

**Why Turnstile over reCAPTCHA:**
- Completely invisible to users
- Better privacy (no Google tracking)
- Free unlimited usage
- Effective bot blocking

#### WPCode (formerly Insert Headers and Footers)
**Purpose:** Custom PHP snippets and code injection  
**Version:** (Current version)  
**Status:** Active  
**License:** Free/(Pro - Document if upgraded)

**Active Snippets:**
- (Document active code snippets)
- Custom PHP functions
- Header/footer code injections
- Tracking code implementation

See also: `06_Code_Snippets/PHP_Functions.md`

---

### Content & Publishing Plugins

#### Kadence Blocks
**Purpose:** Extended block editor functionality  
**Version:** (Current version)  
**Status:** Active  
**License:** Free  
**Bundled With:** Kadence Theme

**Blocks in Use:**
- Advanced Heading
- Row Layout
- Icon List
- (Document others as identified)

---

### Email & Communication Plugins

#### SendLayer SMTP (or similar SMTP plugin)
**Purpose:** Reliable transactional email delivery  
**Version:** (Current version)  
**Status:** Active  
**Configuration:** Connected to SendLayer account

**Settings:**
- SMTP Host: (Document)
- From Email: (Typically store@lexingtonalarm.org for WooCommerce)
- From Name: Lexington Alarm
- Authentication: Yes

See also: `03_Email_Systems/Transactional_Email.md`

#### Mailchimp Integration (Plugin name - Document)
**Purpose:** Newsletter signup and audience syncing  
**Version:** (Current version)  
**Status:** Active  
**Configuration:** Connected to Mailchimp account

**Features Used:**
- Signup forms
- Audience syncing
- Tag automation
- (Document specific features)

See also: `03_Email_Systems/Mailchimp_Integration.md`

---

### Utility & Enhancement Plugins

#### UpdraftPlus
**Purpose:** Automated backups to Dropbox  
**Version:** (Current version)  
**Status:** Active  
**License:** Free/(Pro - Document)

**Backup Schedule:**
- Full backup: (Frequency)
- Database only: (Frequency)
- Remote storage: Dropbox

**Retention:** (How many backups kept)

#### Plausible Analytics (or similar)
**Purpose:** Privacy-focused website analytics  
**Version:** (Current version)  
**Status:** Active/(Planned - Document)  
**Configuration:** (Document if active)

See also: `06_Code_Snippets/JavaScript_Tracking.md`

#### Advanced Shipping Packages for WooCommerce
**Purpose:** Prevent incompatible shipping classes in same cart  
**Version:** (Current version)  
**Status:** Active/(Testing - Document)  
**License:** (Free/Pro - Document)

**Purpose:** Resolve issues with customers mixing:
- Local pickup items (yard signs)
- Nationwide shipping items
- Printful print-on-demand items

See also: `02_Store_System/Checkout_Flow.md`

---

### Security & Performance Plugins

#### Security Plugin (Document name if active)
**Examples:** Wordfence, Sucuri, iThemes Security  
**Status:** (Active/Not Installed - Document)  
**Features Enabled:**
- [ ] Firewall
- [ ] Malware scanning
- [ ] Login protection
- [ ] Two-factor authentication

#### Caching Plugin (Document name if active)
**Examples:** WP Rocket, W3 Total Cache, WP Super Cache  
**Status:** (Active/Not Installed - Document)  
**Settings:**
- Page caching: (Enabled/Disabled)
- Object caching: (Enabled/Disabled)
- Browser caching: (Enabled/Disabled)

---

## Third-Party Service Integrations

### Tockify (External Service)
**Purpose:** Events calendar  
**Integration Method:** Embedded iframe/JavaScript  
**Account:** lexingtonalarm calendar  
**Implementation:** See `04_Content_Publishing/Events_Calendar.md`

**Features Used:**
- Calendar view (monthly default)
- Pinboard view (for featured events)
- Event filtering by tags
- Responsive embedding

### Stripe (Payment Processor)
**Purpose:** Credit card processing  
**Integration Method:** Payment Plugins for Stripe WooCommerce  
**Account Type:** (Standard/Express - Document)  
**Connected:** (Date connected)

**Payment Methods Enabled:**
- Credit/Debit cards
- Apple Pay
- (NOT Google Pay - intentionally avoided)

### Printful (Print-on-Demand)
**Purpose:** Merchandise fulfillment  
**Integration Method:** (WooCommerce plugin or API - Document)  
**Status:** (Active/Planned - Document)  
**Products:** T-shirts, buttons, other merchandise

### Google Drive (Planned/Under Review)
**Purpose:** File storage and team collaboration  
**Integration Method:** (Document if/when implemented)  
**Status:** Under consideration

---

## Plugin Management Strategy

### Update Protocol
1. **Before Updating:**
   - Full site backup via UpdraftPlus
   - Review plugin changelog for breaking changes
   - Test in staging environment (if available)

2. **Update Priority Order:**
   - Security plugins first
   - WooCommerce and payment plugins (together, same session)
   - Content/publishing plugins
   - Theme last

3. **After Updating:**
   - Test critical functionality:
     - Store checkout process
     - Form submissions
     - Email delivery
     - Calendar display
   - Clear all caches
   - Monitor error logs

### Deactivated/Unused Plugins
**Policy:** Remove unused plugins completely, don't just deactivate  
**Current Deactivated:** (Document any plugins kept deactivated with reason)

---

## Plugin Conflicts & Compatibility

### Known Issues
- (Document any known plugin conflicts)

### Resolved Conflicts
- (Document past conflicts and solutions)

### Compatibility Testing
**Last Tested:** (Date)  
**Environment:** Production  
**Results:** (Summary of functionality check)

---

## Plugin Dependencies

### WooCommerce Ecosystem
```
WooCommerce (core)
├── Payment Plugins for Stripe WooCommerce
├── Advanced Shipping Packages for WooCommerce
└── (Other WooCommerce extensions)
```

### Form Ecosystem
```
WPForms Pro (core)
├── Various form submissions stored in database
└── Email notifications integrated with SMTP
```

---

## License Management

### Active Licenses
- WPForms Pro: (License key stored securely)
- (Other premium plugins)

### License Renewal Dates
- WPForms Pro: (Renewal date)
- (Others)

### License Key Storage
**Location:** (Password manager, secure note location)  
**Access:** Toby (primary)

---

## Performance Impact

### Heavy Plugins (Monitor)
- WooCommerce (essential, monitor performance)
- WPForms Pro (acceptable impact)
- (Others that may impact load time)

### Optimization
- Lazy loading for heavy scripts
- Conditional loading (only load where needed)
- Regular database cleanup for form submissions, order history

---

## Future Plugin Considerations

### Under Evaluation
- [ ] Advanced form analytics
- [ ] Enhanced WooCommerce reporting
- [ ] Social media auto-posting
- [ ] Advanced SEO plugin
- [ ] Member directory/portal

### Explicitly Avoided
- ❌ Complex page builders (using blocks instead)
- ❌ Duplicate functionality plugins
- ❌ Unmaintained plugins
- ❌ Plugins with poor reviews

---

## Troubleshooting Common Plugin Issues

### WooCommerce Order Issues
1. Check SMTP plugin status
2. Verify Stripe connection
3. Review WooCommerce logs (WooCommerce → Status → Logs)
4. Test checkout in incognito/private browsing

### Form Submission Issues
1. Verify WPForms license active
2. Check SMTP email delivery
3. Review form notification settings
4. Test from different email address

### Email Delivery Issues
1. Check SendLayer quota/status
2. Verify SMTP credentials in plugin
3. Test with WP Mail SMTP test email feature
4. Check spam folders

### Calendar Display Issues
1. Verify Tockify script loading
2. Check for JavaScript errors in console
3. Clear browser and WordPress caches
4. Verify calendar account still active

---

## Plugin Documentation Quick Links

### WooCommerce
- Official docs: https://woocommerce.com/documentation/
- Settings location: WordPress Admin → WooCommerce → Settings

### WPForms
- Official docs: https://wpforms.com/docs/
- Settings location: WordPress Admin → WPForms → Settings

### Stripe
- Official docs: https://stripe.com/docs
- Plugin settings: WooCommerce → Settings → Payments → Stripe

---

## Change History

### 2024 Q4
- Added Advanced Shipping Packages for cart validation
- Configured Plausible Analytics (if active)
- Updated all plugins to current versions
- Resolved (specific conflict if any)

### 2024 Q3
- Initial plugin installation and configuration
- WooCommerce setup complete
- Payment processing activated
- Form builder integrated

---

**Related Documentation:**
- `02_Store_System/WooCommerce_Setup.md` - WooCommerce configuration details
- `03_Email_Systems/Transactional_Email.md` - Email plugin configuration
- `04_Content_Publishing/News_System.md` - WPForms implementation
- `06_Code_Snippets/PHP_Functions.md` - WPCode snippets

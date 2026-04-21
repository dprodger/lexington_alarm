# Common Tasks - Quick How-To Guide

**Last Updated:** November 22, 2024  
**For:** Fast reference on frequently needed operations

---

## Content Management

### Add a New Page
1. WordPress Admin → Pages → Add New
2. Enter page title
3. Add content using block editor
4. Set page attributes (parent page if needed)
5. Set featured image (if applicable)
6. Publish or Save Draft

### Edit Existing Page
1. WordPress Admin → Pages
2. Find page in list (use search if needed)
3. Click "Edit"
4. Make changes
5. Click "Update"
6. View page to verify changes

### Add Page to Navigation Menu
1. WordPress Admin → Appearance → Menus
2. Select menu to edit (typically "Primary Menu")
3. Find page in left column under "Pages"
4. Check box next to page
5. Click "Add to Menu"
6. Drag to position in menu
7. Click "Save Menu"

---

## Store Management

### Add a New Product
1. WordPress Admin → Products → Add New
2. Enter product title
3. Add product description (full) and short description (excerpt)
4. Set Product Data:
   - Type (Simple or Variable)
   - Price
   - SKU (optional)
   - Inventory (manage stock if needed)
   - Shipping class (CRITICAL - must be set correctly)
5. Add product image (featured image)
6. Add gallery images (if multiple photos)
7. Set product category
8. Publish

### Edit Product Price
1. WordPress Admin → Products
2. Find product and click "Edit"
3. Scroll to Product Data section
4. Update Regular Price
5. Set Sale Price (if applicable)
6. Click "Update"

### Update Product Inventory
1. WordPress Admin → Products
2. Find product and click "Edit"
3. Product Data → Inventory tab
4. Update "Stock quantity"
5. Click "Update"

### Process an Order
1. WordPress Admin → WooCommerce → Orders
2. Click order number to view
3. Review order details
4. Change status:
   - "Processing" = payment received, preparing order
   - "Completed" = order fulfilled
5. Add order note if needed (check "Customer note" to send email)
6. Update order

### Refund an Order
1. WooCommerce → Orders → Select order
2. Scroll to Items section
3. Click "Refund" button
4. Enter refund amount
5. Select "Refund via Stripe" (processes refund through payment gateway)
6. Add reason/note
7. Click "Refund"
8. Customer notified automatically

---

## News & Content Publishing

### Publish a News Article
1. WordPress Admin → Posts → Add New
2. Enter title
3. Write article in editor
4. Add featured image
5. Set category (News, Updates, Press, etc.)
6. Set tags (optional)
7. Publish

### Schedule a Future Post
1. Create post as normal
2. Before publishing, click "Publish" panel on right
3. Click "Immediately" next to Publish date
4. Select future date and time
5. Click "Schedule"

### Add Article to Newsletter
**Process:** (Document your newsletter compilation workflow)
1. Individual articles published first to site
2. Compile selected articles for newsletter
3. (Continue with specific steps)

---

## Events Management

### Add an Event to Calendar
1. Go to Tockify.com and log in
2. Select lexingtonalarm calendar
3. Click "Add Event"
4. Enter event details:
   - Title
   - Start/End date and time
   - Location
   - Description (can use HTML)
5. Add tags (include "featured" for featured events)
6. Upload event image (optional)
7. Save event
8. Event appears on website automatically

### Make an Event "Featured"
1. Log into Tockify
2. Find event and click Edit
3. Add "featured" to Tags field
4. Save
5. Event now appears in Featured Events section

### Edit an Event
1. Tockify → Find event in list
2. Click edit icon
3. Make changes
4. Save
5. Updates appear on website immediately

### Delete an Event
1. Tockify → Find event
2. Click delete icon
3. Confirm deletion
4. Event removed from website

---

## Email & Communication

### Send Newsletter via Mailchimp
**Process:** (Document your specific workflow)
1. Compile content (typically bi-weekly)
2. Create campaign in Mailchimp
3. Select audience/segments
4. Design email using template
5. Preview and test
6. Schedule or send

### Update Email Notification Template
1. WooCommerce → Settings → Emails
2. Select email type to edit
3. Click "Manage"
4. Edit:
   - Subject line
   - Heading
   - Additional content
   - Footer text
5. Save changes
6. Send test email to verify

### Add Someone to Newsletter List
**Method 1 - Manual:**
1. Log into Mailchimp
2. Audience → Add contacts
3. Enter email address and details
4. Add tags if appropriate
5. Save

**Method 2 - Signup Form:**
- Direct user to signup form on website
- Automatic addition to list with confirmation

---

## User & Access Management

### Create New User Account
1. WordPress Admin → Users → Add New
2. Enter username (cannot be changed later)
3. Enter email address
4. Set first/last name
5. Select role:
   - Administrator: Full access (use sparingly)
   - Editor: Can publish/edit posts and pages
   - Author: Can publish own posts only
   - (Others as needed)
6. Send password: Check box to email new user
7. Add New User

### Change User Role
1. Users → All Users
2. Find user and click Edit
3. Change Role dropdown
4. Update User

### Reset User Password
1. Users → All Users
2. Click Edit on user
3. Scroll to Account Management
4. Click "Generate Password"
5. Copy password to send to user (or check "Send email" to auto-notify)
6. Update User

---

## Design & Styling

### Update Custom CSS
1. WordPress Admin → Appearance → Customize
2. Additional CSS (at bottom of left menu)
3. Add or edit CSS code
4. Preview changes in real-time
5. Click "Publish" to make live

**Backup First:** Copy existing CSS before major changes

### Change Site Colors (Brand Colors)
**Current Colors:**
- Blue: #044f9d
- Red: #c3202e
- White: #ffffff

**To Change:**
1. Update CSS variables in Additional CSS
2. Find and replace hex codes site-wide
3. Test thoroughly across all pages

### Update Header/Banner
1. Appearance → Customize → Header
2. Logo/Site Identity section
3. Upload new image
4. Adjust size if needed
5. Publish

---

## Technical Maintenance

### Clear WordPress Cache
**If using cache plugin:**
1. Find cache plugin in admin toolbar
2. Click "Clear Cache" or "Purge Cache"

**No cache plugin:**
- Browser cache: Ctrl+Shift+R (PC) or Cmd+Shift+R (Mac)

### Update Plugins
1. WordPress Admin → Plugins
2. Check for updates (number indicator)
3. Select plugins to update
4. Click "Update" 
5. Verify site still functions after updates

**Best Practice:** Take backup before updating

### Create Manual Backup
1. Plugins → UpdraftPlus Backups (or your backup plugin)
2. Click "Backup Now"
3. Select what to backup (database, files, or both)
4. Click "Backup Now"
5. Wait for completion
6. Download backup (optional but recommended)

### Restore from Backup
1. UpdraftPlus → Existing Backups tab
2. Select backup date
3. Click "Restore"
4. Select components to restore
5. Confirm and restore
6. Wait for completion

**Warning:** This overwrites current site. Use carefully.

---

## Troubleshooting

### Site Loading Slowly
1. Clear WordPress cache
2. Clear browser cache
3. Check server status (hosting control panel)
4. Deactivate plugins one at a time to find culprit
5. Check image sizes (optimize large images)

### Can't Log Into WordPress
1. Try password reset (use "Lost your password?" link)
2. Check email for reset link
3. Clear browser cookies
4. Try different browser
5. Contact hosting support if still can't access

### Page Not Displaying Correctly
1. Clear browser cache (Ctrl+Shift+R)
2. Clear WordPress cache
3. Check for JavaScript errors (browser console: F12)
4. Try different browser
5. Check if recent plugin/theme update caused issue

### Email Not Sending
1. WooCommerce → Status → Logs
2. Check SMTP plugin status
3. Send test email from SMTP plugin settings
4. Verify SendLayer account active and not over limit
5. Check spam folder

### Order Not Appearing
1. Check WooCommerce → Orders for all statuses
2. Verify email notifications are working
3. Check Stripe dashboard for payment
4. Look in spam/junk folder for notification
5. Check WooCommerce logs for errors

---

## Analytics & Tracking

### Check Website Traffic
**Using Plausible Analytics:**
1. Log into Plausible (if implemented)
2. View dashboard for lexingtonalarm.org
3. Review:
   - Unique visitors
   - Page views
   - Top pages
   - Traffic sources

### Check Store Performance
1. WooCommerce → Analytics
2. Select date range
3. Review:
   - Revenue
   - Orders
   - Products (best sellers)
   - Variations

### Check Newsletter Performance
1. Log into Mailchimp
2. Campaigns → View Report
3. Review:
   - Open rate
   - Click rate
   - Top links clicked
   - Subscriber engagement

---

## File Management

### Upload File to Media Library
1. WordPress Admin → Media → Add New
2. Click "Select Files" or drag and drop
3. Wait for upload
4. Edit file details (title, alt text, description)
5. File available for use in posts/pages

### Find Uploaded File URL
1. Media → Library
2. Click on file
3. Copy URL from "File URL" field
4. Or click "Copy URL to clipboard" button

### Organize Media Files
**Best Practices:**
- Use descriptive filenames before uploading
- Add alt text for images (accessibility + SEO)
- Create folders/categories (if using media organizer plugin)
- Delete unused files periodically

---

## Form Management

### View Form Submissions
1. WordPress Admin → WPForms → Entries
2. Select form from dropdown
3. View entries list
4. Click entry to see details
5. Export entries if needed (Export button)

### Edit Form
1. WPForms → All Forms
2. Hover over form and click "Edit"
3. Drag and drop fields to reorganize
4. Click field to edit settings
5. Save form

### Create New Form
1. WPForms → Add New
2. Select template or start blank
3. Add fields from left panel
4. Configure field settings
5. Configure form settings (notifications, confirmations)
6. Save form
7. Copy shortcode to embed in page

---

## Quick Links

### Important WordPress Admin Pages
- Dashboard: `/wp-admin/`
- Posts: `/wp-admin/edit.php`
- Pages: `/wp-admin/edit.php?post_type=page`
- Products: `/wp-admin/edit.php?post_type=product`
- Orders: `/wp-admin/edit.php?post_type=shop_order`
- Menus: `/wp-admin/nav-menus.php`
- Plugins: `/wp-admin/plugins.php`
- Settings: `/wp-admin/options-general.php`

### External Services
- Tockify: https://tockify.com/
- Mailchimp: https://mailchimp.com/
- Stripe: https://stripe.com/
- SendLayer: (Document URL)
- ProtonMail: https://protonmail.com/

---

## Keyboard Shortcuts

### WordPress Editor
- `Ctrl+S` (PC) / `Cmd+S` (Mac): Save draft
- `Ctrl+Shift+D` (PC) / `Cmd+Shift+D` (Mac): Duplicate block
- `/`: Slash command to add block
- `Ctrl+K` (PC) / `Cmd+K` (Mac): Insert link

### Browser
- `Ctrl+R` (PC) / `Cmd+R` (Mac): Refresh page
- `Ctrl+Shift+R` (PC) / `Cmd+Shift+R` (Mac): Hard refresh (clear cache)
- `Ctrl+F` (PC) / `Cmd+F` (Mac): Find on page
- `F12`: Open developer console

---

## Before Making Major Changes

### Pre-Change Checklist
- [ ] Take full backup
- [ ] Document current state (screenshot/notes)
- [ ] Test in staging environment (if available)
- [ ] Have rollback plan ready
- [ ] Schedule during low-traffic time
- [ ] Notify team if site will be briefly unavailable

### After Making Changes
- [ ] Test thoroughly on multiple devices
- [ ] Clear all caches
- [ ] Verify emails still sending (if applicable)
- [ ] Check critical pages (home, shop, checkout)
- [ ] Monitor for errors in first few hours

---

## Getting Help

### Documentation Resources
- **This Project:** See other docs in LexingtonAlarm_Docs folder
- **WordPress:** https://wordpress.org/support/
- **WooCommerce:** https://woocommerce.com/documentation/
- **Kadence:** https://www.kadencewp.com/documentation/

### Support Contacts
- **Hosting (Bluehost):** (Document support URL/phone)
- **Technical Lead:** Toby
- **Executive Committee:** Steve, Karin, Jonina

### When to Ask for Help
- Security issues (site hacked, malware)
- Payment processing problems
- Major site errors (white screen, database errors)
- Complex technical implementations
- Strategic decisions affecting organization

---

**Remember:** When in doubt, take a backup first!

**Related Documentation:**
- Full technical details in section-specific docs
- This is a quick reference only
- Consult detailed docs for complex tasks

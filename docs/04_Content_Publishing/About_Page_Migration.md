# About Page Migration to WordPress
**Source:** `/about.html`  
**Target:** WordPress About Page  
**Date:** September 8, 2025

---

## PAGE CONTENT FOR MIGRATION

### Section 1: About LexingtonAlarm
**Heading Style:** H1, Blue (#044f9d), Centered, LARGER SIZE (suggest 2.5rem or 36px)

Lexington Alarm!, is a group of concerned citizens from Lexington and surrounding towns who took a stand against Tyranny on the 250th anniversary of the Battle of Lexington and Concord. We support the US Constitution, the rule of law, and the ideals of the American revolution.

From 1775 to 2025 we pledge to resist tyranny in America. Public demonstrations of resistance and non-cooperation are important and necessary. That is why we have campaigned to display our No King! No Tyranny signs throughout Massachusetts and beyond.

You may reach us at info@lexingtonalarm.org.

---

### Section 2: LexingtonAlarm! Vision and Mission
**Main Heading Style:** H1, Red (#c3202e), Centered

#### Vision
**Subheading Style:** H2, Centered

We believe in an America where all people defend the rule of law and our constitutional rights when they are under attack, creating a society rooted in liberty, accountability, and justice.

#### Mission
**Subheading Style:** H2, Centered

Lexington Alarm exists to reawaken the spirit of resistance to tyranny that animated America's founding 250 years ago. We peacefully oppose and resist government actions that contradict the spirit of our founding as embodied in the Declaration of Independence, our Constitution, and the Bill of Rights.

We will act to:
- Raise awareness locally and beyond of our founders' fight to oppose tyranny and create a country where "the Law is King."
- Provide historically grounded resources to strengthen civic engagement.
- Work with other organizations mobilizing to defend rights and freedoms that are under attack.

---

### Section 3: Donate
**Heading Style:** H1, Blue (#044f9d)

[VENMO QR CODE IMAGE: venmo_lexingtonalarm.png - needs to be uploaded to WordPress Media Library]

We are asking $10 donation per sign ordered. You may pay here or when you pick up. We are also asking for general donations to support materials like buttons, stickers, and printing materials. When you make a venmo donation please make sure to indicate if for "signs" or "general donation" in the note section that appears after you have entered the payment amount and clicked pay.

---

## WORDPRESS IMPLEMENTATION INSTRUCTIONS

### 1. Page Setup
- Create new page titled "About"
- Use Kadence blocks for layout

### 2. Content Structure
Use the following block structure:

```
[Kadence Section - Full Width Container]
  [Kadence Row]
    [Column - Full Width]
      
      <!-- Section 1 -->
      [Text Box with class: la-text-box]
        [Heading - H1, Blue, Centered]
        [Paragraph blocks]
        [Email link: mailto:info@lexingtonalarm.org]
      
      <!-- Section 2 -->
      [Text Box with class: la-text-box]
        [Heading - H1, Red, Centered]
        [Heading - H2, Centered] Vision
        [Paragraph]
        [Heading - H2, Centered] Mission
        [Paragraph]
        [List block - bullets]
      
      <!-- Section 3 -->
      [Text Box with class: la-text-box]
        [Heading - H1, Blue]
        [Image block - centered, 25% width]
        [Paragraph]
```

### 3. Styling Classes to Apply
- Text boxes: `la-text-box`
- Section wrapper: `la-section`
- Interior sections: `interior` (if needed)

### 4. Images to Upload
- [ ] venmo_lexingtonalarm.png (resize to appropriate dimensions, suggest 400px width)

### 5. Special Formatting Notes
- Email should be a clickable mailto link
- Venmo image should be centered and responsive
- Maintain the three-section structure with visual separation
- Bullet points should use standard WordPress list formatting

### 6. Mobile Responsiveness Check
- [ ] Text remains readable on mobile
- [ ] Venmo QR code stays scannable size
- [ ] Email link is easily tappable
- [ ] Sections stack properly

### 7. SEO Considerations
- Page Title: "About Lexington Alarm - Vision, Mission & Support"
- Meta Description: "Learn about Lexington Alarm's mission to defend constitutional rights and the rule of law. Join our peaceful resistance movement rooted in America's founding principles."
- Focus Keywords: Lexington Alarm, constitutional rights, peaceful protest, Patriots Day

### 8. Content Updates Needed
Consider updating:
- ✅ Updated to focus on 250th anniversary and timeless resistance to tyranny
- ✅ Email updated to info@lexingtonalarm.org
- Add current year activities/accomplishments
- Update donation methods if needed (add PayPal, etc.)

---

## MIGRATION CHECKLIST

- [ ] Create About page in WordPress
- [ ] Apply Kadence blocks structure
- [ ] Add all three content sections
- [ ] Upload and insert Venmo QR code image
- [ ] Apply brand colors to headings
- [ ] Test email link functionality
- [ ] Check mobile responsiveness
- [ ] Add page to main navigation menu
- [ ] Test donation QR code scanning
- [ ] Review and update outdated content
- [ ] Set SEO metadata
- [ ] Preview on all devices
- [ ] Publish page

---

## NOTES
- The current HTML page has inline styles that should be replaced with the WordPress theme's CSS classes
- The donation section might be better as a reusable block if it appears on multiple pages
- Consider adding a contact form in addition to the email address for better user experience
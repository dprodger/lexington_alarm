# MC4WP Form Configuration for News Page
**Collects:** First Name, Last Name, Email, Town

---

## STEP 1: Create/Edit Your MC4WP Form

1. Go to **WordPress Admin → Mailchimp for WP → Forms**
2. Either edit your existing form OR click **"Add new form"**
3. In the form editor, paste this code:

---

## MC4WP FORM CODE (Copy This):

```html
<style>
.mc4wp-form-fields {
    text-align: left;
}
.mc4wp-form-fields p {
    margin-bottom: 15px;
}
.mc4wp-form-fields label {
    font-family: 'UglyQua', serif;
    color: #044f9d;
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}
.mc4wp-form-fields input[type="text"],
.mc4wp-form-fields input[type="email"] {
    width: 100%;
    padding: 12px;
    border: 2px solid #044f9d;
    border-radius: 4px;
    font-size: 16px;
}
.mc4wp-form-fields input[type="submit"] {
    width: 100%;
    background: #c3202e;
    color: white;
    padding: 15px 30px;
    border: none;
    font-family: 'ArmaliteRifle', sans-serif;
    font-size: 20px;
    cursor: pointer;
    text-transform: uppercase;
    border-radius: 4px;
    transition: all 0.3s ease;
}
.mc4wp-form-fields input[type="submit"]:hover {
    background: #a01a24;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
}
</style>

<p>
    <label>First Name</label>
    <input type="text" name="FNAME" placeholder="Your first name" required />
</p>

<p>
    <label>Last Name</label>
    <input type="text" name="LNAME" placeholder="Your last name" required />
</p>

<p>
    <label>Email Address *</label>
    <input type="email" name="EMAIL" placeholder="your.email@example.com" required />
</p>

<p>
    <label>Town</label>
    <input type="text" name="MMERGE9" placeholder="e.g., Lexington, Arlington" />
</p>

<p style="text-align: center; margin-top: 20px;">
    <input type="submit" value="SOUND THE ALARM" />
</p>
```

---

## STEP 2: Configure Form Settings

In the same form editor, scroll down to **Form Settings**:

### Messages Tab:
- **Success:** "Thank you! You're now part of the Lexington Alarm Network."
- **Error:** "Oops! Something went wrong. Please try again."
- **Already subscribed:** "You're already receiving our updates!"

### Settings Tab:
- ✅ **Double opt-in:** Recommended (compliance)
- ✅ **Update existing subscribers:** Yes
- ✅ **Replace interest groups:** No (keep existing preferences)

---

## STEP 3: Map Mailchimp Fields

**IMPORTANT:** Make sure these field names match your Mailchimp audience:

| Form Field | Mailchimp Merge Tag | Description |
|------------|---------------------|-------------|
| `FNAME` | First Name | Standard Mailchimp field |
| `LNAME` | Last Name | Standard Mailchimp field |
| `EMAIL` | Email Address | Required field |
| `MMERGE9` | Town | Your custom field |

**To verify your MERGE9 field:**
1. Log into Mailchimp
2. Go to **Audience → Settings → Audience fields and *|MERGE|* tags**
3. Find your "Town" field
4. Note the merge tag (might be MMERGE9, MERGE9, or something else)
5. Update the form code if different

---

## STEP 4: Save and Get Form ID

1. **Save** the form
2. Note the **Form ID** (shown in the forms list, e.g., "456")
3. Copy that number

---

## STEP 5: Add to News Page

Use the simplified News page code:

```html
<!-- wp:html -->
<div class="news-page-wrapper">
    
    <!-- FEATURED STORY -->
    <div class="featured-story-section">
        <h2 class="section-title">FEATURED STORY</h2>
        [featured_story]
    </div>
    
    <!-- SUBSCRIBE BANNER -->
    <div class="subscribe-banner" style="background: linear-gradient(135deg, #044f9d 0%, #0367c7 100%); 
         color: white; padding: 50px 30px; text-align: center; margin: 40px 0; 
         border: 4px solid #c3202e; position: relative; overflow: hidden;">
        
        <!-- Decorative corners -->
        <div style="position: absolute; top: 0; left: 0; width: 60px; height: 60px; 
             border-top: 3px solid white; border-left: 3px solid white;"></div>
        <div style="position: absolute; top: 0; right: 0; width: 60px; height: 60px; 
             border-top: 3px solid white; border-right: 3px solid white;"></div>
        <div style="position: absolute; bottom: 0; left: 0; width: 60px; height: 60px; 
             border-bottom: 3px solid white; border-left: 3px solid white;"></div>
        <div style="position: absolute; bottom: 0; right: 0; width: 60px; height: 60px; 
             border-bottom: 3px solid white; border-right: 3px solid white;"></div>
        
        <div style="position: relative; z-index: 1; max-width: 600px; margin: 0 auto;">
            <h2 style="color: white; font-family: 'ArmaliteRifle', sans-serif; 
                 font-size: 2.5em; text-transform: uppercase; margin-bottom: 15px; 
                 text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                STAY INFORMED
            </h2>
            
            <p style="font-size: 1.2em; margin-bottom: 30px; line-height: 1.6;">
                Get updates on events, actions, and ways to defend democracy
            </p>
            
            <!-- MAILCHIMP FORM -->
            <div class="mailchimp-form-wrapper" style="background: white; padding: 30px; 
                 border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                
                [mc4wp_form id="456"]
                
            </div>
            
            <p style="font-size: 0.85em; margin-top: 20px; opacity: 0.9;">
                📧 Twice a month • Unsubscribe anytime • We never share your info
            </p>
        </div>
    </div>
    
    <!-- RECENT POSTS -->
    <div class="blog-posts-section">
        <h2 class="section-title" style="color: #044f9d;">RECENT NEWS</h2>
        [blog_posts_grid]
    </div>
    
    <!-- NEWSLETTER ARCHIVE -->
    <div class="newsletter-archive-section">
        <h2 class="section-title">NEWSLETTER ARCHIVE</h2>
        [newsletter_archive]
    </div>
    
</div>

<style>
/* Mobile responsive */
@media (max-width: 768px) {
    .subscribe-banner {
        padding: 30px 15px !important;
    }
    
    .subscribe-banner h2 {
        font-size: 1.8em !important;
    }
    
    .subscribe-banner p {
        font-size: 1em !important;
    }
    
    .mailchimp-form-wrapper {
        padding: 20px 15px !important;
    }
}
</style>
<!-- /wp:html -->
```

**Replace `[mc4wp_form id="456"]` with your actual form ID!**

---

## 🎯 QUICK SETUP SUMMARY

1. ✅ Create MC4WP form with First Name, Last Name, Email, Town
2. ✅ Save form and note the ID
3. ✅ Add `[mc4wp_form id="YOUR_ID"]` to News page
4. ✅ Test signup!

---

## ✅ WHAT YOUR FORM COLLECTS

- **First Name** (FNAME) - Required
- **Last Name** (LNAME) - Required  
- **Email** (EMAIL) - Required
- **Town** (MMERGE9) - Optional but requested

All styled with your brand colors and fonts!

---

## 🔍 TROUBLESHOOTING

### "Field not mapping to Mailchimp"
Check the merge tag name in Mailchimp matches exactly:
- Go to Mailchimp → Audience → Settings → Audience fields
- Find your "Town" field
- Copy the exact merge tag (MMERGE9, MERGE9, etc.)
- Update the form code

### "Form styling looks wrong"
The CSS is embedded in the form itself, so it should work automatically. If not:
- Clear browser cache
- Clear WordPress cache
- Check that custom fonts are loaded on your site

### "Test signup not appearing in Mailchimp"
- Check MC4WP → Settings → Mailchimp → Test connection
- Verify correct audience is selected
- Check if double opt-in is enabled (subscriber needs to confirm email)
- Look in Mailchimp for "Pending" subscribers

---

**Ready to set it up?** Follow the steps above and you'll have a beautiful, functional newsletter signup on your News page!

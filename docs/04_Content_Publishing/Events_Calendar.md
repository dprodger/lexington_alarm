# Events Calendar

**Last Updated:** November 22, 2024  
**System:** Tockify  
**Page:** Events (lexingtonalarm.org/events)  
**Status:** Active and Functional

---

## Current State

### Overview
**Two-tier event display system on Events page:**
1. **Featured Events** - Pinboard view showing high-priority upcoming events
2. **All Upcoming Events** - Full monthly calendar view showing all events

**Purpose:** 
- Highlight most important upcoming events
- Provide comprehensive calendar view
- Easy public access to event information
- No login required to view

---

## Tockify Account

### Account Details
**Calendar Name:** lexingtonalarm  
**Public URL:** https://tockify.com/lexingtonalarm (or similar - document)  
**Admin Access:** (Stored securely)

### Tockify Plan
**Plan Type:** (Free/Paid - document current plan)  
**Features Available:**
- Unlimited events
- Multiple view types (calendar, pinboard, agenda, compact)
- Event tagging and filtering
- Embeddable widgets
- Custom styling

---

## Events Page Implementation

### Page Structure

The Events page uses a two-tier system to balance highlighting priority events with comprehensive calendar access.

### HTML Code
```html
<!-- Two-Tier Events Page: Featured + Full Calendar -->
<div class="events-page-wrapper">
    <!-- TIER 1: Featured Events Section -->
    <div class="featured-events-section">
        <h2 class="section-title">FEATURED EVENTS</h2>
        <div class="featured-events-container">
            <div data-tockify-component="pinboard" 
                 data-tockify-calendar="lexingtonalarm"
                 data-tockify-search="featured">
            </div>
        </div>
    </div>
    
    <!-- Visual Separator -->
    <div class="section-divider">
        <span class="divider-text">ALL UPCOMING EVENTS</span>
    </div>
    
    <!-- TIER 2: Full Calendar Section -->
    <div class="full-calendar-section">
        <div data-tockify-component="calendar" 
             data-tockify-calendar="lexingtonalarm"
             data-tockify-view="monthly">
        </div>
    </div>
</div>
   
<!-- Tockify Script (only need once) -->
<script data-cfasync="false" data-tockify-script="embed" 
        src="https://public.tockify.com/browser/embed.js"></script>
```

### Key Implementation Details

**Tier 1 - Featured Events:**
- Component: `pinboard` view
- Filter: `data-tockify-search="featured"`
- Shows: Only events tagged with "featured" keyword in Tockify
- Style: Card-based pinboard layout

**Tier 2 - Full Calendar:**
- Component: `calendar` view
- View: `monthly` (default)
- Shows: All events in monthly grid
- Interactive: Users can switch to other views (agenda, week)

**Script:**
- Load Tockify embed script once
- Script handles rendering both components
- Automatically responsive

---

## CSS Styling

### Custom CSS Added to Main Stylesheet

```css
/* Events Page Wrapper */
.events-page-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

/* Featured Events Section */
.featured-events-section {
    margin-bottom: 3rem;
}

.section-title {
    font-family: 'ArmaliteRifle', sans-serif;
    color: #c3202e; /* Red */
    text-align: center;
    text-transform: uppercase;
    font-size: 2rem;
    margin-bottom: 1.5rem;
}

/* Section Divider */
.section-divider {
    border-top: 3px solid #044f9d; /* Blue */
    margin: 3rem 0;
    position: relative;
    text-align: center;
}

.divider-text {
    background: #ffffff;
    padding: 0 1rem;
    position: relative;
    top: -0.75rem;
    font-family: 'ArmaliteRifle', sans-serif;
    color: #c3202e; /* Red */
    font-size: 1.5rem;
    text-transform: uppercase;
}

/* Full Calendar Section */
.full-calendar-section {
    margin-top: 2rem;
}

/* Tockify Calendar Title Centering Override */
.tockify-calendar-title {
    text-align: center !important;
}
```

**Purpose:**
- Maintain brand consistency with red/blue color scheme
- Use ArmaliteRifle font for section headings
- Center section titles for visual balance
- Create clear separation between featured and full calendar
- Override Tockify default styles where needed

---

## Tockify Configuration

### Calendar Settings
**Access:** Tockify Dashboard → Settings

**General Settings:**
- Calendar Name: lexingtonalarm
- Time Zone: America/New_York (Eastern)
- First Day of Week: Sunday (or Monday - document)
- Date Format: (MM/DD/YYYY or other - document)

**Display Settings:**
- Default View: Monthly
- "No events" message: Disabled (don't show when no events)
- Event colors: (Document color scheme if customized)

### Featured Events Filtering
**How It Works:**
1. When adding event in Tockify, include "featured" in the event title, description, or tags
2. The pinboard component searches for "featured" keyword
3. Only matching events display in Featured Events section
4. All events (including featured) still appear in full calendar

**Best Practice:** 
- Use Tockify tags field for "featured" rather than in title
- Keeps event titles clean
- Easy to add/remove featured status

---

## Adding Events to Calendar

### Event Creation Process
**Access:** Tockify Dashboard → Add Event

**Required Information:**
1. **Event Title:** Clear, descriptive name
2. **Start Date/Time:** When event begins
3. **End Date/Time:** When event ends (or all-day if applicable)
4. **Location:** Physical address or "Online"
5. **Description:** Full event details (supports HTML formatting)

**Optional but Recommended:**
6. **Tags:** Include "featured" for high-priority events
7. **Image:** Event banner or relevant photo
8. **Registration Link:** External link to RSVP form if applicable
9. **Organizer:** Contact information for event organizer
10. **Category:** (If using Tockify categories for filtering)

### Event Description Best Practices
**Include:**
- What: Event type and purpose
- When: Date and time (redundant with calendar fields, but helpful in description)
- Where: Location with address
- Why: Why people should attend
- How: How to register/RSVP/prepare
- Contact: Who to contact with questions

**Formatting:**
- Use HTML for formatting (bold, italics, links)
- Break into short paragraphs
- Use bullet points for lists
- Include call-to-action (RSVP, register, etc.)

### Featured Event Criteria
**Consider "Featured" Status For:**
- Major rallies or demonstrations
- Critical organizational meetings open to public
- Educational events with speakers
- Milestone anniversaries (Battle of Lexington anniversary)
- Events with registration deadlines

**Don't Feature:**
- Regular recurring meetings
- Internal committee meetings
- Past events
- Events with limited capacity already filled

---

## Event Management

### Editing Events
**Process:**
1. Log into Tockify dashboard
2. Find event in list
3. Click edit
4. Make changes
5. Save - updates appear immediately on website

### Deleting Events
**Process:**
1. Tockify dashboard → Find event
2. Click delete
3. Confirm - event removed from all views

**When to Delete:**
- Event is cancelled
- Event already occurred (after reasonable archive period)
- Event was entered in error

### Recurring Events
**Setup:**
1. Create event normally
2. Check "Repeat" or "Recurring" option
3. Set pattern (daily, weekly, monthly)
4. Set end date or number of occurrences

**Use Cases:**
- Weekly organizing meetings
- Monthly community forums
- Regular volunteer shifts

---

## Calendar Views Available

### Monthly View (Default)
**Display:** Grid showing all days of month  
**Best For:** Overview of upcoming events, scheduling  
**User Can:** Click dates to see event details, navigate months

### Pinboard View
**Display:** Card-based layout showing event tiles  
**Best For:** Featured events section (current implementation)  
**User Can:** Click cards for details, scroll through events

### Agenda View
**Display:** List of upcoming events in chronological order  
**Best For:** Text-focused view, printing  
**User Can:** Scroll through upcoming events

### Compact View
**Display:** Condensed list view  
**Best For:** Sidebar widgets (if ever used elsewhere on site)  
**User Can:** See event titles and dates quickly

**Note:** Users can switch between available views in the full calendar section.

---

## Mobile Responsiveness

### Mobile Behavior
**Automatic:** Tockify embeds are responsive by default  
**Adjustments:** Calendar switches to mobile-friendly layout on small screens

**Mobile Experience:**
- Monthly view shows simplified grid
- Pinboard cards stack vertically
- Touch-friendly event interaction
- Swipe to navigate months

**Testing:** Regular testing on iPhone and Android devices recommended

---

## Integration with Other Site Elements

### News System
**Connection:** Major events can be announced via news posts  
**Cross-linking:** News articles can link to specific events  
**Workflow:** Event announcement → News post → Calendar entry

### Newsletter
**Connection:** Featured events highlighted in newsletters  
**Process:** Pull featured events from calendar for newsletter content  
**Timing:** Promote events 1-2 weeks in advance

### Social Media
**Process:** Share featured events on social platforms  
**Scheduling:** Promote major events multiple times leading up to date  
**Graphics:** Create event graphics using brand assets

---

## Analytics & Tracking

### Current Tracking
**Tockify Built-in:** (Document if Tockify provides any analytics)  
**Website Analytics:** Track Events page views via Plausible

### Potential Tracking
- Event detail clicks (how many people view specific events)
- Registration link clicks (track RSVP button clicks)
- Calendar interaction (view switches, month navigation)

**Implementation:** Add Plausible event tracking to Events page  
**See:** `06_Code_Snippets/JavaScript_Tracking.md`

---

## Troubleshooting

### Calendar Not Displaying
**Possible Causes:**
1. Tockify script not loading (check browser console)
2. Incorrect calendar name in embed code
3. JavaScript error on page blocking script
4. Caching issue (clear browser and WordPress cache)

**Solutions:**
1. Verify script URL correct
2. Check calendar name matches Tockify account
3. Disable other plugins temporarily to test for conflicts
4. Clear all caches

### Featured Events Not Showing
**Possible Causes:**
1. Events not tagged with "featured"
2. Featured events are in the past
3. Search filter typo in embed code

**Solutions:**
1. Verify events have "featured" tag in Tockify
2. Check event dates are in future
3. Verify `data-tockify-search="featured"` is correct

### Calendar Shows Wrong Time Zone
**Possible Causes:**
1. Tockify account time zone setting incorrect
2. Event created with wrong time zone

**Solutions:**
1. Tockify Settings → Set time zone to America/New_York
2. Edit events and verify time zone

### Events Display Oddly on Mobile
**Possible Causes:**
1. Custom CSS interfering with Tockify responsive design
2. Theme CSS conflicts
3. Viewport meta tag missing

**Solutions:**
1. Review custom CSS for overly specific selectors
2. Test with default WordPress theme to isolate issue
3. Verify viewport meta tag in site header

---

## Future Enhancements

### Potential Improvements
- [ ] Add calendar subscription link (iCal/Google Calendar)
- [ ] Implement event categories (Rally, Meeting, Educational, Social)
- [ ] Add map view for event locations
- [ ] Enable event registration directly in calendar
- [ ] Create event submission form for community members

### Under Consideration
- [ ] Upgrade Tockify plan for additional features
- [ ] Integration with Mailchimp for event reminders
- [ ] Automatic social media posting of new events
- [ ] Event photo galleries after events occur

---

## Change History

### 2024 Q4 (Current)
- Two-tier system functioning well
- Regular event additions and management
- Consider analytics enhancement

### September 2024
- Events page created with two-tier system
- Tockify embedded (pinboard + calendar views)
- Custom CSS styling applied
- Featured event filtering implemented
- "No events" message disabled in Tockify
- Monthly set as default calendar view

---

## Key Decisions Made

### Design Decisions
- **Two-tier approach:** Highlight important events while maintaining comprehensive calendar
- **Removed duplicate heading:** Single "FEATURED EVENTS" heading (originally had two)
- **Monthly default view:** More visual than agenda view for users
- **Divider styling:** Blue border with centered text for visual separation

### Functional Decisions
- **Disabled "no events" message:** Less cluttered when calendar is empty
- **Featured filter:** Use "featured" tag rather than separate calendar
- **Public calendar:** No login required, open to community
- **Centered titles:** Override Tockify defaults for brand consistency

---

**Related Documentation:**
- `08_Quick_References/Brand_Assets.md` - Colors and fonts used in styling
- `06_Code_Snippets/Custom_CSS.md` - Full CSS code
- `01_Technical_Foundation/Plugins_And_Integrations.md` - Tockify as third-party integration
- `08_Quick_References/Common_Tasks.md` - How to add/edit events

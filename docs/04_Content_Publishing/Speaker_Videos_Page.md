# Speaker Videos / Oct 18 No Kings Rally Recap Page

**Page URL:** `/speaker-videos/`  
**Page Title:** Oct 18 No Kings Recap (renamed from "Speaker Videos")  
**Page Type:** WordPress page with custom HTML blocks  
**Last Updated:** December 6, 2025

---

## Page Purpose

This page serves as a permanent archive for the October 18, 2025 "No Kings" rally on Lexington Battle Green, which drew 6,000+ attendees. It includes:

1. **Speaker video archive** - YouTube embeds from LexMedia recordings
2. **Rally photo gallery** - Three photos with credits
3. **Rally summary** - Text description and call-to-action buttons

---

## Page Structure

```
┌─────────────────────────────────────────┐
│    "Speaker videos courtesy of LexMedia"│
│              (header)                   │
├─────────────────────────────────────────┤
│  SPEAKER 1: Regie O'Hare Gibson         │
│  [Bio text]        [YouTube video]      │
│  (33.33%)              (66.66%)         │
├─────────────────────────────────────────┤
│  SPEAKER 2: Bill McKibben               │
│  [Bio text]        [YouTube video]      │
├─────────────────────────────────────────┤
│  ... (10 speakers total) ...            │
├─────────────────────────────────────────┤
│       RALLY RECAP SECTION               │
│  [Photos 66.66%]  [Text + CTAs 33.33%]  │
└─────────────────────────────────────────┘
```

---

## Speaker List

| Speaker | Role/Description | YouTube Video ID |
|---------|------------------|------------------|
| Regie O'Hare Gibson | Poet Laureate of Massachusetts | 13L9n-ljBL8 |
| Bill McKibben | Founder of Third Act, author | QrOO1b-M3Vw |
| Senator Ed Markey | US Senator from Massachusetts | c1lAruRN40w |
| Jared and Laurie Berezin | Started ICE Office standouts | Gdm54Rgl3DQ |
| Jessie Steigerwald | President of LexSeeHer | JRE-vGuRzJ4 |
| Valerie Overton | Chair of LexPride | pfUKs_dao6c |
| Charu Verma | VP, National ACLU | HG3WctHyQQM |
| Karin Travers | Reading Sen. Warren's statement | UBjfSyV8hRs |
| Amahl Bishara | Professor at Tufts University | GDiis4Lz1F4 |
| Kunal Botla | Youngest Town Meeting member | nNZpBByN6YA |

---

## Column Layout Template

Each speaker uses a consistent 33.33% / 66.66% column layout:

```html
<!-- SPEAKER: [Name] -->
<!-- wp:columns -->
<div class="wp-block-columns">
    <!-- wp:column {"width":"33.33%"} -->
    <div class="wp-block-column" style="flex-basis:33.33%">
        <!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"#c3202e"}}},"color":{"text":"#c3202e"}}} -->
        <h2 class="wp-block-heading has-text-color has-link-color" style="color:#c3202e">[Speaker Name]</h2>
        <!-- /wp:heading -->
        <!-- wp:paragraph -->
        <p class="">[Speaker bio/description]</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->
    <!-- wp:column {"width":"66.66%"} -->
    <div class="wp-block-column" style="flex-basis:66.66%">
        <!-- wp:embed {"url":"https://youtu.be/[VIDEO_ID]","type":"video","providerNameSlug":"youtube","responsive":true,"className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} -->
        <figure class="wp-embed-aspect-16-9 wp-has-aspect-ratio wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube">
            <div class="wp-block-embed__wrapper">
                https://youtu.be/[VIDEO_ID]
            </div>
        </figure>
        <!-- /wp:embed -->
    </div>
    <!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"30px"} -->
<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->
```

---

## Rally Recap Section

Located at the bottom of the page, this section includes:

**Left Column (66.66%):**
- Main rally photo (Lauren Feeney, Lexington Observer)
- Two smaller photos in sub-columns:
  - Crowd photo (Maggie Scales, Lexington Observer) - 60%
  - Band photo (Lauren Feeney, Lexington Observer) - 40%

**Right Column (33.33%):**
- "6000 Turn Out for Massive No Kings Rally" header
- Link to speaker videos (self-referential)
- Two paragraphs of rally summary
- "Read Full Story" button
- Three CTA buttons:
  - Subscribe to Updates (blue)
  - Support Our Movement (red)
  - Order Your Sign (red)
- Closing paragraph about yard signs

---

## Adding a New Speaker

1. Copy the speaker template above
2. Replace `[Speaker Name]` with the name
3. Replace `[Speaker bio/description]` with their description
4. Replace `[VIDEO_ID]` with the YouTube video ID
5. Insert before the Rally Recap section
6. Add 30px spacer after

---

## Photo Credits

All rally photos credited to Lexington Observer:
- Lauren Feeney (main photo, band photo)
- Maggie Scales (crowd photo)

---

## Technical Notes

### December 6, 2025 Cleanup

**Problem:** Page had orphaned `<!-- /wp:post-content -->` and wrapper `<div>` tags causing layout breaks.

**Symptoms:**
- Some speakers had no left margin
- Rally section appeared inside speaker columns
- Inconsistent spacing between sections

**Solution:**
- Removed all orphaned closing tags
- Removed misplaced padding wrapper divs
- Ensured all columns properly closed before next section
- Added consistent 30px spacers between all speakers

**Key Learning:** Never insert wrapper divs between column siblings - it breaks the flex layout.

---

## Related Documentation

- **Home Page:** `04_Content_Publishing/Home_Page.md`
- **News System:** `04_Content_Publishing/News_System/`
- **Rally Coverage Story:** See News system for the full story post

---

## Change Log

| Date | Change |
|------|--------|
| Dec 6, 2025 | Complete code cleanup - fixed orphaned div tags |
| Dec 6, 2025 | Page renamed from "Speaker Videos" to "Oct 18 No Kings Recap" |
| Dec 6, 2025 | Rally recap section moved here from Home page |
| Oct 2025 | Original page created with speaker video embeds |

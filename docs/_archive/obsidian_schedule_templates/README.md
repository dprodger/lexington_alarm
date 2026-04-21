# Schedule Templates - Setup Instructions

## How to Use These Templates

### Installation

1. **Copy this folder** to your Obsidian vault
   - Suggested location: `/Templates/Schedule/` or `/Schedule_Templates/`

2. **Set up in Obsidian Settings** (optional)
   - Settings → Core Plugins → Templates → Enable
   - Set template folder location

### Daily Note Integration

**Option A: Link from Daily Note**

Add this to your daily note template:
```markdown
## Today's Schedule
See: [[Monday_Schedule]] <!-- change day as needed -->
```

Or use Obsidian's templater plugin for automatic day detection:
```markdown
## Today's Schedule
See: [[<% tp.date.now("dddd") %>_Schedule]]
```

**Option B: Embed Schedule in Daily Note**

```markdown
## Schedule
![[Monday_Schedule#⏰ Schedule]]
```

This embeds just the schedule section.

### Workflow

1. **Start of day:** Open daily note, click link to that day's schedule
2. **Select priorities:** Check 1-2 items in the Focus section
3. **During day:** Check off time blocks as completed
4. **End of day:** Fill in Notes section

### Weekly Rhythm

- **Sunday evening or Monday morning:** Open [[Weekly_Overview]], set the week's priority
- **Friday afternoon:** Do weekly review in Friday template
- **End of week:** Fill in Weekly_Overview end-of-week review

---

## File List

| Template | Purpose |
|----------|---------|
| `Monday_Schedule.md` | Development day (3 hrs AM) |
| `Tuesday_Schedule.md` | Development day + protected PM |
| `Wednesday_Schedule.md` | Men's Group day, lighter schedule |
| `Thursday_Schedule.md` | Exec Call day, LA operations focus |
| `Friday_Schedule.md` | Development + weekly wrap-up |
| `Saturday_Schedule.md` | **Protected hobby AM**, flexible PM |
| `Sunday_Schedule.md` | Rest day, light optional work |
| `Weekly_Overview.md` | Week planning and tracking |

---

## Key Principles Built Into These Templates

1. **Development capped at ~11 hours/week** across M/Tu/W/F mornings
2. **Protected time is marked** - Tuesday PM, Thursday PM, Saturday AM
3. **Thursday is light** - Exec call dominates the day
4. **Friday ends at 3pm** - Early weekend start
5. **Sunday is optional** - 2-4 hours max, only if desired

---

## Customization

Feel free to adjust times, but **keep the boundaries**:
- Don't schedule development after 5pm
- Don't skip protected hobby time
- Don't exceed ~14 hours/week development

---

## Links to Project Tracking

Update these links to match your vault structure:

- [[CURRENT_PRIORITIES]] - Active project list
- [[Development_Timeline_History]] - Past work reference

---

*Created: January 10, 2026*

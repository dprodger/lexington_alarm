# Newsletter Archive with Titles - Quick Guide

## How to Add Newsletters

Super simple format - just type the title and paste the URL:

```php
'Title Here' => 'URL Here',
```

---

## Example

```php
$newsletters = array(
    
    'ICE Grabs Lexington Landscape Worker Aug 28th' => 'https://us17.campaign-archive.com/?u=3a64af74077cb1e5e461c36af&id=740436db51',
    
    'September Newsletter' => 'https://us17.campaign-archive.com/?u=3a64af74077cb1e5e461c36af&id=abc123',
    
    'August Newsletter' => 'https://us17.campaign-archive.com/?u=3a64af74077cb1e5e461c36af&id=xyz789',
    
);
```

---

## Rules

1. ✅ **Title in single quotes** `'Like this'`
2. ✅ **Arrow between** `=>`
3. ✅ **URL in single quotes** `'Like this'`
4. ✅ **Comma at the end** `,`
5. ✅ **Newest at the TOP**

---

## Adding a New Newsletter

**Step 1:** Copy this line:
```php
'Title Here' => 'URL Here',
```

**Step 2:** Change the title and URL:
```php
'October Newsletter' => 'https://us17.campaign-archive.com/?u=3a64af74077cb1e5e461c36af&id=NEW_ID',
```

**Step 3:** Paste it at the TOP of the array:
```php
$newsletters = array(
    
    'October Newsletter' => 'https://us17.campaign-archive.com/?u=3a64af74077cb1e5e461c36af&id=NEW_ID',  ← NEW
    
    'ICE Grabs Lexington Landscape Worker Aug 28th' => 'https://us17.campaign-archive.com/?u=3a64af74077cb1e5e461c36af&id=740436db51',
    
);
```

**Step 4:** Click Update

---

## What It Looks Like on Your Site

```
╔═══════════════════════════════════════════════════════╗
║                                                       ║
║             NEWSLETTER ARCHIVE                        ║
║                                                       ║
╚═══════════════════════════════════════════════════════╝

📧  ICE Grabs Lexington Landscape Worker Aug 28th
    View in Browser →

───────────────────────────────────────────────────────

📧  September Newsletter
    View in Browser →

───────────────────────────────────────────────────────

📧  August Newsletter
    View in Browser →
```

---

## Setup Steps

1. **Go to:** WordPress → Snippets → Edit "News Shortcodes" (ID: 651)
2. **Find the** `display_newsletter_archive()` function
3. **Replace it** with the code from `NEWSLETTER_ARCHIVE_WITH_TITLES.php`
4. **Add your newsletters** using the format above
5. **Click Update**
6. **Visit your News page** to see it working!

---

## Quick Copy Template

Copy this to add a new newsletter:

```php
'TITLE GOES HERE' => 'URL GOES HERE',
```

Just change TITLE and URL, then paste at the top!

---

## Common Issues

**"Parse error" or "unexpected"**
- Check you have matching single quotes `'...'`
- Check you have the arrow `=>`
- Check you have a comma at the end `,`

**Newsletter not showing**
- Make sure it's inside the `array( ... )` brackets
- Make sure you clicked Update
- Clear your browser cache (Ctrl+Shift+R)

---

Ready to add your newsletters!

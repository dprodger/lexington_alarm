# ⚠️ IMPORTANT: Custom Page Templates Guide for Lexington Alarm

## CRITICAL REFERENCE - ALWAYS CONSULT BEFORE CREATING CUSTOM PAGES

**Last Updated:** January 31, 2026  
**Status:** Production Tested & Verified

---

## Overview

This document covers the two methods for creating custom page templates in WordPress using WPCode snippets:

1. **WITH Kadence Header** - Uses `get_header()` for full site navigation
2. **WITHOUT Site Footer** - Critical for print-friendly pages

---

## Key Discoveries (Hard-Won Knowledge)

### The Footer Problem

When creating custom templates, there are THREE ways the Kadence footer can appear:

1. **`get_footer()`** - Explicitly loads the theme footer
2. **`wp_footer()`** - Fires WordPress hooks, which Kadence uses to inject its footer
3. **CSS not hiding it** - Even with manual HTML closing, footer may persist

### ⚠️ THE CRITICAL SOLUTION

**To completely eliminate the Kadence footer, you must NOT call `wp_footer()` at all.**

Kadence hooks its footer markup to the `wp_footer` action. Even without calling `get_footer()`, if you call `wp_footer()`, Kadence will inject its footer.

---

## Template Pattern 1: Full Header, No Footer (RECOMMENDED FOR CAMPAIGN PAGES)

Use this when you want:
- Full Kadence header with banner, tagline, and navigation
- No Kadence footer (for clean print output)
- Custom content in the middle

```php
<?php
/**
 * CUSTOM PAGE TEMPLATE - WITH HEADER, NO FOOTER
 * Use for: Campaign letters, printable pages, action pages
 */

// Register custom page template
add_filter('theme_page_templates', 'my_custom_add_page_template');
function my_custom_add_page_template($templates) {
    $templates['my-custom-template'] = 'My Custom Page';
    return $templates;
}

// Load custom template
add_filter('template_include', 'my_custom_load_template');
function my_custom_load_template($template) {
    if (is_page()) {
        $page_template = get_post_meta(get_the_ID(), '_wp_page_template', true);
        if ($page_template == 'my-custom-template') {
            return my_custom_render_template();
        }
    }
    return $template;
}

// Render the template
function my_custom_render_template() {
    // Load Kadence header (includes <!DOCTYPE>, <html>, <head>, wp_head(), and site header with nav)
    get_header();
    ?>
    
    <style>
        /* Your custom styles here */
        
        /* Print Styles - CRITICAL */
        @media print {
            body {
                background: white;
            }
            
            .site-header,
            #masthead,
            header,
            .your-page-header,
            .your-instructions,
            .your-action-buttons {
                display: none !important;
            }
            
            .your-wrapper {
                padding: 0;
                max-width: none;
            }
            
            .your-content-container {
                box-shadow: none;
                border: none;
                padding: 0.5in;
            }
        }
    </style>

    <div class="your-wrapper">
        <!-- Your page content here -->
    </div>

</body>
</html>
<?php
    exit;
}
```

### Critical Points:
- ✅ Uses `get_header()` for full site header
- ✅ Ends with `</body></html>` directly - **NO `wp_footer()` call**
- ✅ **NO `get_footer()` call**
- ✅ `exit;` prevents any further output

---

## Template Pattern 2: Completely Standalone (No Theme Elements)

Use this when you want:
- Complete control over all HTML
- No Kadence elements at all
- Fastest loading (no theme overhead)

```php
<?php
/**
 * STANDALONE PAGE TEMPLATE - NO THEME ELEMENTS
 */

add_filter('theme_page_templates', function($templates) {
    $templates['standalone-template'] = 'Standalone Page';
    return $templates;
});

add_filter('template_include', function($template) {
    global $post;
    
    if ($post && get_page_template_slug($post->ID) === 'standalone-template') {
        standalone_render_page();
        exit;
    }
    
    return $template;
});

function standalone_render_page() {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_the_title(); ?> | Lexington Alarm</title>
    <style>
        /* All styles self-contained */
        
        /* Print Styles */
        @media print {
            body {
                background: white;
            }
            
            .site-header,
            .page-header,
            .instructions,
            .action-buttons {
                display: none;
            }
            
            .wrapper {
                padding: 0;
                max-width: none;
            }
            
            .content-container {
                box-shadow: none;
                border: none;
                padding: 0.5in;
            }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <a href="<?php echo home_url(); ?>">
            <img src="<?php echo home_url('/wp-content/uploads/2024/09/LexAlarmBanner8.svg'); ?>" alt="Lexington Alarm">
        </a>
    </header>

    <div class="wrapper">
        <!-- Your content here -->
    </div>
</body>
</html>
<?php
}
```

### Critical Points:
- ✅ Complete HTML document - no theme dependencies
- ✅ No `get_header()`, `get_footer()`, or `wp_footer()`
- ✅ Fastest, cleanest output
- ⚠️ No site navigation unless you build it yourself

---

## Template Pattern 3: With Header AND Footer (Standard Theme Integration)

Use this when you want:
- Full site header
- Full site footer
- Standard WordPress page behavior

```php
// Render the template
function my_custom_render_template() {
    get_header();
    ?>
    
    <style>
        /* Your styles */
    </style>

    <div class="your-wrapper">
        <!-- Your content here -->
    </div>

    <?php
    get_footer();
    exit;
}
```

---

## Print Styles Best Practices

### Elements to Always Hide in Print:
```css
@media print {
    body {
        background: white;
    }
    
    /* Site header elements */
    .site-header,
    #masthead,
    header,
    
    /* Page-specific elements (not part of letter/document) */
    .page-header,
    .instructions,
    .action-buttons,
    
    /* Footer elements (if using get_footer) */
    .site-footer,
    #colophon,
    .custom-footer {
        display: none !important;
    }
    
    /* Content adjustments */
    .wrapper {
        padding: 0;
        max-width: none;
    }
    
    .content-container {
        box-shadow: none;
        border: none;
        padding: 0.5in;
    }
}
```

---

## Snippet Naming Convention

To avoid confusion between similar templates:

| Snippet Name | Template Slug | Template Display Name |
|--------------|---------------|----------------------|
| `CAMPAIGN_NAME Letter Template` | `campaign-letter-template` | Campaign Name Letter |
| `CAMPAIGN_NAME Standalone` | `campaign-standalone` | Campaign Name (Standalone) |

**Always make the WPCode snippet name clearly indicate what the template does.**

---

## Troubleshooting

### Footer Still Appearing?
1. ⚠️ **Check if using `wp_footer()` - REMOVE IT** (This is the #1 cause!)
2. Check if using `get_footer()` - remove it
3. Verify snippet is active
4. Clear all caches

### Header Not Appearing?
1. Verify using `get_header()`
2. Check page is assigned to correct template (in Page editor sidebar)
3. Verify snippet is active and has no PHP errors

### Print Shows Unwanted Elements?
1. Add more specific selectors to `@media print` CSS
2. Use `!important` on `display: none`
3. Browser print headers/footers (date, URL, page numbers) are browser settings, not CSS controllable

---

## Live Examples (as of Jan 2026)

| Page | Template Type | Snippet ID |
|------|--------------|------------|
| Massport Campaign | With Header, Custom Footer | #1397 |
| National Development Letter | With Header, No Footer | #1879 |

---

## Quick Reference Summary

### Want full header + NO footer? (Most common for campaign letters)
```php
get_header();
// ... your content ...
</body>
</html>
<?php exit;
```
**KEY: Do NOT call wp_footer() or get_footer()**

### Want completely standalone?
```php
// Build complete HTML yourself - no WordPress functions
<!DOCTYPE html>
// ... everything ...
</html>
<?php exit;
```

### Want full header + full footer?
```php
get_header();
// ... your content ...
get_footer();
exit;
```

---

## ⚠️ THE GOLDEN RULE

**To eliminate the Kadence footer completely: DO NOT call `wp_footer()`**

Kadence hooks `Kadence\footer_markup` to the `wp_footer` action. Even closing `</body></html>` manually won't help if you call `wp_footer()` before it - the footer HTML will already be injected.

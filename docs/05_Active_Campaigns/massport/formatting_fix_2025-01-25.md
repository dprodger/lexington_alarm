# Formatting Fix - January 25, 2026

## Issue
The "Option 2: Submit Written Letter to Governor Healey" text was displaying as a large blue heading instead of normal text because of malformed HTML - `<p>` tags were improperly nested inside an `<h2>` tag.

## Location in Code
Find this section (around line 470-480 in the code snippet):

```html
<h2>📧 You Have 3 Options on this page. <p>
			Option 1: Submit Written Public Comment to Massport
			</p>Option 2: Submit Written Letter to Governor Healey Using Her Intake Form<p>
			<p>
				Option 3: Send Written letters by postal mail (you supply envalopes and stamps) to the seven members of the Massport Board, and to Governor Healey.
			</p>
			</p></h2>
```

## Replace With

```html
<h2>📧 You Have 3 Options on this page.</h2>
        <p><strong>Option 1:</strong> Submit Written Public Comment to Massport</p>
        <p><strong>Option 2:</strong> Submit Written Letter to Governor Healey Using Her Intake Form</p>
        <p><strong>Option 3:</strong> Send Written letters by postal mail (you supply envelopes and stamps) to the seven members of the Massport Board, and to Governor Healey.</p>
```

## Also Fixed
- Typo: "envalopes" → "envelopes"

## Instructions
1. Go to WordPress Admin → Snippets → All Snippets
2. Find "Massport Campaign Template"
3. Search for `You Have 3 Options on this page`
4. Replace the malformed HTML block with the corrected version above
5. Save Changes

# Massachusetts Campaign Template - Governor Email Section Fix

## Issue
The Governor Healey email currently contains:
```
"Your role as a Board Member is critical to..."
```

But Governor Healey is NOT a Massport Board Member.

## Correction
Change to:
```
"Your role as the Governor is critical to..."
```

---

## Location in Code

In the **Massport Campaign Template** code snippet, search for the Governor Healey email section. Look for the JavaScript variable containing the email body text.

### Find this text:
```javascript
"Your role as a Board Member is critical to ensuring Massport complies with Massachusetts constitutional protections."
```

### Replace with:
```javascript
"Your role as the Governor is critical to ensuring Massport complies with Massachusetts constitutional protections."
```

---

## Full Updated Governor Email Body

Replace the entire Governor Healey email body (`governorHealeyLetter` variable) with this text:

```javascript
var governorHealeyLetter = "Dear Governor Maura Healey,%0D%0A%0D%0A" +
    "Over 2,000 Massachusetts residents have been forcibly removed from our state using ICE charter flights from Hanscom Field. Their constitutional rights of due process have been recklessly disregarded by Massport. Massport must ensure its operations do not violate Massachusetts residents' due-process rights under our state constitution.%0D%0A%0D%0A" +
    "You have the power to appoint 2 directors to the Massport Board in 2026:%0D%0A%0D%0A" +
    "- Warren Fields, whose term expired June 2025 and has not been reappointed, and%0D%0A" +
    "- Sean M. O'Brien, whose term expires in 2026.%0D%0A%0D%0A" +
    "In addition your cabinet secretary of the Dept. of Transportation is an ex-officio member.%0D%0A%0D%0A" +
    "Therefore you have considerable leverage and authority to direct the Board to protect our citizens liberty interest under our State Constitution.%0D%0A%0D%0A" +
    "Our communities are being terrorized by ICE use of unconstitutional stops, searches, and refusals to allow immigrants and asylum seekers with legal agreements with the federal government of their immigration status to seek court review before their status is arbitrarily changed by ICE.%0D%0A%0D%0A" +
    "When resident asylum seekers, holders of valid work permits, or spouses of U.S. citizens entitled to hearings before Massachusetts immigration judges are flown out of state without access to counsel or family support, their due-process rights are violated. Committee for Public Counsel Services v. ICE (D. Mass. 2020) supports this conclusion. In addition, Lunn v. Commonwealth confirms that state officials have no authority to hold people on civil immigration detainers.%0D%0A%0D%0A" +
    "We call on you to urge Massport to:%0D%0A%0D%0A" +
    "• Publish agreements and records in advance of all ICE-related air operations, using flight records obtained from Hanscom FBOs, as required under the Massachusetts Public Records Law and as requested by the Hanscom Field Advisory Commission in their letter of Sept. 17, 2025.%0D%0A%0D%0A" +
    "• Adopt a Lunn-Compliance and Custody-Transfer Transparency Directive for Hanscom Field and all Massport facilities. This policy must prohibit state actor facilitation based solely on ICE detainers, require warrant verification for any custody transfers, and mandate public monthly reporting of ICE charter operations.%0D%0A%0D%0A" +
    "• Require charter operators and fixed-base operators to certify their compliance with Massachusetts law, constitutional protections, and Massport's directives as a condition of using Massport property.%0D%0A%0D%0A" +
    "• Require charter operators to certify the safety of refueling operations with chained and shackled passengers. Air safety guidance for refueling does not envision chained and shackled passengers with limited movement. You must require all charter operators boarding shackled and chained passengers to certify their safety procedures and that flight attendants are trained in evacuating these passengers. If certification is not forthcoming, you must prohibit refueling if passengers are on board.%0D%0A%0D%0A" +
    "• Create an MOU with State Police Troop F to ensure that all State Police activities at Hanscom Field are fully compliant with Lunn and the Attorney General's guidelines prohibiting local law enforcement from assisting in ICE operations.%0D%0A%0D%0A" +
    "Other actions are available to Massport under the anti-commandeering doctrine of the Tenth Amendment of the U.S. Constitution. For example, Massport has no obligation to allow State Police from Troop F to provide any service to ICE contract flights that they do not already provide to other commercial contract operations.%0D%0A%0D%0A" +
    "Further, Massport is protected from loss of funding or other fiscal retaliation from the federal government if it changes contractor policies or withdraws special permissions granted to ICE alone. Recent injunctions and court cases—most notably Attorney General Andrea Campbell's successful lawsuit with 19 other states—resulted in a permanent injunction preventing the Department of Transportation from conditioning federal funds on cooperation or non-cooperation with ICE.%0D%0A%0D%0A" +
    "You must prevent Massport from hiding behind federal preemption to ignore our state constitutional protections where it has the power to intervene. Massport has full regulatory authority to impose conditions on all operators using their facilities that ensures Massport and its contractors are not flagrantly violating our State Constitution's guarantee of due process.%0D%0A%0D%0A" +
    "We expect you to use the full range of powers you have as Governor to protect residents of our state from being terrorized in their own communities.%0D%0A%0D%0A" +
    "Sincerely,%0D%0A";
```

---

## Additional Template Change: Add Governor Paper Letter Download

In the Governor Healey section of the campaign template, add a button to download the Governor letter PDF.

### Add this button after the existing Governor contact form button:

```html
<a href="<?php echo esc_url( home_url('/wp-content/uploads/2025/12/MA_Governor_Letter_Sample.pdf') ); ?>" 
   class="action-button secondary" 
   download
   style="display: inline-block; background: #6c757d; color: white; padding: 15px 25px; font-size: 16px; font-weight: bold; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; text-align: center; margin-top: 15px;">
    📄 Download Governor Letter (PDF)
</a>
```

**Note:** You'll need to upload the Governor letter sample PDF to this location, or update the URL to match where you upload it.

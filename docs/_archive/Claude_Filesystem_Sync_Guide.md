# Claude Filesystem Permissions Sync Guide

**Last Updated:** 2025-01-08  
**Preferred Environment:** Claude Desktop (MCP filesystem)

## Overview

Claude has two separate environments with independent filesystem permissions:

| Environment | Tool Name | Config Location |
|-------------|-----------|-----------------|
| **Claude Desktop** (preferred) | `filesystem` (lowercase) | `~/Library/Application Support/Claude/claude_desktop_config.json` |
| **Claude.ai (web)** | `Filesystem:` (uppercase) | Project Settings → Files → Allowed Directories |

These do NOT sync automatically. When adding new directories, update both.

---

## Master Directory List

All directories that should be accessible in both environments:

### Active Project Directories
- [ ] `/Users/jtsackton/Library/CloudStorage/ProtonDrive-info@lexingtonalarm.org-folder/Secure Website Materials` — HFW, secure docs
- [ ] `/Users/jtsackton/Desktop/LexingtonAlarm_Docs` — LA documentation
- [ ] `/Users/jtsackton/Local Sites/la-wordpress-local` — WordPress local dev
- [ ] `/Users/jtsackton/Documents/Massport Campaign` — Massport work

### Seafood/Writing Projects
- [ ] `/Volumes/Seafood_Knowledge` — Seafood RAG system
- [ ] `/Users/jtsackton/Documents/winding glass 40 years` — Winding Glass archive
- [ ] `/Users/jtsackton/Documents/2025-26 projects/Data Files` — Data files
- [ ] `/Users/jtsackton/Documents/2025-26 projects/FCC 2025` — FCC project
- [ ] `/Users/jtsackton/Documents/2025-26 projects/2024-25 projects/2025 projects/New Brunswick/completed for translators`
- [ ] `/Users/jtsackton/Documents/2025-26 projects/2024-25 projects/2025 projects/Newfoundland crab`

### Personal
- [ ] `/Users/jtsackton/vault` — Obsidian vault

---

## How to Update Each System

### Claude Desktop (MCP) — Primary

Edit the config file:
```zsh
open "/Users/jtsackton/Library/Application Support/Claude/claude_desktop_config.json"
```

Add directories to the `args` array in the `filesystem` server section:
```json
"filesystem": {
  "command": "npx",
  "args": [
    "-y",
    "@modelcontextprotocol/server-filesystem",
    "/path/to/new/directory",
    ... existing directories ...
  ]
}
```

**After editing:** Quit and restart Claude Desktop for changes to take effect.

### Claude.ai (Web)

1. Open the project at claude.ai
2. Click project name → Settings (gear icon)
3. Scroll to "Files" or "Filesystem" section
4. Add allowed directories one at a time
5. Save

---

## Why You Might Be in Claude.ai

You may have ended up in the web interface if:
- Clicked a claude.ai link
- Used the mobile app
- Desktop app wasn't running
- Opened a shared conversation link

**To return to Desktop:** Open Claude Desktop app directly. Your projects there are separate from claude.ai projects.

---

## Sync Checklist (When Adding New Directory)

- [ ] Add to `claude_desktop_config.json`
- [ ] Restart Claude Desktop
- [ ] Add to claude.ai project settings (if using web)
- [ ] Update this document's Master Directory List
- [ ] Test access in both environments

---

## Current Sync Status

**Claude Desktop (MCP):** ✅ Has all directories per config.json

**Claude.ai (this project):** ❌ Missing:
- `/Volumes/Seafood_Knowledge`
- `/Users/jtsackton/vault`
- `/Users/jtsackton/Documents/winding glass 40 years`
- `/Users/jtsackton/Library/CloudStorage/ProtonDrive-info@lexingtonalarm.org-folder/Secure Website Materials`
- `/Users/jtsackton/Documents/Massport Campaign`

**Action needed:** Add missing directories to claude.ai project settings, OR switch to Claude Desktop for HFW work.

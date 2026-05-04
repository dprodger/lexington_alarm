/* Autocomplete helper for fields that take Jinja2-style {{ var }} placeholders.
 *
 * Behaviour:
 *   - Type "{{ "  → popup of top-level scopes (writer, target, date, ...).
 *   - Type "scope." → popup of that scope's attributes.
 *   - Arrow keys navigate, Enter / Tab accept, Escape dismisses.
 *   - Clicking a row also accepts.
 *   - Attribute completions auto-close with " }}" so the user can keep going.
 *
 * The schema is supplied via `window.PLACEHOLDER_SCHEMA` (set by an inline
 * script in the template, populated from routes_admin.PLACEHOLDER_SCHEMA).
 * Attach by adding `class="placeholder-aware"` to the input/textarea.
 */

(function () {
  const SCHEMA = window.PLACEHOLDER_SCHEMA || {};

  let popupEl = null;
  let activeField = null;
  let activeMatches = [];
  let activeIndex = 0;
  let activeMatchInfo = null;  // { type, prefix, scope }

  function init() {
    document.querySelectorAll(".placeholder-aware").forEach(attach);
  }

  function attach(field) {
    field.addEventListener("input", () => updateForField(field));
    field.addEventListener("keydown", onKeyDown);
    field.addEventListener("click", () => updateForField(field));
    field.addEventListener("keyup", onKeyUp);
    field.addEventListener("blur", () => setTimeout(hidePopup, 150));
  }

  function onKeyUp(e) {
    // Catch arrow keys / Home / End that move the caret without firing input.
    if (["ArrowLeft", "ArrowRight", "Home", "End"].indexOf(e.key) !== -1) {
      updateForField(e.target);
    }
  }

  function onKeyDown(e) {
    if (!popupEl || popupEl.style.display === "none" || activeField !== e.target) return;
    if (e.key === "ArrowDown") {
      e.preventDefault();
      activeIndex = (activeIndex + 1) % activeMatches.length;
      renderPopup();
    } else if (e.key === "ArrowUp") {
      e.preventDefault();
      activeIndex = (activeIndex - 1 + activeMatches.length) % activeMatches.length;
      renderPopup();
    } else if ((e.key === "Enter" || e.key === "Tab") && activeMatches.length > 0) {
      e.preventDefault();
      applySelection(activeMatches[activeIndex]);
    } else if (e.key === "Escape") {
      e.preventDefault();
      hidePopup();
    }
  }

  function updateForField(field) {
    activeField = field;
    const cursor = field.selectionStart;
    const match = parseAtCursor(field.value, cursor);
    if (!match) {
      hidePopup();
      return;
    }
    let candidates;
    if (match.type === "scope") {
      candidates = Object.keys(SCHEMA);
    } else {
      candidates = SCHEMA[match.scope];
      if (!Array.isArray(candidates)) {
        // Unknown scope, or a leaf (e.g. `date.something`) — nothing to suggest.
        hidePopup();
        return;
      }
    }
    const lowerPrefix = match.prefix.toLowerCase();
    const filtered = candidates.filter(c => c.toLowerCase().startsWith(lowerPrefix));
    // If the prefix already exactly matches the only candidate, the user has
    // finished typing it — no need to keep popping the menu.
    if (filtered.length === 0 ||
        (filtered.length === 1 && filtered[0] === match.prefix)) {
      hidePopup();
      return;
    }
    activeMatchInfo = match;
    activeMatches = filtered;
    activeIndex = 0;
    showPopup(field);
  }

  function parseAtCursor(text, cursor) {
    const before = text.substring(0, cursor);
    const lastOpen = before.lastIndexOf("{{");
    if (lastOpen === -1) return null;
    const lastClose = before.lastIndexOf("}}");
    if (lastClose > lastOpen) return null;
    const inner = before.substring(lastOpen + 2);
    if (inner.indexOf("\n") !== -1) return null;
    const stripped = inner.replace(/^\s*/, "");
    // Only continue if what's left looks like a partial placeholder identifier.
    if (!/^[a-zA-Z0-9_.]*$/.test(stripped)) return null;
    const dotIdx = stripped.indexOf(".");
    if (dotIdx === -1) {
      return { type: "scope", prefix: stripped };
    }
    return {
      type: "attribute",
      scope: stripped.substring(0, dotIdx),
      prefix: stripped.substring(dotIdx + 1),
    };
  }

  function applySelection(name) {
    const field = activeField;
    const match = activeMatchInfo;
    if (!field || !match) return;
    const cursor = field.selectionStart;
    const before = field.value.substring(0, cursor);
    const after = field.value.substring(cursor);
    const replaceStart = cursor - match.prefix.length;
    let insertion = name;
    let cursorOffset = name.length;
    if (match.type === "attribute") {
      // Attribute completions auto-close with " }}" and put cursor after it.
      insertion = name + " }}";
      cursorOffset = insertion.length;
    }
    field.value = before.substring(0, replaceStart) + insertion + after;
    const newCursor = replaceStart + cursorOffset;
    field.setSelectionRange(newCursor, newCursor);
    field.focus();
    hidePopup();
    field.dispatchEvent(new Event("input", { bubbles: true }));
  }

  function showPopup(field) {
    if (!popupEl) {
      popupEl = document.createElement("div");
      popupEl.className = "placeholder-popup";
      // mousedown.preventDefault keeps the textarea focused so Enter/click work.
      popupEl.addEventListener("mousedown", e => e.preventDefault());
      document.body.appendChild(popupEl);
    }
    renderPopup();
    positionPopup(field);
    popupEl.style.display = "block";
  }

  function renderPopup() {
    if (!popupEl) return;
    popupEl.innerHTML = "";
    activeMatches.forEach((m, i) => {
      const item = document.createElement("div");
      item.className = "placeholder-popup-item" + (i === activeIndex ? " active" : "");
      item.textContent = m;
      item.addEventListener("click", () => applySelection(m));
      popupEl.appendChild(item);
    });
  }

  function positionPopup(field) {
    const rect = field.getBoundingClientRect();
    popupEl.style.position = "fixed";
    popupEl.style.left = rect.left + "px";
    popupEl.style.top = (rect.bottom + 4) + "px";
    popupEl.style.minWidth = "180px";
    popupEl.style.maxWidth = Math.max(rect.width, 240) + "px";
  }

  function hidePopup() {
    if (popupEl) popupEl.style.display = "none";
    activeMatches = [];
    activeIndex = 0;
    activeMatchInfo = null;
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();

/* Drag-and-drop reordering for any list with a `data-reorder-list` element.
 *
 * Markup contract:
 *
 *   <ul class="..." data-reorder-list data-reorder-url="/.../reorder">
 *     <li data-reorder-id="123">
 *       <span class="drag-handle">⋮⋮</span>
 *       ...
 *     </li>
 *   </ul>
 *
 *   The wrapper can be any element; children that should be reorderable need
 *   `data-reorder-id`. Drag is initiated only from a `.drag-handle` inside
 *   the row, so links and form controls inside the row stay usable. Each
 *   list runs in its own closure, so the dragged item from list A isn't
 *   accepted as a drop target in list B.
 *
 *   On dragend the page sends the new order to `data-reorder-url` as
 *   ``ids[]=...&ids[]=...``; the server is expected to reply 204.
 */
(function () {
  document.querySelectorAll("[data-reorder-list]").forEach(initList);

  function initList(list) {
    const url = list.dataset.reorderUrl;
    if (!url) return;
    let dragged = null;

    list.querySelectorAll("[data-reorder-id]").forEach(item => {
      item.setAttribute("draggable", "true");

      // Only let drag start when grabbing the handle. mousedown elsewhere
      // marks the row non-draggable so clicks/edits inside still work.
      item.addEventListener("mousedown", e => {
        const onHandle = e.target.closest && e.target.closest(".drag-handle");
        item.setAttribute("draggable", onHandle ? "true" : "false");
      });

      item.addEventListener("dragstart", e => {
        dragged = item;
        item.classList.add("dragging");
        // Collapse a `<details>` row so the dragged-around element stays
        // one line; otherwise the open form bloats the layout while in flight.
        if (item.tagName === "DETAILS" && item.open) item.open = false;
        e.dataTransfer.effectAllowed = "move";
        // Some browsers require setData to allow the drag at all.
        e.dataTransfer.setData("text/plain", item.dataset.reorderId || "");
        // Use the summary line as the drag preview rather than the whole row.
        const summary = item.querySelector(":scope > summary");
        if (summary && e.dataTransfer.setDragImage) {
          e.dataTransfer.setDragImage(summary, 0, 0);
        }
      });

      item.addEventListener("dragend", () => {
        if (!dragged) return;
        dragged.classList.remove("dragging");
        dragged = null;
        saveOrder();
      });

      item.addEventListener("dragover", e => {
        // Closure-scoped `dragged` is null when a drag started in a different
        // list, so cross-list drops never call preventDefault and the browser
        // rejects them.
        if (!dragged || dragged === item) return;
        e.preventDefault();
        const rect = item.getBoundingClientRect();
        const before = (e.clientY - rect.top) < rect.height / 2;
        list.insertBefore(dragged, before ? item : item.nextSibling);
      });
    });

    // Clicking the handle should not toggle the parent <details> (when the
    // row uses one) or otherwise activate.
    list.querySelectorAll(".drag-handle").forEach(h => {
      h.addEventListener("click", e => {
        e.preventDefault();
        e.stopPropagation();
      });
    });

    function saveOrder() {
      const ids = Array.from(list.querySelectorAll("[data-reorder-id]"))
        .map(i => i.dataset.reorderId)
        .filter(Boolean);
      const params = new URLSearchParams();
      ids.forEach(id => params.append("ids[]", id));
      fetch(url, {
        method: "POST",
        body: params,
        credentials: "same-origin",
      });
    }
  }
})();

# Forsale Search Page — UI Stability Analysis & Fixes (Phase 1)

## TASK 1 — UI BLOCKING & FREEZE SOURCES

### 1) JavaScript that blocks the main thread or fires repeatedly

| Location | What happens | Why it can cause lag/freeze |
|----------|--------------|-----------------------------|
| **car_search_form.blade.php** — delegated click on `.dropdown-item` | On every dropdown option click: `applyDropdownItemSelection()` then **immediately** `postFilterForm(form)`. No debounce. | Rapid clicks (e.g. scrolling through options and clicking) trigger a **new POST to /filter** on every click. Each request is in-flight until the server responds. |
| **car_search_form.blade.php** — `postFilterForm()` | Builds `FormData`, creates XHR, sends request. On response: `applyFacetsToForm(form, payload.facets)` then `updateForsaleResults(payload, form)`. | **applyFacetsToForm** rebuilds **all** dropdown lists (make, model, variant, body_type, engine_size, fuel_type, gear_box, doors, colors, seller_type, year_from, year_to, price, miles) by setting `listEl.innerHTML = ''` and appending many nodes. **updateForsaleResults** does `grid.innerHTML = payload.cars_html` (full results grid replace). Both are **synchronous, main-thread** DOM work. Large payloads = long blocking time. |
| **car_search_form.blade.php** — `rebuildLists()` inside `applyFacetsToForm` | For each facet config: `rebuild(desktopList)` and `rebuild(mobileList)` — each clears list and appends many `<li>`/`<a>` nodes. | Multiple `querySelector`/`appendChild`/innerHTML in a tight loop. No yielding to the browser; one big synchronous run per response. |
| **forsale_page.blade.php** — `setSortOption()` | Re-sorts existing card nodes by moving them in the DOM (`container.appendChild(frag)`). | Runs synchronously; for many cards can cause reflow/layout. Less severe than full grid replace but still main-thread. |

### 2) Multiple concurrent requests and responses doing heavy DOM work

| Location | What happens | Why it can cause issues |
|----------|--------------|-------------------------|
| **postFilterForm** | Each dropdown click starts a **new** XHR. Previous XHR is **not** aborted. Only a **sequence number** (`form.dataset.reqSeq`) is used to **ignore** out-of-order responses (if response N arrives after N+1, it’s discarded). | Multiple requests can be in flight. When response 1 arrives late after response 2, it’s correctly ignored for *applying* data, but **response 2’s handler has already run** — so we don’t double-apply. However: **every** response that matches the current seq still runs **applyFacetsToForm** + **updateForsaleResults** in full. Rapid clicks → many responses in short order → **multiple full DOM rebuilds** (one per response that “wins” or runs before being superseded). So we can get **stacked** DOM work from several responses. |
| **Load more** (forsale_page) | Fetches next page and appends HTML to `#mobilelayout`. Uses `isLoading` to prevent double load-more. | Does **not** coordinate with hero form’s **postFilterForm**. So: user changes filter (hero) → POST /filter in flight; user scrolls → load more runs → GET page 2. Both can complete and update the grid (filter response replaces grid, load more appends). Order depends on timing; grid can be wrong or flicker. Not the main cause of “freeze” but can add to confusion. |

### 3) Re-render / DOM replacement patterns that could cause visible freezing

| Pattern | Where | Why it can freeze |
|---------|--------|-------------------|
| **Full grid replace** | `updateForsaleResults`: `grid.innerHTML = payload.cars_html` | Replaces the entire results container in one go. Browser must parse the HTML string, build a subtree, replace children, and reflow. For 20+ cards with images and structure, this is a **large** synchronous layout/paint cost. |
| **Full list rebuilds** | `rebuildLists` for each facet: `listEl.innerHTML = ''` then many `appendChild`s | Multiple dropdowns (desktop + mobile lists) are rebuilt in one go. Each rebuild clears and re-adds many nodes. No `requestAnimationFrame` or chunking — all in one tick. |
| **No yielding** | Entire response handler runs in one synchronous block: parse JSON → applyFacetsToForm → updateForsaleResults → setSearchButtonLoading(false) | Main thread is busy until all DOM updates finish. If the user clicks again during that time, another request may already be sent (no debounce), so the thread stays busy. |

---

## TASK 2 — SCROLL LOCK & HEADER BEHAVIOR

### What locks the scroll?

| Mechanism | Where | When |
|-----------|--------|------|
| **Body class `forsale-filter-open`** | forsale_page.blade.php CSS: `body.forsale-filter-open { overflow: hidden !important; position: fixed !important; width: 100%; height: 100%; }` | Added in: (1) **Filter modal** `openFilter()` on `show.bs.modal` / `shown.bs.modal` when mobile (≤990px); (2) **Mobile search panel** `openPanel()` when mobile (≤768px). |
| **Body overflow** | car_search_form.blade.php `setBodyScrollLocked(true)` | Sets `document.body.style.overflow = 'hidden'` when a **custom-select modal** (hero form dropdown on mobile) is opened. Saves previous overflow in `document.body.dataset.prevOverflow`. |

### What unlocks the scroll?

| Mechanism | Where | When |
|-----------|--------|------|
| **Remove body class** | forsale_page.blade.php `closeFilter()` | Called on filter modal `hide.bs.modal` / `hidden.bs.modal`. Removes `forsale-filter-open` and restores `savedScrollY` via `requestAnimationFrame`. |
| **Remove body class** | forsale_page.blade.php `closePanel()` | Called when closing the mobile search panel (close button, Escape). Removes `forsale-filter-open` and restores scroll. |
| **Restore overflow** | car_search_form.blade.php `setBodyScrollLocked(false)` | Restores `document.body.style.overflow` from `dataset.prevOverflow` when custom-select modal is closed (item selected or close). |

### Where cleanup can fail

| Scenario | Why cleanup can fail |
|----------|----------------------|
| **Hero form submit on mobile (forsale page)** | Form submit handler (car_search_form) does **not** remove `forsale-filter-open`. It only does: `container.classList.remove('show')` and `document.body.style.overflow = ''`. So after “Search” on the hero panel, the **body keeps** `forsale-filter-open` → navbar stays hidden (CSS: `body.forsale-filter-open .navbar { display: none !important }`) and body stays `position: fixed` → **scroll remains trapped**. |
| **Bootstrap modal doesn’t fire `hidden.bs.modal`** | If the filter modal is closed in an unusual way (e.g. DOM removal, rapid double-close, or Bootstrap bug), `closeFilter()` might never run → `forsale-filter-open` stays → scroll and navbar stay locked. |
| **Two scroll-lock mechanisms** | Filter modal / search panel use **class**; custom-select uses **overflow**. If one path fails to restore (e.g. class not removed), the other’s restoration is not enough — body can stay fixed. |
| **popstate** | Back button handler calls `__forsaleCloseFilterModal()` or `__forsaleCloseSearchPanel()`. Those trigger Bootstrap hide or the panel’s close logic, which should fire the same cleanup. So popstate itself is OK **if** the underlying close functions run. If they don’t (e.g. modal already gone), popstate doesn’t remove the class itself. |

### Why the header sometimes does not reappear

- **Primary:** After applying filters from the **hero form** on mobile, the submit handler closes the panel but **never removes** `forsale-filter-open`. The navbar is hidden by `body.forsale-filter-open .navbar { display: none !important }`, so it stays hidden until refresh or another close path runs.
- **Secondary:** If the filter modal is closed without `hidden.bs.modal` firing, `closeFilter()` never runs, so the class (and thus the navbar) is never restored.

---

## TASK 3 — SAFE STABILITY FIXES (UI ONLY)

Proposed minimal, low-risk changes **without** changing filter logic, backend, or data/count logic:

1. **Debounce `postFilterForm`** (e.g. 300–350 ms) so rapid dropdown clicks send one request per “burst” and reduce stacked DOM updates.
2. **Abort previous XHR** when starting a new `postFilterForm` (store the active XHR on the form and call `.abort()` before sending a new one). Ensures only the latest request’s response does DOM work (seq check already ignores stale responses; abort reduces server load and avoids redundant work).
3. **Fix hero form submit close** so that when we close the mobile search panel after submit on the forsale page, we **remove** `forsale-filter-open` and restore scroll (e.g. call `window.__forsaleCloseSearchPanel()` if available instead of only removing `show` and `overflow`). This restores navbar and scroll after “Search” on mobile.
4. **Yield before heavy DOM work** in the filter response handler: run `applyFacetsToForm` and `updateForsaleResults` inside `requestAnimationFrame` (or a single `setTimeout(..., 0)`) so the browser can paint/process input before doing the big DOM updates. Reduces perceived freeze; no change to filter logic.
5. **Defensive cleanup on forsale page** (optional): When the filter modal is closed (e.g. on `hidden.bs.modal`), ensure body class is removed. Already done in `closeFilter`. Optionally, add a small guard that removes `forsale-filter-open` when the modal is not shown (e.g. on `visibilitychange` or when panel is not open) to recover from edge cases. Can be minimal (e.g. only remove class if modal/panel are both closed).

---

## TASK 4 — IMPLEMENTATION PLAN

| # | Change | File(s) / functions | Prevents |
|---|--------|---------------------|----------|
| 1 | Debounce `postFilterForm` by ~300 ms | car_search_form.blade.php — `postFilterForm`, and the delegated click that calls it | Multiple requests per rapid interaction; stacked DOM updates from many responses. |
| 2 | Abort previous XHR when starting a new `postFilterForm` | car_search_form.blade.php — inside `postFilterForm`, store `form._filterXhr`, abort if set, then assign new XHR | Stale responses and redundant DOM work; server load. |
| 3 | On hero form submit (forsale + mobile), close panel via `__forsaleCloseSearchPanel` | car_search_form.blade.php — form `submit` handler: when closing panel, call `window.__forsaleCloseSearchPanel()` instead of only removing `show` and `overflow` | Scroll trap and navbar not reappearing after “Search” on mobile. |
| 4 | Run applyFacetsToForm + updateForsaleResults in requestAnimationFrame | car_search_form.blade.php — in XHR `onreadystatechange`, wrap `applyFacetsToForm`, `updateForsaleResults`, and related UI updates in one `requestAnimationFrame` callback | Long main-thread block in one tick; improves responsiveness. |
| 5 | (Optional) Defensive remove of `forsale-filter-open` when modal/panel are closed | forsale_page.blade.php — e.g. in `closeFilter` and in a guard when panel closes, or on visibility change | Header/scroll stuck if Bootstrap or close path fails to fire. |

---

## TASK 5 — STABILITY TEST CHECKLIST

Manual tests to confirm stability (no filter correctness checks):

1. **Page never freezes**  
   - Open hero search (mobile), change make then model then fuel type quickly (several clicks in &lt; 2 s). Page should remain responsive; no long white freezes.  
   - Open filter modal, change 2–3 selects, Apply. Page should not freeze.

2. **Scroll always works after closing any menu**  
   - Mobile: open filter modal → close (X or backdrop). Scroll the page → should scroll.  
   - Mobile: open hero search panel → close (Close or Escape). Scroll → should scroll.  
   - Mobile: open hero search, pick an option from a dropdown (custom-select), close. Scroll → should scroll.  
   - Mobile: open hero search, click “Search” (submit). After results load, scroll → should scroll (no trap).

3. **Header always returns**  
   - Mobile: open filter modal → close. Navbar should be visible again.  
   - Mobile: open hero search panel → close. Navbar should be visible.  
   - Mobile: open hero search, click “Search”. After results load, navbar should be visible (no permanent hide).

4. **Responsive under rapid interaction**  
   - Rapidly open/close filter modal 2–3 times. No stuck overlay; scroll and navbar OK.  
   - Rapidly open hero panel, change make twice quickly, close. No freeze; final state correct.

5. **Back button**  
   - Mobile: open filter modal → browser Back. Modal should close; scroll and navbar restored.  
   - Mobile: open hero panel → Back. Panel should close; scroll and navbar restored.

---

STOP AFTER THIS PHASE.  
Wait for confirmation before moving to filter correctness issues.

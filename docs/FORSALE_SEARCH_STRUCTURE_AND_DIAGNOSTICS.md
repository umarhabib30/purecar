# Car Dealership Search Page — Structure Map & Diagnostics

## Section 1: Architecture Map

### 1.1 Which files/components control what

| Area | Primary file(s) | Notes |
|------|-----------------|--------|
| **Search page (route / view)** | `routes/web.php`: `Route::view('/forsalepage','forsale_page')` (view-only) and `Route::match(['get','post'], '/forsalesfilter', [CarController::class, 'search_car'])` → `CarController::search_car` returns `view('forsale_page', ...)`. | The “live” search page is served by **GET/POST /forsalesfilter** (name: `forsale_filter`). **/forsalepage** is view-only and does not pass `$cars`, `$search_field`, etc. — so either that route is unused or a View Composer supplies data (not found in codebase). |
| **Filter UI – hero (mobile search panel)** | `resources/views/partials/car_search_form.blade.php` (included in `forsale_page.blade.php` as `#mobileSearchForm` with `formId => 'heroSearchForm'`). | Dropdowns (make, model, variant, year_from, year_to, price_from, price_to, fuel_type, miles, etc.) with hidden inputs; desktop = Bootstrap dropdowns, mobile = custom full-screen modals (`.custom-select-modal`). |
| **Filter UI – modal (Filter & Sort)** | `resources/views/forsale_page.blade.php`: `#filterModal` (Bootstrap modal), form `method="POST" action="{{ route('forsale_filter') }}"` (~line 1053). | Native `<select>` elements for make, model, variant, year_from, year_to, price_from, price_to, fuel_type, miles, gear_box, seller_type, body_type, doors, engine_size, colors. |
| **Results list** | `resources/views/partials/car_list.blade.php` (included in `forsale_page.blade.php` inside `#mobilelayout`). | Renders `$cars` (paginated). Grid container: `#mobilelayout` with `data-next-page-url`, `data-prev-page-url`, `data-current-page`, `data-last-page`, `data-filter-query`. |
| **Header / top bar** | `forsale_page.blade.php`: `#topbarpadding` (~line 779) – filter chips + “Filter & Sort” + count (“X used cars found”) + sort dropdown. Layout navbar: `resources/views/layout/layout.blade.php` (`.navbar`). | Top bar is initially `display:none !important` (line 780). Sticky at `min-width: 999px` (lines 119–130: `position: sticky; top: 0; z-index: 1000`). |
| **Overlay / scroll lock** | `forsale_page.blade.php` inline scripts: (1) `#filterModal` `show.bs.modal` / `hide.bs.modal` add/remove `body.forsale-filter-open`; (2) `#mobileSearchForm` open/close toggles same class; (3) `car_search_form.blade.php`: custom-select modals set `body.style.overflow = 'hidden'` via `setBodyScrollLocked(true)`. | CSS: `body.forsale-filter-open { overflow: hidden; position: fixed; ... }`, `body.forsale-filter-open .navbar { display: none !important }` (max-width 990px). |

### 1.2 Where filter state lives

| Location | What lives there |
|----------|-------------------|
| **URL (query string)** | Used after **full-page** apply: form in `#filterModal` POSTs to `/forsalesfilter`, then server redirects/renders with new URL. **Load more** builds URLs from `#mobilelayout` `data-filter-query` + `page`. Hero form **does not** update URL when using AJAX (it POSTs to `/filter` and updates DOM only). |
| **Local component state (DOM)** | **Hero form:** hidden inputs (e.g. `#makeInput`, `#yearfromInput`, `#yeartoInput`, …) and dropdown button labels. **Modal:** native `<select>` values; chip buttons reflect server-rendered `$makeselected`, etc. So “applied” filter state is either URL + server-rendered HTML (modal path) or DOM hidden inputs + labels (hero path). |
| **Global store** | None (no Redux/Zustand/Context). |
| **Server session** | Not used for filter state. |

### 1.3 Selected/draft vs applied filter values

- **Modal (#filterModal):**
  - **Draft:** User changes `<select>` values while the modal is open.
  - **Applied:** On “Apply Filters”, form POSTs to `/forsalesfilter` → full page reload; applied = whatever the server renders in the new HTML (from `$request` in `CarController::search_car`).
  - No client-side “draft” copy; closing without submit discards changes.

- **Hero form (car_search_form):**
  - **Draft:** Every dropdown selection updates the corresponding hidden input and button label immediately.
  - **Applied:** Each selection also triggers `postFilterForm(form)` → POST to `/filter` → response updates facets and results. So **every selection is applied immediately** (no separate “Apply” for the hero form on the forsale page).
  - “Draft” and “applied” are the same except for the brief period before the `/filter` response returns; out-of-order responses are guarded by `form.dataset.reqSeq` vs `requestSeq`.

### 1.4 How filters depend on each other

- **Backend (CarFacetService):**
  - Facets use “exclude-self” logic: e.g. make facet count = count with all current filters **except** make.
  - So each facet’s options/counts depend on all other applied filters.

- **Hero form (car_search_form):**
  - Make change clears model + variant and disables model/variant until facets apply.
  - Model change clears variant and disables variant until facets apply.
  - **Every** dropdown item click triggers `postFilterForm(form)` (no per-field exclusion). So **every** filter change triggers one full POST to `/filter` and a full facet + results refresh.

- **Modal:**
  - No dependency logic in JS; user can pick any combination and submit. Backend applies all submitted params together.

- **Which trigger re-fetch:**
  - **Modal:** Full POST to `/forsalesfilter` → full page load (one “fetch”).
  - **Hero:** Every dropdown selection → one POST to `/filter` (facets + results).
  - **Load more:** Scroll/button → GET to same URL (from `data-filter-query`) with next `page`; request is to the **same path as the current page** (e.g. `/forsalesfilter?...`) with `Accept: application/json`, handled by `CarController::search_car` (AJAX branch returns JSON with `html`, `next_page_url`, etc.).

- **Which recompute counts/options:**
  - **Modal:** Counts/options are recomputed only on full page load (server-side `$search_field`, `$year_counts`, `$price_counts` in `CarController::search_car`).
  - **Hero:** Counts/options come from `/filter` response `payload.facets` and are applied by `applyFacetsToForm(form, payload.facets)`.

### 1.5 How results are fetched

| Mechanism | Endpoint | Query building | Debounce / throttle | Pagination |
|-----------|----------|----------------|---------------------|------------|
| Full page load (modal apply or first load) | GET/POST `/forsalesfilter` → `CarController::search_car` | Request validation then Eloquent query with filters (make, model, variant, fuel_type, miles, year_from, year_to, price_from, price_to, etc.). Sort from `sort` param; default `inRandomOrder()`. | N/A (form submit). | `$query->paginate(20)->appends($validated)`. |
| Hero form (AJAX) | POST `/filter` → `FilterSearchPageController::filter` | `CarFacetService::applyRequestFilters($baseQuery, $request, ...)`; then `$cars = (clone $baseQuery)->orderByDesc('car_id')->paginate(20)`. | **None.** Every dropdown click sends a new POST. | Paginate 20; response returns `cars_html`, `current_page`, `last_page`, `next_page_url`, `prev_page_url`. |
| Load more (infinite scroll / button) | Same URL as current page (e.g. `/forsalesfilter?make=...&page=2`) with `Accept: application/json` | Handled by `CarController::search_car`; reads same query params from URL (built from `#mobilelayout` `data-filter-query` + `page`). | None (one request per scroll/click). | `buildNextUrl(nextPage)`; appends new HTML to `#mobilelayout` and updates `currentPage` / `lastPage` from response. |

### 1.6 How filter option counts are calculated

- **Full page (modal path):**
  - **Backend-driven**, in `CarController::search_car`.
  - `$search_field` (make, model, variant, fuel_type, gear_box, body_type, doors, engine_size, colors, seller_type) = **global** counts (no other filters applied): e.g. `Car::select('make', DB::raw('COUNT(*) as count'))->whereHas('advert', ...)->groupBy('make')->get()`.
  - Year: `$year_counts` per year, then `$year_counts_to` / `$year_counts_from` (cumulative); price: `$price_counts` from fixed breakpoints.
  - So **modal dropdown counts are not contextual**; they do not reflect “with current filters”.

- **Hero form (AJAX path):**
  - **Backend-driven**, from `FilterSearchPageController::filter` → `CarFacetService::buildFacets` with exclude-self logic.
  - Counts **are** contextual (all other filters applied, excluding the facet’s own field).
  - Same response also returns the results list (`cars_html`, `total`).

- **Source:**
  - Modal: counts from the **same** full-page response as results, but computed with **different** logic (global vs filtered).
  - Hero: counts and results from the **same** `/filter` response (both from the same filtered query + facet build).

### 1.7 Mileage in data

- **DB:** `cars.miles` is `integer`, **nullable** (migration).
- **Filtering:**
  - `CarController::search_car`: `if (!empty($validated['miles'])) { $query->where('miles', '<=', $validated['miles']); }` → rows with `miles = null` are excluded when miles filter is set.
  - `CarFacetService::applyRequestFilters`: `where('miles', '<=', (int)$val)` → same.
  - Facet buckets in `CarFacetService::buildFacets`: `whereNotNull('miles')` then bucket by ranges → nulls excluded from facet counts.
- **Display:** `car_list.blade.php`: `isset($car_data['miles']) ? number_format(...) . ' miles' : 'N/A'`.
- So: **null** = no value / N/A; **0** is valid if present in DB. Empty string not used for filtering (validated as numeric). No special “empty” sentinel beyond null.

### 1.8 How the filter overlay affects layout

- **Body scroll:**
  - `body.forsale-filter-open`: `overflow: hidden`, `position: fixed`, `width/height: 100%`. Applied when `#filterModal` or `#mobileSearchForm` opens (mobile).
  - Custom-select modals (hero form on mobile) use `setBodyScrollLocked(true)` (sets `document.body.style.overflow = 'hidden'`).
  - So **two** mechanisms can lock scroll (class + overflow), and custom-select uses a different one than the modal.

- **Header/navbar visibility:**
  - `body.forsale-filter-open .navbar { display: none !important }` (max-width 990px). So when the **modal** or **mobile search panel** is open (class on body), navbar is hidden.
  - Top bar `#topbarpadding`: `position: sticky; top: 0; z-index: 1000` at min-width 999px; initially `display: none !important` (line 780). When/whether it is shown is not clearly driven by a single event in the snippets seen (e.g. scroll or filter update). **Unknown / needs confirmation** for exact show/hide logic.

- **z-index:**
  - Filter modal: `#filterModal` style `z-index: 10000`; `.modal-header` inside it `z-index: 1000`.
  - Hero search panel (mobile): `.desktop-hero-section-text` full-screen panel `z-index: 75`; custom-select modals `z-index: 100000`.
  - Filter scroll buttons: `.filter-scroll-container` `z-index: 997`.
  - Navbar (layout): `z-index: 999`. So modal (10000) and custom-select (100000) sit above navbar; filter bar (997) can sit below it.

- **Spacing:** Modal uses full-height layout (`height: 100vh/100dvh`), sticky footer; no explicit spacing conflict noted beyond possible double scroll-lock and top bar visibility.

---

## Section 2: Filter State Flow (diagram-style)

- **Entry:** User lands on search (assumed **/forsalesfilter** with or without query params) → `CarController::search_car` → view with `$cars`, `$search_field`, `$year_counts*`, `$price_counts`, selected vars (`$makeselected`, …), `initialFacets`, `totalCount`, etc.
- **Modal path:**
  - User opens `#filterModal` → body gets `forsale-filter-open` (scroll lock, navbar hide).
  - User changes selects → draft in DOM only.
  - “Apply Filters” → POST to `/forsalesfilter` → full reload → new URL + new HTML (results + modal options + chips).
  - Modal closes on submit; `hidden.bs.modal` removes `forsale-filter-open`.
- **Hero path (forsale page):**
  - Form has `action="{{ route('filter') }}"`, `data-initial-facets='@json($initialFacets ?? null)'`.
  - If `initialFacets` present and URL not hydrated → no initial `/filter` call; else (or if URL has params) → `postFilterForm(form)` runs on load.
  - User selects e.g. Make → `applyDropdownItemSelection` → update hidden input + label, clear model/variant, then `postFilterForm(form)` → POST /filter with FormData(form) → response: `facets` + `cars_html`, `total`, pagination.
  - `applyFacetsToForm(form, payload.facets)` rebuilds all dropdown lists; `updateForsaleResults(payload, form)` replaces `#mobilelayout` innerHTML, updates `data-*`, total text, and dispatches `pc:forsale-results-updated`.
  - **No debounce:** each dropdown click = one POST.
- **Load more:**
  - Uses `#mobilelayout` `data-filter-query` and `data-current-page` / `data-last-page`.
  - Fetches same path + query string + `page=N`, `Accept: application/json` → `CarController::search_car` AJAX branch → append HTML, update dataset and UI.
  - If the last results came from **hero** `/filter`, `data-filter-query` is set from `buildFilterQueryFromForm(form)` (hidden inputs). So load-more URL is built from hero form state, not from the current page’s URL. If the user had applied filters via **modal** (full reload), URL and `data-filter-query` come from the server-rendered page.

---

## Section 3: Data & Fetch Flow

- **Two filter UIs, two backends:**
  - **Modal:** POST `/forsalesfilter` → `CarController::search_car` (full page). Builds **global** facet counts (`$search_field`, etc.) and filtered results.
  - **Hero:** POST `/filter` → `FilterSearchPageController::filter` → `CarFacetService::buildFacets` (exclude-self) + same query for results; returns JSON with `facets`, `cars_html`, `total`, pagination.
- **Param naming:**
  - Modal and hero use `year_from` / `year_to` in HTML.
  - `CarController::search_car` sets `$yeartoselected = $request->input('year')` but the modal form sends `year_to` → **mismatch**: “Year To” selected value may not show after modal apply.
  - `getFilteredFieldssale` (if ever used from frontend) uses `yearfrom` / `yearto` in the request; forsale modal does not use that endpoint.
- **Colors:**
  - `CarController::search_car` filters by `advert_colour` (LIKE).
  - `CarFacetService::applyRequestFilters` uses `whereIn('colors', $colors)`.
  - Car model has both `colors` and `advert_colour`. So **/filter** and **/forsalesfilter** may disagree on which column is used for “colors” unless they are kept in sync elsewhere.
- **Sort (modal):** Modal has `<select name="sort">` and submits with the form. Hero form has sort only in the bar dropdown (`setSortOption`), which **sorts the current DOM cards client-side** (price, mileage, “newest” by original index); it does not call the server or change `data-filter-query`. So hero “sort” is local only; modal sort is server-side.

---

## Section 4: Likely Root Causes (no solutions)

- **UI freezing**
  - **No debounce on hero form:** Every dropdown selection triggers a full POST to `/filter` and then `applyFacetsToForm` (rebuilds many lists) + `updateForsaleResults` (replaces grid innerHTML). Rapid clicks can queue many XHRs and many DOM updates.
  - **Re-render scope:** Replacing `#mobilelayout` innerHTML and rebuilding all dropdown lists on every response can cause heavy layout/paint work.
  - **Possible re-render loops:** If any dropdown or total update triggers a change that the script interprets as a new “selection” or form change, that could retrigger `postFilterForm` (no such path was seen, but worth considering).
  - **Blocking:** Main thread does the full facet apply and grid replace; no Web Worker or chunking.

- **Slow dropdowns**
  - Each option click triggers a **full** `/filter` request and **full** facet + results update before the user can interact again; perceived as “slow” dropdowns.
  - Large facet payloads and large `cars_html` strings can make parse + DOM updates slow.
  - Modal dropdowns are server-rendered and only slow on full page reload; hero dropdowns are rebuilt on every selection via AJAX.

- **Mismatched counts**
  - **Modal:** Counts are **global** (no other filters); results are **filtered**. So e.g. “BMW (50)” might show 50 while results are 12 → mismatch.
  - **Hero:** Counts are **contextual** (exclude-self). If the user switches between modal apply (full reload with global counts) and hero (AJAX with contextual counts), or if they see modal after having used hero, the two UIs can show different numbers.
  - **Two sources of truth:** Modal state = URL + server-rendered HTML; hero state = hidden inputs + labels. If the user applies with modal then changes something only in the hero form (or vice versa), the two can be out of sync and counts can look wrong.
  - **Year “to” selected:** `$yeartoselected = $request->input('year')` while form sends `year_to` → after modal apply, “Year To” chip/label may not show the selected value.

- **Race conditions / overlapping fetches**
  - Multiple rapid hero selections → multiple in-flight POSTs to `/filter`. Responses can arrive out of order; code uses `form.dataset.reqSeq` to ignore stale responses for **facet + results** update. So the **last** response wins; intermediate states can be overwritten. No cancellation of previous XHRs.
  - Load more can run while a previous load more or a hero `/filter` request is in flight; `isLoading` prevents double load-more but does not coordinate with hero form requests. So grid could be updated by `/filter` then overwritten by load-more or the opposite.
  - Initial load: if the page is rendered with `initialFacets` and the script still runs `postFilterForm` (e.g. due to `didHydrate` from URL), two sets of facets/results can be in play (initial render + AJAX response).

- **Scroll-lock / overlay cleanup**
  - **Two mechanisms:** `body.forsale-filter-open` (class) and `document.body.style.overflow` (custom-select). If one opens and the other closes, or if an error/early return skips cleanup, scroll can stay locked or navbar stay hidden.
  - **popstate:** Back button closes dropdowns/modal/panel and pushes a new state; if multiple overlays (modal + custom-select) were open, order of cleanup and history state can get tangled.
  - **Bootstrap modal:** If `hidden.bs.modal` fails to fire (e.g. rapid open/close or DOM removal), `forsale-filter-open` might not be removed.
  - **Saved scroll position:** Mobile filter modal saves `savedScrollY` and restores on close; if `closeFilter` runs in a bad order or body is still `position: fixed`, restore can be wrong.

- **Filters not sharing the same source of truth**
  - **Modal:** State = form POST → server → full page; URL is the canonical state after submit.
  - **Hero:** State = hidden inputs; URL is **not** updated on apply. So after modal apply, URL has the filters; hero form’s hidden inputs are still from the previous page or initial render until the next full load or until the hero form is used again.
  - **Counts:** Modal uses global counts; hero uses contextual counts from `/filter`.
  - **Sort:** Modal sort is in the form and applied server-side; hero sort is client-side only and not reflected in `data-filter-query` or in any server request.
  - **updateForsalePaginationFromGrid** is called from `updateForsaleResults` but has no definition in the repo → optional; if it were to sync URL or top bar from grid, that could add another source of truth.

# Changelog

All notable changes to the **Baloch Diamond** WordPress Theme will be documented in this file.

This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.6.1] - 2026-07-08

### Added
- **🎨 Slider Text Overlay Color** — pick any color for the gradient band behind slide titles/excerpts (default black).
- **🌫️ Slider Text Overlay Strength** — 0–100% range slider (5% steps): fully transparent → solid. Implemented with CSS variables (`--bd-slide-overlay-rgb` / `--bd-slide-overlay-alpha`); defaults preserve the classic look on existing sites.

---

## [1.6.0] - 2026-07-08

### Fixed
- **Independent sidebar scrolling** — scrolling inside a tall sticky sidebar no longer moves the whole page. Sidebars now scroll inside their own box (`max-height` + `overflow-y: auto` + `overscroll-behavior: contain`) with a thin, theme-colored scrollbar.

### Added
- **🌗 Default Theme Mode** — admin picks Light, Dark, or Auto (follows the visitor's OS `prefers-color-scheme`) as the site default. A visitor's own toggle choice is stored in their browser and always takes precedence.
- **Flash-free mode switching** — an inline `<head>` script applies the correct mode before first paint (no light→dark flash).
- **Custom Light Mode background color** — replace white with any color (cream, light blue, …).
- **Custom Dark Mode background color** — replace navy with any dark color (deep green, warm charcoal, …).
- **Automatic contrast-safe palettes** — from a single admin-picked background, the theme derives card, border, alt-background and muted-text shades using a WCAG luminance formula. Light backgrounds get dark text and vice-versa, even if the admin picks a "wrong" color for a mode. All derived palettes verified at ≥4.5:1 (body text) and ≥3:1 (muted text).

---

## [1.5.2] - 2026-07-08

### Added
- **📑 Paged Views: Filter Sections** — on `/page/2/` and beyond (Numbered pagination), only the Blog grid plus admin-selected sections render; page 1 always shows the full layout. Master toggle + 11 per-section checkboxes (Hero Slider enabled by default, everything else hidden). Sections enabled for paged views keep their sidebar zones.
- **Smart pagination fallback** — if "Archive Link" mode is selected but no Posts page exists (e.g. the Blog page was deleted), the blog section automatically switches to Numbered pagination so older posts always stay reachable.

---

## [1.5.1] - 2026-07-07

### Changed
- **Single source of truth for section visibility** — the eye toggle in "📋 Sections Order & Visibility" is now the only place to show/hide sections. The 11 duplicate per-section "Show X Section" checkboxes were removed.
- `bd_is_section_visible()` reads the sorter JSON; every template part self-guards with it.

### Added
- **One-time migration** — sections hidden via the old checkboxes are automatically transferred into the sorter (hidden state preserved: if either old switch hid a section, it stays hidden).

---

## [1.5.0] - 2026-07-07

### Fixed
- **Critical:** `bd_comment_callback()` was referenced by `comments.php` but never defined — any post with an approved comment produced a fatal error. Implemented a fully escaped comment renderer (avatar, author + Admin badge, date, moderation notice, nested reply link).

### Security
- Comment text is now kses-filtered at display time as well (defense in depth against markup injected into the database by imports/plugins that bypass input filtering).
- Escaped related-posts titles in `content-single.php` (stored XSS via post title).

### Added
- **🛡️ Comment Protection** Customizer section: strip ALL HTML from comments, reject comments containing links/URLs, blocked words/characters list (case-insensitive, multibyte-safe), minimum/maximum comment length, optional enforcement for logged-in users (moderators always exempt). Rejections show a friendly error page with a back link.

---

## [1.4.4] - 2026-07-07

### Security
- AJAX search results stripped of all markup server-side (`wp_strip_all_tags` + `esc_url_raw`) in addition to client-side escaping — defense in depth against stored XSS via post titles.
- Client-side search rendering validates/escapes result URLs and rejects non-http(s) schemes.
- AJAX load-more numeric inputs clamped (page ≤ 500, per_page ≤ 50) against expensive unbounded queries.
- Newsletter subscriber list capped at 5000 entries against unauthenticated flooding of theme mods.
- Added missing ABSPATH direct-access guard to `footer.php`.

### Fixed
- `bd_topics_get_category_image()` wrapped in `function_exists` to prevent a fatal on Customizer selective refresh.

---

## [1.4.3] - 2026-07-07

### Changed
- **Static pages are now minimal by design** — pages render only the header, optional Hero Slider, page content, optional Newsletter, and footer. No other front-page sections ever appear on pages.

### Added
- **📄 Page Settings** Customizer section with independent Hero Slider and Newsletter toggles for static pages (both also respect their global visibility settings).

---

## [1.4.2] - 2026-07-07

### Added
- **🔢 Numbered blog pagination (new default)** — standard WordPress `paginate_links()` directly on the front page at `/page/2/`, `/page/3/`, … Visitors can browse ALL older posts without any extra "Blog" page.
- `redirect_canonical` guard so `/page/N/` URLs survive on static front pages (plain-permalink `?page=N` fallback included).

### Changed
- Pagination mode selector now offers Numbered / Archive Link / Load More; all existing blog customizations apply to every mode.

### Fixed
- `mb_strtoupper()` fatal on PHP builds without the mbstring extension (team section).

---

## [1.4.1] - 2026-07-07

### Changed
- **Repository-compliant page setup** — replaced programmatic Blog/Home page creation with the WordPress-approved Starter Content API (applies to fresh sites only, via explicit Customizer publish). The theme never changes reading settings on its own.

### Added
- Dismissible admin notice pointing to Settings → Reading when no Posts page is configured.

---

## [1.4.0] - 2026-07-06

### Added
- **🏷️ Topics Section** (`template-parts/section-topics.php`): Post categories rendered as visual cards. Two card styles — the featured image of the category's latest post (with icon fallback) or gradient icon tiles. Options: topic count (1–24), show/hide post counts, order by most posts or alphabetical.
- **🔖 Popular Tags Section** (`template-parts/section-tags.php`): Pill-style tag cloud of the site's most used tags with per-tag post counts. Configurable tag count (1–60).
- **🗄️ Site Archive Section** (`template-parts/section-archive.php`): Monthly archive link cards plus a site statistics row (total posts, categories, tags, approved comments). Configurable month count (1–36) and stats toggle.
- Three new Customizer panels (🏷️ Topics / 🔖 Tags / 🗄️ Archive) with full badge/title/description header controls.
- All three sections support the Left/Right sidebar zones with dedicated compact styles.

### Behaviour
- **Hidden by default**: the new sections ship toggled OFF in the Sections Order & Visibility sorter. Users enable them with the eye toggle.
- **Safe merge for existing sites**: layouts saved before 1.4.0 don't contain the new keys — they are appended automatically as hidden items, so no existing site's appearance changes after updating.

---

## [1.3.1 – 1.3.5] - 2026-07-06

### Changed / Fixed (multi-column layout polish)
- Proportional `fr`-based columns replaced pixel sidebar widths — the admin's 1/2/3-column layout is preserved at every viewport width; only real phones (<640px) stack sidebars below the content.
- Sidebar sections keep their own native backgrounds (card wrapper removed) and carry the same decorative Balochi needlework pattern as the main sections.
- Section headers (badge, title, description) stay centered in every zone.
- Newsletter renders full-width below the multi-column grid (like the Hero Slider above it); Blog section background removed to match other sections.
- Comfortable breathing room between the fixed header/slider and the layout grid; sticky offset tuned.
- Sections Sorter hardened: retry-based init, legacy single-list fallback, locked-item rejection; automatic `filemtime` cache-busting for `style.css` and the sorter script so CDNs can never serve stale assets.
- Overflow protection for sidebar content (inline min-widths neutralised, word-safe wrapping, compact forum/shop layouts).

---

## [1.3.0] - 2026-07-06

### Added
- **Multi-Column Front Page Layout (1 / 2 / 3 columns)**: Sections can now be dragged into a **Left Sidebar** or **Right Sidebar** zone directly from the Customizer sorter (Appearance → Customize → 💎 Baloch Diamond Settings → 📋 Sections Order & Visibility). A sidebar column is created automatically as soon as at least one section is dropped into it — supporting 2-column (left or right) and full 3-column layouts.
- **Zone-aware Sections Sorter**: The drag-and-drop sorter control now shows three connected drop zones (⬅️ Left Sidebar / ▣ Main Column / ➡️ Right Sidebar). Sections can be reordered within a zone or dragged between zones. Eye-toggle show/hide is preserved.
- **Locked sections**: Hero Slider, Newsletter and Blog are locked to the main column (🔒 icon in the sorter). Attempts to drop them into a sidebar bounce back automatically; the server-side sanitizer enforces the same rule.
- **Proportional columns — no pixel settings**: Sidebar and main columns use proportional `fr` widths (2-col: ≈27%/73%, 3-col: ≈24%/52%/24%), so the admin's chosen layout is preserved on every screen size with nothing to configure.
- **Compact sidebar presentation**: Every section placed in a sidebar automatically switches to a compact vertical card style — smaller headers, single-column grids, stacked cards, full-width buttons.
- **Shop section sidebar modes**:
  - Grid layout becomes a compact **horizontal swipe row** (scroll-snap) instead of a tall vertical stack.
  - "Single Big" product layout stacks vertically — image on top, description/price/button **below** the image — at reduced size.
- **Blog auto-shrink**: When a sidebar exists, the main-column blog grid uses smaller cards (`minmax(250px, 1fr)`) so posts still fit comfortably next to the sidebar.
- **Sticky sidebars** on desktop (stick below the fixed header while scrolling).

### Changed
- `bd_sections_layout` JSON schema extended with a `zone` field (`main` | `left` | `right`). **Fully backward compatible** — existing saved layouts without `zone` are treated as `main` (classic one-column behaviour).
- `front-page.php` rewritten to group sections by zone and render a CSS Grid layout wrapper (`.bd-layout--left / --right / --both`) only when a sidebar is in use. In multi-column mode the Hero Slider is always rendered full-width above the grid.
- `assets/js/sections-sorter.js` upgraded to multi-zone connected sortables (`connectWith`), with locked-item rejection and live "drop here" placeholder hints.

### Responsive
- The admin's layout (1/2/3 columns) is preserved at every viewport width — columns scale proportionally.
- Only below 640px (real phones) do sidebars stack under the main content.
- Section headers (badge, title, description) stay centered in every zone.

---

## [1.1.1] - 2026-07-03

### Added
- **Community Members Section** (`template-parts/section-members.php`): New lightweight, fully customizable members grid. Supports up to 8 members with name, role, avatar upload, and profile link. Fully controlled via Customizer (👥 Community Members).
- **Header Account & Cart Icons**: Added quick-access icons for My Account and Shopping Cart in the header. Cart shows live item count badge when WooCommerce is active. Graceful fallback when WooCommerce is not installed.
- **Members Section in Front Page**: Integrated optional Community Members showcase on the homepage (controlled via Customizer).

### Enhanced
- **WooCommerce Shop Filter**: The `bd_shop_filter` setting (Recent / On Sale / Featured / Popular) is now **fully functional** in `template-parts/section-shop.php`. Manual product selection still takes priority.
- **Forum Section**: All previous enhancements preserved (5 display modes, 6 editable statistics, 4 featured discussions by Post ID, 3 quick action buttons, rich bbPress + mock fallback support).
- **Customizer**: New dedicated section "👥 Community Members" with controls for badge, title, count, and 8 individual member cards.

### Changed
- **Version Bump**: Upgraded theme version from `1.1.0` to `1.1.1`.
- **README & Documentation**: Updated with new features, Customizer table, and file structure.
- **Header Structure**: Right-side actions now include Account + Cart icons before the mobile menu button.

### Fixed
- **Shop Filter Logic**: Previously defined but ignored `bd_shop_filter` now correctly filters products using `wc_get_product_ids_on_sale()`, `wc_get_featured_product_ids()`, and popularity ordering.
- **Minor template cleanups** and improved front-page conditional rendering.

### Notes
- All changes are **non-breaking** and fully backward-compatible.
- Recommended plugins for full user system: WooCommerce (already supported), bbPress (already supported), and optionally Paid Memberships Pro or Ultimate Member for advanced membership features.
- Theme continues to use only lightweight, theme-level enhancements for user/account UI (no heavy custom auth systems).

---

## [1.1.0] - 2026-07-02

### Added
- **WooCommerce Product Showcase:** Added dedicated `template-parts/section-shop.php` template for showing shop products in a highly customizable slider or grid. Includes filters for recent, sale, featured, and popular products, plus dynamic star ratings, prices, and sale badges.
- **bbPress Forums Showcase:** Added dedicated `template-parts/section-forum.php` template. Displays latest active discussion topics (replies, author, date) or transitions to a styled Community CTA board with statistics counters.
- **Color Scheme Presets:** Built-in "Color Scheme Preset" selector in Section 1 of the Customizer with 5 premium presets (Ocean Breeze, Desert Sunset, Forest Green, Royal Purple, and Baloch Diamond Default).
- **Interactive Palette Switcher:** Added a floating frontend selector widget to let visitors temporarily preview colors on-the-fly, with an instant "Reset to Default" button.
- **Customizer Typography Control:** Added Section 1.5 with full Google Font integration (Poppins, Roboto, Inter, Montserrat, Lora, Playfair Display, Merriweather) and Right-to-Left (RTL) specific font support (Vazirmatn, Cairo, Tajawal, Amiri).
- **Megamenu with Needlework Borders:** Styled full-width 4-column dropdown menus under `.site-header .megamenu` featuring subtle geometric needlework pattern backdrops.
- **Skeleton Shimmer Loading:** Built-in skeletal loading placeholders with shimmering gradients that transition smoothly into post cards, product cards, and portfolios once pages load.
- **Optional Background Animations:** Added option to slow-animate the traditional background needlework SVG patterns to add life and motion.
- **Multi-page Navigation:** Integrated `wp_link_pages()` into single article views (`content-single.php`).

### Changed
- **Version Bump:** Upgraded theme version to `1.1.0`.
- **Frontend Panel Clean-up:** Relocated the heavy color selectors and settings panels to the secure WordPress Customizer back-end, leaving only a beautiful and lightweight palette preview switcher on the front-end.
- **Pagination Consolidated:** Migrated `the_posts_pagination()` in `index.php` to use the custom, styled `bd_pagination()` function for a streamlined layout.

### Fixed
- **Reflected XSS Vulnerability:** Hardened the search page (`search.php`) by escaping search queries with `esc_html()` inside `printf()` functions.
- **Undefined Variable `$commenter`:** Resolved the PHP warning in `comments.php` by correctly fetching comment author data via `wp_get_current_commenter()`.
- **Customizer Defensive Boundaries:** Patched `bd_sanitize_select()` in `inc/customizer.php` by introducing control verification blocks to prevent PHP fatal errors during import/export.
- **Multibyte UTF-8 Word Count:** Fixed estimated reading time calculations in `inc/template-functions.php` to properly compute Persian, Arabic, and Balochi characters.
- **Article Link Color Styling:** Added custom link styles inside single posts using primary and secondary colors with dashed underlines.

---

## [1.0.0] - 2024-08-27

### Added
- Initial Release of Baloch Diamond WordPress Theme.
- Responsive design, standard translation `.pot` files.
- Slider, Portfolio, Team, Resources, and Newsletter sections.
- Vanilla JS implementations.

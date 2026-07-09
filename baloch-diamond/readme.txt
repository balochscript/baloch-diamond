=== Baloch Diamond ===
Contributors: balochscript
Tags: blog, portfolio, custom-colors, custom-logo, custom-menu, featured-images, theme-options, translation-ready, one-column, two-columns, three-columns, left-sidebar, right-sidebar
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.6.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A premium WordPress theme inspired by the timeless beauty of Balochi needlework artistry. Where tradition meets modern web design excellence.

== Description ==

Baloch Diamond is a premium WordPress theme inspired by the timeless beauty of Balochi needlework artistry. It features a drag-and-drop multi-column layout builder, customizable colors, a hero slider, portfolio showcase, team section, blog section with standard numbered pagination, comment protection, and full dark/light mode support with custom mode colors.

**Features:**

* **Multi-Column Layout Builder** — Drag any front-page section into a Left or Right sidebar zone for 2- or 3-column layouts; proportional columns adapt to every screen size, and tall sidebars scroll independently.
* **Sections Order & Visibility** — One drag-and-drop sorter controls the order, column and visibility (eye toggle) of all 12 sections.
* **Customizable Colors & Presets** — Choose from built-in color presets (Default, Ocean, Desert, Forest, Royal) or set your own custom colors.
* **Hero Slider** — Full-width hero slider with customizable slides, height presets, and a fully adjustable text-overlay color and strength (0–100%).
* **Blog Section** — Display latest posts with three pagination modes: standard Numbered pagination (default, no extra page needed), Archive Link button, or AJAX Load More. On paged views you choose exactly which sections accompany the blog grid.
* **Topics, Tags & Archive Sections** — Category cards (latest-post image or icon tiles), a pill-style tag cloud, and a monthly archive with site statistics. Hidden by default; enable with one click.
* **Portfolio Showcase** — Grid/masonry/slider layouts for showcasing projects and work.
* **Team Section** — Display team members with photos, roles, and social links.
* **WooCommerce Support** — Full compatibility with WooCommerce including product gallery features.
* **Dark/Light Mode** — Toggle between modes; the admin sets the default (Light, Dark, or Auto following the visitor's OS) and can replace both mode backgrounds with any custom color — text contrast is derived automatically.
* **Comment Protection** — Strip HTML from comments, reject comments with links, blocked-words list, and min/max length limits.
* **Custom Fonts** — Choose from Google Fonts for body text, headings, and RTL scripts (including Vazirmatn, Cairo, Tajawal for Persian/Arabic).
* **RTL Support** — Full right-to-left language support for Persian, Arabic, and Balochi.
* **Translation Ready** — Includes `.pot` file for easy translation.
* **Custom Logo** — Upload your own logo via the Customizer.
* **Responsive Design** — Fully responsive across all devices.
* **Custom Menus** — Primary and footer menu locations.
* **Widget Areas** — Three footer widget columns.
* **Newsletter Section** — Built-in newsletter subscription section.
* **Balochi Embroidery Decoration** — Optional traditional Balochi stitch decoration on UI elements.

== Installation ==

1. In your WordPress admin, go to **Appearance → Themes → Add New → Upload Theme**.
2. Upload the `baloch-diamond.zip` file.
3. Click **Install Now**, then **Activate**.
4. Go to **Appearance → Customize** to configure theme options.

**Setting up the Blog page (optional):**

If you want a dedicated Blog archive page with numbered pagination:

1. Create a new page called "Blog" (leave content empty).
2. Go to **Settings → Reading**.
3. Set "Your homepage displays" to "A static page".
4. Set "Posts page" to your new "Blog" page.
5. Set "Homepage" to your desired front page.

If you leave the default setting ("Your latest posts"), the homepage itself serves as the blog archive.

== Frequently Asked Questions ==

= How do I reorder, hide, or move sections into sidebars? =

Go to **Appearance → Customize → 💎 Baloch Diamond Settings → 📋 Sections Order & Visibility**. Drag rows to reorder, drag them into the Left/Right sidebar boxes to build 2- or 3-column layouts, and click the eye icon to show or hide a section. This is the single place that controls section visibility.

= How do I change the blog pagination mode? =

Go to **Appearance → Customize → 📝 Blog Section** and choose "Numbered" (standard WordPress pagination on the front page — the default), "Archive Link", or "Load More" under Pagination Mode. Numbered mode needs no extra Blog page; older posts live at /page/2/, /page/3/ and so on.

= Can I control which sections appear on /page/2/ and beyond? =

Yes. In **📋 Sections Order & Visibility**, enable "Paged Views: Filter Sections" and tick the sections you want to accompany the blog grid on paged views. By default only the Hero Slider joins the blog there; page 1 always shows the full layout.

= How do I set up a separate Blog page? =

Optional — the Numbered pagination mode works without one. If you still want a dedicated Posts page, set it under **Settings → Reading**; the theme's Archive Link mode will use it automatically (and gracefully falls back to Numbered if the page is removed).

= Does the theme work with WooCommerce? =

Yes! Baloch Diamond includes full WooCommerce support with product gallery zoom, lightbox, and slider features.

= How do I enable dark mode or set it as the default? =

Visitors can use the toggle button in the bottom-left corner. As the admin, set the site default (Light, Dark, or Auto following the visitor's operating system) under **Appearance → Customize → ⚙️ Advanced Options** — where you can also replace both mode backgrounds with custom colors.

= How do I protect comments from spam? =

Go to **Appearance → Customize → 🛡️ Comment Protection** to strip HTML from comments, reject comments containing links, define a blocked-words list, and set minimum/maximum comment lengths.

== Changelog ==

= 1.6.2 — Theme Check Compliance =
* Added: GPL copyright notice in style.css header
* Changed: Header search overlay now uses get_search_form() (filterable by plugins) with an overlay context; searchform.php gained screen-reader labels
* Added: Footer widget areas (Footer Column 1–3) are now rendered via dynamic_sidebar() above the footer bottom bar, with responsive styling
* Fixed: Screenshot regenerated at the required 1200x900 (4:3) size
* Fixed: Translation calls in the Customizer social-links loop no longer contain PHP variables (literal strings per i18n guidelines)
* Changed: Comment form now uses the standard comment_form() function so plugins can hook into it (also removes the site_url() usage)
* Added: add_theme_support( 'wp-block-styles' ), editor stylesheet (add_editor_style), one custom block style (Diamond Gradient button, Embroidered quote) and a Diamond CTA Banner block pattern
* Added: .gallery-caption and .bypostauthor CSS classes
* Removed: leftover CHANGELOG-PAGINATION.md from the theme folder

= 1.6.1 — Slider Overlay Control =
* New: "🎨 Text Overlay Color" — pick any color for the gradient band behind the slide title/excerpt (default black)
* New: "🌫️ Text Overlay Strength" range slider (0–100%) — from fully transparent to solid, in 5% steps; title text shadow keeps text readable at low values
* Implemented via CSS variables so the Customizer preview updates cleanly

= 1.6.0 — Theme Modes & Sidebar Scrolling =
* Fixed: Scrolling inside a tall sticky sidebar no longer moves the whole page — sidebars now scroll independently inside their own box (max-height + overflow-y auto + overscroll-behavior contain, thin styled scrollbar)
* New: "🌗 Default Theme Mode" — the admin chooses Light, Dark or Auto (follows the visitor's OS preference) as the site default; a visitor's own toggle choice is still remembered and takes precedence
* New: Flash-free mode switching — an inline head script applies the correct mode before first paint
* New: Custom Light Mode background color — pick any color (cream, light blue, …) instead of white; card, border, alt-background and muted-text shades are DERIVED automatically with WCAG-safe contrast (dark text on light colors, light text on dark colors — even if the admin picks a dark color for light mode)
* New: Custom Dark Mode background color — same automatic palette derivation (e.g. deep green, warm charcoal, dark purple)
* Contrast verified: all derived palettes tested at 4.5:1+ for body text and 3:1+ for muted text

= 1.5.2 — Paged View Section Control =
* New: Smart fallback — if "Archive Link" pagination is selected but no Posts page exists (e.g. the Blog page was deleted), the blog section automatically switches to Numbered pagination so older posts always stay reachable
* New: "📑 Paged Views: Filter Sections" master toggle — on /page/2/ and beyond (Numbered pagination) only the Blog grid plus admin-selected sections are rendered; page 1 always shows the full layout
* New: Per-section paged-view checkboxes for all 11 sections (Hero Slider enabled by default, everything else hidden by default) — fully user-configurable, nothing hardcoded
* Sections enabled for paged views keep their sidebar placement (zones preserved)

= 1.5.1 — Unified Section Visibility =
* Changed: Section visibility now has a SINGLE source of truth — the eye toggle in "📋 Sections Order & Visibility". The duplicate per-section "Show X Section" checkboxes were removed from all 11 section panels
* Added: One-time automatic migration — sections hidden via the old checkboxes are transferred into the sorter (hidden state preserved; if either old switch hid a section, it stays hidden)
* Changed: bd_is_section_visible() now reads the sorter JSON; every template part self-guards with it, so visibility is enforced consistently everywhere (front page, static pages)
* All comment-protection options remain fully user-configurable via the Customizer (no hardcoded values)

= 1.5.0 — Comment Security & Protection =
* Fixed (critical): bd_comment_callback() was referenced by comments.php but never defined — any post with an approved comment produced a fatal error. Implemented a fully escaped comment renderer (avatar, author + Admin badge, date, moderation notice, reply link)
* Security: comment text is now kses-filtered at display time as well (defense in depth against markup injected into the database by imports/plugins bypassing input filtering)
* Security: escaped related-posts titles in content-single.php (stored XSS via post title)
* New: 🛡️ Comment Protection Customizer section:
*   - Strip ALL HTML tags from comments (plain-text comments)
*   - Reject comments containing links/URLs (anti-spam)
*   - Blocked words/characters list (one per line, case-insensitive, multibyte-safe)
*   - Minimum / maximum comment length
*   - Optional enforcement for logged-in users (moderators always exempt)
* All rejections show a friendly error page with a back link (same UX as core's duplicate-comment notice)

= 1.4.4 — Security Hardening =
* Security: AJAX search results are now stripped of all markup server-side (wp_strip_all_tags + esc_url_raw) in addition to the existing client-side escaping — defense in depth against stored XSS via post titles
* Security: Client-side search rendering now also validates/escapes result URLs and rejects non-http(s) schemes
* Security: AJAX load-more numeric inputs are clamped (page ≤ 500, per_page ≤ 50) to prevent expensive unbounded queries
* Security: Newsletter subscriber list capped at 5000 entries to prevent unauthenticated flooding of theme mods
* Security: Added missing ABSPATH direct-access guard to footer.php
* Fixed: bd_topics_get_category_image() wrapped in function_exists to prevent fatal on Customizer selective refresh

= 1.4.3 =
* New: Static pages now show ONLY the header, optional Hero Slider, page content, optional Newsletter, and footer — no other front-page sections ever render on pages
* New: "📄 Page Settings" Customizer section with independent toggles for the Hero Slider and Newsletter on static pages (both also respect their global visibility settings)

= 1.4.2 =
* New: "Numbered" blog pagination mode (now the default) — standard WordPress paginate_links() directly on the front page at /page/2/, /page/3/ … visitors can browse ALL older posts without any extra "Blog" page
* Changed: Pagination mode selector now offers Numbered / Archive Link / Load More; all existing customizations (thumbnails, meta toggles, texts, per-page count) apply to every mode
* Added: redirect_canonical guard so /page/N/ URLs work on static front pages (plain-permalink ?page=N fallback included)
* Fixed: mb_strtoupper() fatal on PHP without the mbstring extension (team section)

= 1.4.1 =
* Changed: Replaced programmatic Blog/Home page creation with the WordPress-approved Starter Content API (fresh sites only, applied via Customizer on explicit publish)
* Added: Dismissible admin notice pointing to Settings → Reading when no Posts page is set
* Theme never changes reading settings on its own — repository-compliant behaviour

= 1.4.0 =
* New: Topics section — displays post categories as visual cards with the latest post image or icon tiles, post counts, and ordering options (hidden by default; enable in Sections Order & Visibility)
* New: Popular Tags section — pill-style tag cloud with post counts (hidden by default)
* New: Site Archive section — monthly archive links plus site statistics: posts, categories, tags, comments (hidden by default)
* New: Dedicated Customizer panels for all three sections (badge/title/description, counts, styles)
* New sections merge safely into existing saved layouts as hidden items — existing sites keep their exact appearance
* All three sections fully support the sidebar zones with compact layouts

= 1.3.0 =
* New: Multi-column front page — drag sections into Left/Right sidebar zones in the Customizer sorter to build 2- or 3-column layouts
* New: Proportional (percentage-based) columns — the chosen layout is kept on every screen size, no width settings needed; only real phones (<640px) stack the sidebars below the content
* New: Compact vertical presentation for sections placed in a sidebar (single-column grids, stacked cards, smaller headers)
* New: Shop section in sidebar — grid becomes a horizontal swipe row; "Single Big" layout stacks image above description at a smaller size
* New: Blog grid auto-shrinks its cards when a sidebar is active
* Changed: bd_sections_layout JSON now stores a per-section zone (backward compatible with old saved layouts)
* Locked: Hero Slider, Newsletter and Blog always stay in the main column

= 1.2.0 =
* Fixed: "View All Posts" button now uses `get_post_type_archive_link('post')` instead of `home_url('/')`
* Fixed: Blog archive pages now use standard `the_posts_pagination()` for numbered pagination
* New: Two selectable pagination modes via Customizer — Archive Link and Load More (AJAX)
* New: 7 Customizer settings for blog pagination customization
* Changed: `bd_pagination()` now wraps `the_posts_pagination()` instead of custom HTML
* Removed: Non-standard auto-page-creation functionality
* Removed: `update_option()` calls for reading settings (themes should not modify these)
* Cleaned up: Dead CSS classes replaced with standard WordPress pagination classes

= 1.1.0 =
* Initial release with hero slider, portfolio, team, blog sections
* Dark/light mode support
* WooCommerce compatibility
* RTL language support
* Customizer options for colors, fonts, and layout

== Copyright ==

Baloch Diamond WordPress Theme, Copyright (C) 2026 Baloch Script Team
Baloch Diamond is distributed under the terms of the GNU GPL v2 or later.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

**Bundled resources:**

* All SVG icons are original works by the Baloch Script Team, licensed under GPLv2 or later (based on the Feather icon style, MIT-compatible line-art originals).
* The Balochi needlework SVG patterns are original works by the Baloch Script Team, licensed under GPLv2 or later.
* Google Fonts (Poppins, Playfair Display, Work Sans, Oswald, Cairo, Vazirmatn, and others) are loaded from the Google Fonts CDN and licensed under the SIL Open Font License 1.1.
* The screenshot shows the theme's own demo content; the slider artwork in the screenshot is an original work by the Baloch Script Team (GPLv2 or later).

== Upgrade Notice ==

= 1.6.1 =
Major update since 1.2: multi-column layout builder with drag-and-drop sidebars, standard numbered blog pagination (no Blog page needed), paged-view section filtering, three new sections (Topics/Tags/Archive), comment protection, custom light/dark mode colors with automatic contrast, slider overlay control, plus an important security hardening pass and a critical comment-rendering fix. Recommended for all users.

= 1.5.0 =
Critical fix: posts with approved comments no longer produce a fatal error. Includes a security hardening pass — update strongly recommended.

= 1.2.0 =
Important bug fix: The "View All Posts" button now correctly links to the blog archive instead of the homepage. Also adds configurable pagination modes and standard WordPress pagination functions.

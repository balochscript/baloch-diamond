# Changelog

All notable changes to the **Baloch Diamond** WordPress Theme will be documented in this file.

This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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

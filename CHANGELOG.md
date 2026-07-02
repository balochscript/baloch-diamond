# Changelog

All notable changes to the **Baloch Diamond** WordPress Theme will be documented in this file.

This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.1.0] - 2026-07-02

### Added 
- **WooCommerce Integration:** Full, official theme support for WooCommerce shop systems. Product gallery features (Zoom, Lightbox, Slider) are now active and styled.
- **bbPress Compatibility:** Enhanced compatibility styling for forums and community-driven discussion sections.
- **Promo Hub Section:** Created `template-parts/section-promo-hub.php` containing a beautiful dual-purpose promotional box right under the hero post slider. Admin can direct visitors to Forums and Shops with Baloch-inspired design.
- **WordPress Customizer Color Presets:** Added the "Color Scheme Preset" option to Section 1 of the official WordPress Customizer. Users can select from 5 premium pre-designed color palettes (Ocean Breeze, Desert Sunset, Forest Green, Royal Purple, and Baloch Diamond Default) or set custom colors.
- **Multi-page Post Navigation:** Added `wp_link_pages()` to `template-parts/content-single.php` to support single articles split across multiple pages.

### Changed 
- **Version Bump:** Upgraded theme version to `1.1.0`.
- **Frontend Clean-up:** Removed the redundant frontend customizer menu, floating overlay, and sliders from `header.php` to give a cleaner, faster, production-ready website appearance.
- **Pagination Clean-up:** Consolidated the duplication inside `index.php` by migrating default post pagination to the custom `bd_pagination()` function for design consistency.

### Fixed 
- **Reflected XSS Vulnerability:** Fully sanitized the search query output inside `search.php` using `esc_html()` to prevent Cross-Site Scripting (XSS).
- **Undefined Variable `$commenter` Warning:** Fixed PHP Warning notices inside `comments.php` by properly fetching comment author metadata via `wp_get_current_commenter()`.
- **Customizer PHP Fatal Error risk:** Patched `bd_sanitize_select()` in `inc/customizer.php` by introducing defensive check constraints on active controls, preventing fatal errors during import/export pipelines.
- **Multibyte Word Count (Persian/Balochi):** Corrected the estimated reading time calculation inside `inc/template-functions.php` to use a UTF-8 compatible Regex parser instead of Latin-only `str_word_count()`.
- **Single Post Link Color styling:** Added elegant, cohesive link styles matching the Baloch Diamond palette inside single post paragraph tags (using dashed underlines and transitional color shifts on hover).

---

## [1.0.0] - 2024-08-27

### Added
- Initial Release of Baloch Diamond WordPress Theme.
- Responsive design, RTL support, standard translation `.pot` files.
- Slider, Portfolio, Team, Resources, and Newsletter sections.
- Vanilla JS implementations.

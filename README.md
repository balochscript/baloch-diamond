<div align="center">

# 💎 Baloch Diamond WordPress Theme

A premium, highly-customizable WordPress theme inspired by the timeless beauty of Balochi needlework artistry. Where tradition meets modern web design. Fully optimized for blogging, portfolio showcases, WooCommerce storefronts, and bbPress community forums.

![Baloch Diamond Theme](screenshot.png)

[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-GPL%20v2-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
[![Version](https://img.shields.io/badge/Version-1.6.1-orange.svg)](#)

[Live Demo](#) • [Download](#) • [Documentation](#) • [Report Bug](../../issues)

</div>

---

## ✨ Features

### 🏗️ Multi-Column Layout Builder (New in v1.3)
- **1 / 2 / 3-Column Front Page** — Drag any section into a Left or Right sidebar zone straight from the Customizer sorter; sidebar columns appear automatically.
- **Zone-Aware Drag & Drop Sorter** — Three connected drop zones (⬅️ Left / ▣ Main / ➡️ Right) with eye-toggle show/hide per section. The single source of truth for section visibility.
- **Proportional Columns** — `fr`-based widths keep the chosen layout on every screen size with zero pixel settings; only real phones stack the sidebars.
- **Compact Sidebar Presentation** — Sections dropped into a sidebar automatically switch to a compact vertical style (the Shop grid even becomes a horizontal swipe row).
- **Independent Sidebar Scrolling (New in v1.6)** — Tall sticky sidebars scroll inside their own box without moving the page.

### 📰 Blog & Pagination (New in v1.4–1.5)
- **Standard Numbered Pagination (default)** — WordPress `paginate_links()` right on the front page (`/page/2/`, `/page/3/`, …). No extra "Blog" page needed; smart fallback if a Posts page is deleted.
- **Three Pagination Modes** — Numbered / Archive-Link button / AJAX Load More.
- **Paged-View Section Filtering** — On `/page/2/`+ show only the Blog grid plus admin-selected sections (Hero Slider on by default); page 1 always shows the full layout.
- **🏷️ Topics, 🔖 Popular Tags & 🗄️ Site Archive sections** — Category cards (image or icon tiles), pill-style tag cloud, and monthly archive with site statistics. All hidden by default; enable with one click.

### 🎨 Design & Layout
- **Balochi-Inspired Patterns** — Elegant, geometric SVG pattern backdrops reflecting traditional needlework (also on sidebar columns).
- **Optional Animated Patterns (New in v1.1.0)** — Slow, beautiful, CSS-powered sliding pattern backgrounds, toggleable via the WordPress Customizer.
- **Customizable Color Schemes** — 5 preset palettes (Ocean Breeze, Desert Sunset, Forest Green, Royal Purple, and Baloch Diamond Default) or complete custom colors.
- **Slider Overlay Control (New in v1.6.1)** — Pick any color AND strength (0–100%) for the gradient band behind hero-slide titles.
- **Interactive Palette Switcher (New in v1.1.0)** — A clean, beautiful frontend sliding palette widget allowing users to temporarily preview theme colors on-the-fly, with an instant "Reset to Default" button.
- **Responsive Megamenu (New in v1.1.0)** — Style any drop-down menu into a stunning 4-column full-width grid menu decorated with elegant needlework motifs by simply adding the `megamenu` CSS class.
- **Skeleton Shimmer Loading (New in v1.1.0)** — Shimmering skeletal animation placeholders that transition beautifully into loaded content to improve perceived performance.

### 🔌 Advanced Integrations (Enhanced v1.1.1)
- **WooCommerce Marketplace Section** — Fully isolated shop showcase support. Highlights on-sale, recent, featured, or popular products in a grid or slider carousel layout with ratings and dynamic pricing. **Filter fully functional** (Recent / On Sale / Featured / Popular).
- **bbPress Discussion Board Section** — Display latest active forum topics with reply counters, author metadata, and categories, or toggle a high-converting community CTA statistics board. **5 display modes** + 6 fully editable stats.
- **Community Members Showcase (New in v1.1.1)** — Lightweight, fully customizable members grid in the Customizer. Display up to 8 artisans/creators with name, role, avatar upload, and profile links.
- **Header Account & Cart (New in v1.1.1)** — Quick-access icons for My Account and Shopping Cart (with live item count badge) when WooCommerce is active.

### 🌗 Dark/Light Mode (Upgraded in v1.6)
- One-click theme toggle, saved locally in the visitor's browser, respecting WooCommerce, bbPress, and custom blocks.
- **Admin-selectable default mode** — Light, Dark, or Auto (follows the visitor's OS preference), applied before first paint (no flash).
- **Custom mode colors** — Replace white/navy with ANY background color; card, border and text shades are derived automatically with WCAG-safe contrast.

### 🎛️ Extensive Customizer Options (v1.1.1)
- **Theme Colors & Scheme Presets**
- **Typography & Font Selector** — Full Google Font + RTL support.
- **Shop & Forum Sections** — Toggle layouts, choose counts, and filters independently.
- **Community Members Section** — 8 fully customizable member cards (name, role, avatar, link).
- **Portfolio, Blog, Team, and Resources** — Tailor images, slide counts, post grids, and social icons.
- **Header** — 5 display modes, solid/gradient headers.

### 🛡️ Security & Comment Protection (New in v1.4.4–1.5)
- **Security-audited** — escaped output everywhere, nonce-protected AJAX, kses-filtered comments at display time, clamped AJAX inputs, ABSPATH guards.
- **Comment Protection Customizer section** — strip all HTML from comments, reject comments containing links, blocked-words list (multibyte-safe), min/max comment length, optional enforcement for logged-in users.
- **Repository-friendly** — no pages created programmatically; uses the WordPress Starter Content API and never touches reading settings on its own.

### 🌐 Safety & Performance
- **XSS Hardened** — Fully sanitizes search query strings and general template functions.
- **Multibyte UTF-8 Support** — Calculates estimated reading times correctly for Persian, Arabic, and Balochi.
- **Automatic cache-busting** — `filemtime`-based asset versions, so CDNs (e.g. Cloudflare) never serve stale CSS/JS after an update.
- No jQuery dependencies on the front end (Vanilla JS).

---

## 📦 Installation

### Method 1: WordPress Dashboard
1. Download the latest release **`baloch-diamond.zip`** from the [Releases](../../releases) tab.
2. Go to **Appearance → Themes → Add New → Upload Theme**.
3. Upload `baloch-diamond.zip` and click **Activate**.

### Method 2: FTP/File Manager
1. Extract `baloch-diamond.zip`.
2. Upload the `baloch-diamond` folder to `/wp-content/themes/`.
3. Go to **Appearance → Themes** and activate **Baloch Diamond**.

---

## ⚙️ Setup After Activation

### 1. Set Homepage
Go to Dashboard → Settings → Reading → Select "A static page" or "Your latest posts".

### 2. Customize Theme
Go to Dashboard → Appearance → Customize → 💎 Baloch Diamond Settings.

### 3. Create Megamenus
Go to Dashboard → Appearance → Menus. Under **Screen Options** (top right), check **CSS Classes**. Add the class `megamenu` to any top-level menu item to expand its submenu into a full-width, 4-column needlework grid.

### 4. Enable Localizer / Languages
Compatible with Loco Translate and Poedit. The theme textdomain is `baloch-diamond`.

---

## 🎨 Customizer Sections

| Section | Options |
|---------|---------|
| 📋 Sections Order & Visibility | Drag & drop between Left/Main/Right zones, eye-toggle show/hide (single source of truth), paged-view section filtering |
| 🎨 Theme Colors | Pre-designed scheme presets, custom color pickers, Balochi embroidery decoration |
| 🔤 Typography & Fonts | Body font, Heading font, RTL-specific font selection, custom .woff2 uploads |
| 🚀 Advanced Core Features | Toggle animated patterns, Toggle skeleton shimmer loading |
| ⚙️ Advanced Options | Dark/light toggle visibility, **default theme mode (Light/Dark/Auto)**, **custom light & dark background colors** |
| 🛍️ Shop Showcase | Layout type (grid/slider/single-big), query filter (Recent/Sale/Featured/Popular), product count, 12 manual product selectors |
| 💬 Forum Showcase | Display mode (5 modes: topics/categories/featured/live-stats/cta), count limit, 6 editable stats, 3 quick action buttons |
| 👥 Community Members | Title/badge, up to 8 custom members (name, role, avatar, profile link) |
| 📌 Header | 5 display modes, solid/gradient/image headers, gradient direction + **Account & Cart icons** |
| 🖼️ Hero Slider | Source selection, slide count, custom post IDs, height presets, **overlay color & strength (0–100%)** |
| 💼 Portfolio | 12 custom items, layout/columns/card styles, filter tabs |
| 📝 Blog | Element toggles, read-more labels, **pagination mode (Numbered/Archive-Link/Load More)** |
| 🏷️ Topics / 🔖 Tags / 🗄️ Archive | Category cards (image or icon tiles), tag cloud, monthly archive + site stats (hidden by default) |
| 📚 Resources | 10 card items with custom SVG icon selectors |
| 👥 Team | 8 custom member cards, role, biography, photo shapes, social links |
| 📧 Newsletter | Title, description, placeholder, CTA button text |
| 📄 Page Settings | Hero Slider & Newsletter toggles for static pages |
| 🛡️ Comment Protection | Strip HTML, block links, blocked words, min/max length, logged-in enforcement |
| 🦶 Footer | Logo, about/copyright texts, colors, layouts (1–4 col), 8 social networks |

---

## 📁 File Structure

    baloch-diamond/
    ├── style.css
    ├── functions.php
    ├── index.php
    ├── front-page.php (multi-column zone layout + paged-view filtering)
    ├── header.php (Account + Cart icons, flash-free theme mode)
    ├── footer.php
    ├── single.php
    ├── page.php (minimal: slider + content + newsletter)
    ├── home.php
    ├── archive.php
    ├── search.php
    ├── 404.php
    ├── comments.php
    ├── searchform.php
    ├── screenshot.png
    ├── readme.txt
    ├── inc/
    │   ├── customizer.php (all section controls + zone sorter)
    │   └── template-functions.php (comment renderer, visibility helper)
    ├── template-parts/
    │   ├── hero-slider.php
    │   ├── section-shop.php (3 layouts, sidebar-aware)
    │   ├── section-forum.php (5 modes + 6 stats)
    │   ├── section-members.php
    │   ├── section-portfolio.php
    │   ├── section-blog.php (3 pagination modes)
    │   ├── section-topics.php (category cards)
    │   ├── section-tags.php (tag cloud)
    │   ├── section-archive.php (monthly archive + stats)
    │   ├── section-resources.php
    │   ├── section-team.php
    │   ├── section-newsletter.php
    │   ├── content.php
    │   ├── content-single.php
    │   └── content-none.php
    ├── assets/
    │   └── js/
    │       ├── main.js
    │       ├── sections-sorter.js (multi-zone drag & drop)
    │       └── customizer-preview.js
    └── languages/
        └── baloch-diamond.pot

---

## 📄 License

Licensed under the [GNU General Public License v2 or later](https://www.gnu.org/licenses/gpl-2.0.html).

---

<div align="center">

**Crafted with 💎 inspired by Balochi art & culture**

Made with ❤️ by the Baloch Script Team

</div>

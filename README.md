<div align="center">

# 💎 Baloch Diamond WordPress Theme

A premium, highly-customizable WordPress theme inspired by the timeless beauty of Balochi needlework artistry. Where tradition meets modern web design. Fully optimized for blogging, portfolio showcases, WooCommerce storefronts, and bbPress community forums.

![Baloch Diamond Theme](screenshot.png)

[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-GPL%20v2-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
[![Version](https://img.shields.io/badge/Version-1.1.1-orange.svg)](#)

[Live Demo](#) • [Download](#) • [Documentation](#) • [Report Bug](../../issues)

</div>

---

## ✨ Features

### 🎨 Design & Layout
- **Balochi-Inspired Patterns** — Elegant, geometric SVG pattern backdrops reflecting traditional needlework.
- **Optional Animated Patterns (New in v1.1.0)** — Slow, beautiful, CSS-powered sliding pattern backgrounds, toggleable via the WordPress Customizer.
- **Customizable Color Schemes** — 5 preset palettes (Ocean Breeze, Desert Sunset, Forest Green, Royal Purple, and Baloch Diamond Default) or complete custom colors.
- **Interactive Palette Switcher (New in v1.1.0)** — A clean, beautiful frontend sliding palette widget allowing users to temporarily preview theme colors on-the-fly, with an instant "Reset to Default" button.
- **Responsive Megamenu (New in v1.1.0)** — Style any drop-down menu into a stunning 4-column full-width grid menu decorated with elegant needlework motifs by simply adding the `megamenu` CSS class.
- **Skeleton Shimmer Loading (New in v1.1.0)** — Shimmering skeletal animation placeholders that transition beautifully into loaded content to improve perceived performance.

### 🔌 Advanced Integrations (Enhanced v1.1.1)
- **WooCommerce Marketplace Section** — Fully isolated shop showcase support. Highlights on-sale, recent, featured, or popular products in a grid or slider carousel layout with ratings and dynamic pricing. **Filter fully functional** (Recent / On Sale / Featured / Popular).
- **bbPress Discussion Board Section** — Display latest active forum topics with reply counters, author metadata, and categories, or toggle a high-converting community CTA statistics board. **5 display modes** + 6 fully editable stats.
- **Community Members Showcase (New in v1.1.1)** — Lightweight, fully customizable members grid in the Customizer. Display up to 8 artisans/creators with name, role, avatar upload, and profile links.
- **Header Account & Cart (New in v1.1.1)** — Quick-access icons for My Account and Shopping Cart (with live item count badge) when WooCommerce is active.

### 🌗 Dark/Light Mode
- One-click theme toggle, saved locally in user's browser, respecting WooCommerce, bbPress, and custom blocks.

### 🎛️ Extensive Customizer Options (v1.1.1)
- **Theme Colors & Scheme Presets**
- **Typography & Font Selector** — Full Google Font + RTL support.
- **Shop & Forum Sections** — Toggle layouts, choose counts, and filters independently.
- **Community Members Section** — 8 fully customizable member cards (name, role, avatar, link).
- **Portfolio, Blog, Team, and Resources** — Tailor images, slide counts, post grids, and social icons.
- **Header** — 5 display modes, solid/gradient headers.

### 🌐 Safety & Performance
- **XSS Hardened** — Fully sanitizes search query strings and general template functions.
- **Multibyte UTF-8 Support** — Calculates estimated reading times correctly for Persian, Arabic, and Balochi.
- No jQuery dependencies (Vanilla JS).

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
| 🎨 Theme Colors | Pre-designed scheme presets, custom color pickers |
| 🔤 Typography & Fonts | Body font, Heading font, RTL-specific font selection |
| 🚀 Advanced Core Features | Toggle animated patterns, Toggle skeleton shimmer loading |
| 🛍️ Shop Showcase | Show/hide, layout type (grid/slider), query filter (Recent/Sale/Featured/Popular), product count, 12 manual product selectors |
| 💬 Forum Showcase | Show/hide, display mode (5 modes: topics/categories/featured/live-stats/cta), count limit, 6 editable stats, 4 featured discussions by ID, 3 quick action button texts |
| 👥 Community Members (New) | Show/hide, title/badge, up to 8 custom members (name, role, avatar, profile link) |
| 📌 Header | 5 display modes, solid/gradient headers, gradient direction + **Account & Cart icons** |
| 🖼️ Hero Slider | Source selection, slide count limits, custom post IDs |
| 💼 Portfolio | 10 custom items with featured image overrides, badges |
| 📝 Blog | Web-grid post count, custom read-more labels |
| 📚 Resources | 10 card items with 10 custom SVG icon selectors |
| 👥 Team | 10 custom member cards, role, biography, custom card headers |
| 📧 Newsletter | Newsletter title, description, placeholder, CTA button text |
| 🦶 Footer | About texts, column labels, social configurations |

---

## 📁 File Structure

    baloch-diamond/
    ├── style.css
    ├── functions.php
    ├── index.php
    ├── front-page.php
    ├── header.php (Account + Cart icons)
    ├── footer.php
    ├── single.php
    ├── page.php
    ├── archive.php
    ├── search.php
    ├── 404.php
    ├── comments.php
    ├── searchform.php
    ├── screenshot.png
    ├── README.md
    ├── CHANGELOG.md
    ├── update_pot.py
    ├── inc/
    │   ├── customizer.php (Shop + Forum + Members controls)
    │   └── template-functions.php
    ├── template-parts/
    │   ├── hero-slider.php
    │   ├── section-shop.php (Filter fully active)
    │   ├── section-forum.php (5 modes + 6 stats)
    │   ├── section-members.php (NEW)
    │   ├── section-portfolio.php
    │   ├── section-blog.php
    │   ├── section-resources.php
    │   ├── section-team.php
    │   ├── section-newsletter.php
    │   ├── content.php
    │   ├── content-single.php
    │   └── content-none.php
    ├── assets/
    │   ├── js/
    │   │   ├── main.js
    │   │   └── customizer-preview.js
    │   └── images/
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

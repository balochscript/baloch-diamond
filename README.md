<div align="center">

# 💎 Baloch Diamond WordPress Theme

A premium WordPress theme inspired by the timeless beauty of Balochi needlework artistry.
Where tradition meets modern web design excellence. Now fully ready for e-commerce shops and interactive forums.

![Baloch Diamond Theme](screenshot.png)

[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-GPL%20v2-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
[![Version](https://img.shields.io/badge/Version-1.1.0-orange.svg)](#)

[Live Demo](#) • [Download](#) • [Documentation](#) • [Report Bug](../../issues)

</div>

---

## ✨ Features

### 🔌 Advanced Integrations (New in v1.1.0)
- **WooCommerce Support** — Full integration with WordPress shop systems, featuring zoom, lightbox, and slider support for product galleries.
- **Forums & Community Ready** — Styled and optimized for bbPress and community-centric forum networks.
- **Promo Hub Block** — A dual-purpose promotional grid section right under the hero slider featuring custom Baloch-inspired SVG icons to drive conversions to your Forums and Shop.

### 🎨 Design & Customization
- **Balochi-inspired patterns** — Unique SVG patterns inspired by traditional needlework
- **Gradient color scheme** — Beautiful sky-blue to orange gradient throughout
- **Color Presets inside Customizer** — 5 professional preset schemes (Ocean Breeze, Desert Sunset, Forest Green, Royal Purple, and Baloch Diamond Default) or full custom colors, managed 100% inside the WordPress Customizer.
- **Modern card-based layout** — Clean, professional design
- **Smooth animations** — Intersection Observer-based scroll animations
- **Custom scrollbar** — Themed gradient scrollbar

### 🌗 Dark/Light Mode
- One-click theme toggle
- Saves preference in localStorage
- Respects all sections, custom elements, and third-party integrations (WooCommerce/bbPress)

### 📱 Fully Responsive
- Mobile-first approach
- Slide-out mobile menu
- Touch-enabled hero slider
- Optimized for all screen sizes

### 🎛️ Extensive Customizer Options
- **Theme Colors** — Primary & Secondary color pickers with official scheme presets
- **Promo Hub (New)** — Customize badge, title, desc, cards, link URLs, and button texts
- **Header** — 5 display modes, solid/gradient backgrounds, direction control
- **Hero Slider** — Up to 7 slides, recent posts or custom selection
- **Portfolio** — Up to 10 projects with images, descriptions, links
- **Blog** — Customizable post count, section texts
- **Resources** — Up to 10 cards with 10 icon choices
- **Team** — Up to 10 members with avatars, bios, social links, custom card headers
- **Newsletter** — Fully customizable CTA section with AJAX subscription
- **Footer** — 4 columns, social links, custom copyright
- **Social Media** — 8 social network URL fields

### ⚡ Performance & Safety
- **XSS Protection** — Fully escaped and sanitized templates (including security patches on search query rendering)
- **UTF-8 Reading Time** — Correct estimated reading times supporting multibyte languages (Persian, Balochi, Arabic, etc.)
- Vanilla JavaScript (no jQuery dependency)
- Lazy loading images

### 🌐 Translation Ready
- Full `.pot` file included
- Compatible with Poedit and Loco Translate plugin
- Text domain: `baloch-diamond`

---

## 📦 Installation

### Method 1: WordPress Dashboard
1. Download the latest release `.zip` file
2. Go to **Appearance → Themes → Add New → Upload Theme**
3. Upload `baloch-diamond.zip`
4. Click **Activate**

### Method 2: FTP/File Manager
1. Extract `baloch-diamond.zip`
2. Upload the `baloch-diamond` folder to `/wp-content/themes/`
3. Go to **Appearance → Themes**
4. Activate **Baloch Diamond**

---

## ⚙️ Setup After Activation

### 1. Set Homepage
Go to Dashboard → Settings → Reading → Select "A static page" or "Your latest posts"

### 2. Customize Theme
Go to Dashboard → Appearance → Customize → 💎 Baloch Diamond Settings

### 3. Create Menus
Go to Dashboard → Appearance → Menus → Create "Primary Menu" and "Footer Menu" → Assign to theme locations

### 4. Set Logo
Go to Dashboard → Appearance → Customize → Site Identity → Upload Logo and Site Icon

### 5. Configure Footer Widgets
Go to Dashboard → Appearance → Widgets → Footer Column 1, 2, 3

---

## 🎨 Customizer Sections

| Section | Options |
|---------|---------|
| 🎨 Theme Colors | Presets selection, Primary color, Secondary color |
| 📣 Promo Hub | Show/hide, customize Forums & Shop headings, texts, links |
| 📌 Header | Display mode (5), Background type, Gradient direction |
| 🖼️ Hero Slider | Source, Count, Custom post IDs (7) |
| 💼 Portfolio | 10 items (image, title, desc, link), Section texts |
| 📝 Blog | Post count, Section texts, Read more text |
| 📚 Resources | 10 items (icon, title, desc, link), Section texts |
| 👥 Team | 10 members (avatar, name, role, bio, socials, header style) |
| 📧 Newsletter | Title, Desc, Placeholder, Button text |
| 🦶 Footer | About text, Column titles, Copyright |
| 📞 Contact | Email, Address, Phone |
| 🔗 Social Media | Twitter, GitHub, LinkedIn, Instagram, Facebook, YouTube, Telegram, WhatsApp |

---

## 📁 File Structure

    baloch-diamond/
    ├── style.css
    ├── functions.php
    ├── index.php
    ├── front-page.php
    ├── header.php
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
    ├── inc/
    │   ├── customizer.php
    │   └── template-functions.php
    ├── template-parts/
    │   ├── hero-slider.php
    │   ├── section-promo-hub.php
    │   ├── section-portfolio.php
    │   ├── section-blog.php
    │   ├── section-resources.php
    │   ├── section-team.php
    │   ├── section-newsletter.php
    │   ├── content.php
    │   ├── content-single.php
    │   └── content-none.php
    ├── assets/
    │   ├── css/
    │   │   └── fonts.css
    │   ├── fonts/
    │   │   ├── poppins-*.woff2
    │   │   ├── playfair-*.woff2
    │   │   └── LICENSE.txt
    │   ├── js/
    │   │   ├── main.js
    │   │   └── customizer-preview.js
    │   └── images/
    └── languages/
        └── baloch-diamond.pot

---

## 🔧 Requirements

- WordPress 6.0 or higher
- PHP 7.4 or higher
- Modern browser (Chrome, Firefox, Safari, Edge)

---

## 📜 Credits

### Fonts
- **Poppins** — Indian Type Foundry ([SIL OFL 1.1](http://scripts.sil.org/OFL))
- **Playfair Display** — Claus Eggers Sorensen ([SIL OFL 1.1](http://scripts.sil.org/OFL))

### Inspiration
- Traditional Balochi needlework patterns (Soozan Doozi)
- The geometric diamond motifs of Balochistan artistry

---

## 📄 License

Baloch Diamond WordPress Theme is licensed under the [GNU General Public License v2 or later](https://www.gnu.org/licenses/gpl-2.0.html).

---

<div align="center">

**Crafted with 💎 inspired by Balochi art & culture**

Made with ❤️ by the Baloch Script Team

</div>

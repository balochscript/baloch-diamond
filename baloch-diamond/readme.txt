=== Baloch Diamond ===
Contributors: balochscript
Tags: blog, portfolio, custom-colors, custom-logo, custom-menu, featured-images, theme-options, translation-ready, one-column, two-columns
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A premium WordPress theme inspired by the timeless beauty of Balochi needlework artistry. Where tradition meets modern web design excellence.

== Description ==

Baloch Diamond is a premium WordPress theme inspired by the timeless beauty of Balochi needlework artistry. It features customizable colors, a hero slider, portfolio showcase, team section, blog section with configurable pagination, and full dark/light mode support.

**Features:**

* **Customizable Colors & Presets** — Choose from built-in color presets (Default, Ocean, Desert, Forest, Royal) or set your own custom colors.
* **Hero Slider** — Full-width hero slider with customizable slides, height, and overlay effects.
* **Blog Section** — Display latest posts on the homepage with two pagination modes: Archive Link button or AJAX Load More.
* **Portfolio Showcase** — Grid layout for showcasing projects and work.
* **Team Section** — Display team members with photos, roles, and social links.
* **WooCommerce Support** — Full compatibility with WooCommerce including product gallery features.
* **Dark/Light Mode** — Toggle between dark and light themes with smooth transitions.
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

= How do I change the blog pagination mode? =

Go to **Appearance → Customize → Blog Section** and select either "Archive Link" or "Load More" under Pagination Mode.

= How do I set up a separate Blog page? =

See the "Setting up the Blog page" section above. The theme uses WordPress's standard `get_post_type_archive_link('post')` function, which automatically handles both reading modes.

= Does the theme work with WooCommerce? =

Yes! Baloch Diamond includes full WooCommerce support with product gallery zoom, lightbox, and slider features.

= How do I enable dark mode? =

Click the dark/light mode toggle button in the bottom-left corner of the screen, or use the settings panel.

== Changelog ==

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

== Upgrade Notice ==

= 1.2.0 =
Important bug fix: The "View All Posts" button now correctly links to the blog archive instead of the homepage. Also adds configurable pagination modes and standard WordPress pagination functions.

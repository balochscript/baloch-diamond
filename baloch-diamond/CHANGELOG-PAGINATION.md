# Pagination Changelog

## v1.2.2 — Standard WordPress Blog Archive

### What Changed

- **Created `home.php`** — The standard WordPress template for the blog index page.
  WordPress automatically uses `home.php` when a "Posts page" is set in
  Settings → Reading. Uses the main WordPress query loop with
  `the_posts_pagination()` for fully native pagination.

- **Removed `page-blog.php`** — No longer needed. The Page Template approach
  has been replaced by the standard `home.php` + `page_for_posts` method.

- **Auto-setup on activation** — `bd_maybe_setup_blog_page()` runs once on
  theme activation and:
  1. Creates a "Blog" page if one doesn't exist
  2. Sets it as `page_for_posts` in Settings → Reading
  3. If `show_on_front='posts'`, also creates a "Home" page and switches
     to `show_on_front='page'`
  4. Respects existing settings — if the user already configured Reading
     settings, nothing is changed

- **Simplified `bd_get_blog_archive_url()`** — Returns
  `get_permalink(page_for_posts)` or empty string. No circular URL issues.

- **Simplified `section-blog.php` URL resolution** — Removed 3-tier fallback
  logic. Now simply calls `bd_get_blog_archive_url()`. If no blog archive
  page exists, the "View All Posts" button is hidden gracefully (no error
  shown to visitors).

- **Updated `front-page.php`** — Added support for `show_on_front='posts'`
  mode: if the user selects "Your latest posts" in Settings → Reading, the
  front page shows the blog index instead of custom sections. This is
  required for WordPress.org theme review compliance.

- **Deprecated `bd_blog_archive_pagination()`** — Marked with
  `_deprecated_function()`. Use `the_posts_pagination()` directly.

- **Standardized pagination CSS** — `.nav-links`, `.page-numbers` styles
  already in `style.css` work with `the_posts_pagination()` output.

### How It Works Now

1. Theme activates → "Blog" page auto-created → set as Posts page
2. Front page (`front-page.php`) shows custom sections
3. Blog section "View All Posts" button → links to `/blog/`
4. `/blog/` loads `home.php` → header + slider + posts grid + pagination + footer
5. `/blog/page/2/` works natively with WordPress rewrite rules
6. `posts_per_page` read from Settings → Reading

### No Visitor-Facing Errors

If `page_for_posts` is not set:
- The "View All Posts" button is simply **not rendered** — no setup notice,
  no error message, nothing shown to visitors. Only the admin sees a note
  in the Customizer control description.

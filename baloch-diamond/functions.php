<?php
/**
 * Baloch Diamond Theme Functions
 *
 * @package Baloch_Diamond
 * @version 1.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Theme version constant
define( 'BD_VERSION', '1.6.2' );

/**
 * ============================================
 * THEME SETUP
 * ============================================
 */
function bd_theme_setup() {

    // Make theme available for translation
    load_theme_textdomain( 'baloch-diamond', get_template_directory() . '/languages' );

    // Add support for post thumbnails
    add_theme_support( 'post-thumbnails' );

    // Custom image sizes
    add_image_size( 'bd-slider', 1400, 800, true );
    add_image_size( 'bd-card', 600, 440, true );
    add_image_size( 'bd-project', 600, 400, true );
    add_image_size( 'bd-related', 400, 250, true );
    add_image_size( 'bd-avatar', 200, 200, true );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Custom logo support
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Automatic feed links
    add_theme_support( 'automatic-feed-links' );

    // Custom background
    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff',
    ) );

    // Wide alignment support for Gutenberg
    add_theme_support( 'align-wide' );

    // Default block styles for a consistent look with the editor
    add_theme_support( 'wp-block-styles' );

    // Editor stylesheet so the block editor matches the front end
    add_editor_style( 'assets/css/editor-style.css' );

    // Responsive embeds
    add_theme_support( 'responsive-embeds' );

    // WooCommerce support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Register navigation menus
    register_nav_menus( array(
        'primary'     => esc_html__( 'Primary Menu', 'baloch-diamond' ),
        'footer'      => esc_html__( 'Footer Menu', 'baloch-diamond' ),
    ) );
}
add_action( 'after_setup_theme', 'bd_theme_setup' );

/**
 * Get the blog archive URL.
 *
 * Returns the permalink of the "Posts page" set in Settings → Reading.
 * If no Posts page is set, returns empty string (the "View All Posts"
 * button will be hidden gracefully — no error shown to visitors).
 *
 * @return string Blog archive URL, or empty string if not configured.
 */
function bd_get_blog_archive_url() {
    $page_id = get_option( 'page_for_posts' );
    if ( $page_id ) {
        return get_permalink( $page_id );
    }
    // Fallback: try get_post_type_archive_link (works when page_for_posts is set)
    $url = get_post_type_archive_link( 'post' );
    if ( $url && untrailingslashit( $url ) !== untrailingslashit( home_url( '/' ) ) ) {
        return $url;
    }
    return '';
}

/**
 * Check whether the blog archive is a SEPARATE page from the front page.
 *
 * @return bool True if there is a distinct blog archive page.
 */
function bd_has_blog_archive_page() {
    return (bool) bd_get_blog_archive_url();
}

/**
 * Starter Content — the WordPress.org-approved way to suggest a
 * "Home" (front page) + "Blog" (posts page) setup.
 *
 * Unlike programmatic page creation, starter content:
 *  - Only applies to FRESH sites (fresh_site flag = true).
 *  - Is only ever imported inside the Customizer preview.
 *  - Is only saved when the USER explicitly clicks "Publish".
 *  - Never touches existing sites or overrides user settings.
 *
 * On existing sites the admin simply sets Settings → Reading →
 * "A static page" manually; the theme degrades gracefully either way
 * (see bd_get_blog_archive_url()).
 */
function bd_register_starter_content() {
    add_theme_support( 'starter-content', array(
        'posts'   => array(
            'home' => array(
                'post_type'  => 'page',
                'post_title' => _x( 'Home', 'Theme starter content', 'baloch-diamond' ),
            ),
            'blog' => array(
                'post_type'  => 'page',
                'post_title' => _x( 'Blog', 'Theme starter content', 'baloch-diamond' ),
            ),
        ),
        'options' => array(
            'show_on_front'  => 'page',
            'page_on_front'  => '{{home}}',
            'page_for_posts' => '{{blog}}',
        ),
    ) );
}
add_action( 'after_setup_theme', 'bd_register_starter_content', 20 );

/**
 * Admin notice (dismissible, once): if no Posts page is configured,
 * politely point the admin to Settings → Reading. The theme never
 * changes these options itself.
 */
function bd_reading_settings_notice() {
    // Only for admins, only when relevant, only if not dismissed
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( get_option( 'page_for_posts' ) || get_user_meta( get_current_user_id(), 'bd_dismiss_reading_notice', true ) ) {
        return;
    }

    // Mark dismissal via query arg
    if ( isset( $_GET['bd_dismiss_reading_notice'] ) && check_admin_referer( 'bd_dismiss_reading_notice' ) ) {
        update_user_meta( get_current_user_id(), 'bd_dismiss_reading_notice', 1 );
        return;
    }

    $settings_url = admin_url( 'options-reading.php' );
    $dismiss_url  = wp_nonce_url( add_query_arg( 'bd_dismiss_reading_notice', '1' ), 'bd_dismiss_reading_notice' );
    ?>
    <div class="notice notice-info">
        <p>
            <strong><?php esc_html_e( 'Baloch Diamond:', 'baloch-diamond' ); ?></strong>
            <?php esc_html_e( 'For the best experience, set a static Front page and a Posts page (e.g. "Blog") so the "View All Posts" button has a destination.', 'baloch-diamond' ); ?>
            <a href="<?php echo esc_url( $settings_url ); ?>"><?php esc_html_e( 'Go to Settings → Reading', 'baloch-diamond' ); ?></a>
            &nbsp;|&nbsp;
            <a href="<?php echo esc_url( $dismiss_url ); ?>"><?php esc_html_e( 'Dismiss', 'baloch-diamond' ); ?></a>
        </p>
    </div>
    <?php
}
add_action( 'admin_notices', 'bd_reading_settings_notice' );

/**
 * Allow /page/N/ pagination on the static front page.
 *
 * WordPress's canonical redirect normally strips /page/N/ from a static
 * front page URL (because the page itself is not paginated with
 * <!--nextpage-->). The front-page blog section paginates a custom
 * query, so when the "Numbered" pagination mode is active we keep
 * those URLs intact. Standard approach used by many portfolio/one-page
 * themes.
 *
 * @param string $redirect_url  The redirect URL.
 * @param string $requested_url The originally requested URL.
 * @return string|false
 */
function bd_front_page_pagination_canonical( $redirect_url, $requested_url ) {
    if ( 'numbered' !== get_theme_mod( 'bd_blog_pagination_mode', 'numbered' ) ) {
        return $redirect_url;
    }
    if ( is_front_page() && ! is_home() && get_query_var( 'page' ) > 1 ) {
        return false;
    }
    return $redirect_url;
}
add_filter( 'redirect_canonical', 'bd_front_page_pagination_canonical', 10, 2 );

/**
 * ============================================
 * ONE-TIME MIGRATION: per-section "Show" checkboxes → sorter JSON
 *
 * Until 1.5.0 every section had its own "Show X Section" checkbox
 * (bd_slider_show, bd_shop_show, …) IN ADDITION to the eye toggle in
 * the drag-and-drop sorter — two places controlling the same thing.
 * From 1.5.1 the sorter is the single source of truth. This migration
 * runs once: any section a user had hidden via the old checkbox is
 * written into bd_sections_layout as visible=false, then the flag is
 * set so it never runs again. The old theme_mods are left untouched
 * (harmless), so downgrading is safe too.
 * ============================================
 */
function bd_migrate_visibility_to_sorter() {
    if ( get_theme_mod( 'bd_visibility_migrated', false ) ) {
        return;
    }

    $keys = array( 'slider', 'shop', 'forum', 'portfolio', 'blog', 'resources', 'team', 'newsletter', 'members', 'topics', 'tags', 'archive' );

    $raw    = get_theme_mod( 'bd_sections_layout', '' );
    $layout = $raw ? json_decode( $raw, true ) : array();
    if ( ! is_array( $layout ) ) {
        $layout = array();
    }

    // Index existing entries by key
    $indexed = array();
    foreach ( $layout as $item ) {
        if ( isset( $item['key'] ) ) {
            $indexed[ $item['key'] ] = $item;
        }
    }

    $changed = false;
    foreach ( $keys as $key ) {
        $legacy_visible = (bool) get_theme_mod( 'bd_' . $key . '_show', true );

        if ( isset( $indexed[ $key ] ) ) {
            // Respect the stricter of the two old switches:
            // hidden anywhere → hidden in the merged result.
            $sorter_visible = ! isset( $indexed[ $key ]['visible'] ) || (bool) $indexed[ $key ]['visible'];
            $merged         = $sorter_visible && $legacy_visible;
            if ( $merged !== $sorter_visible ) {
                $indexed[ $key ]['visible'] = $merged;
                $changed = true;
            }
        } elseif ( ! $legacy_visible ) {
            // Key missing from saved layout but hidden via old checkbox
            $indexed[ $key ] = array( 'key' => $key, 'visible' => false, 'zone' => 'main' );
            $changed = true;
        }
    }

    if ( $changed ) {
        // Preserve original order, append any newly added keys at the end
        $result = array();
        foreach ( $layout as $item ) {
            if ( isset( $item['key'] ) && isset( $indexed[ $item['key'] ] ) ) {
                $result[] = $indexed[ $item['key'] ];
                unset( $indexed[ $item['key'] ] );
            }
        }
        foreach ( $indexed as $item ) {
            $result[] = $item;
        }
        set_theme_mod( 'bd_sections_layout', wp_json_encode( $result ) );
    }

    set_theme_mod( 'bd_visibility_migrated', true );
}
add_action( 'after_setup_theme', 'bd_migrate_visibility_to_sorter', 30 );

/**
 * ============================================
 * COMMENT PROTECTION
 * Customizer: 💎 Baloch Diamond → 🛡️ Comment Protection
 * Extra validation on top of core Discussion settings.
 * ============================================
 */

/**
 * Should the protection filters run for the current commenter?
 *
 * Moderators are always exempt; other logged-in users are exempt
 * unless the admin opted in via bd_comments_filter_logged_in.
 *
 * @return bool
 */
function bd_comment_filters_apply() {
    if ( current_user_can( 'moderate_comments' ) ) {
        return false;
    }
    if ( is_user_logged_in() && ! get_theme_mod( 'bd_comments_filter_logged_in', false ) ) {
        return false;
    }
    return true;
}

/**
 * Validate incoming comments BEFORE they are saved.
 *
 * Runs on preprocess_comment (the standard hook for comment
 * validation). Rejections use wp_die() with a readable message and
 * a back link — identical UX to core's own duplicate/flood checks.
 *
 * @param array $commentdata Comment data.
 * @return array
 */
function bd_validate_comment( $commentdata ) {
    // Only filter real user-submitted comment types
    $type = isset( $commentdata['comment_type'] ) ? $commentdata['comment_type'] : '';
    if ( ! in_array( $type, array( '', 'comment' ), true ) ) {
        return $commentdata;
    }

    if ( ! bd_comment_filters_apply() ) {
        return $commentdata;
    }

    $content = isset( $commentdata['comment_content'] ) ? (string) $commentdata['comment_content'] : '';

    // ---- Length limits ----
    $min = absint( get_theme_mod( 'bd_comments_min_length', 0 ) );
    $max = absint( get_theme_mod( 'bd_comments_max_length', 0 ) );
    $len = function_exists( 'mb_strlen' ) ? mb_strlen( wp_strip_all_tags( $content ) ) : strlen( wp_strip_all_tags( $content ) );

    if ( $min > 0 && $len < $min ) {
        wp_die(
            sprintf(
                /* translators: %d: minimum number of characters. */
                esc_html__( 'Your comment is too short. Please write at least %d characters.', 'baloch-diamond' ),
                (int) $min
            ),
            esc_html__( 'Comment Rejected', 'baloch-diamond' ),
            array( 'response' => 400, 'back_link' => true )
        );
    }

    if ( $max > 0 && $len > $max ) {
        wp_die(
            sprintf(
                /* translators: %d: maximum number of characters. */
                esc_html__( 'Your comment is too long. Please keep it under %d characters.', 'baloch-diamond' ),
                (int) $max
            ),
            esc_html__( 'Comment Rejected', 'baloch-diamond' ),
            array( 'response' => 400, 'back_link' => true )
        );
    }

    // ---- Link blocking ----
    if ( get_theme_mod( 'bd_comments_block_links', false ) ) {
        if ( preg_match( '#(https?://|www\.)\S+#i', $content )
            || preg_match( '#<a\s#i', $content ) ) {
            wp_die(
                esc_html__( 'Comments containing links are not allowed on this site.', 'baloch-diamond' ),
                esc_html__( 'Comment Rejected', 'baloch-diamond' ),
                array( 'response' => 400, 'back_link' => true )
            );
        }
    }

    // ---- Blocked words / character sequences ----
    $blocked_raw = (string) get_theme_mod( 'bd_comments_blocked_words', '' );
    if ( '' !== trim( $blocked_raw ) ) {
        $blocked = array_filter( array_map( 'trim', explode( "\n", $blocked_raw ) ) );
        // Case-insensitive haystack (multibyte-safe)
        $haystack = function_exists( 'mb_strtolower' ) ? mb_strtolower( $content ) : strtolower( $content );
        foreach ( $blocked as $word ) {
            $needle = function_exists( 'mb_strtolower' ) ? mb_strtolower( $word ) : strtolower( $word );
            if ( '' !== $needle && false !== strpos( $haystack, $needle ) ) {
                wp_die(
                    esc_html__( 'Your comment contains words that are not allowed on this site.', 'baloch-diamond' ),
                    esc_html__( 'Comment Rejected', 'baloch-diamond' ),
                    array( 'response' => 400, 'back_link' => true )
                );
            }
        }
    }

    return $commentdata;
}
add_filter( 'preprocess_comment', 'bd_validate_comment' );

/**
 * Optionally strip ALL HTML from comment content before saving.
 *
 * WordPress core already kses-filters untrusted comments (only a small
 * whitelist like <a>, <b>, <blockquote> survives). This option removes
 * even those, storing pure plain text.
 *
 * @param string $content Comment content.
 * @return string
 */
function bd_maybe_strip_comment_html( $content ) {
    if ( get_theme_mod( 'bd_comments_strip_html', false ) && bd_comment_filters_apply() ) {
        $content = wp_strip_all_tags( $content );
    }
    return $content;
}
add_filter( 'pre_comment_content', 'bd_maybe_strip_comment_html', 1 );

/**
 * Defense in depth: kses-filter comment text at DISPLAY time too.
 *
 * Core sanitizes untrusted comments on INPUT; this also protects
 * against markup that entered the database through other routes
 * (imports, plugins calling wp_insert_comment() without filtering).
 * Uses the same allowlist core applies to comment data.
 *
 * @param string $comment_text Comment text being displayed.
 * @return string
 */
function bd_kses_comment_display( $comment_text ) {
    if ( get_theme_mod( 'bd_comments_strip_html', false ) ) {
        return wp_strip_all_tags( $comment_text );
    }
    return wp_kses( $comment_text, 'comment' );
}
add_filter( 'comment_text', 'bd_kses_comment_display', 9 );

/**
 * When "strip HTML" is on, also disable the allowed-tags hint filters
 * so commenters are not misled — and make kses run with an empty
 * allowlist for display of NEW comments (defense in depth).
 */
function bd_comments_disable_html_notice() {
    if ( get_theme_mod( 'bd_comments_strip_html', false ) ) {
        add_filter( 'comment_form_defaults', function ( $defaults ) {
            $defaults['comment_notes_after'] = '';
            return $defaults;
        } );
    }
}
add_action( 'init', 'bd_comments_disable_html_notice' );

/**
 * ============================================
 * BLOCK STYLES & PATTERNS
 * ============================================
 */
function bd_register_block_styles() {
    if ( function_exists( 'register_block_style' ) ) {
        register_block_style( 'core/button', array(
            'name'  => 'bd-gradient',
            'label' => __( 'Diamond Gradient', 'baloch-diamond' ),
            'inline_style' => '.wp-block-button.is-style-bd-gradient .wp-block-button__link{background:linear-gradient(135deg,var(--color-primary,#38bdf8),var(--color-secondary,#f97316));border:none;color:#fff;}',
        ) );

        register_block_style( 'core/quote', array(
            'name'  => 'bd-embroidered',
            'label' => __( 'Embroidered Border', 'baloch-diamond' ),
            'inline_style' => '.wp-block-quote.is-style-bd-embroidered{border-left:3px dashed var(--color-secondary,#f97316);background:var(--bg-alt,#f8fafc);padding:20px 24px;border-radius:0 12px 12px 0;}',
        ) );
    }
}
add_action( 'init', 'bd_register_block_styles' );

function bd_register_block_patterns() {
    if ( function_exists( 'register_block_pattern' ) ) {
        register_block_pattern( 'baloch-diamond/cta-banner', array(
            'title'       => __( 'Diamond CTA Banner', 'baloch-diamond' ),
            'description' => __( 'A call-to-action banner with a gradient heading and button, in the Baloch Diamond style.', 'baloch-diamond' ),
            'categories'  => array( 'call-to-action' ),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"48px","bottom":"48px","left":"24px","right":"24px"}},"border":{"radius":"18px"}},"backgroundColor":"","layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="border-radius:18px;padding-top:48px;padding-right:24px;padding-bottom:48px;padding-left:24px"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">' . esc_html__( 'Where Tradition Meets Modern Design', 'baloch-diamond' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . esc_html__( 'Discover authentic craftsmanship woven into every detail.', 'baloch-diamond' ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-bd-gradient"} -->
<div class="wp-block-button is-style-bd-gradient"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Explore Now', 'baloch-diamond' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
        ) );
    }
}
add_action( 'init', 'bd_register_block_patterns' );

/**
 * ============================================
 * CONTENT WIDTH
 * ============================================
 */
function bd_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'bd_content_width', 800 );
}
add_action( 'after_setup_theme', 'bd_content_width', 0 );

/**
 * ============================================
 * ENQUEUE STYLES & SCRIPTS
 * ============================================
 */
function bd_enqueue_scripts() {

    // Retrieve customizer font keys
    $primary_font            = get_theme_mod( 'bd_primary_font',        'Poppins' );
    $heading_font            = get_theme_mod( 'bd_heading_font',        'Playfair Display' );
    $rtl_font                = get_theme_mod( 'bd_rtl_font',            'Vazirmatn' );
    $custom_primary_font_url = get_theme_mod( 'bd_custom_primary_font', '' );
    $custom_heading_font_url = get_theme_mod( 'bd_custom_heading_font', '' );
    $custom_rtl_font_url     = get_theme_mod( 'bd_custom_rtl_font',     '' );

    // ---------------------------------------------------------------
    // Font map: Customizer key => [ 'slug' => Google Fonts slug,
    //                               'css'  => exact CSS font-family name ]
    // ---------------------------------------------------------------
    $body_fonts = array(
        'Poppins'          => array( 'slug' => 'Poppins:wght@300;400;500;600;700;800;900',          'css' => 'Poppins' ),
        'Roboto'           => array( 'slug' => 'Roboto:wght@300;400;500;700;900',                   'css' => 'Roboto' ),
        'Inter'            => array( 'slug' => 'Inter:wght@300;400;500;600;700;800;900',            'css' => 'Inter' ),
        'Montserrat'       => array( 'slug' => 'Montserrat:wght@300;400;500;600;700;800;900',       'css' => 'Montserrat' ),
        'Lora'             => array( 'slug' => 'Lora:wght@400;500;600;700',                         'css' => 'Lora' ),
        'OpenSans'         => array( 'slug' => 'Open+Sans:wght@300;400;500;600;700;800',            'css' => 'Open Sans' ),
        'Nunito'           => array( 'slug' => 'Nunito:wght@300;400;500;600;700;800;900',           'css' => 'Nunito' ),
        'Rubik'            => array( 'slug' => 'Rubik:wght@300;400;500;600;700;800',               'css' => 'Rubik' ),
        'WorkSans'         => array( 'slug' => 'Work+Sans:wght@300;400;500;600;700;800',            'css' => 'Work Sans' ),
        'DM Sans'          => array( 'slug' => 'DM+Sans:wght@300;400;500;600;700',                 'css' => 'DM Sans' ),
        'Outfit'           => array( 'slug' => 'Outfit:wght@300;400;500;600;700;800',               'css' => 'Outfit' ),
    );

    $heading_fonts = array(
        'Playfair Display' => array( 'slug' => 'Playfair+Display:wght@400;700;900',                'css' => 'Playfair Display' ),
        'PlayfairDisplay'  => array( 'slug' => 'Playfair+Display:wght@400;700;900',                'css' => 'Playfair Display' ),
        'Poppins'          => array( 'slug' => 'Poppins:wght@400;700;900',                         'css' => 'Poppins' ),
        'Montserrat'       => array( 'slug' => 'Montserrat:wght@400;700;900',                      'css' => 'Montserrat' ),
        'Merriweather'     => array( 'slug' => 'Merriweather:wght@300;400;700;900',                'css' => 'Merriweather' ),
        'EBGaramond'       => array( 'slug' => 'EB+Garamond:wght@400;500;600;700',                 'css' => 'EB Garamond' ),
        'Oswald'           => array( 'slug' => 'Oswald:wght@400;500;600;700',                      'css' => 'Oswald' ),
        'BebasNeue'        => array( 'slug' => 'Bebas+Neue',                                       'css' => 'Bebas Neue' ),
    );

    $rtl_fonts = array(
        'Vazirmatn'      => array( 'slug' => 'Vazirmatn:wght@300;400;500;700;900',                  'css' => 'Vazirmatn' ),
        'Cairo'          => array( 'slug' => 'Cairo:wght@300;400;500;700;900',                      'css' => 'Cairo' ),
        'Tajawal'        => array( 'slug' => 'Tajawal:wght@300;400;500;700;900',                    'css' => 'Tajawal' ),
        'Amiri'          => array( 'slug' => 'Amiri:wght@400;700',                                  'css' => 'Amiri' ),
        'NotoSansArabic' => array( 'slug' => 'Noto+Sans_Arabic:wght@400;500;600;700',               'css' => 'Noto Sans Arabic' ),
        'Almarai'        => array( 'slug' => 'Almarai:wght@300;400;700;800',                        'css' => 'Almarai' ),
    );

    // ---------------------------------------------------------------
    // Build Google Fonts URL — collect unique slugs
    // ---------------------------------------------------------------
    $font_slugs = array();

    // Body font
    if ( $primary_font === 'custom' && ! empty( $custom_primary_font_url ) ) {
        // Custom upload — no Google Fonts needed
    } elseif ( isset( $body_fonts[ $primary_font ] ) ) {
        $font_slugs[] = $body_fonts[ $primary_font ]['slug'];
    }

    // Heading font
    if ( $heading_font === 'custom' && ! empty( $custom_heading_font_url ) ) {
        // Custom upload
    } elseif ( isset( $heading_fonts[ $heading_font ] ) ) {
        $slug = $heading_fonts[ $heading_font ]['slug'];
        if ( ! in_array( $slug, $font_slugs, true ) ) {
            $font_slugs[] = $slug;
        }
    }

    // RTL font
    if ( $rtl_font !== 'custom' && $rtl_font !== 'system' && isset( $rtl_fonts[ $rtl_font ] ) ) {
        $slug = $rtl_fonts[ $rtl_font ]['slug'];
        if ( ! in_array( $slug, $font_slugs, true ) ) {
            $font_slugs[] = $slug;
        }
    }

    // Enqueue Google Fonts
    if ( ! empty( $font_slugs ) ) {
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', $font_slugs ) . '&display=swap';
        wp_enqueue_style( 'bd-google-fonts', $fonts_url, array(), null );
    }

    // Main theme stylesheet.
    // Cache-bust with filemtime so CDNs (e.g. Cloudflare) always fetch the
    // fresh file after a theme update, even if BD_VERSION is unchanged.
    $bd_style_path = get_template_directory() . '/style.css';
    $bd_style_ver  = file_exists( $bd_style_path ) ? BD_VERSION . '.' . filemtime( $bd_style_path ) : BD_VERSION;
    wp_enqueue_style( 'bd-style', get_stylesheet_uri(), array(), $bd_style_ver );

    // Main JavaScript
    wp_enqueue_script(
        'bd-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        BD_VERSION,
        true
    );

    // Pass PHP data to JavaScript
    wp_localize_script( 'bd-main', 'bdData', array(
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'nonce'     => wp_create_nonce( 'bd_nonce' ),
        'homeUrl'   => home_url( '/' ),
        'themeUrl'  => get_template_directory_uri(),
        'i18n'      => array(
            'searchPlaceholder' => esc_html__( 'Search posts, projects, docs...', 'baloch-diamond' ),
            'noResults'         => esc_html__( 'No results found for', 'baloch-diamond' ),
            'navigation'        => esc_html__( 'Navigation', 'baloch-diamond' ),
            'viewArchive'       => esc_html__( 'View Full Archive', 'baloch-diamond' ),
        ),
    ) );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'bd_enqueue_scripts' );

/**
 * ============================================
 * REGISTER WIDGET AREAS
 * ============================================
 */
function bd_widgets_init() {

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 1', 'baloch-diamond' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Widgets in footer column 1', 'baloch-diamond' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 2', 'baloch-diamond' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Widgets in footer column 2', 'baloch-diamond' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 3', 'baloch-diamond' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Widgets in footer column 3', 'baloch-diamond' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'bd_widgets_init' );

/**
 * ============================================
 * CUSTOMIZER
 * ============================================
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * ============================================
 * TEMPLATE FUNCTIONS
 * ============================================
 */
require_once get_template_directory() . '/inc/template-functions.php';

/**
 * ============================================
 * THEME MODE COLOR HELPERS
 * Derive readable shades from a single custom
 * background color so text never clashes.
 * ============================================
 */

/**
 * Hex → [r, g, b].
 *
 * @param string $hex e.g. #aabbcc or #abc.
 * @return array|null
 */
function bd_hex_to_rgb( $hex ) {
    $hex = ltrim( (string) $hex, '#' );
    if ( 3 === strlen( $hex ) ) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    if ( 6 !== strlen( $hex ) || ! ctype_xdigit( $hex ) ) {
        return null;
    }
    return array( hexdec( substr( $hex, 0, 2 ) ), hexdec( substr( $hex, 2, 2 ) ), hexdec( substr( $hex, 4, 2 ) ) );
}

/**
 * Mix a color towards white (positive amount) or black (negative amount).
 *
 * @param string $hex    Base color.
 * @param float  $amount -1..1 (0.1 = 10% towards white, -0.1 = 10% towards black).
 * @return string        Hex color.
 */
function bd_shade( $hex, $amount ) {
    $rgb = bd_hex_to_rgb( $hex );
    if ( ! $rgb ) {
        return $hex;
    }
    $target = $amount >= 0 ? 255 : 0;
    $amount = min( 1, abs( $amount ) );
    foreach ( $rgb as $i => $c ) {
        $rgb[ $i ] = (int) round( $c + ( $target - $c ) * $amount );
    }
    return sprintf( '#%02x%02x%02x', $rgb[0], $rgb[1], $rgb[2] );
}

/**
 * Relative luminance (0 = black, 1 = white) — WCAG formula (simplified).
 *
 * @param string $hex Color.
 * @return float
 */
function bd_luminance( $hex ) {
    $rgb = bd_hex_to_rgb( $hex );
    if ( ! $rgb ) {
        return 1.0;
    }
    return ( 0.2126 * $rgb[0] + 0.7152 * $rgb[1] + 0.0722 * $rgb[2] ) / 255;
}

/**
 * Build a full, contrast-safe palette from one background color.
 *
 * Light backgrounds get dark text; dark backgrounds get light text —
 * regardless of which "mode" the admin put the color in, so a user
 * choosing a dark color for light mode still gets readable text.
 *
 * @param string $bg Background hex color.
 * @return array     bg, bg_alt, card_bg, border, text, text_muted, shadow.
 */
function bd_palette_from_bg( $bg ) {
    $is_light = bd_luminance( $bg ) >= 0.5;

    if ( $is_light ) {
        return array(
            'bg'         => $bg,
            'bg_alt'     => bd_shade( $bg, -0.045 ),
            'card_bg'    => bd_shade( $bg, 0.5 ),
            'border'     => bd_shade( $bg, -0.12 ),
            'text'       => '#1e293b',
            'text_muted' => '#5b6b7f',
            'shadow'     => '0 4px 24px rgba(0,0,0,0.08)',
        );
    }

    return array(
        'bg'         => $bg,
        'bg_alt'     => bd_shade( $bg, 0.07 ),
        'card_bg'    => bd_shade( $bg, 0.07 ),
        'border'     => bd_shade( $bg, 0.18 ),
        'text'       => '#f1f5f9',
        'text_muted' => bd_shade( $bg, 0.55 ),
        'shadow'     => '0 4px 24px rgba(0,0,0,0.3)',
    );
}

/**
 * ============================================
 * DYNAMIC CSS OUTPUT (Colors from Customizer)
 * ============================================
 */
function bd_dynamic_css() {

    $preset = get_theme_mod( 'bd_color_preset', 'default' );

    $presets = array(
        'default' => array( 'primary' => '#38bdf8', 'secondary' => '#f97316' ),
        'ocean'   => array( 'primary' => '#0ea5e9', 'secondary' => '#06b6d4' ),
        'desert'  => array( 'primary' => '#f97316', 'secondary' => '#ef4444' ),
        'forest'  => array( 'primary' => '#10b981', 'secondary' => '#059669' ),
        'royal'   => array( 'primary' => '#8b5cf6', 'secondary' => '#ec4899' ),
    );

    if ( $preset !== 'custom' && isset( $presets[ $preset ] ) ) {
        $primary   = $presets[ $preset ]['primary'];
        $secondary = $presets[ $preset ]['secondary'];
    } else {
        $primary   = get_theme_mod( 'bd_primary_color', '#38bdf8' );
        $secondary = get_theme_mod( 'bd_secondary_color', '#f97316' );
    }

    // Header settings
    $header_bg_type = get_theme_mod( 'bd_header_bg_type', 'default' );
    $header_bg_color = get_theme_mod( 'bd_header_bg_color', '' );
    $header_grad_1 = get_theme_mod( 'bd_header_gradient_1', '#38bdf8' );
    $header_grad_2 = get_theme_mod( 'bd_header_gradient_2', '#f97316' );
    $header_grad_direction = get_theme_mod( 'bd_header_gradient_direction', '135deg' );

    // Resolve font CSS names directly
    $primary_font_key        = get_theme_mod( 'bd_primary_font',        'Poppins' );
    $heading_font_key        = get_theme_mod( 'bd_heading_font',        'Playfair Display' );
    $rtl_font_key            = get_theme_mod( 'bd_rtl_font',            'Vazirmatn' );
    $custom_primary_font_url = get_theme_mod( 'bd_custom_primary_font', '' );
    $custom_heading_font_url = get_theme_mod( 'bd_custom_heading_font', '' );
    $custom_rtl_font_url     = get_theme_mod( 'bd_custom_rtl_font',     '' );

    $body_font_names = array(
        'Poppins'    => 'Poppins', 'Roboto'     => 'Roboto', 'Inter'      => 'Inter',
        'Montserrat' => 'Montserrat', 'Lora'       => 'Lora', 'OpenSans'   => 'Open Sans',
        'Nunito'     => 'Nunito', 'Rubik'      => 'Rubik', 'WorkSans'   => 'Work Sans',
        'DM Sans'    => 'DM Sans', 'Outfit'     => 'Outfit',
    );
    $heading_font_names = array(
        'Playfair Display' => 'Playfair Display', 'PlayfairDisplay'  => 'Playfair Display',
        'Poppins'          => 'Poppins', 'Montserrat'       => 'Montserrat',
        'Merriweather'     => 'Merriweather', 'EBGaramond'       => 'EB Garamond',
        'Oswald'           => 'Oswald', 'BebasNeue'        => 'Bebas Neue',
    );
    $rtl_font_names = array(
        'Vazirmatn'      => 'Vazirmatn', 'Cairo'          => 'Cairo',
        'Tajawal'        => 'Tajawal', 'Amiri'          => 'Amiri',
        'NotoSansArabic' => 'Noto Sans Arabic', 'Almarai'        => 'Almarai',
    );

    if ( $primary_font_key === 'custom' && ! empty( $custom_primary_font_url ) ) {
        $font_body = 'CustomPrimaryFont';
    } else {
        $font_body = isset( $body_font_names[ $primary_font_key ] ) ? $body_font_names[ $primary_font_key ] : 'Poppins';
    }

    if ( $heading_font_key === 'custom' && ! empty( $custom_heading_font_url ) ) {
        $font_heading = 'CustomHeadingFont';
    } else {
        $font_heading = isset( $heading_font_names[ $heading_font_key ] ) ? $heading_font_names[ $heading_font_key ] : 'Playfair Display';
    }

    if ( $rtl_font_key === 'system' ) {
        $font_rtl = null;
    } elseif ( $rtl_font_key === 'custom' && ! empty( $custom_rtl_font_url ) ) {
        $font_rtl = 'CustomRTLFont';
    } else {
        $font_rtl = isset( $rtl_font_names[ $rtl_font_key ] ) ? $rtl_font_names[ $rtl_font_key ] : 'Vazirmatn';
    }

    $slider_height       = get_theme_mod( 'bd_slider_height',       '55vh' );
    $slider_shadow_color = get_theme_mod( 'bd_slider_shadow_color', 'rgba(0,0,0,0.5)' );
    $embroidery_thread_1 = get_theme_mod( 'bd_embroidery_thread_1', '#fde68a' );
    $embroidery_thread_2 = get_theme_mod( 'bd_embroidery_thread_2', '#ffffff' );

    // Custom light/dark mode backgrounds → derived, contrast-safe palettes
    $light_bg      = get_theme_mod( 'bd_light_bg_color', '' );
    $dark_bg       = get_theme_mod( 'bd_dark_bg_color', '' );
    $light_palette = ( $light_bg && bd_hex_to_rgb( $light_bg ) ) ? bd_palette_from_bg( $light_bg ) : null;
    $dark_palette  = ( $dark_bg && bd_hex_to_rgb( $dark_bg ) ) ? bd_palette_from_bg( $dark_bg ) : null;

    // Slider text-overlay color + strength (fully user-adjustable, 0–100%)
    $overlay_hex   = get_theme_mod( 'bd_slider_overlay_color', '#000000' );
    $overlay_rgb   = bd_hex_to_rgb( $overlay_hex );
    if ( ! $overlay_rgb ) {
        $overlay_rgb = array( 0, 0, 0 );
    }
    $overlay_alpha = max( 0, min( 100, absint( get_theme_mod( 'bd_slider_overlay_opacity', 80 ) ) ) ) / 100;
    ?>
    <style id="bd-dynamic-css">
        :root {
            --color-primary:   <?php echo esc_attr( $primary ); ?>;
            --color-secondary: <?php echo esc_attr( $secondary ); ?>;
            --gradient:        linear-gradient(135deg, <?php echo esc_attr( $primary ); ?>, <?php echo esc_attr( $secondary ); ?>);
            --gradient-reverse:linear-gradient(135deg, <?php echo esc_attr( $secondary ); ?>, <?php echo esc_attr( $primary ); ?>);
            --bd-slider-height:<?php echo esc_attr( $slider_height ); ?>;
            --bd-slide-overlay-rgb: <?php echo esc_attr( implode( ', ', $overlay_rgb ) ); ?>;
            --bd-slide-overlay-alpha: <?php echo esc_attr( $overlay_alpha ); ?>;
            --bd-embroidery-thread-1: <?php echo esc_attr( $embroidery_thread_1 ); ?>;
            --bd-embroidery-thread-2: <?php echo esc_attr( $embroidery_thread_2 ); ?>;
            --font-body:    '<?php echo esc_attr( $font_body ); ?>', sans-serif;
            --font-heading: '<?php echo esc_attr( $font_heading ); ?>', serif;
            --font-rtl:     <?php echo $font_rtl ? "'" . esc_attr( $font_rtl ) . "', sans-serif" : 'sans-serif'; ?>;
        }

        <?php if ( $light_palette ) : ?>
        /* Custom LIGHT mode palette (derived from one admin color) */
        :root, [data-theme="light"] {
            --bg:         <?php echo esc_attr( $light_palette['bg'] ); ?>;
            --bg-alt:     <?php echo esc_attr( $light_palette['bg_alt'] ); ?>;
            --card-bg:    <?php echo esc_attr( $light_palette['card_bg'] ); ?>;
            --border:     <?php echo esc_attr( $light_palette['border'] ); ?>;
            --text:       <?php echo esc_attr( $light_palette['text'] ); ?>;
            --text-muted: <?php echo esc_attr( $light_palette['text_muted'] ); ?>;
            --shadow:     <?php echo esc_attr( $light_palette['shadow'] ); ?>;
        }
        <?php endif; ?>

        <?php if ( $dark_palette ) : ?>
        /* Custom DARK mode palette (derived from one admin color) */
        [data-theme="dark"] {
            --bg:         <?php echo esc_attr( $dark_palette['bg'] ); ?>;
            --bg-alt:     <?php echo esc_attr( $dark_palette['bg_alt'] ); ?>;
            --card-bg:    <?php echo esc_attr( $dark_palette['card_bg'] ); ?>;
            --border:     <?php echo esc_attr( $dark_palette['border'] ); ?>;
            --text:       <?php echo esc_attr( $dark_palette['text'] ); ?>;
            --text-muted: <?php echo esc_attr( $dark_palette['text_muted'] ); ?>;
            --shadow:     <?php echo esc_attr( $dark_palette['shadow'] ); ?>;
        }
        <?php endif; ?>

        *, body, p, a, span, li, td, th, label, input, button, select, textarea, blockquote, figcaption,
        .menu-item, .footer-links a, .post-card-excerpt, .post-card-title a,
        .project-card-excerpt, .doc-desc, .team-bio, .team-role, .slide-excerpt,
        .read-more, .btn-gradient, .btn-outline, .section-desc, .search-input,
        .newsletter-input, .newsletter-btn, .comment-text, .comment-body,
        .wp-block-paragraph, .entry-content p, .entry-content li, .entry-content a,
        .single-post-content p, .single-post-content li,
        .single-post-content a:not(.btn-gradient):not(.btn-outline) {
            font-family: var(--font-body) !important;
        }

        h1, h2, h3, h4, h5, h6, .site-name, .slide-title, .section-title,
        .post-card-title, .post-card-title a, .project-card-title, .project-card-title a,
        .doc-title, .team-name, .newsletter-title, .footer-logo-text,
        .error-number, .error-title, .single-post-content h1,
        .single-post-content h2, .single-post-content h3, .single-post-content h4,
        .single-post-content h5, .single-post-content h6, .comment-author,
        .comment-form-wrapper h4, .entry-content h1, .entry-content h2,
        .entry-content h3, .entry-content h4, .entry-content h5,
        .entry-content h6, .wp-block-heading {
            font-family: var(--font-heading) !important;
        }

        .slide-title {
            text-shadow: 0 2px 10px <?php echo esc_attr( $slider_shadow_color ); ?>, 0 4px 20px rgba(0,0,0,0.3) !important;
        }

        .hero-slider { height: var(--bd-slider-height) !important; }

        body.rtl *, body.rtl, body.rtl p, body.rtl a, body.rtl span, body.rtl li,
        body.rtl button, body.rtl input, body.rtl select, body.rtl textarea,
        body.rtl h1, body.rtl h2, body.rtl h3, body.rtl h4, body.rtl h5, body.rtl h6,
        body.rtl .site-name, body.rtl .section-title, body.rtl .section-desc,
        body.rtl .post-card-title, body.rtl .post-card-excerpt,
        body.rtl .project-card-title, body.rtl .project-card-excerpt,
        body.rtl .doc-title, body.rtl .doc-desc, body.rtl .team-name,
        body.rtl .team-role, body.rtl .team-bio, body.rtl .product-title,
        body.rtl .slide-title, body.rtl .slide-excerpt, body.rtl .newsletter-title,
        body.rtl .footer-links a, body.rtl .menu-item, body.rtl .entry-content {
            font-family: var(--font-rtl) !important;
        }

        <?php if ( ! empty( $custom_primary_font_url ) ) : ?>
        @font-face { font-family: 'CustomPrimaryFont'; src: url('<?php echo esc_url( $custom_primary_font_url ); ?>') format('woff2'); font-weight: 100 900; font-style: normal; font-display: swap; }
        <?php endif; ?>
        <?php if ( ! empty( $custom_heading_font_url ) ) : ?>
        @font-face { font-family: 'CustomHeadingFont'; src: url('<?php echo esc_url( $custom_heading_font_url ); ?>') format('woff2'); font-weight: 100 900; font-style: normal; font-display: swap; }
        <?php endif; ?>
        <?php if ( ! empty( $custom_rtl_font_url ) ) : ?>
        @font-face { font-family: 'CustomRTLFont'; src: url('<?php echo esc_url( $custom_rtl_font_url ); ?>') format('woff2'); font-weight: 100 900; font-style: normal; font-display: swap; }
        <?php endif; ?>

        <?php if ( $header_bg_type === 'solid' && $header_bg_color ) : ?>
        .site-header { background: <?php echo esc_attr( $header_bg_color ); ?>; }
        <?php elseif ( $header_bg_type === 'gradient' ) : ?>
        .site-header { background: linear-gradient(<?php echo esc_attr( $header_grad_direction ); ?>, <?php echo esc_attr( $header_grad_1 ); ?>, <?php echo esc_attr( $header_grad_2 ); ?>); }
        .site-header .header-icon, .site-header .site-name { color: white; -webkit-text-fill-color: white; }
        <?php endif; ?>
    </style>
    <?php
}
add_action( 'wp_head', 'bd_dynamic_css', 100 );

/**
 * ============================================
 * HELPER FUNCTIONS
 * ============================================
 */

function bd_get_logo_svg() {
    return '<svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="logoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:var(--color-primary)"/><stop offset="100%" style="stop-color:var(--color-secondary)"/></linearGradient></defs><path d="M30 4 L50 22 L30 56 L10 22Z" stroke="url(#logoGrad)" stroke-width="2.5" fill="none"/><path d="M30 12 L42 22 L30 46 L18 22Z" stroke="url(#logoGrad)" stroke-width="1.5" fill="none" opacity="0.6"/><path d="M10 22 L50 22" stroke="url(#logoGrad)" stroke-width="1.5" opacity="0.4"/><path d="M30 4 L22 22 M30 4 L38 22" stroke="url(#logoGrad)" stroke-width="1" opacity="0.3"/><circle cx="30" cy="22" r="3" fill="url(#logoGrad)" opacity="0.5"/></svg>';
}

function bd_get_footer_logo_svg() {
    return '<svg width="36" height="36" viewBox="0 0 60 60" fill="none"><path d="M30 4 L50 22 L30 56 L10 22Z" stroke="var(--color-primary)" stroke-width="2.5" fill="none"/><path d="M30 12 L42 22 L30 46 L18 22Z" stroke="var(--color-secondary)" stroke-width="1.5" fill="none" opacity="0.6"/><circle cx="30" cy="22" r="3" fill="var(--color-primary)" opacity="0.5"/></svg>';
}

function bd_icon( $name, $width = 24, $height = 24 ) {

    $icons = array(
        'search' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
        'menu' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" width="' . $width . '" height="' . $height . '"><line x1="3" y1="6" x2="21" y2="6"/><line x1="7" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>',
        'close' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
        'check-circle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>',
        'home' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>',
        'file-text' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10,9 9,9 8,9"/></svg>',
        'user' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
        'tag' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>',
        'arrow-right' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12,5 19,12 12,19"/></svg>',
        'arrow-right-small' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12,5 19,12 12,19"/></svg>',
        'arrow-left' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12,19 5,12 12,5"/></svg>',
        'calendar' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
        'comment' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>',
        'users' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'monitor' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
        'twitter' => '<svg viewBox="0 0 24 24" fill="currentColor" width="' . $width . '" height="' . $height . '"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
        'github' => '<svg viewBox="0 0 24 24" fill="currentColor" width="' . $width . '" height="' . $height . '"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>',
        'linkedin' => '<svg viewBox="0 0 24 24" fill="currentColor" width="' . $width . '" height="' . $height . '"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
        'instagram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
        'send' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22,2 15,22 11,13 2,9 22,2"/></svg>',
        'phone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
        'map-pin' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
        'mail' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
        'settings' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>',
        'sun' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>',
        'moon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>',
        'shopping-cart' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>',
        'clock' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>',
        'book' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
        'shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        'zap' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><polygon points="13,2 3,14 12,14 11,22 21,10 12,10 13,2"/></svg>',
        'code' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><polyline points="16,18 22,12 16,6"/><polyline points="8,6 2,12 8,18"/></svg>',
        'globe' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
    );

    return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * ============================================
 * BODY CLASSES
 * ============================================
 */
function bd_body_classes( $classes ) {
    if ( is_front_page() ) { $classes[] = 'is-front-page'; }
    if ( is_singular() ) { $classes[] = 'is-singular'; }
    if ( get_theme_mod( 'bd_animated_patterns', true ) ) { $classes[] = 'balochi-pattern-animated'; }
    if ( get_theme_mod( 'bd_skeleton_loading', true ) ) { $classes[] = 'skeleton-enabled'; }
    if ( get_theme_mod( 'bd_embroidery_enable', false ) ) { $classes[] = 'bd-embroidery-enabled'; }
    return $classes;
}
add_filter( 'body_class', 'bd_body_classes' );

/**
 * ============================================
 * MOBILE MENU WALKER
 * ============================================
 */
class BD_Mobile_Menu_Walker extends Walker_Nav_Menu {
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $title = apply_filters( 'nav_menu_item_title', esc_html( $item->title ), $item, $args, $depth );
        $output .= '<a class="menu-item" href="' . esc_url( $item->url ) . '"' . $class_names . '>' . $title . '</a>';
    }
}

// ============================================
// MEMBERS / USER HELPERS
// ============================================

function bd_get_user_display_name() {
    if ( is_user_logged_in() ) {
        $current_user = wp_get_current_user();
        return $current_user->display_name ?: $current_user->user_login;
    }
    return '';
}

function bd_get_account_url() {
    if ( class_exists( 'WooCommerce' ) ) { return wc_get_page_permalink( 'myaccount' ); }
    return home_url( '/my-account' );
}

/**
 * ============================================
 * AJAX HANDLERS
 * ============================================
 */

function bd_ajax_search() {
    check_ajax_referer( 'bd_nonce', 'nonce' );
    $query = isset( $_POST['query'] ) ? sanitize_text_field( wp_unslash( $_POST['query'] ) ) : '';
    if ( strlen( $query ) < 2 ) { wp_send_json_success( array() ); }

    $search_query = new WP_Query( array(
        'post_type'      => array( 'post', 'page' ),
        'post_status'    => 'publish',
        'posts_per_page' => 8,
        's'              => $query,
        'orderby'        => 'relevance',
    ) );

    $results = array();
    if ( $search_query->have_posts() ) {
        while ( $search_query->have_posts() ) {
            $search_query->the_post();
            $results[] = array(
                'id'    => get_the_ID(),
                // Defense-in-depth: strip any markup server-side too;
                // the JS layer additionally HTML-escapes before rendering.
                'title' => wp_strip_all_tags( get_the_title() ),
                'url'   => esc_url_raw( get_permalink() ),
                'type'  => get_post_type(),
                'desc'  => wp_strip_all_tags( wp_trim_words( get_the_excerpt(), 12 ) ),
            );
        }
        wp_reset_postdata();
    }
    wp_send_json_success( $results );
}
add_action( 'wp_ajax_bd_search', 'bd_ajax_search' );
add_action( 'wp_ajax_nopriv_bd_search', 'bd_ajax_search' );

function bd_ajax_subscribe() {
    check_ajax_referer( 'bd_nonce', 'nonce' );
    $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    if ( ! is_email( $email ) ) { wp_send_json_error( esc_html__( 'Please enter a valid email address.', 'baloch-diamond' ) ); }

    $subscribers   = get_theme_mod( 'bd_newsletter_subscribers', array() );
    $subscribers   = is_array( $subscribers ) ? $subscribers : array();
    if ( in_array( $email, $subscribers, true ) ) { wp_send_json_success( esc_html__( 'You are already subscribed!', 'baloch-diamond' ) ); }

    // Storage cap: theme_mods load on every request, so an unauthenticated
    // endpoint must never grow one unboundedly (flood/DoS hardening).
    if ( count( $subscribers ) >= 5000 ) {
        wp_send_json_error( esc_html__( 'Subscription list is full. Please contact the site owner.', 'baloch-diamond' ) );
    }

    $subscribers[] = $email;
    set_theme_mod( 'bd_newsletter_subscribers', $subscribers );
    wp_send_json_success( esc_html__( 'Thanks for subscribing!', 'baloch-diamond' ) );
}
add_action( 'wp_ajax_bd_subscribe', 'bd_ajax_subscribe' );
add_action( 'wp_ajax_nopriv_bd_subscribe', 'bd_ajax_subscribe' );

function bd_ajax_loadmore() {
    check_ajax_referer( 'bd_nonce', 'nonce' );

    // Clamp all client-supplied numbers to sane ranges so a malicious
    // request can't force an unbounded/expensive query (DoS hardening).
    $page           = isset( $_POST['page'] ) ? min( 500, max( 1, absint( $_POST['page'] ) ) ) : 1;
    $per_page       = isset( $_POST['per_page'] ) ? min( 50, max( 1, absint( $_POST['per_page'] ) ) ) : 6;
    $initial_count  = isset( $_POST['initial_count'] ) ? min( 50, max( 1, absint( $_POST['initial_count'] ) ) ) : 6;
    $offset         = $initial_count + ( ( $page - 1 ) * $per_page );

    $show_thumbnail  = get_theme_mod( 'bd_blog_show_thumbnail',  true );
    $show_date_badge = get_theme_mod( 'bd_blog_show_date_badge', true );
    $show_author     = get_theme_mod( 'bd_blog_show_author',     true );
    $show_comments   = get_theme_mod( 'bd_blog_show_comments',   true );
    $show_category   = get_theme_mod( 'bd_blog_show_category',   true );
    $show_excerpt    = get_theme_mod( 'bd_blog_show_excerpt',    true );
    $show_readmore   = get_theme_mod( 'bd_blog_show_readmore',   true );
    $read_more_text  = get_theme_mod( 'bd_blog_readmore_text',   esc_html__( 'Read More', 'baloch-diamond' ) );

    $query = new WP_Query( array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'offset'         => $offset,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    if ( ! $query->have_posts() ) {
        wp_send_json_success( array( 'html' => '', 'has_more' => false, 'loaded' => 0 ) );
    }

    ob_start();
    while ( $query->have_posts() ) : $query->the_post();
    ?>
    <article class="post-card bd-newly-loaded">
        <?php if ( $show_thumbnail ) : ?>
        <div class="post-card-img-wrapper">
            <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'bd-card' ); ?></a>
            <?php else : ?>
            <a href="<?php the_permalink(); ?>" style="display:flex;height:100%;background:var(--bg-alt);align-items:center;justify-content:center;">
                <div style="opacity:0.15;"><?php echo bd_icon( 'file-text', 48, 48 ); ?></div>
            </a>
            <?php endif; ?>
            <?php if ( $show_date_badge ) : ?>
            <div class="post-date-badge"><span class="day"><?php echo get_the_date( 'j' ); ?></span><span class="month"><?php echo get_the_date( 'M' ); ?></span></div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="post-card-body">
            <?php if ( $show_author || $show_comments || $show_category ) : ?>
            <div class="post-meta">
                <?php if ( $show_category ) : $cats = get_the_category(); if ( ! empty( $cats ) ) : ?>
                <a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>" class="post-meta-item" style="color:var(--color-primary);font-weight:600;text-decoration:none;"><?php echo bd_icon( 'tag', 14, 14 ); ?><?php echo esc_html( $cats[0]->name ); ?></a>
                <?php endif; endif; ?>
                <?php if ( $show_author ) : ?><span class="post-meta-item"><?php echo bd_icon( 'user', 14, 14 ); ?><?php the_author(); ?></span><?php endif; ?>
                <?php if ( $show_comments ) : ?><span class="post-meta-item"><?php echo bd_icon( 'comment', 14, 14 ); ?><?php printf( esc_html( _n( '%s Comment', '%s Comments', get_comments_number(), 'baloch-diamond' ) ), number_format_i18n( get_comments_number() ) ); ?></span><?php endif; ?>
            </div>
            <?php endif; ?>
            <h3 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php if ( $show_excerpt ) : ?><p class="post-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p><?php endif; ?>
            <?php if ( $show_readmore ) : ?><a href="<?php the_permalink(); ?>" class="read-more"><?php echo esc_html( $read_more_text ); ?><?php echo bd_icon( 'arrow-right', 16, 16 ); ?></a><?php endif; ?>
        </div>
    </article>
    <?php
    endwhile;
    wp_reset_postdata();
    $html = ob_get_clean();

    $total_publish = wp_count_posts( 'post' );
    $total_publish = isset( $total_publish->publish ) ? (int) $total_publish->publish : 0;
    $shown         = $offset + $query->post_count;
    $has_more      = ( $shown < $total_publish );

    wp_send_json_success( array(
        'html'      => $html,
        'has_more'  => $has_more,
        'loaded'    => $query->post_count,
        'shown'     => $shown,
        'total'     => $total_publish,
    ) );
}
add_action( 'wp_ajax_bd_loadmore', 'bd_ajax_loadmore' );
add_action( 'wp_ajax_nopriv_bd_loadmore', 'bd_ajax_loadmore' );

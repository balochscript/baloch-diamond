<?php
/**
 * Front Page Template — Multi-Column Zone Layout
 *
 * Sections are rendered in the order, visibility AND column-zone defined by
 * the admin via the drag-and-drop sorter in:
 * Appearance → Customize → 💎 Baloch Diamond Settings → 📋 Sections Order & Visibility
 *
 * Zones:
 *   'main'  → the central (default) column
 *   'left'  → left sidebar  (created automatically when at least one section is placed there)
 *   'right' → right sidebar (created automatically when at least one section is placed there)
 *
 * Locked sections (always full/main, never movable to a sidebar):
 *   - slider     (hero, always rendered full-width at the top in multi-column mode)
 *   - newsletter (wide banner, stays in the main column)
 *   - blog       (stays in the main column; its cards shrink automatically when a sidebar exists)
 *
 * @package Baloch_Diamond
 * @version 1.3.0
 */

get_header();

// ---- Sections that can never be moved into a sidebar ----
$bd_locked_sections = array( 'slider', 'newsletter', 'blog' );

// ---- Default section order (used on first install) ----
// topics / tags / archive ship HIDDEN by default — enable them in the sorter.
$bd_default_layout = array(
    array( 'key' => 'slider',     'visible' => true,  'zone' => 'main' ),
    array( 'key' => 'shop',       'visible' => true,  'zone' => 'main' ),
    array( 'key' => 'forum',      'visible' => true,  'zone' => 'main' ),
    array( 'key' => 'portfolio',  'visible' => true,  'zone' => 'main' ),
    array( 'key' => 'blog',       'visible' => true,  'zone' => 'main' ),
    array( 'key' => 'topics',     'visible' => false, 'zone' => 'main' ),
    array( 'key' => 'tags',       'visible' => false, 'zone' => 'main' ),
    array( 'key' => 'archive',    'visible' => false, 'zone' => 'main' ),
    array( 'key' => 'resources',  'visible' => true,  'zone' => 'main' ),
    array( 'key' => 'team',       'visible' => true,  'zone' => 'main' ),
    array( 'key' => 'newsletter', 'visible' => true,  'zone' => 'main' ),
    array( 'key' => 'members',    'visible' => true,  'zone' => 'main' ),
);

// ---- Read saved layout from Customizer ----
$raw    = get_theme_mod( 'bd_sections_layout', '' );
$layout = $raw ? json_decode( $raw, true ) : array();

// Fallback: if JSON is empty/invalid, use default
if ( ! is_array( $layout ) || empty( $layout ) ) {
    $layout = $bd_default_layout;
}

// ---- Merge in any NEW section keys missing from a saved layout ----
// (e.g. topics/tags/archive added in 1.4.0 — appended hidden so
// existing sites keep their exact current appearance)
$bd_saved_keys = array();
foreach ( $layout as $item ) {
    if ( isset( $item['key'] ) ) {
        $bd_saved_keys[] = $item['key'];
    }
}
foreach ( $bd_default_layout as $default_item ) {
    if ( ! in_array( $default_item['key'], $bd_saved_keys, true ) ) {
        $default_item['visible'] = false; // never surprise existing sites
        $layout[] = $default_item;
    }
}

// ---- Map section keys to their template parts ----
// Visibility is decided in ONE place only: the eye toggle in the
// Sections Order & Visibility sorter (checked by the rendering loop
// below via the 'visible' flag). No per-section checkboxes anymore.
$bd_section_templates = array(
    'slider'     => 'template-parts/hero-slider',
    'shop'       => 'template-parts/section-shop',
    'forum'      => 'template-parts/section-forum',
    'portfolio'  => 'template-parts/section-portfolio',
    'blog'       => 'template-parts/section-blog',
    'resources'  => 'template-parts/section-resources',
    'team'       => 'template-parts/section-team',
    'newsletter' => 'template-parts/section-newsletter',
    'members'    => 'template-parts/section-members',
    'topics'     => 'template-parts/section-topics',
    'tags'       => 'template-parts/section-tags',
    'archive'    => 'template-parts/section-archive',
);

$bd_section_callbacks = array();
foreach ( $bd_section_templates as $bd_key => $bd_template ) {
    $bd_section_callbacks[ $bd_key ] = function() use ( $bd_template ) {
        get_template_part( $bd_template );
    };
}

// ---- Group visible sections into zones (order preserved) ----
$bd_zones = array(
    'left'  => array(),
    'main'  => array(),
    'right' => array(),
);

foreach ( $layout as $item ) {
    $key     = isset( $item['key'] )     ? sanitize_key( $item['key'] ) : '';
    $visible = isset( $item['visible'] ) ? (bool) $item['visible']      : true;

    // Skip hidden or unknown sections
    if ( ! $visible || ! isset( $bd_section_callbacks[ $key ] ) ) {
        continue;
    }

    $zone = ( isset( $item['zone'] ) && in_array( $item['zone'], array( 'left', 'main', 'right' ), true ) )
        ? $item['zone']
        : 'main';

    // Locked sections are always forced back to the main column
    if ( in_array( $key, $bd_locked_sections, true ) ) {
        $zone = 'main';
    }

    $bd_zones[ $zone ][] = $key;
}

$bd_has_left  = ! empty( $bd_zones['left'] );
$bd_has_right = ! empty( $bd_zones['right'] );
$bd_is_multi  = $bd_has_left || $bd_has_right;

// =====================================================
// PAGED VIEW (/page/2/, /page/3/ …) — SECTION FILTERING
// =====================================================
// When the visitor is browsing older posts via the blog section's
// numbered pagination, the admin decides which sections accompany
// the blog grid. Defaults: Hero Slider stays visible, everything
// else is hidden — each section has its own Customizer checkbox
// (📋 Sections Order & Visibility → Paged View options).
$bd_current_page = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$bd_blog_visible = in_array( 'blog', array_merge( $bd_zones['left'], $bd_zones['main'], $bd_zones['right'] ), true );

// Effective pagination mode (mirror the smart fallback in section-blog.php:
// archive_link without a Posts page behaves as numbered).
$bd_effective_mode = get_theme_mod( 'bd_blog_pagination_mode', 'numbered' );
if ( 'archive_link' === $bd_effective_mode && function_exists( 'bd_get_blog_archive_url' ) && ! bd_get_blog_archive_url() ) {
    $bd_effective_mode = 'numbered';
}

if ( $bd_current_page > 1
    && $bd_blog_visible
    && get_theme_mod( 'bd_paged_blog_only', true )
    && 'numbered' === $bd_effective_mode ) {

    // Per-section defaults on paged views: slider shown, others hidden.
    $bd_paged_defaults = array( 'slider' => true );

    // Keep the blog (it IS the pagination) plus any sections the
    // admin explicitly enabled for paged views. Sections stay in
    // their original zones, so an enabled sidebar section keeps
    // its sidebar placement on /page/N/ too.
    foreach ( $bd_zones as $bd_zone_key => $bd_zone_keys ) {
        $bd_zones[ $bd_zone_key ] = array_values( array_filter(
            $bd_zone_keys,
            function ( $key ) use ( $bd_paged_defaults ) {
                if ( 'blog' === $key ) {
                    return true;
                }
                $default = isset( $bd_paged_defaults[ $key ] ) ? $bd_paged_defaults[ $key ] : false;
                return (bool) get_theme_mod( 'bd_paged_show_' . $key, $default );
            }
        ) );
    }

    $bd_has_left  = ! empty( $bd_zones['left'] );
    $bd_has_right = ! empty( $bd_zones['right'] );
    $bd_is_multi  = $bd_has_left || $bd_has_right;
}

// ---- Small helper: render a list of section keys ----
$bd_render_zone = function( $keys ) use ( $bd_section_callbacks ) {
    foreach ( $keys as $key ) {
        call_user_func( $bd_section_callbacks[ $key ] );
    }
};

?>

<main class="site-main" id="mainContent">

<?php if ( ! $bd_is_multi ) : ?>

    <?php
    // =====================================================
    // ONE-COLUMN MODE — identical to the classic behaviour
    // =====================================================
    $bd_render_zone( $bd_zones['main'] );
    ?>

<?php else : ?>

    <?php
    // =====================================================
    // MULTI-COLUMN MODE
    // =====================================================

    // The hero slider is always full-width: pull it out of the main
    // column and render it above the grid.
    $bd_slider_pos = array_search( 'slider', $bd_zones['main'], true );
    if ( false !== $bd_slider_pos ) {
        call_user_func( $bd_section_callbacks['slider'] );
        unset( $bd_zones['main'][ $bd_slider_pos ] );
        $bd_zones['main'] = array_values( $bd_zones['main'] );
    }

    // The newsletter is also always full-width: pull it out of the main
    // column and render it below the grid.
    $bd_newsletter_after = false;
    $bd_newsletter_pos   = array_search( 'newsletter', $bd_zones['main'], true );
    if ( false !== $bd_newsletter_pos ) {
        $bd_newsletter_after = true;
        unset( $bd_zones['main'][ $bd_newsletter_pos ] );
        $bd_zones['main'] = array_values( $bd_zones['main'] );
    }

    // Wrapper class: which sidebars exist?
    if ( $bd_has_left && $bd_has_right ) {
        $bd_layout_class = 'bd-layout--both';
    } elseif ( $bd_has_left ) {
        $bd_layout_class = 'bd-layout--left';
    } else {
        $bd_layout_class = 'bd-layout--right';
    }
    ?>

    <div class="bd-layout <?php echo esc_attr( $bd_layout_class ); ?>">

        <?php if ( $bd_has_left ) : ?>
            <aside class="bd-zone bd-zone--sidebar bd-zone--left" aria-label="<?php esc_attr_e( 'Left sidebar sections', 'baloch-diamond' ); ?>">
                <?php $bd_render_zone( $bd_zones['left'] ); ?>
            </aside>
        <?php endif; ?>

        <div class="bd-zone bd-zone--main">
            <?php $bd_render_zone( $bd_zones['main'] ); ?>
        </div>

        <?php if ( $bd_has_right ) : ?>
            <aside class="bd-zone bd-zone--sidebar bd-zone--right" aria-label="<?php esc_attr_e( 'Right sidebar sections', 'baloch-diamond' ); ?>">
                <?php $bd_render_zone( $bd_zones['right'] ); ?>
            </aside>
        <?php endif; ?>

    </div>

    <?php
    // Newsletter renders full-width below the multi-column grid.
    if ( $bd_newsletter_after ) {
        call_user_func( $bd_section_callbacks['newsletter'] );
    }
    ?>

<?php endif; ?>

</main>

<?php
get_footer();

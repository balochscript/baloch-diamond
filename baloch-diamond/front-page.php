<?php
/**
 * Front Page Template
 *
 * Sections are rendered in the order and visibility defined by the admin via
 * the drag-and-drop sorter in:
 * Appearance → Customize → 💎 Baloch Diamond Settings → 📋 Sections Order & Visibility
 *
 * @package Baloch_Diamond
 * @version 1.1.2
 */

get_header();

// ---- Default section order (used on first install) ----
$bd_default_layout = array(
    array( 'key' => 'slider',     'visible' => true ),
    array( 'key' => 'shop',       'visible' => true ),
    array( 'key' => 'forum',      'visible' => true ),
    array( 'key' => 'portfolio',  'visible' => true ),
    array( 'key' => 'blog',       'visible' => true ),
    array( 'key' => 'resources',  'visible' => true ),
    array( 'key' => 'team',       'visible' => true ),
    array( 'key' => 'newsletter', 'visible' => true ),
    array( 'key' => 'members',    'visible' => true ),
);

// ---- Read saved layout from Customizer ----
$raw    = get_theme_mod( 'bd_sections_layout', '' );
$layout = $raw ? json_decode( $raw, true ) : array();

// Fallback: if JSON is empty/invalid, use default
if ( ! is_array( $layout ) || empty( $layout ) ) {
    $layout = $bd_default_layout;
}

// ---- Map section keys to their render callbacks ----
$bd_section_callbacks = array(
    'slider' => function() {
        if ( bd_is_section_visible( 'slider' ) ) {
            get_template_part( 'template-parts/hero-slider' );
        }
    },
    'shop' => function() {
        if ( bd_is_section_visible( 'shop' ) ) {
            get_template_part( 'template-parts/section-shop' );
        }
    },
    'forum' => function() {
        if ( get_theme_mod( 'bd_forum_show', true ) ) {
            get_template_part( 'template-parts/section-forum' );
        }
    },
    'portfolio' => function() {
        if ( get_theme_mod( 'bd_portfolio_show', true ) ) {
            get_template_part( 'template-parts/section-portfolio' );
        }
    },
    'blog' => function() {
        if ( bd_is_section_visible( 'blog' ) ) {
            get_template_part( 'template-parts/section-blog' );
        }
    },
    'resources' => function() {
        if ( get_theme_mod( 'bd_resources_show', true ) ) {
            get_template_part( 'template-parts/section-resources' );
        }
    },
    'team' => function() {
        if ( get_theme_mod( 'bd_team_show', true ) ) {
            get_template_part( 'template-parts/section-team' );
        }
    },
    'newsletter' => function() {
        if ( get_theme_mod( 'bd_newsletter_show', true ) ) {
            get_template_part( 'template-parts/section-newsletter' );
        }
    },
    'members' => function() {
        if ( get_theme_mod( 'bd_members_show', true ) ) {
            get_template_part( 'template-parts/section-members' );
        }
    },
);
?>

<main class="site-main" id="mainContent">

    <?php
    // Render each section in the saved order, skip hidden ones
    foreach ( $layout as $item ) {
        $key     = isset( $item['key'] )     ? sanitize_key( $item['key'] )   : '';
        $visible = isset( $item['visible'] ) ? (bool) $item['visible']        : true;

        // Skip if toggled off in the sorter UI
        if ( ! $visible ) {
            continue;
        }

        // Skip unknown keys
        if ( ! isset( $bd_section_callbacks[ $key ] ) ) {
            continue;
        }

        // Each callback also checks its own per-section show/hide setting,
        // so both the sorter toggle AND the individual setting must be on.
        call_user_func( $bd_section_callbacks[ $key ] );
    }
    ?>

</main>

<?php
get_footer();

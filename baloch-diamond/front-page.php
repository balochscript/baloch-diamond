<?php
/**
 * Front Page Template
 *
 * @package Baloch_Diamond
 */

get_header();
?>

<main class="site-main" id="mainContent">

    <?php
    // Hero Slider
    if ( bd_is_section_visible( 'slider' ) ) {
        get_template_part( 'template-parts/hero-slider' );
    }

    // Shop (WooCommerce) Showcase Section
    if ( bd_is_section_visible( 'shop' ) ) {
        get_template_part( 'template-parts/section-shop' );
    }

    // Forum (bbPress) Showcase Section
    if ( bd_is_section_visible( 'forum' ) ) {
        get_template_part( 'template-parts/section-forum' );
    }

    // Portfolio Section
    if ( bd_is_section_visible( 'portfolio' ) ) {
        get_template_part( 'template-parts/section-portfolio' );
    }

    // Blog Section
    if ( bd_is_section_visible( 'blog' ) ) {
        get_template_part( 'template-parts/section-blog' );
    }

    // Resources Section
    if ( bd_is_section_visible( 'resources' ) ) {
        get_template_part( 'template-parts/section-resources' );
    }

    // Team Section
    if ( bd_is_section_visible( 'team' ) ) {
        get_template_part( 'template-parts/section-team' );
    }

    // Newsletter Section
    if ( bd_is_section_visible( 'newsletter' ) ) {
        get_template_part( 'template-parts/section-newsletter' );
    }
    ?>

</main>

<?php
get_footer();

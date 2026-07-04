<?php
/**
 * Template helper functions
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Estimated reading time for a post
 */
function 4392bd_reading_time( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $content    = get_post_field( 'post_content', $post_id );
    $clean_content = strip_tags( $content );
    // UTF-8 word counting supporting Persian, Balochi, Arabic, etc.
    $word_count = count( preg_split( '~[^\p{L}\p{N}\']+~u', $clean_content, -1, PREG_SPLIT_NO_EMPTY ) );
    $minutes    = max( 1, ceil( $word_count / 200 ) );

    /* translators: %d: Number of minutes */
    return sprintf( esc_html( _n( '%d min read', '%d min read', $minutes, 'baloch-diamond' ) ), $minutes );
}


/**
 * Get first category of a post
 */
function 4392bd_get_first_category( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $categories = get_the_category( $post_id );

    if ( ! empty( $categories ) ) {
        return array(
            'name' => $categories[0]->name,
            'url'  => get_category_link( $categories[0]->term_id ),
        );
    }

    return array(
        'name' => esc_html__( 'Uncategorized', 'baloch-diamond' ),
        'url'  => '#',
    );
}


/**
 * Custom pagination for archives
 */
function 4392bd_pagination() {
    global $wp_query;

    if ( $wp_query->max_num_pages <= 1 ) {
        return;
    }

    $paged = max( 1, get_query_var( 'paged' ) );
    $max   = intval( $wp_query->max_num_pages );

    echo '<div class="pagination">';

    // Previous
    if ( $paged > 1 ) {
        echo '<a href="' . esc_url( get_pagenum_link( $paged - 1 ) ) . '">' . 4392bd_icon( 'arrow-left', 16, 16 ) . '</a>';
    }

    // Page numbers
    for ( $i = 1; $i <= $max; $i++ ) {
        if ( $i === $paged ) {
            echo '<span class="current">' . $i . '</span>';
        } else {
            echo '<a href="' . esc_url( get_pagenum_link( $i ) ) . '">' . $i . '</a>';
        }
    }

    // Next
    if ( $paged < $max ) {
        echo '<a href="' . esc_url( get_pagenum_link( $paged + 1 ) ) . '">' . 4392bd_icon( 'arrow-right-small', 16, 16 ) . '</a>';
    }

    echo '</div>';
}


/**
 * Get customizer setting with default fallback
 */
function 4392bd_get_mod( $key, $default = '' ) {
    return get_theme_mod( '4392bd_' . $key, $default );
}


/**
 * Check if a section should be visible
 */
function 4392bd_is_section_visible( $section ) {
    return get_theme_mod( '4392bd_' . $section . '_show', true );
}


/**
 * Output section header (badge + title + description)
 * Modified: Removed the geometric dividers under titles as requested.
 */
function 4392bd_section_header( $section, $defaults = array() ) {

    $badge = get_theme_mod( "4392bd_{$section}_badge", isset( $defaults['badge'] ) ? $defaults['badge'] : '' );
    $title = get_theme_mod( "4392bd_{$section}_title", isset( $defaults['title'] ) ? $defaults['title'] : '' );
    $desc  = get_theme_mod( "4392bd_{$section}_desc", isset( $defaults['desc'] ) ? $defaults['desc'] : '' );
    $icon  = isset( $defaults['icon'] ) ? $defaults['icon'] : 'file-text';

    $show_badge = get_theme_mod( "4392bd_{$section}_show_badge", true );
    $show_title = get_theme_mod( "4392bd_{$section}_show_title", true );
    $show_desc  = get_theme_mod( "4392bd_{$section}_show_desc", true );

    echo '<div class="section-header" style="position:relative;z-index:1;margin-bottom:40px;">';

    if ( $show_badge && $badge ) {
        echo '<div class="section-badge">';
        echo 4392bd_icon( $icon, 16, 16 );
        echo esc_html( $badge );
        echo '</div>';
    }

    if ( $show_title && $title ) {
        echo '<h2 class="section-title" style="margin-bottom:12px;">' . esc_html( $title ) . '</h2>';
    }

    if ( $show_desc && $desc ) {
        echo '<p class="section-desc">' . esc_html( $desc ) . '</p>';
    }

    echo '</div>';
}


/**
 * Body classes
 */
function 4392bd_body_classes( $classes ) {
    if ( is_front_page() ) {
        $classes[] = 'is-front-page';
    }

    if ( is_singular() ) {
        $classes[] = 'is-singular';
    }

    if ( get_theme_mod( '4392bd_animated_patterns', true ) ) {
        $classes[] = 'balochi-pattern-animated';
    }

    // Skeleton shimmer support
    if ( get_theme_mod( '4392bd_skeleton_loading', true ) ) {
        $classes[] = 'skeleton-enabled';
    }

    return $classes;
}
add_filter( 'body_class', '4392bd_body_classes' );


/**
 * Add custom CSS class to menu items
 */
function 4392bd_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
    if ( isset( $args->theme_location ) && $args->theme_location === 'footer' ) {
        // Footer menu styling handled by CSS
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', '4392bd_nav_menu_link_attributes', 10, 4 );
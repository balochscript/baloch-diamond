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
function bd_reading_time( $post_id = null ) {
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
function bd_get_first_category( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $categories = get_the_category( $post_id );

    if ( ! empty( $categories ) ) {
        $link = get_category_link( $categories[0]->term_id );
        return array(
            'name' => $categories[0]->name,
            'url'  => is_wp_error( $link ) ? '#' : $link,
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
function bd_pagination() {
    global $wp_query;

    if ( $wp_query->max_num_pages <= 1 ) {
        return;
    }

    $paged = max( 1, get_query_var( 'paged' ) );
    $max   = intval( $wp_query->max_num_pages );

    echo '<div class="pagination">';

    // Previous
    if ( $paged > 1 ) {
        echo '<a href="' . esc_url( get_pagenum_link( $paged - 1 ) ) . '">' . bd_icon( 'arrow-left', 16, 16 ) . '</a>';
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
        echo '<a href="' . esc_url( get_pagenum_link( $paged + 1 ) ) . '">' . bd_icon( 'arrow-right-small', 16, 16 ) . '</a>';
    }

    echo '</div>';
}


/**
 * Get customizer setting with default fallback
 */
function bd_get_mod( $key, $default = '' ) {
    return get_theme_mod( 'bd_' . $key, $default );
}


/**
 * Check if a section should be visible
 */
function bd_is_section_visible( $section ) {
    return get_theme_mod( 'bd_' . $section . '_show', true );
}


/**
 * Output section header (badge + title + description)
 * Modified: Removed the geometric dividers under titles as requested.
 */
function bd_section_header( $section, $defaults = array() ) {

    $badge = get_theme_mod( "bd_{$section}_badge", isset( $defaults['badge'] ) ? $defaults['badge'] : '' );
    $title = get_theme_mod( "bd_{$section}_title", isset( $defaults['title'] ) ? $defaults['title'] : '' );
    $desc  = get_theme_mod( "bd_{$section}_desc", isset( $defaults['desc'] ) ? $defaults['desc'] : '' );
    $icon  = isset( $defaults['icon'] ) ? $defaults['icon'] : 'file-text';

    $show_badge = get_theme_mod( "bd_{$section}_show_badge", true );
    $show_title = get_theme_mod( "bd_{$section}_show_title", true );
    $show_desc  = get_theme_mod( "bd_{$section}_show_desc", true );

    echo '<div class="section-header" style="position:relative;z-index:1;margin-bottom:40px;">';

    if ( $show_badge && $badge ) {
        echo '<div class="section-badge">';
        echo bd_icon( $icon, 16, 16 );
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
 * Add custom CSS class to menu items
 */
function bd_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
    if ( isset( $args->theme_location ) && $args->theme_location === 'footer' ) {
        // Footer menu styling handled by CSS
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'bd_nav_menu_link_attributes', 10, 4 );

/**
 * Render a WooCommerce product card.
 *
 * @param array $prod Product data array.
 * @return void
 */
function bd_render_product_card_html( $prod ) {
    ?>
    <div class="project-card product-card" style="height:100%;">
        <div class="project-card-img-wrapper" style="position:relative;height:240px;overflow:hidden;">
            <?php if ( $prod['on_sale'] && $prod['discount'] > 0 ) : ?>
                <div style="position:absolute;top:14px;left:-6px;background:#ef4444;color:#fff;font-weight:900;font-size:.68rem;padding:5px 28px;transform:rotate(-43deg);box-shadow:0 2px 8px rgba(239,68,68,.3);z-index:2;letter-spacing:.3px;">
                    -<?php echo esc_html( $prod['discount'] ); ?>%
                </div>
            <?php endif; ?>

            <?php if ( $prod['image'] ) : ?>
                <img class="project-card-image" src="<?php echo esc_url( $prod['image'] ); ?>" alt="<?php echo esc_attr( $prod['title'] ); ?>" style="width:100%;height:100%;object-fit:cover;">
            <?php else : ?>
                <div style="width:100%;height:100%;background:var(--bg-alt);display:flex;align-items:center;justify-content:center;opacity:.12;">
                    <?php echo bd_icon( 'tag', 62, 62 ); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="project-card-content" style="padding:22px 20px 24px;text-align:center;">
            <div style="color:#fbbf24;font-size:1rem;margin-bottom:6px;">
                <?php for ( $s = 1; $s <= 5; $s++ ) { echo esc_html( $s <= floor( $prod['rating'] ) ? '★' : '☆' ); } ?>
            </div>

            <h3 class="project-card-title" style="font-size:1.1rem;margin-bottom:8px;">
                <a href="<?php echo esc_url( $prod['link'] ); ?>" style="color:inherit;text-decoration:none;"><?php echo esc_html( $prod['title'] ); ?></a>
            </h3>

            <div style="font-size:1.18rem;font-weight:700;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:16px;">
                <?php echo wp_kses_post( $prod['price'] ); ?>
            </div>

            <a href="<?php echo esc_url( $prod['link'] ); ?>" class="btn-outline" style="width:100%;justify-content:center;border-radius:10px;">
                <?php esc_html_e( 'View Details', 'baloch-diamond' ); ?>
            </a>
        </div>
    </div>
    <?php
}

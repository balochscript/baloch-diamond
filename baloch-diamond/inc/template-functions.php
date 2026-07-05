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
 * "Newer Posts" / "Older Posts" pagination for the Blog archive page
 * (index.php). Reuses the .bd-blog-nav styling from the homepage Blog
 * section for a consistent look across the site.
 */
function bd_blog_archive_pagination() {
    global $wp_query;

    if ( $wp_query->max_num_pages <= 1 ) {
        return;
    }

    $paged = max( 1, (int) get_query_var( 'paged' ) );
    $max   = (int) $wp_query->max_num_pages;

    $prev_url = ( $paged > 1 ) ? get_pagenum_link( $paged - 1 ) : '';
    $next_url = ( $paged < $max ) ? get_pagenum_link( $paged + 1 ) : '';
    ?>
    <div class="bd-blog-nav" style="margin-top:48px;">

        <?php if ( $prev_url ) : ?>
        <a href="<?php echo esc_url( $prev_url ); ?>" class="bd-blog-nav__btn bd-blog-nav__btn--prev btn-outline">
            <?php echo bd_icon( 'arrow-left', 18, 18 ); ?>
            <span><?php esc_html_e( 'Newer Posts', 'baloch-diamond' ); ?></span>
        </a>
        <?php else : ?>
        <span class="bd-blog-nav__btn bd-blog-nav__btn--prev bd-blog-nav__btn--disabled btn-outline" aria-disabled="true">
            <?php echo bd_icon( 'arrow-left', 18, 18 ); ?>
            <span><?php esc_html_e( 'Newer Posts', 'baloch-diamond' ); ?></span>
        </span>
        <?php endif; ?>

        <span class="bd-blog-nav__counter">
            <?php echo esc_html( $paged ); ?>
            <span class="bd-blog-nav__sep">/</span>
            <?php echo esc_html( $max ); ?>
        </span>

        <?php if ( $next_url ) : ?>
        <a href="<?php echo esc_url( $next_url ); ?>" class="bd-blog-nav__btn bd-blog-nav__btn--next btn-gradient">
            <span><?php esc_html_e( 'Older Posts', 'baloch-diamond' ); ?></span>
            <?php echo bd_icon( 'arrow-right', 18, 18 ); ?>
        </a>
        <?php else : ?>
        <span class="bd-blog-nav__btn bd-blog-nav__btn--next bd-blog-nav__btn--disabled btn-gradient" aria-disabled="true">
            <span><?php esc_html_e( 'Older Posts', 'baloch-diamond' ); ?></span>
            <?php echo bd_icon( 'arrow-right', 18, 18 ); ?>
        </span>
        <?php endif; ?>

    </div>
    <?php
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
 * Render the Balochi-embroidered "bookmark" sale ribbon as an inline SVG.
 *
 * Rendered as self-contained SVG markup (gradient + decoration defined inside
 * the SVG itself) so the badge always looks correct even if the external
 * stylesheet hasn't finished loading or is served from a stale cache.
 *
 * @param int    $discount Discount percentage (0 = do not render).
 * @param string $size     'md' (default, large cards) or 'sm' (compact grid cards).
 * @return string HTML markup, or an empty string when there is no discount.
 */
function bd_render_discount_bookmark( $discount, $size = 'md' ) {
    static $bd_bookmark_uid = 0;

    $discount = (int) $discount;
    if ( $discount <= 0 ) {
        return '';
    }

    $bd_bookmark_uid++;
    $gradient_id = 'bdBookmarkGrad' . $bd_bookmark_uid;
    $size_class  = ( $size === 'sm' ) ? ' bd-bookmark--sm' : '';

    ob_start();
    ?>
    <div class="bd-bookmark<?php echo esc_attr( $size_class ); ?>" role="img" aria-label="<?php echo esc_attr( sprintf(
        /* translators: %d: Discount percentage */
        __( '%d%% off', 'baloch-diamond' ), $discount
    ) ); ?>">
        <svg viewBox="0 0 52 76" xmlns="http://www.w3.org/2000/svg" focusable="false" aria-hidden="true">
            <defs>
                <linearGradient id="<?php echo esc_attr( $gradient_id ); ?>" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#f43f5e"/>
                    <stop offset="55%" stop-color="#dc2626"/>
                    <stop offset="100%" stop-color="#9f1239"/>
                </linearGradient>
            </defs>
            <!-- Bookmark body: flat top, sharp pointed "ears" at bottom around a V notch -->
            <path d="M2,0 H50 V70 L26,52 L2,70 Z" fill="url(#<?php echo esc_attr( $gradient_id ); ?>)"/>
            <rect x="2" y="0" width="48" height="4" fill="#fbbf24"/>
            <path d="M2,0 H50 V70 L26,52 L2,70 Z" fill="none" stroke="#fde68a" stroke-width="1.2" stroke-dasharray="3 2" opacity="0.9"/>
            <!-- Balochi needlework motif: embroidered diamond row -->
            <g fill="none" stroke="#fde68a" stroke-width="1.1">
                <path d="M13,10 L16,14 L13,18 L10,14 Z"/>
                <path d="M26,10 L29,14 L26,18 L23,14 Z"/>
                <path d="M39,10 L42,14 L39,18 L36,14 Z"/>
            </g>
            <g fill="#38bdf8">
                <circle cx="13" cy="14" r="1.1"/>
                <circle cx="26" cy="14" r="1.1"/>
                <circle cx="39" cy="14" r="1.1"/>
            </g>
            <text x="26" y="38" text-anchor="middle" fill="#ffffff" font-size="14" font-weight="900" font-family="Arial, sans-serif">-<?php echo esc_html( $discount ); ?>%</text>
            <text x="26" y="47" text-anchor="middle" fill="#fde68a" font-size="6" font-weight="700" letter-spacing="1.2" font-family="Arial, sans-serif"><?php esc_html_e( 'OFF', 'baloch-diamond' ); ?></text>
        </svg>
    </div>
    <?php
    return ob_get_clean();
}

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
                <?php echo bd_render_discount_bookmark( $prod['discount'], 'sm' ); ?>
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

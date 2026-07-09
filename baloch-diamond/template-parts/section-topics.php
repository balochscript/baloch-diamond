<?php
/**
 * Topics Section Template Part (Front Page)
 *
 * Displays post categories as visual cards. Each card shows either the
 * featured image of the latest post in that category or a decorative
 * icon tile, plus the category name and post count.
 *
 * Hidden by default — enable via:
 * Appearance → Customize → 💎 Baloch Diamond Settings → 🏷️ Topics Section
 *
 * @package Baloch_Diamond
 * @version 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! bd_is_section_visible( 'topics' ) ) {
    return;
}

// ---- Customizer settings ----
$topics_count      = (int) get_theme_mod( 'bd_topics_count', 6 );
$topics_style      = get_theme_mod( 'bd_topics_style', 'image' ); // image | icon
$topics_show_count = get_theme_mod( 'bd_topics_show_count', true );
$topics_orderby    = get_theme_mod( 'bd_topics_orderby', 'count' ); // count | name

$categories = get_categories( array(
    'orderby'    => $topics_orderby,
    'order'      => 'count' === $topics_orderby ? 'DESC' : 'ASC',
    'number'     => max( 1, $topics_count ),
    'hide_empty' => true,
) );

if ( empty( $categories ) ) {
    return;
}

/**
 * Resolve a representative image for a category:
 * the featured image of its most recent post (if any).
 *
 * Wrapped in function_exists so re-rendering the template part
 * (e.g. selective refresh in the Customizer) can never fatal
 * with a "cannot redeclare" error.
 *
 * @param  int $term_id Category term ID.
 * @return string       Image URL or empty string.
 */
if ( ! function_exists( 'bd_topics_get_category_image' ) ) {
    function bd_topics_get_category_image( $term_id ) {
        $posts = get_posts( array(
            'numberposts' => 1,
            'category'    => $term_id,
            'meta_key'    => '_thumbnail_id', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
            'fields'      => 'ids',
        ) );

        if ( ! empty( $posts ) ) {
            $url = get_the_post_thumbnail_url( $posts[0], 'medium_large' );
            if ( $url ) {
                return $url;
            }
        }
        return '';
    }
}

// Icon rotation for icon-style tiles
$bd_topic_icons = array( 'tag', 'book', 'code', 'globe', 'zap', 'monitor', 'shield', 'file-text' );
?>

<section class="section" id="topics">

    <?php
    bd_section_header( 'topics', array(
        'badge' => esc_html__( 'Explore', 'baloch-diamond' ),
        'title' => esc_html__( 'Browse by Topic', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Find the content you care about, organized by subject.', 'baloch-diamond' ),
        'icon'  => 'tag',
    ) );
    ?>

    <div class="topics-grid">
        <?php foreach ( $categories as $i => $cat ) :
            $cat_link = get_category_link( $cat->term_id );
            $cat_img  = ( 'image' === $topics_style ) ? bd_topics_get_category_image( $cat->term_id ) : '';
            $icon_key = $bd_topic_icons[ $i % count( $bd_topic_icons ) ];
        ?>
        <a href="<?php echo esc_url( $cat_link ); ?>" class="topic-card">

            <div class="topic-card-media<?php echo $cat_img ? ' has-image' : ''; ?>">
                <?php if ( $cat_img ) : ?>
                    <img src="<?php echo esc_url( $cat_img ); ?>" alt="<?php echo esc_attr( $cat->name ); ?>" loading="lazy">
                    <span class="topic-card-overlay"></span>
                <?php else : ?>
                    <span class="topic-card-icon"><?php echo bd_icon( $icon_key, 30, 30 ); ?></span>
                <?php endif; ?>
            </div>

            <div class="topic-card-body">
                <h3 class="topic-card-name"><?php echo esc_html( $cat->name ); ?></h3>
                <?php if ( $topics_show_count ) : ?>
                    <span class="topic-card-count">
                        <?php
                        /* translators: %s: number of posts. */
                        echo esc_html( sprintf( _n( '%s post', '%s posts', $cat->count, 'baloch-diamond' ), number_format_i18n( $cat->count ) ) );
                        ?>
                    </span>
                <?php endif; ?>
            </div>

        </a>
        <?php endforeach; ?>
    </div>

</section>

<?php
/**
 * Blog Section Template Part (Front Page)
 *
 * Displays a preview grid of the latest posts with configurable pagination:
 *   - "Archive Link" mode: button linking to the full blog archive
 *   - "Load More" mode: AJAX-powered inline post loading
 *
 * The blog archive URL is resolved using WordPress core functions.
 * Works with both WordPress reading modes — no manual page setup required.
 *
 * @package Baloch_Diamond
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ---- Customizer settings ----
$blog_count       = max( 1, (int) get_option( 'posts_per_page', 10 ) );
$read_more_text   = get_theme_mod( 'bd_blog_readmore_text',  esc_html__( 'Read More', 'baloch-diamond' ) );
$show_thumbnail   = get_theme_mod( 'bd_blog_show_thumbnail', true );
$show_date_badge  = get_theme_mod( 'bd_blog_show_date_badge', true );
$show_author      = get_theme_mod( 'bd_blog_show_author',    true );
$show_comments    = get_theme_mod( 'bd_blog_show_comments',  true );
$show_category    = get_theme_mod( 'bd_blog_show_category',  true );
$show_excerpt     = get_theme_mod( 'bd_blog_show_excerpt',   true );
$show_readmore    = get_theme_mod( 'bd_blog_show_readmore',  true );

// ---- Pagination / View All settings ----
// Backward compat: check OLD keys first (bd_blog_show_viewall / bd_blog_viewall_text)
// then fall back to NEW keys (bd_blog_show_archive_link / bd_blog_archive_link_text)
$show_viewall     = get_theme_mod( 'bd_blog_show_viewall',        null );
if ( null === $show_viewall ) {
    $show_viewall = get_theme_mod( 'bd_blog_show_archive_link',   true );
}

$viewall_text     = get_theme_mod( 'bd_blog_viewall_text',        '' );
if ( ! $viewall_text ) {
    $viewall_text = get_theme_mod( 'bd_blog_archive_link_text',
        esc_html__( 'View All Posts', 'baloch-diamond' ) );
}

// ---- Pagination mode: 'archive_link' or 'load_more' ----
$pagination_mode  = get_theme_mod( 'bd_blog_pagination_mode', 'archive_link' );

// ---- Load More settings ----
$loadmore_text    = get_theme_mod( 'bd_blog_loadmore_text', esc_html__( 'Load More Posts', 'baloch-diamond' ) );
$loadmore_loading = get_theme_mod( 'bd_blog_loadmore_loading_text', esc_html__( 'Loading...', 'baloch-diamond' ) );
$loadmore_nomore  = get_theme_mod( 'bd_blog_loadmore_nomore_text', esc_html__( 'No more posts to show', 'baloch-diamond' ) );
$posts_per_load   = max( 1, (int) get_option( 'posts_per_page', 10 ) );

// ---- Resolve blog archive URL ----
// Uses page_for_posts (set in Settings → Reading or auto-created on activation).
// Returns empty string if no blog archive page exists — button is simply hidden.
$blog_archive_url = bd_get_blog_archive_url();

// ---- Query: fixed-size preview, no front-page pagination ----
$args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $blog_count,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$blog_query = new WP_Query( $args );

if ( ! $blog_query->have_posts() ) {
    return;
}

// Total published posts for Load More
$total_publish  = 0;
$total_counts   = wp_count_posts( 'post' );
if ( $total_counts && isset( $total_counts->publish ) ) {
    $total_publish = (int) $total_counts->publish;
}
$has_more_posts = ( $blog_count < $total_publish );
?>

<section class="section" id="updates" style="background:var(--bg-alt)">

    <?php
    bd_section_header( 'blog', array(
        'badge' => esc_html__( 'Blog', 'baloch-diamond' ),
        'title' => esc_html__( 'Latest Updates', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Stay updated with our latest articles, tutorials, and industry insights. Fresh content delivered regularly.', 'baloch-diamond' ),
        'icon'  => 'file-text',
    ) );
    ?>

    <div class="posts-grid" id="bd-blog-grid">

        <?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>

        <article class="post-card">

            <?php if ( $show_thumbnail ) : ?>
            <div class="post-card-img-wrapper">
                <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail( 'bd-card' ); ?>
                </a>
                <?php else : ?>
                <a href="<?php the_permalink(); ?>" style="display:flex;height:100%;background:var(--bg-alt);align-items:center;justify-content:center;">
                    <div style="opacity:0.15;"><?php echo bd_icon( 'file-text', 48, 48 ); ?></div>
                </a>
                <?php endif; ?>

                <?php if ( $show_date_badge ) : ?>
                <div class="post-date-badge">
                    <span class="day"><?php echo get_the_date( 'j' ); ?></span>
                    <span class="month"><?php echo get_the_date( 'M' ); ?></span>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <div class="post-card-body">

                <?php if ( $show_author || $show_comments || $show_category ) : ?>
                <div class="post-meta">

                    <?php if ( $show_category ) :
                        $cats = get_the_category();
                        if ( ! empty( $cats ) ) : ?>
                    <a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>"
                       class="post-meta-item"
                       style="color:var(--color-primary);font-weight:600;text-decoration:none;">
                        <?php echo bd_icon( 'tag', 14, 14 ); ?>
                        <?php echo esc_html( $cats[0]->name ); ?>
                    </a>
                    <?php endif; endif; ?>

                    <?php if ( $show_author ) : ?>
                    <span class="post-meta-item">
                        <?php echo bd_icon( 'user', 14, 14 ); ?>
                        <?php the_author(); ?>
                    </span>
                    <?php endif; ?>

                    <?php if ( $show_comments ) : ?>
                    <span class="post-meta-item">
                        <?php echo bd_icon( 'comment', 14, 14 ); ?>
                        <?php printf(
                            esc_html( _n( '%s Comment', '%s Comments', get_comments_number(), 'baloch-diamond' ) ),
                            number_format_i18n( get_comments_number() )
                        ); ?>
                    </span>
                    <?php endif; ?>

                </div>
                <?php endif; ?>

                <h3 class="post-card-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>

                <?php if ( $show_excerpt ) : ?>
                <p class="post-card-excerpt">
                    <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                </p>
                <?php endif; ?>

                <?php if ( $show_readmore ) : ?>
                <a href="<?php the_permalink(); ?>" class="read-more">
                    <?php echo esc_html( $read_more_text ); ?>
                    <?php echo bd_icon( 'arrow-right', 16, 16 ); ?>
                </a>
                <?php endif; ?>

            </div>

        </article>

        <?php endwhile; wp_reset_postdata(); ?>

    </div><!-- .posts-grid -->

    <?php
    // ====================================================
    //  PAGINATION — Archive Link Mode
    // ====================================================
    if ( $pagination_mode === 'archive_link' && $show_viewall && $blog_archive_url ) :
    ?>
    <div class="bd-blog-footer" style="text-align:center;margin-top:48px">
        <a href="<?php echo esc_url( $blog_archive_url ); ?>" class="btn-gradient bd-blog-viewall-btn" style="padding:14px 32px;font-size:0.98rem;border-radius:14px">
            <?php echo esc_html( $viewall_text ); ?>
            <?php echo bd_icon( 'arrow-right', 18, 18 ); ?>
        </a>
    </div>
    <?php endif; ?>

    <?php
    // ====================================================
    //  PAGINATION — Load More Mode (AJAX)
    // ====================================================
    if ( $pagination_mode === 'load_more' && $has_more_posts ) :
    ?>
    <div class="bd-blog-footer bd-blog-loadmore-wrap" style="text-align:center;margin-top:48px">
        <button
            type="button"
            id="bd-loadmore-btn"
            class="btn-gradient bd-loadmore-btn"
            style="padding:14px 32px;font-size:0.98rem;border-radius:14px;position:relative;min-width:220px;justify-content:center"
            data-page="1"
            data-per-page="<?php echo esc_attr( $posts_per_load ); ?>"
            data-loading-text="<?php echo esc_attr( $loadmore_loading ); ?>"
            data-nomore-text="<?php echo esc_attr( $loadmore_nomore ); ?>"
            data-total="<?php echo esc_attr( $total_publish ); ?>"
            data-initial-count="<?php echo esc_attr( $blog_count ); ?>"
            data-archive-url="<?php echo esc_url( $blog_archive_url ); ?>"
        >
            <?php echo esc_html( $loadmore_text ); ?>
            <?php echo bd_icon( 'arrow-right', 18, 18 ); ?>
        </button>
        <p class="bd-loadmore-status" style="margin-top:12px;font-size:0.85rem;color:var(--text-muted);display:none"></p>
    </div>
    <?php endif; ?>

</section>

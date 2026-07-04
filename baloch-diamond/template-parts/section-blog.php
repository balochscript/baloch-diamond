<?php
/**
 * Blog Section Template Part (Front Page)
 *
 * Displays paginated WordPress posts.
 * Navigation: Previous / Next page buttons + View All Posts link.
 *
 * @package Baloch_Diamond
 * @version 1.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ---- Customizer settings ----
$blog_count       = max( 1, (int) get_theme_mod( 'bd_blog_count',         6 ) );
$pagination_style = get_theme_mod( 'bd_blog_pagination',     'prevnext' );
$read_more_text   = get_theme_mod( 'bd_blog_readmore_text',  esc_html__( 'Read More', 'baloch-diamond' ) );
$show_thumbnail   = get_theme_mod( 'bd_blog_show_thumbnail', true );
$show_date_badge  = get_theme_mod( 'bd_blog_show_date_badge', true );
$show_author      = get_theme_mod( 'bd_blog_show_author',    true );
$show_comments    = get_theme_mod( 'bd_blog_show_comments',  true );
$show_category    = get_theme_mod( 'bd_blog_show_category',  true );
$show_excerpt     = get_theme_mod( 'bd_blog_show_excerpt',   true );
$show_readmore    = get_theme_mod( 'bd_blog_show_readmore',  true );
$show_viewall     = get_theme_mod( 'bd_blog_show_viewall',   true );
$viewall_text     = get_theme_mod( 'bd_blog_viewall_text',   esc_html__( 'View All Posts', 'baloch-diamond' ) );

// ---- Resolve blog archive URL ----
// Works whether WordPress is set to show posts on front page or a static page.
$blog_archive_url = home_url( '/' );
$page_for_posts   = (int) get_option( 'page_for_posts' );
if ( $page_for_posts ) {
    $blog_archive_url = get_permalink( $page_for_posts );
} elseif ( get_post_type_archive_link( 'post' ) ) {
    $blog_archive_url = get_post_type_archive_link( 'post' );
}

// ---- Current page number ----
$paged = max( 1, (int) get_query_var( 'paged' ) );

// ---- Query ----
$args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $blog_count,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

if ( $pagination_style === 'none' ) {
    $args['posts_per_page'] = -1;
    $args['paged']          = 1;
}

$blog_query  = new WP_Query( $args );
$total_pages = (int) $blog_query->max_num_pages;

if ( ! $blog_query->have_posts() ) {
    return;
}

// Build page URLs (appends ?paged=N to the blog archive URL)
$prev_url = ( $paged > 1 )
    ? add_query_arg( 'paged', $paged - 1, $blog_archive_url )
    : '';

$next_url = ( $paged < $total_pages )
    ? add_query_arg( 'paged', $paged + 1, $blog_archive_url )
    : '';
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
    // ---- Navigation: Prev / Next + View All ----
    $has_prev = ! empty( $prev_url );
    $has_next = ! empty( $next_url );
    $show_nav = $pagination_style !== 'none' && $total_pages > 1;
    ?>

    <?php if ( $show_nav || $show_viewall ) : ?>
    <div class="bd-blog-footer">

        <?php if ( $show_nav ) : ?>
        <div class="bd-blog-nav">

            <?php if ( $has_prev ) : ?>
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
                <?php echo esc_html( $total_pages ); ?>
            </span>

            <?php if ( $has_next ) : ?>
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
        <?php endif; ?>

        <?php if ( $show_viewall ) : ?>
        <a href="<?php echo esc_url( $blog_archive_url ); ?>" class="bd-blog-viewall">
            <?php echo esc_html( $viewall_text ); ?>
            <?php echo bd_icon( 'arrow-right', 14, 14 ); ?>
        </a>
        <?php endif; ?>

    </div><!-- .bd-blog-footer -->
    <?php endif; ?>

</section>

<?php
/**
 * Template part for displaying single post content
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$category = bd_get_first_category();
?>

<!-- Hero -->
<div class="single-post-hero">
    <?php if ( has_post_thumbnail() ) : ?>
        <?php the_post_thumbnail( 'bd-slider', array( 'alt' => get_the_title() ) ); ?>
    <?php else : ?>
        <div style="width:100%;height:100%;background:var(--gradient);display:flex;align-items:center;justify-content:center">
            <div style="opacity:0.15"><?php echo bd_icon( 'file-text', 80, 80 ); ?></div>
        </div>
    <?php endif; ?>

    <div class="overlay">
        <a href="<?php echo esc_url( $category['url'] ); ?>" class="slide-category" style="margin-bottom:12px;text-decoration:none">
            <?php echo esc_html( $category['name'] ); ?>
        </a>

        <h1 style="font-family:'Playfair Display',serif;font-size:2.2rem;font-weight:900;color:white;text-shadow:0 2px 10px rgba(0,0,0,0.5);max-width:700px;line-height:1.3">
            <?php the_title(); ?>
        </h1>

        <div style="display:flex;gap:16px;margin-top:16px;color:rgba(255,255,255,0.8);font-size:0.9rem;flex-wrap:wrap">
            <span style="display:flex;align-items:center;gap:6px">
                <?php echo bd_icon( 'user', 14, 14 ); ?>
                <?php
                /* translators: %s: Author name */
                printf( esc_html__( 'By %s', 'baloch-diamond' ), get_the_author() );
                ?>
            </span>
            <span style="display:flex;align-items:center;gap:6px">
                <?php echo bd_icon( 'calendar', 14, 14 ); ?>
                <?php echo get_the_date(); ?>
            </span>
            <span style="display:flex;align-items:center;gap:6px">
                <?php echo bd_icon( 'comment', 14, 14 ); ?>
                <?php
                printf(
                    esc_html( _n( '%s Comment', '%s Comments', get_comments_number(), 'baloch-diamond' ) ),
                    number_format_i18n( get_comments_number() )
                );
                ?>
            </span>
            <span style="display:flex;align-items:center;gap:6px">
                <?php echo bd_icon( 'clock', 14, 14 ); ?>
                <?php echo bd_reading_time(); ?>
            </span>
        </div>
    </div>
</div>

<!-- Content -->
<div class="single-post-content">

    <?php the_content(); ?>

    <?php
    wp_link_pages( array(
        'before'      => '<div class="pagination" style="margin-top:32px;margin-bottom:32px">',
        'after'       => '</div>',
        'link_before' => '<span>',
        'link_after'  => '</span>',
    ) );
    ?>

    <!-- Tags -->
    <?php
    $tags = get_the_tags();
    if ( $tags ) :
    ?>
        <div class="post-tags">
            <?php echo bd_icon( 'tag', 16, 16 ); ?>
            <?php foreach ( $tags as $tag ) : ?>
                <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="post-tag">
                    <?php echo esc_html( $tag->name ); ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Author Box -->
    <div class="author-box">
        <?php echo get_avatar( get_the_author_meta( 'ID' ), 70, '', get_the_author(), array( 'class' => '' ) ); ?>
        <div class="author-box-content">
            <h4><?php the_author(); ?></h4>
            <p><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
        </div>
    </div>

    <!-- Related Posts -->
    <?php
    $categories = get_the_category();
    if ( $categories ) :
        $cat_ids = wp_list_pluck( $categories, 'term_id' );

        $related_query = new WP_Query( array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'category__in'   => $cat_ids,
            'post__not_in'   => array( get_the_ID() ),
            'posts_per_page' => 3,
            'orderby'        => 'rand',
        ) );

        if ( $related_query->have_posts() ) :
    ?>
        <div style="margin-top:48px">
            <h3 style="font-family:'Playfair Display',serif;font-size:1.4rem;margin-bottom:24px">
                <?php esc_html_e( 'Related Posts', 'baloch-diamond' ); ?>
            </h3>
            <div class="related-posts-grid">
                <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="related-post-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'bd-related' ); ?>
                        <?php else : ?>
                            <div style="height:130px;background:var(--bg-alt);display:flex;align-items:center;justify-content:center">
                                <div style="opacity:0.15"><?php echo bd_icon( 'file-text', 32, 32 ); ?></div>
                            </div>
                        <?php endif; ?>
                        <h4><?php the_title(); ?></h4>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
    <?php
        wp_reset_postdata();
        endif;
    endif;
    ?>

    <!-- Comments -->
    <?php
    if ( comments_open() || get_comments_number() ) {
        comments_template();
    }
    ?>

</div>
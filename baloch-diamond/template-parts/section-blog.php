<?php
/**
 * Blog Section Template Part (Front Page)
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$blog_count = get_theme_mod( 'bd_blog_count', 6 );

$blog_query = new WP_Query( array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $blog_count,
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

if ( ! $blog_query->have_posts() ) {
    return;
}

$read_more_text = get_theme_mod( 'bd_blog_readmore_text', esc_html__( 'Read More', 'baloch-diamond' ) );
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

    <div class="posts-grid">

        <?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>

            <article class="post-card">

                <!-- Image -->
                <div class="post-card-img-wrapper">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'bd-card' ); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>" style="display:block;height:100%;background:var(--bg);display:flex;align-items:center;justify-content:center">
                            <div style="opacity:0.15"><?php echo bd_icon( 'file-text', 48, 48 ); ?></div>
                        </a>
                    <?php endif; ?>

                    <div class="post-date-badge">
                        <span class="day"><?php echo get_the_date( 'j' ); ?></span>
                        <span class="month"><?php echo get_the_date( 'M' ); ?></span>
                    </div>
                </div>

                <!-- Body -->
                <div class="post-card-body">

                    <!-- Meta -->
                    <div class="post-meta">
                        <span class="post-meta-item">
                            <?php echo bd_icon( 'user', 14, 14 ); ?>
                            <?php the_author(); ?>
                        </span>
                        <span class="post-meta-item">
                            <?php echo bd_icon( 'comment', 14, 14 ); ?>
                            <?php
                            printf(
                                esc_html( _n( '%s Comment', '%s Comments', get_comments_number(), 'baloch-diamond' ) ),
                                number_format_i18n( get_comments_number() )
                            );
                            ?>
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 class="post-card-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>

                    <!-- Excerpt -->
                    <p class="post-card-excerpt">
                        <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                    </p>

                    <!-- Read More -->
                    <a href="<?php the_permalink(); ?>" class="read-more">
                        <?php echo esc_html( $read_more_text ); ?>
                        <?php echo bd_icon( 'arrow-right', 16, 16 ); ?>
                    </a>

                </div>
            </article>

        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>

    </div>
</section>
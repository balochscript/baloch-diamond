<?php
/**
 * Template part for displaying post cards in archive/index
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

    <!-- Image -->
    <div class="post-card-img-wrapper">
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'bd-card' ); ?>
            </a>
        <?php else : ?>
            <a href="<?php the_permalink(); ?>" style="display:flex;height:100%;background:var(--bg-alt);align-items:center;justify-content:center">
                <div style="opacity:0.15"><?php echo 4392bd_icon( 'file-text', 48, 48 ); ?></div>
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
                <?php echo 4392bd_icon( 'user', 14, 14 ); ?>
                <?php the_author(); ?>
            </span>
            <span class="post-meta-item">
                <?php echo 4392bd_icon( 'comment', 14, 14 ); ?>
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
            <?php esc_html_e( 'Read More', 'baloch-diamond' ); ?>
            <?php echo 4392bd_icon( 'arrow-right', 16, 16 ); ?>
        </a>

    </div>
</article>
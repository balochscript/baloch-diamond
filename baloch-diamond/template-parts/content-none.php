<?php
/**
 * Template part for displaying "no posts found"
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="error-404" style="padding:60px 24px">
    <div class="error-diamond" style="width:40px;height:40px"></div>

    <?php if ( is_search() ) : ?>

        <h2 class="error-title" style="font-size:1.5rem">
            <?php esc_html_e( 'No Results Found', 'baloch-diamond' ); ?>
        </h2>
        <p class="error-desc" style="font-size:1rem">
            <?php
            /* translators: %s: Search query */
            printf( esc_html__( 'Sorry, no results were found for "%s". Try different keywords.', 'baloch-diamond' ), '<strong>' . get_search_query() . '</strong>' );
            ?>
        </p>

    <?php else : ?>

        <h2 class="error-title" style="font-size:1.5rem">
            <?php esc_html_e( 'Nothing Found', 'baloch-diamond' ); ?>
        </h2>
        <p class="error-desc" style="font-size:1rem">
            <?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'baloch-diamond' ); ?>
        </p>

    <?php endif; ?>

    <div style="max-width:400px;margin:24px auto 0">
        <?php get_search_form(); ?>
    </div>

    <div class="error-buttons" style="margin-top:24px">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-gradient">
            <?php echo 4392bd_icon( 'home', 18, 18 ); ?>
            <?php esc_html_e( 'Back to Home', 'baloch-diamond' ); ?>
        </a>
    </div>
</div>
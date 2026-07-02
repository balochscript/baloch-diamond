<?php
/**
 * Single Post Template
 *
 * @package Baloch_Diamond
 */

get_header();
?>

<main class="site-main" id="mainContent">

    <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'template-parts/content-single' ); ?>

    <?php endwhile; ?>

    <!-- Post Navigation -->
    <div class="section" style="padding-top:0;padding-bottom:40px">
        <div style="max-width:800px;margin:0 auto;display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap">
            <?php
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            ?>

            <?php if ( $prev_post ) : ?>
                <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>"
                   class="btn-outline"
                   style="flex:1;min-width:200px;text-decoration:none">
                    <?php echo bd_icon( 'arrow-left', 16, 16 ); ?>
                    <span style="display:flex;flex-direction:column;align-items:flex-start;gap:2px">
                        <small style="font-size:0.7rem;opacity:0.7;text-transform:uppercase;letter-spacing:1px">
                            <?php esc_html_e( 'Previous', 'baloch-diamond' ); ?>
                        </small>
                        <span style="font-size:0.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px">
                            <?php echo esc_html( get_the_title( $prev_post->ID ) ); ?>
                        </span>
                    </span>
                </a>
            <?php endif; ?>

            <?php if ( $next_post ) : ?>
                <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"
                   class="btn-outline"
                   style="flex:1;min-width:200px;text-decoration:none;text-align:right;justify-content:flex-end">
                    <span style="display:flex;flex-direction:column;align-items:flex-end;gap:2px">
                        <small style="font-size:0.7rem;opacity:0.7;text-transform:uppercase;letter-spacing:1px">
                            <?php esc_html_e( 'Next', 'baloch-diamond' ); ?>
                        </small>
                        <span style="font-size:0.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px">
                            <?php echo esc_html( get_the_title( $next_post->ID ) ); ?>
                        </span>
                    </span>
                    <?php echo bd_icon( 'arrow-right-small', 16, 16 ); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>

</main>

<?php
get_footer();
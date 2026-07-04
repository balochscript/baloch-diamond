<?php
/**
 * Page Template
 *
 * @package Baloch_Diamond
 */

get_header();
?>

<main class="site-main" id="mainContent">

    <?php while ( have_posts() ) : the_post(); ?>

        <!-- Page Hero -->
        <div class="single-post-hero" style="<?php echo has_post_thumbnail() ? '' : 'min-height:250px;height:30vh;'; ?>">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'bd-slider', array( 'alt' => get_the_title() ) ); ?>
            <?php else : ?>
                <div style="width:100%;height:100%;background:var(--gradient);display:flex;align-items:center;justify-content:center">
                    <div style="opacity:0.1">
                        <?php echo 4392bd_icon( 'file-text', 80, 80 ); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="overlay">
                <h1 style="font-family:'Playfair Display',serif;font-size:2.5rem;font-weight:900;color:white;text-shadow:0 2px 10px rgba(0,0,0,0.5);max-width:700px;line-height:1.3">
                    <?php the_title(); ?>
                </h1>
            </div>
        </div>

        <!-- Page Content -->
        <div class="single-post-content">
            <?php the_content(); ?>

            <?php
            // Page links (for paginated pages)
            wp_link_pages( array(
                'before'      => '<div class="pagination" style="margin-top:32px">',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
            ) );
            ?>
        </div>

        <!-- Comments on pages (if enabled) -->
        <?php if ( comments_open() || get_comments_number() ) : ?>
            <div style="max-width:800px;margin:0 auto;padding:0 24px 60px">
                <?php comments_template(); ?>
            </div>
        <?php endif; ?>

    <?php endwhile; ?>

</main>

<?php
get_footer();
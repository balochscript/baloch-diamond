<?php
/**
 * Blog Index Template (home.php)
 *
 * This is the standard WordPress template for the blog archive page.
 * WordPress automatically uses this template when a "Posts page" is set
 * in Settings → Reading.
 *
 * Uses the main WordPress query loop with the_posts_pagination() for
 * fully native pagination support. Reads posts_per_page from
 * Settings → Reading automatically.
 *
 * Layout: Header → Slider → Posts Grid → Pagination → Footer
 *
 * @package Baloch_Diamond
 * @version 1.2.2
 */

get_header();
?>

<main class="site-main" id="mainContent">

    <?php get_template_part( 'template-parts/hero-slider' ); ?>

    <!-- Page Header -->
    <div class="section" style="padding-bottom:30px">
        <div class="section-header">
            <div class="section-badge">
                <?php echo bd_icon( 'file-text', 16, 16 ); ?>
                <?php esc_html_e( 'Blog', 'baloch-diamond' ); ?>
            </div>
            <h1 class="section-title">
                <?php
                if ( is_home() && ! is_front_page() ) {
                    single_post_title();
                } else {
                    esc_html_e( 'Latest Updates', 'baloch-diamond' );
                }
                ?>
            </h1>
            <p class="section-desc">
                <?php esc_html_e( 'Stay updated with our latest articles, tutorials, and industry insights.', 'baloch-diamond' ); ?>
            </p>
        </div>
    </div>

    <!-- Posts Grid — uses WordPress main query -->
    <div class="section" style="padding-top:0">
        <?php if ( have_posts() ) : ?>

            <div class="posts-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content' ); ?>
                <?php endwhile; ?>
            </div>

            <!-- Standard WordPress pagination -->
            <?php
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => bd_icon( 'arrow-left', 16, 16 ) . ' <span class="nav-prev-text">' . esc_html__( 'Newer', 'baloch-diamond' ) . '</span>',
                'next_text' => '<span class="nav-next-text">' . esc_html__( 'Older', 'baloch-diamond' ) . '</span> ' . bd_icon( 'arrow-right', 16, 16 ),
            ) );
            ?>

        <?php else : ?>

            <!-- No Posts Found -->
            <div class="error-404" style="padding:40px 24px">
                <div class="error-diamond" style="width:40px;height:40px"></div>
                <h2 class="error-title" style="font-size:1.5rem"><?php esc_html_e( 'No Posts Found', 'baloch-diamond' ); ?></h2>
                <p class="error-desc" style="font-size:1rem">
                    <?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'baloch-diamond' ); ?>
                </p>
                <div class="error-buttons">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-gradient">
                        <?php echo bd_icon( 'home', 18, 18 ); ?>
                        <?php esc_html_e( 'Back to Home', 'baloch-diamond' ); ?>
                    </a>
                </div>
            </div>

        <?php endif; ?>
    </div>

</main>

<?php
get_footer();

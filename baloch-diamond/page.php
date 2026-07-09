<?php
/**
 * Page Template
 *
 * Static pages intentionally stay minimal: header, optional Hero Slider,
 * the page content, optional Newsletter, and the footer.
 * No other front-page sections (shop, forum, portfolio, blog, …) are
 * ever rendered on pages.
 *
 * Both extras are Customizer-controlled:
 * Appearance → Customize → 💎 Baloch Diamond Settings → 📄 Page Settings
 *
 * @package Baloch_Diamond
 * @version 1.4.3
 */

get_header();

// ---- Optional Hero Slider on pages ----
$bd_page_has_slider = false;
if ( get_theme_mod( 'bd_page_show_slider', true ) && bd_is_section_visible( 'slider' ) ) {
    get_template_part( 'template-parts/hero-slider' );
    $bd_page_has_slider = true;
}
?>

<main class="site-main" id="mainContent">

    <?php while ( have_posts() ) : the_post(); ?>

        <!-- Page Hero -->
        <div class="single-post-hero<?php echo $bd_page_has_slider ? ' page-hero--after-slider' : ''; ?>" style="<?php echo has_post_thumbnail() ? '' : 'min-height:250px;height:30vh;'; ?>">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'bd-slider', array( 'alt' => get_the_title() ) ); ?>
            <?php else : ?>
                <div style="width:100%;height:100%;background:var(--gradient);display:flex;align-items:center;justify-content:center">
                    <div style="opacity:0.1">
                        <?php echo bd_icon( 'file-text', 80, 80 ); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="overlay">
                <h1 style="font-family:var(--font-heading);font-size:2.5rem;font-weight:900;color:white;text-shadow:0 2px 10px rgba(0,0,0,0.5);max-width:700px;line-height:1.3">
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

    <?php
    // ---- Optional Newsletter on pages (full-width, above the footer) ----
    if ( get_theme_mod( 'bd_page_show_newsletter', true ) && bd_is_section_visible( 'newsletter' ) ) {
        get_template_part( 'template-parts/section-newsletter' );
    }
    ?>

</main>

<?php
get_footer();

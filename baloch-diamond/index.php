<?php
/**
 * The main template file (fallback)
 *
 * Also serves as the dedicated Blog Archive page (when `is_home()` is true):
 * Header → Hero Slider → Post List (with Newer/Older Posts pagination) → Footer.
 * No other homepage sections (shop, forum, portfolio, etc.) are rendered here.
 *
 * @package Baloch_Diamond
 */

get_header();

$bd_is_blog_archive = is_home();
?>

<main class="site-main" id="mainContent">

    <?php if ( $bd_is_blog_archive ) : ?>
        <?php get_template_part( 'template-parts/hero-slider' ); ?>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="section" style="<?php echo $bd_is_blog_archive ? '' : 'margin-top:70px;'; ?>padding-bottom:30px">
        <div class="section-header">

            <?php if ( is_home() && ! is_front_page() ) : ?>
                <div class="section-badge">
                    <?php echo bd_icon( 'file-text', 16, 16 ); ?>
                    <?php esc_html_e( 'Blog', 'baloch-diamond' ); ?>
                </div>
                <h1 class="section-title">
                    <?php single_post_title(); ?>
                </h1>

            <?php elseif ( is_home() ) : ?>
                <div class="section-badge">
                    <?php echo bd_icon( 'file-text', 16, 16 ); ?>
                    <?php esc_html_e( 'Blog', 'baloch-diamond' ); ?>
                </div>
                <h1 class="section-title">
                    <?php esc_html_e( 'Latest Updates', 'baloch-diamond' ); ?>
                </h1>
                <p class="section-desc">
                    <?php esc_html_e( 'Stay updated with our latest articles, tutorials, and industry insights.', 'baloch-diamond' ); ?>
                </p>

            <?php else : ?>
                <h1 class="section-title">
                    <?php esc_html_e( 'Latest Posts', 'baloch-diamond' ); ?>
                </h1>
            <?php endif; ?>

        </div>
    </div>


    <!-- Posts Grid -->
    <div class="section" style="padding-top:0">
        <?php if ( have_posts() ) : ?>

            <div class="posts-grid">
                <?php while ( have_posts() ) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

                        <!-- Post Image -->
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-card-img-wrapper">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'bd-card' ); ?>
                                </a>
                                <div class="post-date-badge">
                                    <span class="day"><?php echo get_the_date( 'j' ); ?></span>
                                    <span class="month"><?php echo get_the_date( 'M' ); ?></span>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="post-card-img-wrapper" style="height:220px;background:var(--bg-alt);display:flex;align-items:center;justify-content:center">
                                <div style="opacity:0.2"><?php echo bd_icon( 'file-text', 48, 48 ); ?></div>
                                <div class="post-date-badge">
                                    <span class="day"><?php echo get_the_date( 'j' ); ?></span>
                                    <span class="month"><?php echo get_the_date( 'M' ); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Post Body -->
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
                                        /* translators: %s: Number of comments */
                                        esc_html( _n( '%s Comment', '%s Comments', get_comments_number(), 'baloch-diamond' ) ),
                                        number_format_i18n( get_comments_number() )
                                    );
                                    ?>
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="post-card-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <!-- Excerpt -->
                            <p class="post-card-excerpt">
                                <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                            </p>

                            <!-- Read More -->
                            <a href="<?php the_permalink(); ?>" class="read-more">
                                <?php esc_html_e( 'Read More', 'baloch-diamond' ); ?>
                                <?php echo bd_icon( 'arrow-right', 16, 16 ); ?>
                            </a>

                        </div>
                    </article>

                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php if ( $bd_is_blog_archive ) : ?>
                <?php bd_blog_archive_pagination(); ?>
            <?php else : ?>
                <?php bd_pagination(); ?>
            <?php endif; ?>

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
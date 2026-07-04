<?php
/**
 * Archive Template (Category, Tag, Date, Author)
 *
 * @package Baloch_Diamond
 */

get_header();
?>

<main class="site-main" id="mainContent">

    <!-- Archive Header -->
    <div class="section" style="margin-top:70px;padding-bottom:30px">
        <div class="section-header">

            <?php if ( is_category() ) : ?>
                <div class="section-badge">
                    <?php echo bd_icon( 'tag', 16, 16 ); ?>
                    <?php esc_html_e( 'Category', 'baloch-diamond' ); ?>
                </div>
                <h1 class="section-title">
                    <?php single_cat_title(); ?>
                </h1>
                <?php if ( category_description() ) : ?>
                        <div class="line"></div>
                        <div class="diamond"></div>
                        <div class="line"></div>
                    </div>
                    <p class="section-desc"><?php echo wp_kses_post( category_description() ); ?></p>
                <?php endif; ?>

            <?php elseif ( is_tag() ) : ?>
                <div class="section-badge">
                    <?php echo bd_icon( 'tag', 16, 16 ); ?>
                    <?php esc_html_e( 'Tag', 'baloch-diamond' ); ?>
                </div>
                <h1 class="section-title">
                    <?php single_tag_title(); ?>
                </h1>
                <?php if ( tag_description() ) : ?>
                        <div class="line"></div>
                        <div class="diamond"></div>
                        <div class="line"></div>
                    </div>
                    <p class="section-desc"><?php echo wp_kses_post( tag_description() ); ?></p>
                <?php endif; ?>

            <?php elseif ( is_author() ) : ?>
                <?php $author = get_queried_object(); ?>
                <div class="section-badge">
                    <?php echo bd_icon( 'user', 16, 16 ); ?>
                    <?php esc_html_e( 'Author', 'baloch-diamond' ); ?>
                </div>

                <!-- Author Info Card -->
                <div class="author-box" style="max-width:600px;margin:0 auto 24px;justify-content:center;text-align:center;flex-direction:column;align-items:center">
                    <?php echo get_avatar( $author->ID, 80, '', $author->display_name ); ?>
                    <div class="author-box-content" style="text-align:center">
                        <h1 style="font-family:var(--font-heading);font-size:2rem;font-weight:900;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:8px">
                            <?php echo esc_html( $author->display_name ); ?>
                        </h1>
                        <?php if ( $author->description ) : ?>
                            <p style="color:var(--text-muted);font-size:0.95rem;line-height:1.7">
                                <?php echo esc_html( $author->description ); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

            <?php elseif ( is_year() ) : ?>
                <div class="section-badge">
                    <?php echo bd_icon( 'calendar', 16, 16 ); ?>
                    <?php esc_html_e( 'Yearly Archive', 'baloch-diamond' ); ?>
                </div>
                <h1 class="section-title">
                    <?php echo get_the_date( 'Y' ); ?>
                </h1>

            <?php elseif ( is_month() ) : ?>
                <div class="section-badge">
                    <?php echo bd_icon( 'calendar', 16, 16 ); ?>
                    <?php esc_html_e( 'Monthly Archive', 'baloch-diamond' ); ?>
                </div>
                <h1 class="section-title">
                    <?php echo get_the_date( 'F Y' ); ?>
                </h1>

            <?php elseif ( is_day() ) : ?>
                <div class="section-badge">
                    <?php echo bd_icon( 'calendar', 16, 16 ); ?>
                    <?php esc_html_e( 'Daily Archive', 'baloch-diamond' ); ?>
                </div>
                <h1 class="section-title">
                    <?php echo get_the_date( 'F j, Y' ); ?>
                </h1>

            <?php else : ?>
                <div class="section-badge">
                    <?php echo bd_icon( 'file-text', 16, 16 ); ?>
                    <?php esc_html_e( 'Archive', 'baloch-diamond' ); ?>
                </div>
                <h1 class="section-title">
                    <?php the_archive_title(); ?>
                </h1>
                <?php if ( get_the_archive_description() ) : ?>
                        <div class="line"></div>
                        <div class="diamond"></div>
                        <div class="line"></div>
                    </div>
                    <p class="section-desc"><?php echo wp_kses_post( get_the_archive_description() ); ?></p>
                <?php endif; ?>

            <?php endif; ?>

            <!-- Post Count -->
            <p style="color:var(--text-muted);font-size:0.85rem;margin-top:12px">
                <?php
                global $wp_query;
                printf(
                    /* translators: %d: Number of posts found */
                    esc_html( _n( '%d post found', '%d posts found', $wp_query->found_posts, 'baloch-diamond' ) ),
                    number_format_i18n( $wp_query->found_posts )
                );
                ?>
            </p>

        </div>
    </div>

    <!-- Posts Grid -->
    <div class="section" style="padding-top:0">
        <?php if ( have_posts() ) : ?>

            <div class="posts-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content' ); ?>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php bd_pagination(); ?>

        <?php else : ?>
            <?php get_template_part( 'template-parts/content-none' ); ?>
        <?php endif; ?>
    </div>

</main>

<?php
get_footer();
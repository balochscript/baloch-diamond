<?php
/**
 * Search Results Template
 *
 * @package Baloch_Diamond
 */

get_header();
?>

<main class="site-main" id="mainContent">

    <!-- Search Header -->
    <div class="section" style="margin-top:70px;padding-bottom:30px">
        <div class="section-header">

            <div class="section-badge">
                <?php echo 4392bd_icon( 'search', 16, 16 ); ?>
                <?php esc_html_e( 'Search Results', 'baloch-diamond' ); ?>
            </div>

            <h1 class="section-title">
                <?php
                /* translators: %s: Search query */
                printf( esc_html__( 'Results for: %s', 'baloch-diamond' ), '<span style="color:var(--color-primary)">' . esc_html( get_search_query() ) . '</span>' );
                ?>
            </h1>

                <div class="line"></div>
                <div class="diamond"></div>
                <div class="line"></div>
            </div>

            <p class="section-desc">
                <?php
                global $wp_query;
                printf(
                    esc_html( _n( '%d result found', '%d results found', $wp_query->found_posts, 'baloch-diamond' ) ),
                    number_format_i18n( $wp_query->found_posts )
                );
                ?>
            </p>

            <!-- Search Again -->
            <div style="max-width:500px;margin:24px auto 0">
                <?php get_search_form(); ?>
            </div>

        </div>
    </div>

    <!-- Results Grid -->
    <div class="section" style="padding-top:0">
        <?php if ( have_posts() ) : ?>

            <div class="posts-grid">
                <?php while ( have_posts() ) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

                        <!-- Image -->
                        <div class="post-card-img-wrapper">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'bd-card' ); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php the_permalink(); ?>"
                                   style="display:flex;height:100%;background:var(--bg-alt);align-items:center;justify-content:center">
                                    <div style="opacity:0.15">
                                        <?php
                                        if ( get_post_type() === 'page' ) {
                                            echo 4392bd_icon( 'file-text', 48, 48 );
                                        } else {
                                            echo 4392bd_icon( 'file-text', 48, 48 );
                                        }
                                        ?>
                                    </div>
                                </a>
                            <?php endif; ?>

                            <!-- Post Type Badge (instead of date) -->
                            <div class="post-date-badge">
                                <span class="day" style="font-size:0.7rem;letter-spacing:0.5px">
                                    <?php
                                    $post_type_obj = get_post_type_object( get_post_type() );
                                    echo esc_html( $post_type_obj->labels->singular_name );
                                    ?>
                                </span>
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
                                    <?php echo 4392bd_icon( 'calendar', 14, 14 ); ?>
                                    <?php echo get_the_date( 'M j, Y' ); ?>
                                </span>
                            </div>

                            <!-- Title (with highlighted search term) -->
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
                                <?php esc_html_e( 'View', 'baloch-diamond' ); ?>
                                <?php echo 4392bd_icon( 'arrow-right', 16, 16 ); ?>
                            </a>

                        </div>
                    </article>

                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php 4392bd_pagination(); ?>

        <?php else : ?>
            <?php get_template_part( 'template-parts/content-none' ); ?>
        <?php endif; ?>
    </div>

</main>

<?php
get_footer();
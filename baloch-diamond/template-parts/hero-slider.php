<?php
/**
 * Hero Slider Template Part
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get slider settings
$slider_source = get_theme_mod( '4392bd_slider_source', 'recent' );
$slider_count  = get_theme_mod( '4392bd_slider_count', 5 );

// Build query
if ( $slider_source === 'custom' ) {
    // Custom selected posts
    $custom_ids = array();
    for ( $i = 1; $i <= 7; $i++ ) {
        $pid = get_theme_mod( "4392bd_slider_post_{$i}", 0 );
        if ( $pid ) {
            $custom_ids[] = intval( $pid );
        }
    }

    if ( empty( $custom_ids ) ) {
        // Fallback to recent
        $slider_args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => $slider_count,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
    } else {
        $slider_args = array(
            'post_type'      => array( 'post', 'page' ),
            'post_status'    => 'publish',
            'post__in'       => $custom_ids,
            'orderby'        => 'post__in',
            'posts_per_page' => count( $custom_ids ),
        );
    }
} else {
    // Recent posts
    $slider_args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => min( $slider_count, 7 ),
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => '_thumbnail_id',
                'compare' => 'EXISTS',
            ),
        ),
    );
}

$slider_query = new WP_Query( $slider_args );

if ( ! $slider_query->have_posts() ) {
    return;
}

$slide_index = 0;
$total_slides = $slider_query->post_count;
?>

<section class="hero-slider" id="heroSlider" data-total="<?php echo esc_attr( $total_slides ); ?>">

    <?php while ( $slider_query->have_posts() ) : $slider_query->the_post(); ?>

        <?php
        $category = 4392bd_get_first_category();
        $has_thumb = has_post_thumbnail();
        ?>

        <div class="slide <?php echo $slide_index === 0 ? 'active' : ''; ?>" data-slide="<?php echo esc_attr( $slide_index ); ?>">

            <?php if ( $has_thumb ) : ?>
                <?php the_post_thumbnail( 'bd-slider', array( 'class' => 'slide-image', 'alt' => get_the_title() ) ); ?>
            <?php else : ?>
                <div class="slide-image" style="width:100%;height:100%;background:var(--gradient);display:flex;align-items:center;justify-content:center">
                    <div style="opacity:0.2"><?php echo 4392bd_icon( 'monitor', 80, 80 ); ?></div>
                </div>
            <?php endif; ?>

            <a href="<?php the_permalink(); ?>" class="slide-link" aria-label="<?php the_title_attribute(); ?>"></a>

            <div class="slide-overlay">
                <span class="slide-category"><?php echo esc_html( $category['name'] ); ?></span>
                <h2 class="slide-title"><?php the_title(); ?></h2>
                <?php if ( has_excerpt() || get_the_content() ) : ?>
                    <p class="slide-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <?php $slide_index++; ?>

    <?php endwhile; ?>

    <?php wp_reset_postdata(); ?>

    <?php if ( $total_slides > 1 ) : ?>

        <!-- Arrows -->
        <button class="slider-arrow prev" id="sliderPrev" aria-label="<?php esc_attr_e( 'Previous slide', 'baloch-diamond' ); ?>">
            <?php echo 4392bd_icon( 'arrow-left', 20, 20 ); ?>
        </button>
        <button class="slider-arrow next" id="sliderNext" aria-label="<?php esc_attr_e( 'Next slide', 'baloch-diamond' ); ?>">
            <?php echo 4392bd_icon( 'arrow-right-small', 20, 20 ); ?>
        </button>

        <!-- Dots -->
        <div class="slider-dots">
            <?php for ( $d = 0; $d < $total_slides; $d++ ) : ?>
                <div class="slider-dot <?php echo $d === 0 ? 'active' : ''; ?>" data-slide="<?php echo esc_attr( $d ); ?>"></div>
            <?php endfor; ?>
        </div>

    <?php endif; ?>

</section>
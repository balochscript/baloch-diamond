<?php
/**
 * Portfolio Section Template Part
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Check how many portfolio items exist
$portfolio_count = 0;
for ( $i = 1; $i <= 10; $i++ ) {
    $title = get_theme_mod( "4392bd_portfolio_item_{$i}_title", '' );
    if ( $title ) {
        $portfolio_count++;
    }
}

// If no items configured, show nothing
if ( $portfolio_count === 0 ) {
    return;
}
?>

<section class="section balochi-pattern" id="projects">

    <?php
    4392bd_section_header( 'portfolio', array(
        'badge' => esc_html__( 'Our Portfolio', 'baloch-diamond' ),
        'title' => esc_html__( 'Featured Projects', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Showcasing our finest work blending tradition with innovation. Each project tells a unique story of creativity and craftsmanship.', 'baloch-diamond' ),
        'icon'  => 'monitor',
    ) );
    ?>

    <div class="projects-grid" style="position:relative;z-index:1">

        <?php for ( $i = 1; $i <= 10; $i++ ) :

            $title   = get_theme_mod( "4392bd_portfolio_item_{$i}_title", '' );
            $desc    = get_theme_mod( "4392bd_portfolio_item_{$i}_desc", '' );
            $image   = get_theme_mod( "4392bd_portfolio_item_{$i}_image", '' );
            $link    = get_theme_mod( "4392bd_portfolio_item_{$i}_link", '' );
            $btn_txt = get_theme_mod( '4392bd_portfolio_btn_text', esc_html__( 'More Info', 'baloch-diamond' ) );

            if ( ! $title ) {
                continue;
            }
        ?>

            <div class="project-card">
                <div class="project-card-img-wrapper">
                    <?php if ( $image ) : ?>
                        <img class="project-card-image"
                             src="<?php echo esc_url( $image ); ?>"
                             alt="<?php echo esc_attr( $title ); ?>"
                             loading="lazy">
                    <?php else : ?>
                        <div class="project-card-image" style="background:var(--bg-alt);display:flex;align-items:center;justify-content:center">
                            <div style="opacity:0.15"><?php echo 4392bd_icon( 'monitor', 48, 48 ); ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="project-card-content">
                    <h3 class="project-card-title"><?php echo esc_html( $title ); ?></h3>

                    <?php if ( $desc ) : ?>
                        <p class="project-card-excerpt"><?php echo esc_html( $desc ); ?></p>
                    <?php endif; ?>

                    <?php if ( $link ) : ?>
                        <a href="<?php echo esc_url( $link ); ?>" class="btn-gradient">
                            <?php echo esc_html( $btn_txt ); ?>
                            <?php echo 4392bd_icon( 'arrow-right', 16, 16 ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        <?php endfor; ?>

    </div>
</section>
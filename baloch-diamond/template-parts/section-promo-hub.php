<?php
/**
 * Shop & Forum Promo Hub Section Template Part
 *
 * @package Baloch_Diamond
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Customizer options
$show_promohub  = get_theme_mod( 'bd_promohub_show', true );
$badge          = get_theme_mod( 'bd_promohub_badge', esc_html__( 'Community & Marketplace', 'baloch-diamond' ) );
$title          = get_theme_mod( 'bd_promohub_title', esc_html__( 'Explore Our Diamond Hub', 'baloch-diamond' ) );
$desc           = get_theme_mod( 'bd_promohub_desc', esc_html__( 'Connect with our thriving community of creators or support local craftsmanship by browsing our premium product collections.', 'baloch-diamond' ) );

// Forum Card
$forum_title    = get_theme_mod( 'bd_promohub_forum_title', esc_html__( 'Discussion Forums', 'baloch-diamond' ) );
$forum_desc     = get_theme_mod( 'bd_promohub_forum_desc', esc_html__( 'Join the conversations, share ideas, and explore deep-dives into traditional Balochi needlework, culture, and modern art.', 'baloch-diamond' ) );
$forum_link     = get_theme_mod( 'bd_promohub_forum_link', '#_forums' );
$forum_btn      = get_theme_mod( 'bd_promohub_forum_btn', esc_html__( 'Enter Forums', 'baloch-diamond' ) );

// Shop Card
$shop_title     = get_theme_mod( 'bd_promohub_shop_title', esc_html__( 'Artisanal Shop', 'baloch-diamond' ) );
$shop_desc      = get_theme_mod( 'bd_promohub_shop_desc', esc_html__( 'Browse our curated catalog of hand-woven garments, digital pattern guides, and premium merchandise handcrafted to perfection.', 'baloch-diamond' ) );
$shop_link      = get_theme_mod( 'bd_promohub_shop_link', '#_shop' );
$shop_btn       = get_theme_mod( 'bd_promohub_shop_btn', esc_html__( 'Browse Shop', 'baloch-diamond' ) );

if ( ! $show_promohub ) {
    return;
}
?>

<section class="section promo-hub-section" id="promo-hub">
    
    <div class="section-header" style="position:relative;z-index:1">
        <?php if ( $badge ) : ?>
            <div class="section-badge">
                <?php echo bd_icon( 'users', 16, 16 ); ?>
                <?php echo esc_html( $badge ); ?>
            </div>
        <?php endif; ?>

        <?php if ( $title ) : ?>
            <h2 class="section-title stitch-border"><?php echo esc_html( $title ); ?></h2>
            <div class="balochi-divider">
                <div class="line"></div>
                <div class="diamond"></div>
                <div class="line"></div>
            </div>
        <?php endif; ?>

        <?php if ( $desc ) : ?>
            <p class="section-desc"><?php echo esc_html( $desc ); ?></p>
        <?php endif; ?>
    </div>

    <div class="promo-hub-grid" style="position:relative;z-index:1;display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:30px;margin-top:30px">
        
        <!-- Forum Card -->
        <div class="promo-card forum-promo-card">
            <div class="promo-card-pattern"></div>
            <div class="promo-card-body">
                <div class="promo-icon-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="promo-svg-icon">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        <path d="M14 8c0 1.1-.9 2-2 2h-1c-.55 0-1 .45-1 1s.45 1 1 1h2a2 2 0 0 1 2 2v1c0 1.1-.9 2-2 2H9" opacity="0.4"></path>
                    </svg>
                </div>
                <h3 class="promo-card-title"><?php echo esc_html( $forum_title ); ?></h3>
                <p class="promo-card-desc"><?php echo esc_html( $forum_desc ); ?></p>
                <div class="promo-action">
                    <a href="<?php echo esc_url( $forum_link ); ?>" class="btn-gradient">
                        <?php echo bd_icon( 'users', 16, 16 ); ?>
                        <?php echo esc_html( $forum_btn ); ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Shop Card -->
        <div class="promo-card shop-promo-card">
            <div class="promo-card-pattern"></div>
            <div class="promo-card-body">
                <div class="promo-icon-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="promo-svg-icon">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
                <h3 class="promo-card-title"><?php echo esc_html( $shop_title ); ?></h3>
                <p class="promo-card-desc"><?php echo esc_html( $shop_desc ); ?></p>
                <div class="promo-action">
                    <a href="<?php echo esc_url( $shop_link ); ?>" class="btn-outline" style="border-width:2px;background:var(--bg)">
                        <?php echo bd_icon( 'tag', 16, 16 ); ?>
                        <?php echo esc_html( $shop_btn ); ?>
                    </a>
                </div>
            </div>
        </div>

    </div>

</section>

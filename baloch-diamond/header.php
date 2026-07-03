<?php
/**
 * The header template
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Header customizer settings
$header_display   = get_theme_mod( 'bd_header_display', 'icon_title' );
$header_bg_type   = get_theme_mod( 'bd_header_bg_type', 'default' );
$header_bg_color  = get_theme_mod( 'bd_header_bg_color', '' );
$header_grad_1    = get_theme_mod( 'bd_header_gradient_1', '#38bdf8' );
$header_grad_2    = get_theme_mod( 'bd_header_gradient_2', '#f97316' );
$header_grad_dir  = get_theme_mod( 'bd_header_gradient_direction', '135deg' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="light">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
<style>.cart-icon{position:relative}.cart-icon .cart-count{position:absolute;top:-6px;right:-6px;background:var(--color-primary);color:white;font-size:9px;width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700}</style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Notification -->
<div class="notification" id="notification">
    <div class="notification-icon">
        <?php echo bd_icon( 'check-circle' ); ?>
    </div>
    <div class="notification-text" id="notificationText"></div>
</div>

<!-- Header -->
<header class="site-header" id="siteHeader"
    <?php if ( $header_bg_type === 'solid' && $header_bg_color ) : ?>
        style="background: <?php echo esc_attr( $header_bg_color ); ?> !important;"
    <?php elseif ( $header_bg_type === 'gradient' ) : ?>
        style="background: linear-gradient(<?php echo esc_attr( $header_grad_dir ); ?>, <?php echo esc_attr( $header_grad_1 ); ?>, <?php echo esc_attr( $header_grad_2 ); ?>) !important;"
    <?php endif; ?>
>
    <div class="header-inner">

        <!-- Search Button (Left) -->
        <button class="header-icon" id="searchOpen" aria-label="<?php esc_attr_e( 'Search', 'baloch-diamond' ); ?>">
            <?php echo bd_icon( 'search' ); ?>
        </button>

        <!-- Center: Logo Area -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">

            <?php if ( $header_display !== 'title_only' ) : ?>
                <?php if ( has_custom_logo() ) : ?>
                    <div class="logo-diamond">
                        <?php
                        $logo_id  = get_theme_mod( 'custom_logo' );
                        $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
                        ?>
                        <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" style="width:100%;height:100%;object-fit:contain">
                    </div>
                <?php else : ?>
                    <div class="logo-diamond">
                        <?php echo bd_get_logo_svg(); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ( $header_display !== 'icon_only' ) : ?>
                <div class="site-logo-text">
                    <span class="site-name"><?php bloginfo( 'name' ); ?></span>
                    <?php if ( $header_display === 'icon_title_desc' || $header_display === 'title_desc' ) : ?>
                        <?php
                        $description = get_bloginfo( 'description', 'display' );
                        if ( $description ) : ?>
                            <span class="site-description-text"><?php echo esc_html( $description ); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </a>

        <!-- Desktop Primary Menu -->
        <nav class="desktop-nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'baloch-diamond' ); ?>">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'desktop-menu',
                    'depth'          => 3,
                    'fallback_cb'    => false,
                ) );
            } else {
                // Fallback menu for when no menu is assigned
                echo '<ul class="desktop-menu">';
                echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'baloch-diamond' ) . '</a></li>';
                $pages = get_pages( array( 'number' => 4 ) );
                foreach ( $pages as $pg ) {
                    echo '<li><a href="' . esc_url( get_permalink( $pg->ID ) ) . '">' . esc_html( $pg->post_title ) . '</a></li>';
                }
                echo '</ul>';
            }
            ?>
        </nav>

        <!-- Right side: Theme Toggle + Menu Button -->
        <div class="header-actions">
            <!-- Account + Cart (WooCommerce + User) -->
            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="header-icon" aria-label="<?php esc_attr_e( 'Account', 'baloch-diamond' ); ?>">
                    <?php echo bd_icon( 'user', 20, 20 ); ?>
                </a>

                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-icon cart-icon" aria-label="<?php esc_attr_e( 'Cart', 'baloch-diamond' ); ?>">
                    <?php echo bd_icon( 'shopping-cart', 20, 20 ); ?>
                    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                </a>
            <?php else : ?>
                <!-- Fallback when no WooCommerce -->
                <a href="<?php echo esc_url( home_url( '/my-account' ) ); ?>" class="header-icon" aria-label="<?php esc_attr_e( 'Account', 'baloch-diamond' ); ?>">
                    <?php echo bd_icon( 'user', 20, 20 ); ?>
                </a>
            <?php endif; ?>

            <!-- Menu Button (Mobile) -->
            <button class="header-icon mobile-only" id="menuOpen" aria-label="<?php esc_attr_e( 'Menu', 'baloch-diamond' ); ?>">
                <?php echo bd_icon( 'menu' ); ?>
            </button>
        </div>

    </div>
</header>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" id="menuOverlay"></div>

<!-- Mobile Menu -->
<nav class="mobile-menu" id="mobileMenu">
    <div class="menu-header">
        <span style="font-weight:700;font-size:1.1rem"><?php esc_html_e( 'Navigation', 'baloch-diamond' ); ?></span>
        <button class="menu-close" id="menuClose" aria-label="<?php esc_attr_e( 'Close menu', 'baloch-diamond' ); ?>">
            <?php echo bd_icon( 'close', 18, 18 ); ?>
        </button>
    </div>
    <div class="menu-items">

        <!-- Home Link (always shown) -->
        <a class="menu-item" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php echo bd_icon( 'home', 20, 20 ); ?>
            <?php esc_html_e( 'Home', 'baloch-diamond' ); ?>
        </a>

        <!-- WordPress Menu Items -->
        <?php
        if ( has_nav_menu( 'primary' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'walker'         => new BD_Mobile_Menu_Walker(),
                'depth'          => 2,
            ) );
        }
        ?>

    </div>
</nav>

<!-- Search Overlay -->
<div class="search-overlay" id="searchOverlay">
    <div class="search-container">
        <div class="search-input-wrapper">
            <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" id="bdSearchForm">
                <input type="search"
                       class="search-input"
                       id="searchInput"
                       name="s"
                       placeholder="<?php esc_attr_e( 'Search posts, pages...', 'baloch-diamond' ); ?>"
                       value="<?php echo get_search_query(); ?>"
                       autocomplete="off">
            </form>
            <button class="search-close" id="searchClose" aria-label="<?php esc_attr_e( 'Close search', 'baloch-diamond' ); ?>">
                <?php echo bd_icon( 'close', 18, 18 ); ?>
            </button>
        </div>
        <div class="search-results" id="searchResults"></div>
    </div>
</div>

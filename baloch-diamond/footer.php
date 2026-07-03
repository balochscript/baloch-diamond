<?php
/**
 * The footer template
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Footer customizer settings
$footer_about     = get_theme_mod( 'bd_footer_about', esc_html__( 'A premium WordPress theme inspired by the timeless beauty of Balochi needlework artistry. Where tradition meets modern web design excellence.', 'baloch-diamond' ) );
$footer_copyright = get_theme_mod( 'bd_footer_copyright', '' );
$footer_show      = get_theme_mod( 'bd_footer_show', true );

// Social links
$social_twitter   = get_theme_mod( 'bd_social_twitter', '' );
$social_github    = get_theme_mod( 'bd_social_github', '' );
$social_linkedin  = get_theme_mod( 'bd_social_linkedin', '' );
$social_instagram = get_theme_mod( 'bd_social_instagram', '' );

// Footer columns
$footer_col1_title = get_theme_mod( 'bd_footer_col1_title', esc_html__( 'Quick Links', 'baloch-diamond' ) );
$footer_col2_title = get_theme_mod( 'bd_footer_col2_title', esc_html__( 'Resources', 'baloch-diamond' ) );
$footer_col3_title = get_theme_mod( 'bd_footer_col3_title', esc_html__( 'Contact', 'baloch-diamond' ) );

// Contact info
$contact_email   = get_theme_mod( 'bd_contact_email', '' );
$contact_address = get_theme_mod( 'bd_contact_address', '' );
$contact_phone   = get_theme_mod( 'bd_contact_phone', '' );
?>

<?php if ( $footer_show ) : ?>
<!-- Footer -->
<footer class="site-footer">
    <div class="footer-top-bar"></div>
    <div class="footer-inner">

        <!-- Footer About -->
        <div class="footer-about">
            <div class="footer-logo">
                <?php if ( has_custom_logo() ) : ?>
                    <?php
                    $logo_id  = get_theme_mod( 'custom_logo' );
                    $logo_url = wp_get_attachment_image_url( $logo_id, 'thumbnail' );
                    ?>
                    <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" style="width:36px;height:36px;object-fit:contain">
                <?php else : ?>
                    <?php echo bd_get_footer_logo_svg(); ?>
                <?php endif; ?>
                <span class="footer-logo-text"><?php bloginfo( 'name' ); ?></span>
            </div>

            <?php if ( $footer_about ) : ?>
                <p><?php echo esc_html( $footer_about ); ?></p>
            <?php endif; ?>

            <?php if ( $social_twitter || $social_github || $social_linkedin || $social_instagram ) : ?>
            <div class="footer-social-row">
                <?php if ( $social_twitter ) : ?>
                    <a href="<?php echo esc_url( $social_twitter ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                        <?php echo bd_icon( 'twitter', 18, 18 ); ?>
                    </a>
                <?php endif; ?>
                <?php if ( $social_github ) : ?>
                    <a href="<?php echo esc_url( $social_github ); ?>" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                        <?php echo bd_icon( 'github', 18, 18 ); ?>
                    </a>
                <?php endif; ?>
                <?php if ( $social_linkedin ) : ?>
                    <a href="<?php echo esc_url( $social_linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                        <?php echo bd_icon( 'linkedin', 18, 18 ); ?>
                    </a>
                <?php endif; ?>
                <?php if ( $social_instagram ) : ?>
                    <a href="<?php echo esc_url( $social_instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                        <?php echo bd_icon( 'instagram', 18, 18 ); ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Footer Column 1 -->
        <div class="footer-col">
            <?php if ( $footer_col1_title ) : ?>
                <h4><?php echo esc_html( $footer_col1_title ); ?></h4>
            <?php endif; ?>

            <?php if ( has_nav_menu( 'footer' ) ) : ?>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'footer-links',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ) );
                ?>
            <?php elseif ( is_active_sidebar( 'footer-1' ) ) : ?>
                <?php dynamic_sidebar( 'footer-1' ); ?>
            <?php else : ?>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'baloch-diamond' ); ?></a></li>
                    <?php
                    $pages = get_pages( array( 'number' => 5 ) );
                    foreach ( $pages as $pg ) :
                    ?>
                        <li><a href="<?php echo esc_url( get_permalink( $pg->ID ) ); ?>"><?php echo esc_html( $pg->post_title ); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Footer Column 2 -->
        <div class="footer-col">
            <?php if ( $footer_col2_title ) : ?>
                <h4><?php echo esc_html( $footer_col2_title ); ?></h4>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                <?php dynamic_sidebar( 'footer-2' ); ?>
            <?php else : ?>
                <ul class="footer-links">
                    <?php
                    $categories = get_categories( array( 'number' => 5 ) );
                    foreach ( $categories as $cat ) :
                    ?>
                        <li><a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"><?php echo esc_html( $cat->name ); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Footer Column 3: Contact -->
        <div class="footer-col">
            <?php if ( $footer_col3_title ) : ?>
                <h4><?php echo esc_html( $footer_col3_title ); ?></h4>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                <?php dynamic_sidebar( 'footer-3' ); ?>
            <?php else : ?>
                <ul class="footer-links">
                    <?php if ( $contact_email ) : ?>
                        <li>
                            <a href="mailto:<?php echo esc_attr( $contact_email ); ?>">
                                <?php echo bd_icon( 'mail', 14, 14 ); ?>
                                <?php echo esc_html( $contact_email ); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ( $contact_address ) : ?>
                        <li>
                            <a href="#">
                                <?php echo bd_icon( 'map-pin', 14, 14 ); ?>
                                <?php echo esc_html( $contact_address ); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ( $contact_phone ) : ?>
                        <li>
                            <a href="tel:<?php echo esc_attr( $contact_phone ); ?>">
                                <?php echo bd_icon( 'phone', 14, 14 ); ?>
                                <?php echo esc_html( $contact_phone ); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>

    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <?php if ( $footer_copyright ) : ?>
            <p><?php echo wp_kses_post( $footer_copyright ); ?></p>
        <?php else : ?>
            <p>
                &copy; <?php echo date( 'Y' ); ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>.
                <?php
                /* translators: %s: Theme name */
                printf( esc_html__( 'Crafted with 💎 by %s. All rights reserved.', 'baloch-diamond' ), 'Baloch Diamond' );
                ?>
            </p>
        <?php endif; ?>
    </div>
</footer>
<?php endif; ?>

<!-- Dark/Light Mode Toggle -->
<button class="theme-toggle" id="themeToggle" aria-label="<?php esc_attr_e( 'Toggle theme', 'baloch-diamond' ); ?>">
    <span id="sunIcon" style="display:none"><?php echo bd_icon( 'sun' ); ?></span>
    <span id="moonIcon"><?php echo bd_icon( 'moon' ); ?></span>
</button>

<!-- Floating Color Switcher (Proposal 1) -->
<button class="switcher-toggle-btn" id="switcherToggleBtn" aria-label="<?php esc_attr_e( 'Open color settings', 'baloch-diamond' ); ?>">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10V2z" opacity="0.4"></path>
    </svg>
</button>

<div class="floating-switcher" id="floatingSwitcher">
    <span style="font-size:0.8rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;"><?php esc_html_e( 'Palette Switcher', 'baloch-diamond' ); ?></span>
    <div class="switcher-palette-row">
        <!-- Default -->
        <div class="switcher-color-dot active" style="background:linear-gradient(135deg, #38bdf8, #f97316)" data-primary="#38bdf8" data-secondary="#f97316" title="Baloch Diamond"></div>
        <!-- Ocean -->
        <div class="switcher-color-dot" style="background:linear-gradient(135deg, #0ea5e9, #06b6d4)" data-primary="#0ea5e9" data-secondary="#06b6d4" title="Ocean Breeze"></div>
        <!-- Desert -->
        <div class="switcher-color-dot" style="background:linear-gradient(135deg, #f97316, #ef4444)" data-primary="#f97316" data-secondary="#ef4444" title="Desert Sunset"></div>
        <!-- Forest -->
        <div class="switcher-color-dot" style="background:linear-gradient(135deg, #10b981, #059669)" data-primary="#10b981" data-secondary="#059669" title="Forest Green"></div>
        <!-- Royal -->
        <div class="switcher-color-dot" style="background:linear-gradient(135deg, #8b5cf6, #ec4899)" data-primary="#8b5cf6" data-secondary="#ec4899" title="Royal Purple"></div>
    </div>
    <button class="btn-outline" id="resetSwitcherBtn" style="padding:6px 12px; font-size:0.75rem; border-radius:8px; justify-content:center;"><?php esc_html_e( 'Reset to Default', 'baloch-diamond' ); ?></button>
</div>

<?php wp_footer(); ?>
</body>
</html>

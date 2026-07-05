<?php
/**
 * Footer Template — Fully Customizable
 *
 * Customizer: 💎 Baloch Diamond Settings → 🦶 Footer Settings
 * - Custom logo upload
 * - About text, copyright text ({year} auto-replace)
 * - Background color, text color, link color
 * - Column layout (1–4 col)
 * - Column titles (editable)
 * - 8 Social networks (Twitter, GitHub, LinkedIn, Instagram, Facebook, YouTube, Telegram, WhatsApp)
 * - Show/Hide: pages column, categories column, social column, footer menu, powered-by text
 *
 * @package Baloch_Diamond
 */

// Gather Customizer values
$footer_show     = get_theme_mod( 'bd_footer_show', true );
$footer_about    = get_theme_mod( 'bd_footer_about', esc_html__( 'A premium WordPress theme inspired by the timeless beauty of Balochi needlework artistry. Where tradition meets modern web design excellence.', 'baloch-diamond' ) );
$footer_copyright = get_theme_mod( 'bd_footer_copyright', esc_html__( '© {year} Baloch Diamond. Crafted with love and heritage.', 'baloch-diamond' ) );
$footer_copyright = str_replace( '{year}', gmdate( 'Y' ), $footer_copyright );

$footer_logo         = get_theme_mod( 'bd_footer_logo', '' );
$footer_bg_color     = get_theme_mod( 'bd_footer_bg_color', '' );
$footer_bg_image     = get_theme_mod( 'bd_footer_bg_image', '' );
$footer_bg_overlay   = get_theme_mod( 'bd_footer_bg_image_overlay', 'rgba(0,0,0,0.55)' );
$footer_text_color   = get_theme_mod( 'bd_footer_text_color', '' );
$footer_link_color   = get_theme_mod( 'bd_footer_link_color', '' );

$show_pages      = get_theme_mod( 'bd_footer_show_pages', true );
$show_categories = get_theme_mod( 'bd_footer_show_categories', true );
$show_social_col = get_theme_mod( 'bd_footer_show_social', true );
$show_menu       = get_theme_mod( 'bd_footer_show_menu', true );
$show_powered    = get_theme_mod( 'bd_footer_show_powered', true );
$powered_text    = get_theme_mod( 'bd_footer_powered_text', esc_html__( 'Powered by WordPress & Baloch Diamond Theme.', 'baloch-diamond' ) );

$col2_title = get_theme_mod( 'bd_footer_col2_title', esc_html__( 'Quick Links', 'baloch-diamond' ) );
$col3_title = get_theme_mod( 'bd_footer_col3_title', esc_html__( 'Categories', 'baloch-diamond' ) );
$col4_title = get_theme_mod( 'bd_footer_col4_title', esc_html__( 'Connect With Us', 'baloch-diamond' ) );

// Column layout (old keys kept for back-compat)
$footer_col1_title = get_theme_mod( 'bd_footer_col1_title', esc_html__( 'Quick Links', 'baloch-diamond' ) );
$footer_col2_title_old = get_theme_mod( 'bd_footer_col2_title', esc_html__( 'Resources', 'baloch-diamond' ) );
$footer_col3_title_old = get_theme_mod( 'bd_footer_col3_title', esc_html__( 'Contact', 'baloch-diamond' ) );

// Social links — new per-network keys (with fallback to old single keys)
$social_networks = array(
    'twitter'   => array( 'url' => get_theme_mod( 'bd_footer_social_twitter',   get_theme_mod( 'bd_social_twitter',   '' ) ), 'label' => 'Twitter',   'icon' => 'twitter' ),
    'github'    => array( 'url' => get_theme_mod( 'bd_footer_social_github',    get_theme_mod( 'bd_social_github',    '' ) ), 'label' => 'GitHub',    'icon' => 'github' ),
    'linkedin'  => array( 'url' => get_theme_mod( 'bd_footer_social_linkedin',  get_theme_mod( 'bd_social_linkedin',  '' ) ), 'label' => 'LinkedIn',  'icon' => 'linkedin' ),
    'instagram' => array( 'url' => get_theme_mod( 'bd_footer_social_instagram', get_theme_mod( 'bd_social_instagram', '' ) ), 'label' => 'Instagram', 'icon' => 'instagram' ),
    'facebook'  => array( 'url' => get_theme_mod( 'bd_footer_social_facebook',  '' ), 'label' => 'Facebook',  'icon' => 'facebook' ),
    'youtube'   => array( 'url' => get_theme_mod( 'bd_footer_social_youtube',   '' ), 'label' => 'YouTube',   'icon' => 'youtube' ),
    'telegram'  => array( 'url' => get_theme_mod( 'bd_footer_social_telegram',  '' ), 'label' => 'Telegram',  'icon' => 'send' ),
    'whatsapp'  => array( 'url' => get_theme_mod( 'bd_footer_social_whatsapp',  '' ), 'label' => 'WhatsApp',  'icon' => 'message-circle' ),
);

$has_any_social = ! empty( array_filter( array_column( $social_networks, 'url' ) ) );

// Contact info (kept for compatibility)
$contact_email   = get_theme_mod( 'bd_contact_email', '' );
$contact_address = get_theme_mod( 'bd_contact_address', '' );
$contact_phone   = get_theme_mod( 'bd_contact_phone', '' );

// Build inline styles
$footer_inline = array();
$footer_has_bg_image = ! empty( $footer_bg_image );
if ( $footer_has_bg_image ) {
    $footer_inline[] = 'background-image: linear-gradient(' . esc_attr( $footer_bg_overlay ) . ',' . esc_attr( $footer_bg_overlay ) . '), url(' . esc_url( $footer_bg_image ) . ')';
    $footer_inline[] = 'background-size: cover';
    $footer_inline[] = 'background-position: center';
} elseif ( $footer_bg_color ) {
    $footer_inline[] = 'background:' . esc_attr( $footer_bg_color );
}
if ( $footer_text_color ) { $footer_inline[] = 'color:' . esc_attr( $footer_text_color ); }
$footer_inline_attr = ! empty( $footer_inline ) ? ' style="' . implode( ';', $footer_inline ) . '"' : '';

// Link color injected as inline <style>
$link_color_css = '';
if ( $footer_link_color ) {
    $link_color_css = '<style>.site-footer a,.footer-links a{color:' . esc_attr( $footer_link_color ) . '!important;}</style>';
}

// Pages & categories
$pages = get_pages( array( 'sort_column' => 'menu_order', 'number' => 6 ) );
$cats  = get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 6, 'hide_empty' => true ) );
?>

<?php echo $link_color_css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

<?php if ( $footer_show ) : ?>
<footer class="site-footer<?php echo $footer_has_bg_image ? ' has-bg-image' : ''; ?>"<?php echo $footer_inline_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

    <div class="footer-top-bar"></div>

    <div class="footer-inner">

        <!-- Column 1: About / Logo -->
        <div class="footer-about">

            <div class="footer-logo">
                <?php if ( $footer_logo ) : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="<?php echo esc_url( $footer_logo ); ?>"
                         alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
                         style="max-height:40px;width:auto;object-fit:contain;">
                </a>
                <?php elseif ( has_custom_logo() ) : ?>
                    <?php
                    $logo_id  = get_theme_mod( 'custom_logo' );
                    $logo_url = wp_get_attachment_image_url( $logo_id, 'thumbnail' );
                    ?>
                    <img src="<?php echo esc_url( $logo_url ); ?>"
                         alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
                         style="width:36px;height:36px;object-fit:contain;">
                <?php else : ?>
                    <?php echo bd_get_footer_logo_svg(); ?>
                <?php endif; ?>
                <span class="footer-logo-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
            </div>

            <?php if ( $footer_about ) : ?>
            <p><?php echo esc_html( $footer_about ); ?></p>
            <?php endif; ?>

            <?php if ( $has_any_social ) : ?>
            <div class="footer-social-row">
                <?php foreach ( $social_networks as $key => $soc ) :
                    if ( empty( $soc['url'] ) ) { continue; }
                ?>
                <a href="<?php echo esc_url( $soc['url'] ); ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="<?php echo esc_attr( $soc['label'] ); ?>">
                    <?php echo bd_icon( $soc['icon'], 18, 18 ); ?>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div><!-- .footer-about -->

        <!-- Column 2: Quick Links / Menu -->
        <?php if ( $show_pages ) : ?>
        <div class="footer-col">
            <h4><?php echo esc_html( $col2_title ); ?></h4>

            <?php if ( $show_menu && has_nav_menu( 'footer' ) ) : ?>
                <?php wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'footer-links',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ) ); ?>
            <?php elseif ( ! empty( $pages ) ) : ?>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'baloch-diamond' ); ?></a></li>
                    <?php foreach ( $pages as $pg ) : ?>
                    <li>
                        <a href="<?php echo esc_url( get_permalink( $pg->ID ) ); ?>">
                            <?php echo esc_html( $pg->post_title ); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div><!-- .footer-col -->
        <?php endif; ?>

        <!-- Column 3: Categories -->
        <?php if ( $show_categories ) : ?>
        <div class="footer-col">
            <h4><?php echo esc_html( $col3_title ); ?></h4>

            <?php if ( ! empty( $cats ) ) : ?>
            <ul class="footer-links">
                <?php foreach ( $cats as $cat ) : ?>
                <li>
                    <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
                        <?php echo esc_html( $cat->name ); ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php elseif ( $contact_email || $contact_address || $contact_phone ) : ?>
            <ul class="footer-links">
                <?php if ( $contact_email ) : ?>
                <li><a href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo bd_icon( 'mail', 14, 14 ); ?> <?php echo esc_html( $contact_email ); ?></a></li>
                <?php endif; ?>
                <?php if ( $contact_address ) : ?>
                <li><a href="#"><?php echo bd_icon( 'map-pin', 14, 14 ); ?> <?php echo esc_html( $contact_address ); ?></a></li>
                <?php endif; ?>
                <?php if ( $contact_phone ) : ?>
                <li><a href="tel:<?php echo esc_attr( $contact_phone ); ?>"><?php echo bd_icon( 'phone', 14, 14 ); ?> <?php echo esc_html( $contact_phone ); ?></a></li>
                <?php endif; ?>
            </ul>
            <?php endif; ?>
        </div><!-- .footer-col -->
        <?php endif; ?>

        <!-- Column 4: Social / Connect -->
        <?php if ( $show_social_col && $has_any_social ) : ?>
        <div class="footer-col">
            <h4><?php echo esc_html( $col4_title ); ?></h4>
            <ul class="footer-links">
                <?php foreach ( $social_networks as $key => $soc ) :
                    if ( empty( $soc['url'] ) ) { continue; }
                ?>
                <li>
                    <a href="<?php echo esc_url( $soc['url'] ); ?>"
                       target="_blank"
                       rel="noopener noreferrer"
                       aria-label="<?php echo esc_attr( $soc['label'] ); ?>">
                        <?php echo bd_icon( $soc['icon'], 14, 14 ); ?>
                        <?php echo esc_html( $soc['label'] ); ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div><!-- .footer-col -->
        <?php endif; ?>

    </div><!-- .footer-inner -->

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <p>
            <?php if ( $footer_copyright ) : ?>
                <?php echo wp_kses_post( $footer_copyright ); ?>
            <?php else : ?>
                &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>.
                <?php esc_html_e( 'Crafted with 💎 by Baloch Diamond. All rights reserved.', 'baloch-diamond' ); ?>
            <?php endif; ?>

            <?php if ( $show_powered && $powered_text ) : ?>
                &nbsp;— <?php echo esc_html( $powered_text ); ?>
            <?php endif; ?>
        </p>
    </div><!-- .footer-bottom -->

</footer><!-- .site-footer -->
<?php endif; ?>

<?php if ( get_theme_mod( 'bd_enable_dark_mode_toggle', true ) ) : ?>
<!-- Dark/Light Mode Toggle -->
<button class="theme-toggle" id="themeToggle" aria-label="<?php esc_attr_e( 'Toggle theme', 'baloch-diamond' ); ?>">
    <span id="sunIcon" style="display:none"><?php echo bd_icon( 'sun' ); ?></span>
    <span id="moonIcon"><?php echo bd_icon( 'moon' ); ?></span>
</button>
<?php endif; ?>


<?php wp_footer(); ?>
</body>
</html>

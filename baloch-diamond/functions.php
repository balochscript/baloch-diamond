<?php
/**
 * Baloch Diamond Theme Functions
 *
 * @package Baloch_Diamond
 * @version 1.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Theme version constant
define( 'BD_VERSION', '1.1.1' );
define( 'BD_DIR', get_template_directory() );
define( 'BD_URI', get_template_directory_uri() );

/**
 * ============================================
 * THEME SETUP
 * ============================================
 */
function bd_theme_setup() {

    // Make theme available for translation
    load_theme_textdomain( 'baloch-diamond', BD_DIR . '/languages' );

    // Add support for post thumbnails
    add_theme_support( 'post-thumbnails' );

    // Custom image sizes
    add_image_size( 'bd-slider', 1400, 800, true );
    add_image_size( 'bd-card', 600, 440, true );
    add_image_size( 'bd-project', 600, 400, true );
    add_image_size( 'bd-related', 400, 250, true );
    add_image_size( 'bd-avatar', 200, 200, true );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Custom logo support
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Automatic feed links
    add_theme_support( 'automatic-feed-links' );

    // Custom background
    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff',
    ) );

    // Wide alignment support for Gutenberg
    add_theme_support( 'align-wide' );

    // Responsive embeds
    add_theme_support( 'responsive-embeds' );

    // WooCommerce support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Register navigation menus
    register_nav_menus( array(
        'primary'     => esc_html__( 'Primary Menu', 'baloch-diamond' ),
        'footer'      => esc_html__( 'Footer Menu', 'baloch-diamond' ),
    ) );
}
add_action( 'after_setup_theme', 'bd_theme_setup' );

/**
 * ============================================
 * CONTENT WIDTH
 * ============================================
 */
function bd_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'bd_content_width', 800 );
}
add_action( 'after_setup_theme', 'bd_content_width', 0 );

/**
 * ============================================
 * ENQUEUE STYLES & SCRIPTS
 * ============================================
 */
function bd_enqueue_scripts() {

    // Retrieve customizer fonts
    $primary_font = get_theme_mod( 'bd_primary_font', 'Poppins' );
    $heading_font = get_theme_mod( 'bd_heading_font', 'Playfair Display' );
    $rtl_font     = get_theme_mod( 'bd_rtl_font', 'Vazirmatn' );
    $custom_primary_font_url = get_theme_mod( 'bd_custom_primary_font', '' );
    $custom_heading_font_url = get_theme_mod( 'bd_custom_heading_font', '' );
    $custom_rtl_font_url = get_theme_mod( 'bd_custom_rtl_font', '' );

    $font_families = array();

    // Map body font
    if ( $primary_font === 'custom' && ! empty( $custom_primary_font_url ) ) {
        // handled via @font-face below
    } elseif ( $primary_font === 'Poppins' ) {
        $font_families[] = 'Poppins:wght@300;400;500;600;700;800;900';
    } elseif ( $primary_font === 'Roboto' ) {
        $font_families[] = 'Roboto:wght@300;400;500;700;900';
    } elseif ( $primary_font === 'Inter' ) {
        $font_families[] = 'Inter:wght@300;400;500;600;700;800;900';
    } elseif ( $primary_font === 'Montserrat' ) {
        $font_families[] = 'Montserrat:wght@300;400;500;600;700;800;900';
    } elseif ( $primary_font === 'Lora' ) {
        $font_families[] = 'Lora:wght@400;500;600;700';
    } elseif ( $primary_font === 'OpenSans' ) {
        $font_families[] = 'Open+Sans:wght@300;400;500;600;700;800';
    } elseif ( $primary_font === 'Nunito' ) {
        $font_families[] = 'Nunito:wght@300;400;500;600;700;800;900';
    } elseif ( $primary_font === 'Rubik' ) {
        $font_families[] = 'Rubik:wght@300;400;500;600;700;800';
    } elseif ( $primary_font === 'WorkSans' ) {
        $font_families[] = 'Work+Sans:wght@300;400;500;600;700;800';
    } elseif ( $primary_font === 'DM Sans' ) {
        $font_families[] = 'DM+Sans:wght@300;400;500;600;700';
    } elseif ( $primary_font === 'Outfit' ) {
        $font_families[] = 'Outfit:wght@300;400;500;600;700;800';
    }

    // Map heading font
    if ( $heading_font === 'custom' && ! empty( $custom_heading_font_url ) ) {
        // handled via @font-face in dynamic CSS
    } elseif ( $heading_font === 'Playfair Display' || $heading_font === 'PlayfairDisplay' ) {
        $font_families[] = 'Playfair+Display:wght@400;700;900';
    } elseif ( $heading_font === 'Poppins' && $primary_font !== 'Poppins' ) {
        $font_families[] = 'Poppins:wght@400;700;900';
    } elseif ( $heading_font === 'Montserrat' && $primary_font !== 'Montserrat' ) {
        $font_families[] = 'Montserrat:wght@400;700;900';
    } elseif ( $heading_font === 'Merriweather' ) {
        $font_families[] = 'Merriweather:wght@300;400;700;900';
    } elseif ( $heading_font === 'EBGaramond' ) {
        $font_families[] = 'EB+Garamond:wght@400;500;600;700';
    } elseif ( $heading_font === 'Oswald' ) {
        $font_families[] = 'Oswald:wght@400;500;600;700';
    } elseif ( $heading_font === 'BebasNeue' ) {
        $font_families[] = 'Bebas+Neue:wght@400';
    }

    // Map RTL font (Persian/Arabic)
    // Skip if using custom upload (handled in dynamic CSS)
    if ( $rtl_font !== 'custom' && $rtl_font !== 'system' ) {
        if ( $rtl_font === 'Vazirmatn' ) {
            $font_families[] = 'Vazirmatn:wght@300;400;500;700;900';
        } elseif ( $rtl_font === 'Cairo' ) {
            $font_families[] = 'Cairo:wght@300;400;500;700;900';
        } elseif ( $rtl_font === 'Tajawal' ) {
            $font_families[] = 'Tajawal:wght@300;400;500;700;900';
        } elseif ( $rtl_font === 'Amiri' ) {
            $font_families[] = 'Amiri:wght@400;700';
        } elseif ( $rtl_font === 'NotoSansArabic' ) {
            $font_families[] = 'Noto+Sans+Arabic:wght@400;500;600;700';
        } elseif ( $rtl_font === 'Almarai' ) {
            $font_families[] = 'Almarai:wght@300;400;700;800';
        }
    }

    if ( ! empty( $font_families ) ) {
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', array_map( 'rawurlencode', $font_families ) ) . '&display=swap';
        
        wp_enqueue_style(
            'bd-google-fonts',
            $fonts_url,
            array(),
            null
        );
    }

    // Main theme stylesheet
    wp_enqueue_style(
        'bd-style',
        get_stylesheet_uri(),
        array( 'bd-google-fonts' ),
        BD_VERSION
    );

    // Main JavaScript
    wp_enqueue_script(
        'bd-main',
        BD_URI . '/assets/js/main.js',
        array(),
        BD_VERSION,
        true
    );

    // Pass PHP data to JavaScript
    wp_localize_script( 'bd-main', 'bdData', array(
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'nonce'     => wp_create_nonce( 'bd_nonce' ),
        'homeUrl'   => home_url( '/' ),
        'themeUrl'  => BD_URI,
        'i18n'      => array(
            'searchPlaceholder' => esc_html__( 'Search posts, projects, docs...', 'baloch-diamond' ),
            'noResults'         => esc_html__( 'No results found for', 'baloch-diamond' ),
            'navigation'        => esc_html__( 'Navigation', 'baloch-diamond' ),
        ),
    ) );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'bd_enqueue_scripts' );

/**
 * ============================================
 * REGISTER WIDGET AREAS
 * ============================================
 */
function bd_widgets_init() {

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 1', 'baloch-diamond' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Widgets in footer column 1', 'baloch-diamond' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 2', 'baloch-diamond' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Widgets in footer column 2', 'baloch-diamond' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 3', 'baloch-diamond' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Widgets in footer column 3', 'baloch-diamond' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'bd_widgets_init' );

/**
 * ============================================
 * CUSTOMIZER
 * ============================================
 */
require_once BD_DIR . '/inc/customizer.php';

/**
 * ============================================
 * TEMPLATE FUNCTIONS
 * ============================================
 */
require_once BD_DIR . '/inc/template-functions.php';

/**
 * ============================================
 * DYNAMIC CSS OUTPUT (Colors from Customizer)
 * ============================================
 */
function bd_dynamic_css() {

    $preset = get_theme_mod( 'bd_color_preset', 'default' );

    $presets = array(
        'default' => array( 'primary' => '#38bdf8', 'secondary' => '#f97316' ),
        'ocean'   => array( 'primary' => '#0ea5e9', 'secondary' => '#06b6d4' ),
        'desert'  => array( 'primary' => '#f97316', 'secondary' => '#ef4444' ),
        'forest'  => array( 'primary' => '#10b981', 'secondary' => '#059669' ),
        'royal'   => array( 'primary' => '#8b5cf6', 'secondary' => '#ec4899' ),
    );

    if ( $preset !== 'custom' && isset( $presets[ $preset ] ) ) {
        $primary   = $presets[ $preset ]['primary'];
        $secondary = $presets[ $preset ]['secondary'];
    } else {
        $primary   = get_theme_mod( 'bd_primary_color', '#38bdf8' );
        $secondary = get_theme_mod( 'bd_secondary_color', '#f97316' );
    }

    // Header settings
    $header_bg_type = get_theme_mod( 'bd_header_bg_type', 'default' );
    $header_bg_color = get_theme_mod( 'bd_header_bg_color', '' );
    $header_grad_1 = get_theme_mod( 'bd_header_gradient_1', '#38bdf8' );
    $header_grad_2 = get_theme_mod( 'bd_header_gradient_2', '#f97316' );
    $header_grad_direction = get_theme_mod( 'bd_header_gradient_direction', '135deg' );

    $primary_font = get_theme_mod( 'bd_primary_font', 'Poppins' );
    $heading_font = get_theme_mod( 'bd_heading_font', 'Playfair Display' );
    $rtl_font     = get_theme_mod( 'bd_rtl_font', 'Vazirmatn' );
    $custom_rtl_font_url = get_theme_mod( 'bd_custom_rtl_font', '' );
    $custom_primary_font_url = get_theme_mod( 'bd_custom_primary_font', '' );
    $custom_heading_font_url = get_theme_mod( 'bd_custom_heading_font', '' );

    // Build proper RTL font family fallback
    $rtl_font_fallback = 'sans-serif';
    if ( $rtl_font === 'Vazirmatn' || $rtl_font === 'Cairo' || $rtl_font === 'Tajawal' || $rtl_font === 'Amiri' || $rtl_font === 'NotoSansArabic' || $rtl_font === 'Almarai' ) {
        $rtl_font_fallback = "'" . str_replace('+', ' ', $rtl_font) . "', sans-serif";
    } elseif ( $rtl_font === 'custom' && ! empty( $custom_rtl_font_url ) ) {
        $rtl_font_fallback = 'CustomRTLFont, sans-serif';
    } elseif ( $rtl_font === 'system' ) {
        $rtl_font_fallback = 'sans-serif';
    }
    $rtl_family = $rtl_font === 'system' ? 'sans-serif' : $rtl_font_fallback;

    // New slider options
    $slider_height       = get_theme_mod( 'bd_slider_height', '55vh' );
    $slider_shadow_color = get_theme_mod( 'bd_slider_shadow_color', 'rgba(0,0,0,0.5)' );
    ?>
    <style id="bd-dynamic-css">
        :root {
            --color-primary: <?php echo esc_attr( $primary ); ?>;
            --color-secondary: <?php echo esc_attr( $secondary ); ?>;
            --gradient: linear-gradient(135deg, <?php echo esc_attr( $primary ); ?>, <?php echo esc_attr( $secondary ); ?>);
            --gradient-reverse: linear-gradient(135deg, <?php echo esc_attr( $secondary ); ?>, <?php echo esc_attr( $primary ); ?>);
            --bd-slider-height: <?php echo esc_attr( $slider_height ); ?>;
        }

        body {
            font-family: '<?php echo esc_attr( $primary_font ); ?>', sans-serif !important;
        }

        h1, h2, h3, h4, h5, h6,
        .site-name,
        .slide-title,
        .section-title,
        .project-card-title,
        .post-card-title,
        .doc-title,
        .team-name,
        .newsletter-title,
        .footer-logo-text,
        .error-number,
        .error-title,
        .single-post-content h2,
        .single-post-content h3,
        .single-post-content h4,
        .comment-author,
        .comment-form-wrapper h4 {
            font-family: '<?php echo esc_attr( $heading_font ); ?>', serif !important;
        }

        .slide-title {
            text-shadow: 0 2px 10px <?php echo esc_attr( $slider_shadow_color ); ?>, 0 4px 20px rgba(0,0,0,0.3) !important;
        }

        .hero-slider {
            height: var(--bd-slider-height) !important;
        }

        body.rtl, 
        body.rtl button, 
        body.rtl input, 
        body.rtl textarea, 
        body.rtl select,
        body.rtl .section-title,
        body.rtl .post-card-title,
        body.rtl .project-card-title,
        body.rtl .product-title,
        body.rtl .team-name {
            font-family: <?php echo $rtl_family; ?> !important;
        }

        <?php if ( $rtl_font === 'custom' && ! empty( $custom_rtl_font_url ) ) : ?>
        @font-face {
            font-family: 'CustomRTLFont';
            src: url('<?php echo esc_url( $custom_rtl_font_url ); ?>') format('woff2');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        <?php endif; ?>

        <?php if ( $primary_font === 'custom' && ! empty( $custom_primary_font_url ) ) : ?>
        @font-face {
            font-family: 'CustomPrimaryFont';
            src: url('<?php echo esc_url( $custom_primary_font_url ); ?>') format('woff2');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }
        <?php endif; ?>

        <?php if ( $heading_font === 'custom' && ! empty( $custom_heading_font_url ) ) : ?>
        @font-face {
            font-family: 'CustomHeadingFont';
            src: url('<?php echo esc_url( $custom_heading_font_url ); ?>') format('woff2');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }
        <?php endif; ?>

        <?php if ( $primary_font === 'custom' && ! empty( $custom_primary_font_url ) ) : ?>
        body {
            font-family: 'CustomPrimaryFont', sans-serif !important;
        }
        <?php endif; ?>

        <?php if ( $heading_font === 'custom' && ! empty( $custom_heading_font_url ) ) : ?>
        h1, h2, h3, h4, h5, h6,
        .site-name,
        .slide-title,
        .section-title,
        .project-card-title,
        .post-card-title,
        .doc-title,
        .team-name,
        .newsletter-title,
        .footer-logo-text,
        .error-number,
        .error-title,
        .single-post-content h2,
        .single-post-content h3,
        .single-post-content h4,
        .comment-author,
        .comment-form-wrapper h4 {
            font-family: 'CustomHeadingFont', serif !important;
        }
        <?php endif; ?>

        <?php if ( $header_bg_type === 'solid' && $header_bg_color ) : ?>
        .site-header {
            background: <?php echo esc_attr( $header_bg_color ); ?>;
        }
        <?php elseif ( $header_bg_type === 'gradient' ) : ?>
        .site-header {
            background: linear-gradient(<?php echo esc_attr( $header_grad_direction ); ?>, <?php echo esc_attr( $header_grad_1 ); ?>, <?php echo esc_attr( $header_grad_2 ); ?>);
        }
        .site-header .header-icon,
        .site-header .site-name {
            color: white;
            -webkit-text-fill-color: white;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action( 'wp_head', 'bd_dynamic_css', 100 );

/**
 * ============================================
 * HELPER FUNCTIONS
 * ============================================
 */

/**
 * Get Diamond Logo SVG
 */
function bd_get_logo_svg() {
    return '<svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="logoGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:var(--color-primary)"/>
                <stop offset="100%" style="stop-color:var(--color-secondary)"/>
            </linearGradient>
        </defs>
        <path d="M30 4 L50 22 L30 56 L10 22Z" stroke="url(#logoGrad)" stroke-width="2.5" fill="none"/>
        <path d="M30 12 L42 22 L30 46 L18 22Z" stroke="url(#logoGrad)" stroke-width="1.5" fill="none" opacity="0.6"/>
        <path d="M10 22 L50 22" stroke="url(#logoGrad)" stroke-width="1.5" opacity="0.4"/>
        <path d="M30 4 L22 22 M30 4 L38 22" stroke="url(#logoGrad)" stroke-width="1" opacity="0.3"/>
        <circle cx="30" cy="22" r="3" fill="url(#logoGrad)" opacity="0.5"/>
    </svg>';
}

/**
 * Get Footer Logo SVG (smaller)
 */
function bd_get_footer_logo_svg() {
    return '<svg width="36" height="36" viewBox="0 0 60 60" fill="none">
        <path d="M30 4 L50 22 L30 56 L10 22Z" stroke="var(--color-primary)" stroke-width="2.5" fill="none"/>
        <path d="M30 12 L42 22 L30 46 L18 22Z" stroke="var(--color-secondary)" stroke-width="1.5" fill="none" opacity="0.6"/>
        <circle cx="30" cy="22" r="3" fill="var(--color-primary)" opacity="0.5"/>
    </svg>';
}

/**
 * SVG Icons helper
 */
function bd_icon( $name, $width = 24, $height = 24 ) {

    $icons = array(
        'search' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',

        'menu' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" width="' . $width . '" height="' . $height . '"><line x1="3" y1="6" x2="21" y2="6"/><line x1="7" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>',

        'close' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',

        'check-circle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>',

        'home' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>',

        'file-text' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10,9 9,9 8,9"/></svg>',

        'user' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',

        'tag' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>',

        'arrow-right' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12,5 19,12 12,19"/></svg>',

        'arrow-right-small' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12,5 19,12 12,19"/></svg>',

        'arrow-left' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12,19 5,12 12,5"/></svg>',

        'calendar' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',

        'comment' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>',

        'users' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',

        'monitor' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',

        'twitter' => '<svg viewBox="0 0 24 24" fill="currentColor" width="' . $width . '" height="' . $height . '"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',

        'github' => '<svg viewBox="0 0 24 24" fill="currentColor" width="' . $width . '" height="' . $height . '"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>',

        'linkedin' => '<svg viewBox="0 0 24 24" fill="currentColor" width="' . $width . '" height="' . $height . '"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',

        'instagram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',

        'send' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22,2 15,22 11,13 2,9 22,2"/></svg>',

        'phone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',

        'map-pin' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',

        'mail' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',

        'settings' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>',

        'sun' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>',

        'moon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>',

        'shopping-cart' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>',

        'clock' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>',

        'book' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',

        'shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',

        'zap' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><polygon points="13,2 3,14 12,14 11,22 21,10 12,10 13,2"/></svg>',

        'code' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><polyline points="16,18 22,12 16,6"/><polyline points="8,6 2,12 8,18"/></svg>',

        'globe' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',

    );

    return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * ============================================
 * BODY CLASSES
 * ============================================
 */
function bd_body_classes( $classes ) {
    if ( is_front_page() ) {
        $classes[] = 'is-front-page';
    }

    if ( is_singular() ) {
        $classes[] = 'is-singular';
    }

    if ( get_theme_mod( 'bd_animated_patterns', true ) ) {
        $classes[] = 'balochi-pattern-animated';
    }

    // Skeleton shimmer support
    if ( get_theme_mod( 'bd_skeleton_loading', true ) ) {
        $classes[] = 'skeleton-enabled';
    }

    return $classes;
}
add_filter( 'body_class', 'bd_body_classes' );

/**
 * ============================================
 * MOBILE MENU WALKER
 * ============================================
 */
class BD_Mobile_Menu_Walker extends Walker_Nav_Menu {
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $title = apply_filters( 'nav_menu_item_title', esc_html( $item->title ), $item, $args, $depth );

        $output .= '<a class="menu-item" href="' . esc_url( $item->url ) . '"' . $class_names . '>';
        $output .= $title;
        $output .= '</a>';
    }
}

// ============================================
// MEMBERS / USER HELPERS
// ============================================

/**
 * Get current user display name (for header)
 */
function bd_get_user_display_name() {
    if ( is_user_logged_in() ) {
        $current_user = wp_get_current_user();
        return $current_user->display_name ?: $current_user->user_login;
    }
    return '';
}

/**
 * Simple account link helper
 */
function bd_get_account_url() {
    if ( class_exists( 'WooCommerce' ) ) {
        return wc_get_page_permalink( 'myaccount' );
    }
    return home_url( '/my-account' );
}

/**
 * ============================================
 * AJAX HANDLERS
 * ============================================
 */

/**
 * AJAX live search handler.
 *
 * @return void
 */
function bd_ajax_search() {
    check_ajax_referer( 'bd_nonce', 'nonce' );

    $query = isset( $_POST['query'] ) ? sanitize_text_field( wp_unslash( $_POST['query'] ) ) : '';

    if ( strlen( $query ) < 2 ) {
        wp_send_json_success( array() );
    }

    $search_query = new WP_Query( array(
        'post_type'      => array( 'post', 'page' ),
        'post_status'    => 'publish',
        'posts_per_page' => 8,
        's'              => $query,
        'orderby'        => 'relevance',
    ) );

    $results = array();

    if ( $search_query->have_posts() ) {
        while ( $search_query->have_posts() ) {
            $search_query->the_post();
            $results[] = array(
                'id'    => get_the_ID(),
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'type'  => get_post_type(),
                'desc'  => wp_trim_words( get_the_excerpt(), 12 ),
            );
        }
        wp_reset_postdata();
    }

    wp_send_json_success( $results );
}
add_action( 'wp_ajax_bd_search', 'bd_ajax_search' );
add_action( 'wp_ajax_nopriv_bd_search', 'bd_ajax_search' );

/**
 * AJAX newsletter subscription handler.
 *
 * Saves the subscriber email as a pending comment on a dedicated placeholder
 * post, or simply validates and returns success. For production use, integrate
 * with a proper mailing service or plugin.
 *
 * @return void
 */
function bd_ajax_subscribe() {
    check_ajax_referer( 'bd_nonce', 'nonce' );

    $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

    if ( ! is_email( $email ) ) {
        wp_send_json_error( esc_html__( 'Please enter a valid email address.', 'baloch-diamond' ) );
    }

    // Store email in theme mod for simple demo purposes.
    // In production, use a proper newsletter plugin or service.
    $subscribers   = get_theme_mod( 'bd_newsletter_subscribers', array() );
    $subscribers   = is_array( $subscribers ) ? $subscribers : array();

    if ( in_array( $email, $subscribers, true ) ) {
        wp_send_json_success( esc_html__( 'You are already subscribed!', 'baloch-diamond' ) );
    }

    $subscribers[] = $email;
    set_theme_mod( 'bd_newsletter_subscribers', $subscribers );

    wp_send_json_success( esc_html__( 'Thanks for subscribing!', 'baloch-diamond' ) );
}
add_action( 'wp_ajax_bd_subscribe', 'bd_ajax_subscribe' );
add_action( 'wp_ajax_nopriv_bd_subscribe', 'bd_ajax_subscribe' );

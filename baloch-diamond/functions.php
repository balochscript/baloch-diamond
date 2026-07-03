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

        'close' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',

        'check-circle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>',

        'home' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="' . $width . '" height="' . $height . '"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>',
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
 * REMOVE "CUSTOMIZE" / "THEME CUSTOMIZER" FROM MENUS
 * ============================================
 */
add_action( 'admin_bar_menu', 'bd_remove_customize_from_admin_bar', 999 );
function bd_remove_customize_from_admin_bar( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'customize' );
    $wp_admin_bar->remove_node( 'customize-site' );
}

add_action( 'admin_menu', 'bd_remove_customize_from_appearance', 999 );
function bd_remove_customize_from_appearance() {
    global $submenu;
    if ( isset( $submenu['themes.php'] ) ) {
        foreach ( $submenu['themes.php'] as $index => $item ) {
            if ( isset( $item[2] ) && $item[2] === 'customize.php' ) {
                unset( $submenu['themes.php'][ $index ] );
            }
        }
    }
}

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

        $output .= '<a class="menu-item" href="' . esc_url( $item->url ) . '"' . $class_names . '>';

        $output .= apply_filters( 'the_title', $item->title, $item->ID );

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

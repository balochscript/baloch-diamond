<?php
/**
 * Baloch Diamond Theme Functions
 *
 * @package Baloch_Diamond
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Theme version constant
define( 'BD_VERSION', '1.0.0' );
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

    // Google Fonts
    wp_enqueue_style(
        'bd-google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;700;900&display=swap',
        array(),
        null
    );

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
 * CUSTOM EXCERPT LENGTH
 * ============================================
 */
function bd_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'bd_excerpt_length' );

function bd_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'bd_excerpt_more' );


/**
 * ============================================
 * CUSTOM WALKER FOR MOBILE MENU
 * ============================================
 */
class BD_Mobile_Menu_Walker extends Walker_Nav_Menu {

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

        $output .= '<a class="menu-item" href="' . esc_url( $item->url ) . '">';

        // Default icon
        $output .= '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>';

        $output .= esc_html( $item->title );
        $output .= '</a>';
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        // No closing tag needed
    }

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '<div class="sub-menu-items" style="padding-left:20px">';
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '</div>';
    }
}


/**
 * ============================================
 * AJAX SEARCH
 * ============================================
 */
function bd_ajax_search() {

    check_ajax_referer( 'bd_nonce', 'nonce' );

    $query = sanitize_text_field( $_POST['query'] );

    if ( strlen( $query ) < 2 ) {
        wp_send_json_success( array() );
    }

    $args = array(
        'post_type'      => array( 'post', 'page' ),
        'post_status'    => 'publish',
        's'              => $query,
        'posts_per_page' => 10,
    );

    $search = new WP_Query( $args );
    $results = array();

    if ( $search->have_posts() ) {
        while ( $search->have_posts() ) {
            $search->the_post();
            $results[] = array(
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'type'  => get_post_type_object( get_post_type() )->labels->singular_name,
                'desc'  => wp_trim_words( get_the_excerpt(), 15 ),
            );
        }
        wp_reset_postdata();
    }

    wp_send_json_success( $results );
}
add_action( 'wp_ajax_bd_search', 'bd_ajax_search' );
add_action( 'wp_ajax_nopriv_bd_search', 'bd_ajax_search' );


/**
 * ============================================
 * AJAX NEWSLETTER SUBSCRIPTION
 * ============================================
 */
function bd_newsletter_subscribe() {

    check_ajax_referer( 'bd_nonce', 'nonce' );

    $email = sanitize_email( $_POST['email'] );

    if ( ! is_email( $email ) ) {
        wp_send_json_error( esc_html__( 'Please enter a valid email address.', 'baloch-diamond' ) );
    }

    // Store in options (simple approach) or integrate with plugin
    $subscribers = get_option( 'bd_subscribers', array() );

    if ( in_array( $email, $subscribers ) ) {
        wp_send_json_error( esc_html__( 'This email is already subscribed.', 'baloch-diamond' ) );
    }

    $subscribers[] = $email;
    update_option( 'bd_subscribers', $subscribers );

    wp_send_json_success( esc_html__( 'Thanks for subscribing!', 'baloch-diamond' ) );
}
add_action( 'wp_ajax_bd_subscribe', 'bd_newsletter_subscribe' );
add_action( 'wp_ajax_nopriv_bd_subscribe', 'bd_newsletter_subscribe' );


/**
 * ============================================
 * DYNAMIC CSS OUTPUT (Colors from Customizer)
 * ============================================
 */
function bd_dynamic_css() {

    $primary   = get_theme_mod( 'bd_primary_color', '#38bdf8' );
    $secondary = get_theme_mod( 'bd_secondary_color', '#f97316' );

    // Header settings
    $header_bg_type = get_theme_mod( 'bd_header_bg_type', 'default' );
    $header_bg_color = get_theme_mod( 'bd_header_bg_color', '' );
    $header_grad_1 = get_theme_mod( 'bd_header_gradient_1', '#38bdf8' );
    $header_grad_2 = get_theme_mod( 'bd_header_gradient_2', '#f97316' );
    $header_grad_direction = get_theme_mod( 'bd_header_gradient_direction', '135deg' );

    ?>
    <style id="bd-dynamic-css">
        :root {
            --color-primary: <?php echo esc_attr( $primary ); ?>;
            --color-secondary: <?php echo esc_attr( $secondary ); ?>;
            --gradient: linear-gradient(135deg, <?php echo esc_attr( $primary ); ?>, <?php echo esc_attr( $secondary ); ?>);
            --gradient-reverse: linear-gradient(135deg, <?php echo esc_attr( $secondary ); ?>, <?php echo esc_attr( $primary ); ?>);
        }

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

        'home' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',

        'arrow-right' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>',

        'arrow-left' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><polyline points="15 18 9 12 15 6"/></svg>',

        'arrow-right-small' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><polyline points="9 18 15 12 9 6"/></svg>',

        'user' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',

        'comment' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>',

        'calendar' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',

        'clock' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',

        'tag' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>',

        'send' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>',

        'sun' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>',

        'moon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>',

        'check-circle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/></svg>',

        'monitor' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',

        'file-text' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>',

        'book' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>',

        'users' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>',

        'mail' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',

        'map-pin' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>',

        'phone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>',

        'alert' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>',

        'settings' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>',

        'twitter' => '<svg viewBox="0 0 24 24" fill="currentColor" width="' . $width . '" height="' . $height . '"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>',

        'github' => '<svg viewBox="0 0 24 24" fill="currentColor" width="' . $width . '" height="' . $height . '"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22"/></svg>',

        'linkedin' => '<svg viewBox="0 0 24 24" fill="currentColor" width="' . $width . '" height="' . $height . '"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>',

        'instagram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="' . $width . '" height="' . $height . '"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
    );

    return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}


/**
 * ============================================
 * INCLUDE CUSTOMIZER
 * ============================================
 */
require_once BD_DIR . '/inc/customizer.php';
require_once BD_DIR . '/inc/template-functions.php';

/**
 * ============================================
 * CUSTOM COMMENT CALLBACK
 * ============================================
 */
function bd_comment_callback( $comment, $args, $depth ) {

    $tag = ( $args['style'] === 'div' ) ? 'div' : 'li';
    $commenter_name = get_comment_author();
    $avatar = get_avatar( $comment, 44, '', $commenter_name );
    ?>

    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( '' ); ?>
        style="<?php echo $depth > 1 ? 'margin-left:' . ( ( $depth - 1 ) * 30 ) . 'px;' : ''; ?>">

        <div class="comment-item">

            <!-- Avatar -->
            <?php if ( $avatar ) : ?>
                <div style="flex-shrink:0">
                    <?php
                    // Add class to avatar img
                    echo str_replace( '<img', '<img class="comment-avatar" style="width:44px;height:44px;border-radius:50%;object-fit:cover"', $avatar );
                    ?>
                </div>
            <?php endif; ?>

            <!-- Comment Body -->
            <div class="comment-body">

                <!-- Meta -->
                <div class="comment-meta">
                    <strong class="comment-author">
                        <?php comment_author_link(); ?>
                    </strong>
                    <span class="comment-date">
                        <?php
                        /* translators: %s: Human-readable time difference */
                        printf(
                            esc_html__( '%s ago', 'baloch-diamond' ),
                            human_time_diff( get_comment_date( 'U' ), current_time( 'timestamp' ) )
                        );
                        ?>
                    </span>
                </div>

                <!-- Awaiting moderation -->
                <?php if ( $comment->comment_approved === '0' ) : ?>
                    <p style="font-size:0.8rem;color:var(--color-secondary);margin-bottom:8px;font-style:italic">
                        <?php esc_html_e( 'Your comment is awaiting moderation.', 'baloch-diamond' ); ?>
                    </p>
                <?php endif; ?>

                <!-- Comment Text -->
                <div class="comment-text">
                    <?php comment_text(); ?>
                </div>

                <!-- Reply Link -->
                <div style="margin-top:8px">
                    <?php
                    comment_reply_link( array_merge( $args, array(
                        'reply_text' => '<span style="font-size:0.8rem;color:var(--color-primary);font-weight:600;cursor:pointer">' . esc_html__( 'Reply', 'baloch-diamond' ) . '</span>',
                        'depth'      => $depth,
                        'max_depth'  => $args['max_depth'],
                    ) ) );
                    ?>

                    <?php
                    // Edit link for admins
                    edit_comment_link(
                        esc_html__( 'Edit', 'baloch-diamond' ),
                        ' <span style="font-size:0.8rem;color:var(--text-muted);font-weight:600">',
                        '</span>'
                    );
                    ?>
                </div>

            </div>

        </div>

    <?php
    // Note: WordPress will close the tag
}


/**
 * ============================================
 * COMMENT FORM DEFAULTS FILTER
 * ============================================
 */
function bd_comment_form_defaults( $defaults ) {

    // Remove default fields (we handle them in comments.php)
    $defaults['comment_field'] = '';
    $defaults['fields'] = array();
    $defaults['title_reply'] = '';
    $defaults['title_reply_before'] = '';
    $defaults['title_reply_after'] = '';
    $defaults['comment_notes_before'] = '';
    $defaults['comment_notes_after'] = '';
    $defaults['submit_button'] = '';
    $defaults['submit_field'] = '%1$s %2$s';

    return $defaults;
}
// Note: We use our own form in comments.php, so this is optional
// add_filter( 'comment_form_defaults', 'bd_comment_form_defaults' );
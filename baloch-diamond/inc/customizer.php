<?php
/**
 * Theme Customizer Settings
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add custom controls
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
    class 4392BD_Separator_Control extends WP_Customize_Control {
        public $type = 'separator';

        public function render_content() {
            echo '<hr style="margin: 15px 0; border: none; border-top: 1px solid #ccc;">';
        }
    }
}

/**
 * Register all customizer settings
 */
function 4392bd_customize_register( $wp_customize ) {

    // Main Panel
    $wp_customize->add_panel( '4392bd_panel', array(
        'title'    => esc_html__( '💎 Baloch Diamond Settings', 'baloch-diamond' ),
        'priority' => 10,
    ) );

    // ================================================
    // SECTION 1: COLORS
    // ================================================
    $wp_customize->add_section( '4392bd_colors_section', array(
        'title'    => esc_html__( '🎨 Colors & Presets', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 10,
    ) );

    // Color Preset
    $wp_customize->add_setting( '4392bd_color_preset', array(
        'default'           => 'default',
        'sanitize_callback' => '4392bd_sanitize_select',
    ) );
    $wp_customize->add_control( '4392bd_color_preset', array(
        'label'   => esc_html__( 'Color Preset', 'baloch-diamond' ),
        'section' => '4392bd_colors_section',
        'type'    => 'select',
        'choices' => array(
            'default' => esc_html__( 'Default (Sky + Orange)', 'baloch-diamond' ),
            'ocean'   => esc_html__( 'Ocean (Blue + Cyan)', 'baloch-diamond' ),
            'desert'  => esc_html__( 'Desert (Orange + Red)', 'baloch-diamond' ),
            'forest'  => esc_html__( 'Forest (Green)', 'baloch-diamond' ),
            'royal'   => esc_html__( 'Royal (Purple + Pink)', 'baloch-diamond' ),
            'custom'  => esc_html__( '🎨 Custom Colors (Set Below)', 'baloch-diamond' ),
        ),
    ) );

    // Primary Color
    $wp_customize->add_setting( '4392bd_primary_color', array(
        'default'           => '#38bdf8',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        '4392bd_primary_color',
        array(
            'label'       => esc_html__( 'Primary Color', 'baloch-diamond' ),
            'description' => esc_html__( 'Used for buttons, links, and accents.', 'baloch-diamond' ),
            'section'     => '4392bd_colors_section',
        )
    ) );

    // Secondary Color
    $wp_customize->add_setting( '4392bd_secondary_color', array(
        'default'           => '#f97316',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        '4392bd_secondary_color',
        array(
            'label'       => esc_html__( 'Secondary Color', 'baloch-diamond' ),
            'description' => esc_html__( 'Used for hover states and highlights.', 'baloch-diamond' ),
            'section'     => '4392bd_colors_section',
        )
    ) );

    // Text Shadow Color for Slider
    $wp_customize->add_setting( '4392bd_slider_shadow_color', array(
        'default'           => 'rgba(0,0,0,0.5)',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        '4392bd_slider_shadow_color',
        array(
            'label'       => esc_html__( 'Slider Text Shadow Color', 'baloch-diamond' ),
            'description' => esc_html__( 'Pick a custom shadow color for the main hero slider titles.', 'baloch-diamond' ),
            'section'     => '4392bd_colors_section',
        )
    ) );

    // ================================================
    // SECTION 1.5: TYPOGRAPHY
    // ================================================
    $wp_customize->add_section( '4392bd_typography_section', array(
        'title'    => esc_html__( '🔤 Typography & Fonts', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 12,
    ) );

    // Primary Font (Body Text)
    $wp_customize->add_setting( '4392bd_primary_font', array(
        'default'           => 'Poppins',
        'sanitize_callback' => '4392bd_sanitize_select',
    ) );
    $wp_customize->add_control( '4392bd_primary_font', array(
        'label'    => esc_html__( 'Primary Font (Body Text)', 'baloch-diamond' ),
        'section'  => '4392bd_typography_section',
        'type'     => 'select',
        'choices'  => array(
            'Poppins'    => 'Poppins (Modern Sans-Serif)',
            'Roboto'     => 'Roboto (Clean Sans-Serif)',
            'Inter'      => 'Inter (Minimalist Sans-Serif)',
            'Montserrat' => 'Montserrat (Geometric Sans-Serif)',
            'Lora'       => 'Lora (Elegant Serif)',
            'OpenSans'   => 'Open Sans (Universal)',
            'Nunito'     => 'Nunito (Friendly Sans)',
            'Rubik'      => 'Rubik (Modern Rounded)',
            'WorkSans'   => 'Work Sans (Clean Professional)',
            'DM Sans'    => 'DM Sans (Versatile Sans)',
            'Outfit'     => 'Outfit (Clean Geometric)',
            'custom'     => esc_html__( 'Custom Upload (see below)', 'baloch-diamond' ),
        ),
    ) );

    // Custom Primary Font Upload
    $wp_customize->add_setting( '4392bd_custom_primary_font', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Upload_Control(
        $wp_customize,
        '4392bd_custom_primary_font',
        array(
            'label'       => esc_html__( 'Upload Custom Primary Font', 'baloch-diamond' ),
            'description' => esc_html__( 'Upload a .woff2 file for body text. Select "Custom Upload" above to use.', 'baloch-diamond' ),
            'section'     => '4392bd_typography_section',
        )
    ) );

    // Heading Font
    $wp_customize->add_setting( '4392bd_heading_font', array(
        'default'           => 'Playfair Display',
        'sanitize_callback' => '4392bd_sanitize_select',
    ) );
    $wp_customize->add_control( '4392bd_heading_font', array(
        'label'    => esc_html__( 'Heading Font', 'baloch-diamond' ),
        'section'  => '4392bd_typography_section',
        'type'     => 'select',
        'choices'  => array(
            'Playfair Display' => 'Playfair Display (Premium Serif)',
            'Poppins'          => 'Poppins (Bold Sans-Serif)',
            'Montserrat'       => 'Montserrat (Display Sans-Serif)',
            'Merriweather'     => 'Merriweather (Classic Editorial)',
            'PlayfairDisplay'  => 'Playfair Display (Serif)',
            'EBGaramond'       => 'EB Garamond (Classic)',
            'Oswald'           => 'Oswald (Bold Condensed)',
            'BebasNeue'        => 'Bebas Neue (Display)',
            'custom'           => esc_html__( 'Custom Upload (see below)', 'baloch-diamond' ),
        ),
    ) );

    // Custom Heading Font Upload
    $wp_customize->add_setting( '4392bd_custom_heading_font', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Upload_Control(
        $wp_customize,
        '4392bd_custom_heading_font',
        array(
            'label'       => esc_html__( 'Upload Custom Heading Font', 'baloch-diamond' ),
            'description' => esc_html__( 'Upload a .woff2 file for headings. Select "Custom Upload" above to use.', 'baloch-diamond' ),
            'section'     => '4392bd_typography_section',
        )
    ) );

    // RTL Font (Persian & Balochi)
    $wp_customize->add_setting( '4392bd_rtl_font', array(
        'default'           => 'Vazirmatn',
        'sanitize_callback' => '4392bd_sanitize_select',
    ) );
    $wp_customize->add_control( '4392bd_rtl_font', array(
        'label'       => esc_html__( 'RTL Font (Persian / Arabic / Balochi)', 'baloch-diamond' ),
        'description' => esc_html__( 'Select the font family for Persian, Balochi, Arabic, and other Right-to-Left (RTL) scripts.', 'baloch-diamond' ),
        'section'     => '4392bd_typography_section',
        'type'        => 'select',
        'choices'     => array(
            'Vazirmatn' => 'Vazirmatn (Recommended for Persian)',
            'Cairo'     => 'Cairo (Modern Geometric)',
            'Tajawal'   => 'Tajawal (Clean & Elegant)',
            'Amiri'     => 'Amiri (Traditional Naskh)',
            'NotoSansArabic' => 'Noto Sans Arabic',
            'Almarai'   => 'Almarai (Popular Arabic)',
            'system'    => 'System default (No web font)',
            'custom'    => esc_html__( 'Custom Upload (see below)', 'baloch-diamond' ),
        ),
    ) );

    // Custom RTL Font Upload (for Persian/Arabic)
    $wp_customize->add_setting( '4392bd_custom_rtl_font', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Upload_Control(
        $wp_customize,
        '4392bd_custom_rtl_font',
        array(
            'label'       => esc_html__( 'Upload Custom RTL Font', 'baloch-diamond' ),
            'description' => esc_html__( 'Upload your custom font file (recommended: .woff2). Only works if "Custom Upload" is selected above.', 'baloch-diamond' ),
            'section'     => '4392bd_typography_section',
        )
    ) );

    // ================================================
    // SECTION 1.6: ADVANCED FEATURES
    // ================================================
    $wp_customize->add_section( '4392bd_advanced_section', array(
        'title'    => esc_html__( '🚀 Advanced Core Features', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 13,
    ) );

    // Animated backgrounds
    $wp_customize->add_setting( '4392bd_animated_patterns', array(
        'default'           => true,
        'sanitize_callback' => '4392bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( '4392bd_animated_patterns', array(
        'label'       => esc_html__( 'Enable Animated Needlework Patterns', 'baloch-diamond' ),
        'description' => esc_html__( 'Check to activate slow, elegant stitch background scroll animations.', 'baloch-diamond' ),
        'section'     => '4392bd_advanced_section',
        'type'        => 'checkbox',
    ) );

    // Skeleton Loading
    $wp_customize->add_setting( '4392bd_skeleton_loading', array(
        'default'           => true,
        'sanitize_callback' => '4392bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( '4392bd_skeleton_loading', array(
        'label'       => esc_html__( 'Enable Skeleton Shimmer Loading', 'baloch-diamond' ),
        'description' => esc_html__( 'Simulate highly optimized content block transitions on slow networks.', 'baloch-diamond' ),
        'section'     => '4392bd_advanced_section',
        'type'        => 'checkbox',
    ) );

    // ================================================
    // SECTION 2: HEADER
    // ================================================
    $wp_customize->add_section( '4392bd_header_section', array(
        'title'    => esc_html__( '📌 Header Settings', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 15,
    ) );

    // Header Display Mode
    $wp_customize->add_setting( '4392bd_header_display', array(
        'default'           => 'icon_title',
        'sanitize_callback' => '4392bd_sanitize_select',
    ) );
    $wp_customize->add_control( '4392bd_header_display', array(
        'label'   => esc_html__( 'Header Center Display', 'baloch-diamond' ),
        'section' => '4392bd_header_section',
        'type'    => 'select',
        'choices' => array(
            'icon_only'       => esc_html__( 'Site Icon Only', 'baloch-diamond' ),
            'icon_title'      => esc_html__( 'Icon + Site Title', 'baloch-diamond' ),
            'icon_title_desc' => esc_html__( 'Icon + Title + Description', 'baloch-diamond' ),
            'title_only'      => esc_html__( 'Title Only (No Icon)', 'baloch-diamond' ),
            'title_desc'      => esc_html__( 'Title + Description (No Icon)', 'baloch-diamond' ),
        ),
    ) );

    // Header BG Type
    $wp_customize->add_setting( '4392bd_header_bg_type', array(
        'default'           => 'default',
        'sanitize_callback' => '4392bd_sanitize_select',
    ) );
    $wp_customize->add_control( '4392bd_header_bg_type', array(
        'label'   => esc_html__( 'Header Background Type', 'baloch-diamond' ),
        'section' => '4392bd_header_section',
        'type'    => 'select',
        'choices' => array(
            'default'  => esc_html__( 'Default (Theme Background)', 'baloch-diamond' ),
            'solid'    => esc_html__( 'Solid Color', 'baloch-diamond' ),
            'gradient' => esc_html__( 'Gradient', 'baloch-diamond' ),
        ),
    ) );

    // Header BG Color (for solid)
    $wp_customize->add_setting( '4392bd_header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        '4392bd_header_bg_color',
        array(
            'label'       => esc_html__( 'Header Background Color', 'baloch-diamond' ),
            'description' => esc_html__( 'Used when "Solid Color" is selected.', 'baloch-diamond' ),
            'section'     => '4392bd_header_section',
        )
    ) );

    // Header Gradient Color 1
    $wp_customize->add_setting( '4392bd_header_gradient_1', array(
        'default'           => '#38bdf8',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        '4392bd_header_gradient_1',
        array(
            'label'       => esc_html__( 'Gradient Color 1', 'baloch-diamond' ),
            'description' => esc_html__( 'Used when "Gradient" is selected.', 'baloch-diamond' ),
            'section'     => '4392bd_header_section',
        )
    ) );

    // Header Gradient Color 2
    $wp_customize->add_setting( '4392bd_header_gradient_2', array(
        'default'           => '#f97316',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        '4392bd_header_gradient_2',
        array(
            'label'   => esc_html__( 'Gradient Color 2', 'baloch-diamond' ),
            'section' => '4392bd_header_section',
        )
    ) );

    // Header Gradient Direction
    $wp_customize->add_setting( '4392bd_header_gradient_direction', array(
        'default'           => '135deg',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( '4392bd_header_gradient_direction', array(
        'label'   => esc_html__( 'Gradient Direction', 'baloch-diamond' ),
        'section' => '4392bd_header_section',
        'type'    => 'select',
        'choices' => array(
            '0deg'    => esc_html__( 'Top to Bottom', 'baloch-diamond' ),
            '90deg'   => esc_html__( 'Left to Right', 'baloch-diamond' ),
            '135deg'  => esc_html__( 'Diagonal (↘)', 'baloch-diamond' ),
            '180deg'  => esc_html__( 'Bottom to Top', 'baloch-diamond' ),
            '270deg'  => esc_html__( 'Right to Left', 'baloch-diamond' ),
            '315deg'  => esc_html__( 'Diagonal (↗)', 'baloch-diamond' ),
        ),
    ) );

    // ================================================
    // SECTION 3: HERO SLIDER
    // ================================================
    $wp_customize->add_section( '4392bd_slider_section', array(
        'title'    => esc_html__( '🖼️ Hero Slider', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 20,
    ) );

    // Show Slider
    $wp_customize->add_setting( '4392bd_slider_show', array(
        'default'           => true,
        'sanitize_callback' => '4392bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( '4392bd_slider_show', array(
        'label'   => esc_html__( 'Show Hero Slider', 'baloch-diamond' ),
        'section' => '4392bd_slider_section',
        'type'    => 'checkbox',
    ) );

    // Slider Height (Preset options - much easier for users)
    $wp_customize->add_setting( '4392bd_slider_height', array(
        'default'           => '55vh',
        'sanitize_callback' => '4392bd_sanitize_select',
    ) );
    $wp_customize->add_control( '4392bd_slider_height', array(
        'label'       => esc_html__( 'Slider Height', 'baloch-diamond' ),
        'description' => esc_html__( 'Choose a preset height for the hero slider (responsive and easy to use).', 'baloch-diamond' ),
        'section'     => '4392bd_slider_section',
        'type'        => 'select',
        'choices'     => array(
            '40vh'   => esc_html__( 'Small — 40% of screen', 'baloch-diamond' ),
            '50vh'   => esc_html__( 'Medium — 50% of screen', 'baloch-diamond' ),
            '55vh'   => esc_html__( 'Default — 55% of screen', 'baloch-diamond' ),
            '65vh'   => esc_html__( 'Large — 65% of screen', 'baloch-diamond' ),
            '75vh'   => esc_html__( 'Extra Large — 75% of screen', 'baloch-diamond' ),
            '100vh'  => esc_html__( 'Full Screen — 100% of screen', 'baloch-diamond' ),
            '500px'  => esc_html__( 'Fixed — 500 pixels', 'baloch-diamond' ),
            '600px'  => esc_html__( 'Fixed — 600 pixels', 'baloch-diamond' ),
            '700px'  => esc_html__( 'Fixed — 700 pixels', 'baloch-diamond' ),
        ),
    ) );

    // Slider Source
    $wp_customize->add_setting( '4392bd_slider_source', array(
        'default'           => 'recent',
        'sanitize_callback' => '4392bd_sanitize_select',
    ) );
    $wp_customize->add_control( '4392bd_slider_source', array(
        'label'   => esc_html__( 'Slider Source', 'baloch-diamond' ),
        'section' => '4392bd_slider_section',
        'type'    => 'select',
        'choices' => array(
            'recent' => esc_html__( 'Recent Posts (with featured image)', 'baloch-diamond' ),
            'custom' => esc_html__( 'Custom Selected Posts/Pages', 'baloch-diamond' ),
        ),
    ) );

    // Slider Count (for recent)
    $wp_customize->add_setting( '4392bd_slider_count', array(
        'default'           => 5,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( '4392bd_slider_count', array(
        'label'       => esc_html__( 'Number of Slides (Recent)', 'baloch-diamond' ),
        'description' => esc_html__( 'Max 7 slides.', 'baloch-diamond' ),
        'section'     => '4392bd_slider_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 7,
        ),
    ) );

    // Custom Slider Posts — now with nice dropdowns (no more ID typing)
    for ( $i = 1; $i <= 7; $i++ ) {
        $wp_customize->add_setting( "4392bd_slider_post_{$i}", array(
            'default'           => 0,
            'sanitize_callback' => 'absint',
        ) );

        // Dynamically build a dropdown of published posts + pages (with featured images preferred)
        $posts_choices = array( 0 => esc_html__( '— Select a Post or Page —', 'baloch-diamond' ) );

        $recent_posts = get_posts( array(
            'post_type'      => array( 'post', 'page' ),
            'post_status'    => 'publish',
            'posts_per_page' => 80,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );

        foreach ( $recent_posts as $post ) {
            $label = $post->post_title;
            if ( has_post_thumbnail( $post->ID ) ) {
                $label .= ' ★'; // star = has image
            }
            $type_label = ( $post->post_type === 'page' ) ? esc_html__( ' (Page)', 'baloch-diamond' ) : '';
            $posts_choices[ $post->ID ] = $label . $type_label;
        }

        $wp_customize->add_control( "4392bd_slider_post_{$i}", array(
            'label'       => sprintf(
                /* translators: %d: Slide number */
                esc_html__( 'Slide %d — Choose Post/Page', 'baloch-diamond' ),
                $i
            ),
            'description' => esc_html__( 'Select any published post or page. Posts with featured images are preferred. ★ means it has an image.', 'baloch-diamond' ),
            'section'     => '4392bd_slider_section',
            'type'        => 'select',
            'choices'     => $posts_choices,
        ) );
    }

    // ================================================
    // SECTION 3.5: SHOP SHOWCASE (WOOCOMMERCE)
    // ================================================
    $wp_customize->add_section( '4392bd_shop_section', array(
        'title'    => esc_html__( '🛍️ Shop Showcase (WooCommerce)', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 21,
    ) );

    // Show Shop
    $wp_customize->add_setting( '4392bd_shop_show', array(
        'default'           => true,
        'sanitize_callback' => '4392bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( '4392bd_shop_show', array(
        'label'   => esc_html__( 'Show Shop Section', 'baloch-diamond' ),
        'section' => '4392bd_shop_section',
        'type'    => 'checkbox',
    ) );

    // Section Headers
    4392bd_add_section_header_controls( $wp_customize, 'shop', '4392bd_shop_section', array(
        'badge' => esc_html__( 'Premium Marketplace', 'baloch-diamond' ),
        'title' => esc_html__( 'Artisanal Collections', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Explore hand-embroidered apparel, authentic Baloch crafts, and modern designer goods made with exquisite attention to detail.', 'baloch-diamond' ),
    ) );

    // Shop Layout
    $wp_customize->add_setting( '4392bd_shop_layout', array(
        'default'           => 'grid',
        'sanitize_callback' => '4392bd_sanitize_select',
    ) );
    $wp_customize->add_control( '4392bd_shop_layout', array(
        'label'   => esc_html__( 'Product Display Style', 'baloch-diamond' ),
        'section' => '4392bd_shop_section',
        'type'    => 'select',
        'choices' => array(
            'grid'              => esc_html__( 'Grid Layout (Cards)', 'baloch-diamond' ),
            'horizontal-scroll' => esc_html__( 'Horizontal Scrollable Slider (RTL / LTR friendly)', 'baloch-diamond' ),
            'single-big'        => esc_html__( 'Single Large Card + Navigation Buttons', 'baloch-diamond' ),
        ),
        'description' => esc_html__( 'Choose the main display. All layouts pull real product data (image, price, discount, rating).', 'baloch-diamond' ),
    ) );

    // Shop Filters
    $wp_customize->add_setting( '4392bd_shop_filter', array(
        'default'           => 'recent',
        'sanitize_callback' => '4392bd_sanitize_select',
    ) );
    $wp_customize->add_control( '4392bd_shop_filter', array(
        'label'   => esc_html__( 'Product Showcase Filter', 'baloch-diamond' ),
        'section' => '4392bd_shop_section',
        'type'    => 'select',
        'choices' => array(
            'recent'   => esc_html__( 'New Arrivals / Recent Products', 'baloch-diamond' ),
            'sale'     => esc_html__( 'On Sale (Discounted Products)', 'baloch-diamond' ),
            'featured' => esc_html__( 'Featured Products (Recommended)', 'baloch-diamond' ),
            'popular'  => esc_html__( 'Best Selling / Popular Products', 'baloch-diamond' ),
        ),
    ) );

    // Products Count
    $wp_customize->add_setting( '4392bd_shop_count', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( '4392bd_shop_count', array(
        'label'   => esc_html__( 'Number of Products to Show', 'baloch-diamond' ),
        'section' => '4392bd_shop_section',
        'type'    => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 12 ),
    ) );

    // --- Dynamic Product Selection (up to 12 cards) ---
    $product_choices = array( 0 => esc_html__( '— None / Empty —', 'baloch-diamond' ) );
    if ( class_exists( 'WooCommerce' ) ) {
        $products = wc_get_products( array( 'limit' => 80, 'status' => 'publish' ) );
        foreach ( $products as $product ) {
            $product_choices[ $product->get_id() ] = $product->get_name() . ' (' . $product->get_price_html() . ')';
        }
    }

    for ( $i = 1; $i <= 12; $i++ ) {
        $wp_customize->add_setting( "4392bd_shop_custom_product_{$i}", array(
            'default'           => 0,
            'sanitize_callback' => 'absint',
        ) );

        $wp_customize->add_control( "4392bd_shop_custom_product_{$i}", array(
            'label'       => sprintf( esc_html__( 'Custom Product %d', 'baloch-diamond' ), $i ),
            'description' => esc_html__( 'Select a product for this card position.', 'baloch-diamond' ),
            'section'     => '4392bd_shop_section',
            'type'        => 'select',
            'choices'     => $product_choices,
        ) );
    }

    // ================================================
    // SECTION 4: BLOG
    // ================================================
    $wp_customize->add_section( '4392bd_blog_section', array(
        'title'    => esc_html__( '📝 Blog Section', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 30,
    ) );

    4392bd_add_section_header_controls( $wp_customize, 'blog', '4392bd_blog_section', array(
        'badge' => esc_html__( 'Latest Insights', 'baloch-diamond' ),
        'title' => esc_html__( 'From the Studio', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Stories, tutorials, and inspiration from the world of Balochi art and modern design.', 'baloch-diamond' ),
    ) );

    $wp_customize->add_setting( '4392bd_blog_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( '4392bd_blog_count', array(
        'label'       => esc_html__( 'Number of Posts', 'baloch-diamond' ),
        'section'     => '4392bd_blog_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 3, 'max' => 12 ),
    ) );

    // ================================================
    // SECTION 5: PORTFOLIO
    // ================================================
    $wp_customize->add_section( '4392bd_portfolio_section', array(
        'title'    => esc_html__( '🖼️ Portfolio Section', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 35,
    ) );

    4392bd_add_section_header_controls( $wp_customize, 'portfolio', '4392bd_portfolio_section', array(
        'badge' => esc_html__( 'Our Work', 'baloch-diamond' ),
        'title' => esc_html__( 'Masterpieces & Projects', 'baloch-diamond' ),
        'desc'  => esc_html__( 'A curated selection of our finest handcrafted work and creative collaborations.', 'baloch-diamond' ),
    ) );

    $wp_customize->add_setting( '4392bd_portfolio_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( '4392bd_portfolio_count', array(
        'label'       => esc_html__( 'Number of Projects', 'baloch-diamond' ),
        'section'     => '4392bd_portfolio_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 3, 'max' => 12 ),
    ) );

    // ================================================
    // SECTION 6: TEAM
    // ================================================
    $wp_customize->add_section( '4392bd_team_section', array(
        'title'    => esc_html__( '👥 Team Section', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 40,
    ) );

    4392bd_add_section_header_controls( $wp_customize, 'team', '4392bd_team_section', array(
        'badge' => esc_html__( 'The Artisans', 'baloch-diamond' ),
        'title' => esc_html__( 'Meet Our Masters', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Talented craftspeople and designers behind every stitch and creation.', 'baloch-diamond' ),
    ) );

    // ================================================
    // SECTION 7: RESOURCES
    // ================================================
    $wp_customize->add_section( '4392bd_resources_section', array(
        'title'    => esc_html__( '📚 Resources Section', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 45,
    ) );

    4392bd_add_section_header_controls( $wp_customize, 'resources', '4392bd_resources_section', array(
        'badge' => esc_html__( 'Learn & Grow', 'baloch-diamond' ),
        'title' => esc_html__( 'Free Guides & Downloads', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Free tutorials, templates, and downloadable resources to help you master traditional and modern techniques.', 'baloch-diamond' ),
    ) );

    // ================================================
    // SECTION 8: FORUM / COMMUNITY - FULLY ENHANCED
    // ================================================
    $wp_customize->add_section( '4392bd_forum_section', array(
        'title'    => esc_html__( '💬 Community Section', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 50,
    ) );

    4392bd_add_section_header_controls( $wp_customize, 'forum', '4392bd_forum_section', array(
        'badge' => esc_html__( 'Join the Circle', 'baloch-diamond' ),
        'title' => esc_html__( 'Community Hub', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Connect with fellow artisans, ask questions, and share your creations.', 'baloch-diamond' ),
    ) );

    // Forum Display Mode
    $wp_customize->add_setting( '4392bd_forum_mode', array(
        'default'           => 'topics',
        'sanitize_callback' => '4392bd_sanitize_select',
    ) );
    $wp_customize->add_control( '4392bd_forum_mode', array(
        'label'   => esc_html__( 'Display Mode', 'baloch-diamond' ),
        'section' => '4392bd_forum_section',
        'type'    => 'select',
        'choices' => array(
            'topics'      => esc_html__( 'Latest Topics (List)', 'baloch-diamond' ),
            'categories'  => esc_html__( 'Forum Categories Grid', 'baloch-diamond' ),
            'featured'    => esc_html__( 'Featured Discussions + Topics', 'baloch-diamond' ),
            'live-stats'  => esc_html__( 'Live Stats + Quick Actions', 'baloch-diamond' ),
            'cta'         => esc_html__( 'Call to Action + Statistics', 'baloch-diamond' ),
        ),
    ) );

    // Number of items
    $wp_customize->add_setting( '4392bd_forum_count', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( '4392bd_forum_count', array(
        'label'       => esc_html__( 'Number of Topics / Items', 'baloch-diamond' ),
        'section'     => '4392bd_forum_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 2, 'max' => 12 ),
    ) );

    // Show statistics row
    $wp_customize->add_setting( '4392bd_forum_show_stats', array(
        'default'           => true,
        'sanitize_callback' => '4392bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( '4392bd_forum_show_stats', array(
        'label'   => esc_html__( 'Show Community Statistics', 'baloch-diamond' ),
        'section' => '4392bd_forum_section',
        'type'    => 'checkbox',
    ) );

    // Forum Statistics (6 customizable stats)
    for ( $s = 1; $s <= 6; $s++ ) {
        $wp_customize->add_setting( "4392bd_forum_stat{$s}_num", array(
            'default'           => ( $s === 1 ) ? '1,240+' : ( ( $s === 2 ) ? '4,800+' : ( ( $s === 3 ) ? '350+' : ( ( $s === 4 ) ? '99%' : ( ( $s === 5 ) ? '42' : '18' ) ) ) ),
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "4392bd_forum_stat{$s}_num", array(
            'label'   => sprintf( esc_html__( 'Stat %d - Number', 'baloch-diamond' ), $s ),
            'section' => '4392bd_forum_section',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( "4392bd_forum_stat{$s}_label", array(
            'default'           => ( $s === 1 ) ? esc_html__( 'Artisans', 'baloch-diamond' ) : ( ( $s === 2 ) ? esc_html__( 'Discussions', 'baloch-diamond' ) : ( ( $s === 3 ) ? esc_html__( 'Patterns Shared', 'baloch-diamond' ) : ( ( $s === 4 ) ? esc_html__( 'Help Rate', 'baloch-diamond' ) : ( ( $s === 5 ) ? esc_html__( 'Workshops', 'baloch-diamond' ) : esc_html__( 'Countries', 'baloch-diamond' ) ) ) ) ),
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "4392bd_forum_stat{$s}_label", array(
            'label'   => sprintf( esc_html__( 'Stat %d - Label', 'baloch-diamond' ), $s ),
            'section' => '4392bd_forum_section',
            'type'    => 'text',
        ) );
    }

    // Featured Discussions (manual selection)
    for ( $f = 1; $f <= 4; $f++ ) {
        $wp_customize->add_setting( "4392bd_forum_featured_{$f}", array(
            'default'           => 0,
            'sanitize_callback' => 'absint',
        ) );
        $wp_customize->add_control( "4392bd_forum_featured_{$f}", array(
            'label'       => sprintf( esc_html__( 'Featured Discussion %d (Post ID)', 'baloch-diamond' ), $f ),
            'description' => esc_html__( 'Enter the Post ID of a discussion or topic you want to feature.', 'baloch-diamond' ),
            'section'     => '4392bd_forum_section',
            'type'        => 'number',
        ) );
    }

    // Quick Action Buttons
    $wp_customize->add_setting( '4392bd_forum_btn_ask', array(
        'default'           => esc_html__( 'Ask a Question', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( '4392bd_forum_btn_ask', array(
        'label'   => esc_html__( 'Button 1 Text', 'baloch-diamond' ),
        'section' => '4392bd_forum_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( '4392bd_forum_btn_share', array(
        'default'           => esc_html__( 'Share Your Pattern', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( '4392bd_forum_btn_share', array(
        'label'   => esc_html__( 'Button 2 Text', 'baloch-diamond' ),
        'section' => '4392bd_forum_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( '4392bd_forum_btn_workshop', array(
        'default'           => esc_html__( 'Join Workshop', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( '4392bd_forum_btn_workshop', array(
        'label'   => esc_html__( 'Button 3 Text', 'baloch-diamond' ),
        'section' => '4392bd_forum_section',
        'type'    => 'text',
    ) );

    // ================================================
    // CTA Mode Specific Texts (fully customizable invitation / call-to-action)
    $wp_customize->add_setting( '4392bd_forum_cta_title', array(
        'default'           => esc_html__( 'Connect with Fellow Creators', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( '4392bd_forum_cta_title', array(
        'label'       => esc_html__( 'CTA Title (in Call to Action mode)', 'baloch-diamond' ),
        'section'     => '4392bd_forum_section',
        'type'        => 'text',
        'description' => esc_html__( 'Main heading shown only when Display Mode is set to "Call to Action + Statistics".', 'baloch-diamond' ),
    ) );

    $wp_customize->add_setting( '4392bd_forum_cta_desc', array(
        'default'           => esc_html__( 'Sign up today and get instant access to hundreds of topics.', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( '4392bd_forum_cta_desc', array(
        'label'       => esc_html__( 'CTA Description', 'baloch-diamond' ),
        'section'     => '4392bd_forum_section',
        'type'        => 'textarea',
        'description' => esc_html__( 'Descriptive text under the CTA title.', 'baloch-diamond' ),
    ) );

    $wp_customize->add_setting( '4392bd_forum_cta_btn_text', array(
        'default'           => esc_html__( 'Join Discussions', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( '4392bd_forum_cta_btn_text', array(
        'label'   => esc_html__( 'CTA Button Text', 'baloch-diamond' ),
        'section' => '4392bd_forum_section',
        'type'    => 'text',
    ) );

    // Bottom link text
    $wp_customize->add_setting( '4392bd_forum_visit_text', array(
        'default'           => esc_html__( 'Visit Full Community Forums →', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( '4392bd_forum_visit_text', array(
        'label'       => esc_html__( 'Visit Full Forums Link Text', 'baloch-diamond' ),
        'section'     => '4392bd_forum_section',
        'type'        => 'text',
        'description' => esc_html__( 'Text shown at the bottom of most modes to link to full forums.', 'baloch-diamond' ),
    ) );
    // SECTION 9: NEWSLETTER
    // ================================================

    // Featured label text (for featured mode)
    $wp_customize->add_setting( '4392bd_forum_featured_label', array(
        'default'           => esc_html__( 'Featured Discussions', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( '4392bd_forum_featured_label', array(
        'label'       => esc_html__( 'Featured Discussions Label', 'baloch-diamond' ),
        'section'     => '4392bd_forum_section',
        'type'        => 'text',
        'description' => esc_html__( 'Heading label shown above featured cards in Featured mode.', 'baloch-diamond' ),
    ) );
    $wp_customize->add_section( '4392bd_newsletter_section', array(
        'title'    => esc_html__( '✉️ Newsletter Section', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 55,
    ) );

    4392bd_add_section_header_controls( $wp_customize, 'newsletter', '4392bd_newsletter_section', array(
        'badge' => esc_html__( 'Stay Connected', 'baloch-diamond' ),
        'title' => esc_html__( 'Join Our Circle', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Get monthly inspiration, new patterns, exclusive discounts, and early access to new collections.', 'baloch-diamond' ),
    ) );

    $wp_customize->add_setting( '4392bd_newsletter_placeholder', array(
        'default'           => esc_html__( 'Your email address', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( '4392bd_newsletter_placeholder', array(
        'label'   => esc_html__( 'Email Field Placeholder', 'baloch-diamond' ),
        'section' => '4392bd_newsletter_section',
        'type'    => 'text',
    ) );

    // ================================================
    // SECTION 10: FOOTER
    // ================================================
    $wp_customize->add_section( '4392bd_footer_section', array(
        'title'    => esc_html__( '🦶 Footer Settings', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 60,
    ) );

    $wp_customize->add_setting( '4392bd_footer_about', array(
        'default'           => esc_html__( 'A premium WordPress theme inspired by the timeless beauty of Balochi needlework artistry. Where tradition meets modern web design excellence.', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( '4392bd_footer_about', array(
        'label'   => esc_html__( 'Footer About Text', 'baloch-diamond' ),
        'section' => '4392bd_footer_section',
        'type'    => 'textarea',
    ) );

    $wp_customize->add_setting( '4392bd_footer_copyright', array(
        'default'           => esc_html__( '© {year} Baloch Diamond. Crafted with love and heritage.', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( '4392bd_footer_copyright', array(
        'label'   => esc_html__( 'Copyright Text', 'baloch-diamond' ),
        'section' => '4392bd_footer_section',
        'type'    => 'text',
    ) );

    // ================================================
    // SECTION 11: ADVANCED
    // ================================================
    $wp_customize->add_section( '4392bd_advanced_core', array(
        'title'    => esc_html__( '⚙️ Advanced Options', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 65,
    ) );

    $wp_customize->add_setting( '4392bd_enable_dark_mode_toggle', array(
        'default'           => true,
        'sanitize_callback' => '4392bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( '4392bd_enable_dark_mode_toggle', array(
        'label'   => esc_html__( 'Show Dark/Light Mode Toggle', 'baloch-diamond' ),
        'section' => '4392bd_advanced_core',
        'type'    => 'checkbox',
    ) );
}
add_action( 'customize_register', '4392bd_customize_register' );

/**
 * Helper function to add consistent section headers
 */
function 4392bd_add_section_header_controls( $wp_customize, $section_id, $section_name, $defaults ) {

    // Badge
    $wp_customize->add_setting( "4392bd_{$section_id}_badge", array(
        'default'           => $defaults['badge'],
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( "4392bd_{$section_id}_badge", array(
        'label'   => esc_html__( 'Badge Text', 'baloch-diamond' ),
        'section' => $section_name,
        'type'    => 'text',
    ) );

    // Title
    $wp_customize->add_setting( "4392bd_{$section_id}_title", array(
        'default'           => $defaults['title'],
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( "4392bd_{$section_id}_title", array(
        'label'   => esc_html__( 'Section Title', 'baloch-diamond' ),
        'section' => $section_name,
        'type'    => 'text',
    ) );

    // Show Description
    $wp_customize->add_setting( "4392bd_{$section_id}_show_desc", array(
        'default'           => true,
        'sanitize_callback' => '4392bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( "4392bd_{$section_id}_show_desc", array(
        'label'   => esc_html__( 'Show Description', 'baloch-diamond' ),
        'section' => $section_name,
        'type'    => 'checkbox',
    ) );

    // Description
    $wp_customize->add_setting( "4392bd_{$section_id}_desc", array(
        'default'           => $defaults['desc'],
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( "4392bd_{$section_id}_desc", array(
        'label'   => esc_html__( 'Section Description', 'baloch-diamond' ),
        'section' => $section_name,
        'type'    => 'textarea',
    ) );
}

/**
 * Sanitize functions
 */
function 4392bd_sanitize_checkbox( $input ) {
    return ( $input === true || $input === '1' || $input === 1 ) ? true : false;
}

function 4392bd_sanitize_select( $input, $setting ) {
    $control = $setting->manager->get_control( $setting->id );
    $choices = $control ? $control->choices : array();
    return ( array_key_exists( $input, $choices ) ) ? $input : $setting->default;
}

/**
 * Customizer Preview JS
 */
function 4392bd_customizer_preview_js() {
    wp_enqueue_script(
        'bd-customizer-preview',
        4392BD_URI . '/assets/js/customizer-preview.js',
        array( 'customize-preview' ),
        4392BD_VERSION,
        true
    );
}
add_action( 'customize_preview_init', '4392bd_customizer_preview_js' );
    // ================================================
    // SECTION: MEMBERS / COMMUNITY
    // ================================================
    $wp_customize->add_section( '4392bd_members_section', array(
        'title'    => esc_html__( '👥 Community Members', 'baloch-diamond' ),
        'panel'    => '4392bd_panel',
        'priority' => 52,
    ) );

    $wp_customize->add_setting( '4392bd_members_show', array(
        'default'           => true,
        'sanitize_callback' => '4392bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( '4392bd_members_show', array(
        'label'   => esc_html__( 'Show Members Section', 'baloch-diamond' ),
        'section' => '4392bd_members_section',
        'type'    => 'checkbox',
    ) );

    4392bd_add_section_header_controls( $wp_customize, 'members', '4392bd_members_section', array(
        'badge' => esc_html__( 'Join the Circle', 'baloch-diamond' ),
        'title' => esc_html__( 'Our Community', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Meet some of the passionate artisans and creators in our growing community.', 'baloch-diamond' ),
    ) );

    $wp_customize->add_setting( '4392bd_members_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( '4392bd_members_count', array(
        'label'       => esc_html__( 'Number of Members to Show', 'baloch-diamond' ),
        'section'     => '4392bd_members_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 3, 'max' => 8 ),
    ) );

    // Individual members (up to 8)
    for ( $i = 1; $i <= 8; $i++ ) {
        $wp_customize->add_setting( "4392bd_member_{$i}_name", array(
            'default'           => ( $i <= 6 ) ? array( 'Durdana Baloch', 'Jahan Baloch', 'Mehrab Script', 'Naznin G.', 'Farah Baloch', 'Khalid Khan' )[ $i - 1 ] : '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "4392bd_member_{$i}_name", array(
            'label'   => sprintf( esc_html__( 'Member %d - Name', 'baloch-diamond' ), $i ),
            'section' => '4392bd_members_section',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( "4392bd_member_{$i}_role", array(
            'default'           => ( $i <= 6 ) ? array( 'Master Artisan', 'Pattern Designer', 'Embroidery Expert', 'Textile Artist', 'Workshop Leader', 'Community Moderator' )[ $i - 1 ] : '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "4392bd_member_{$i}_role", array(
            'label'   => sprintf( esc_html__( 'Member %d - Role', 'baloch-diamond' ), $i ),
            'section' => '4392bd_members_section',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( "4392bd_member_{$i}_avatar", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "4392bd_member_{$i}_avatar", array(
            'label'   => sprintf( esc_html__( 'Member %d - Avatar', 'baloch-diamond' ), $i ),
            'section' => '4392bd_members_section',
        ) ) );

        $wp_customize->add_setting( "4392bd_member_{$i}_link", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( "4392bd_member_{$i}_link", array(
            'label'   => sprintf( esc_html__( 'Member %d - Profile Link', 'baloch-diamond' ), $i ),
            'section' => '4392bd_members_section',
            'type'    => 'url',
        ) );
    }

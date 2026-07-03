<?php
/**
 * Theme Customizer Settings
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function bd_customize_register( $wp_customize ) {

    // ================================================================
    //  PANEL: BALOCH DIAMOND SETTINGS
    // ================================================================
    $wp_customize->add_panel( 'bd_panel', array(
        'title'    => esc_html__( '💎 Baloch Diamond Settings', 'baloch-diamond' ),
        'priority' => 25,
    ) );


    // ================================================================
    //  SECTION 1: COLORS
    // ================================================================
    $wp_customize->add_section( 'bd_colors_section', array(
        'title'    => esc_html__( '🎨 Theme Colors', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 10,
    ) );

    // Color Preset
    $wp_customize->add_setting( 'bd_color_preset', array(
        'default'           => 'default',
        'sanitize_callback' => 'bd_sanitize_select',
    ) );
    $wp_customize->add_control( 'bd_color_preset', array(
        'label'       => esc_html__( 'Color Scheme Preset', 'baloch-diamond' ),
        'description' => esc_html__( 'Select a pre-designed color preset, or choose "Custom" to set your own colors below.', 'baloch-diamond' ),
        'section'     => 'bd_colors_section',
        'type'        => 'select',
        'choices'     => array(
            'default' => esc_html__( '💎 Baloch Diamond (Default)', 'baloch-diamond' ),
            'ocean'   => esc_html__( '🌊 Ocean Breeze', 'baloch-diamond' ),
            'desert'  => esc_html__( '🌅 Desert Sunset', 'baloch-diamond' ),
            'forest'  => esc_html__( '🌿 Forest Green', 'baloch-diamond' ),
            'royal'   => esc_html__( '👑 Royal Purple', 'baloch-diamond' ),
            'custom'  => esc_html__( '🎨 Custom Colors (Set Below)', 'baloch-diamond' ),
        ),
        'priority'    => 5,
    ) );

    // Primary Color
    $wp_customize->add_setting( 'bd_primary_color', array(
        'default'           => '#38bdf8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'bd_primary_color',
        array(
            'label'   => esc_html__( 'Primary Color', 'baloch-diamond' ),
            'section' => 'bd_colors_section',
        )
    ) );

    // Secondary Color
    $wp_customize->add_setting( 'bd_secondary_color', array(
        'default'           => '#f97316',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'bd_secondary_color',
        array(
            'label'   => esc_html__( 'Secondary Color', 'baloch-diamond' ),
            'section' => 'bd_colors_section',
        )
    ) );


    // ================================================================
    //  SECTION 1.5: TYPOGRAPHY (FONTS)
    // ================================================================
    $wp_customize->add_section( 'bd_typography_section', array(
        'title'    => esc_html__( '🔤 Typography & Fonts', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 12,
    ) );

    // Primary Font (Body Text)
    $wp_customize->add_setting( 'bd_primary_font', array(
        'default'           => 'Poppins',
        'sanitize_callback' => 'bd_sanitize_select',
    ) );
    $wp_customize->add_control( 'bd_primary_font', array(
        'label'    => esc_html__( 'Primary Font (Body Text)', 'baloch-diamond' ),
        'section'  => 'bd_typography_section',
        'type'     => 'select',
        'choices'  => array(
            'Poppins'    => 'Poppins (Modern Sans-Serif)',
            'Roboto'     => 'Roboto (Clean Sans-Serif)',
            'Inter'      => 'Inter (Minimalist Sans-Serif)',
            'Montserrat' => 'Montserrat (Geometric Sans-Serif)',
            'Lora'       => 'Lora (Elegant Serif)',
        ),
    ) );

    // Heading Font
    $wp_customize->add_setting( 'bd_heading_font', array(
        'default'           => 'Playfair Display',
        'sanitize_callback' => 'bd_sanitize_select',
    ) );
    $wp_customize->add_control( 'bd_heading_font', array(
        'label'    => esc_html__( 'Heading Font', 'baloch-diamond' ),
        'section'  => 'bd_typography_section',
        'type'     => 'select',
        'choices'  => array(
            'Playfair Display' => 'Playfair Display (Premium Serif)',
            'Poppins'          => 'Poppins (Bold Sans-Serif)',
            'Montserrat'       => 'Montserrat (Display Sans-Serif)',
            'Merriweather'     => 'Merriweather (Classic Editorial)',
        ),
    ) );

    // RTL Font (Persian & Balochi)
    $wp_customize->add_setting( 'bd_rtl_font', array(
        'default'           => 'Vazirmatn',
        'sanitize_callback' => 'bd_sanitize_select',
    ) );
    $wp_customize->add_control( 'bd_rtl_font', array(
        'label'       => esc_html__( 'RTL Font (Persian/Balochi)', 'baloch-diamond' ),
        'description' => esc_html__( 'Select the font family for Persian, Balochi, Arabic, and other Right-to-Left (RTL) scripts.', 'baloch-diamond' ),
        'section'     => 'bd_typography_section',
        'type'        => 'select',
        'choices'     => array(
            'Vazirmatn' => 'Vazirmatn (وزیرمتن - پیشنهادی)',
            'Cairo'     => 'Cairo (کایرو - هندسی و مدرن)',
            'Tajawal'   => 'Tajawal (تاجاوال - روان و شیک)',
            'Amiri'     => 'Amiri (امیری - خط نسخ سنتی)',
            'system'    => 'System default (فونت سیستم بدون وب‌فونت)',
        ),
    ) );


    // ================================================================
    //  SECTION 2: HEADER
    // ================================================================
    $wp_customize->add_section( 'bd_header_section', array(
        'title'    => esc_html__( '📌 Header Settings', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 15,
    ) );

    // Header Display Mode
    $wp_customize->add_setting( 'bd_header_display', array(
        'default'           => 'icon_title',
        'sanitize_callback' => 'bd_sanitize_select',
    ) );
    $wp_customize->add_control( 'bd_header_display', array(
        'label'   => esc_html__( 'Header Center Display', 'baloch-diamond' ),
        'section' => 'bd_header_section',
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
    $wp_customize->add_setting( 'bd_header_bg_type', array(
        'default'           => 'default',
        'sanitize_callback' => 'bd_sanitize_select',
    ) );
    $wp_customize->add_control( 'bd_header_bg_type', array(
        'label'   => esc_html__( 'Header Background Type', 'baloch-diamond' ),
        'section' => 'bd_header_section',
        'type'    => 'select',
        'choices' => array(
            'default'  => esc_html__( 'Default (Theme Background)', 'baloch-diamond' ),
            'solid'    => esc_html__( 'Solid Color', 'baloch-diamond' ),
            'gradient' => esc_html__( 'Gradient', 'baloch-diamond' ),
        ),
    ) );

    // Header BG Color (for solid)
    $wp_customize->add_setting( 'bd_header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'bd_header_bg_color',
        array(
            'label'       => esc_html__( 'Header Background Color', 'baloch-diamond' ),
            'description' => esc_html__( 'Used when "Solid Color" is selected.', 'baloch-diamond' ),
            'section'     => 'bd_header_section',
        )
    ) );

    // Header Gradient Color 1
    $wp_customize->add_setting( 'bd_header_gradient_1', array(
        'default'           => '#38bdf8',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'bd_header_gradient_1',
        array(
            'label'       => esc_html__( 'Gradient Color 1', 'baloch-diamond' ),
            'description' => esc_html__( 'Used when "Gradient" is selected.', 'baloch-diamond' ),
            'section'     => 'bd_header_section',
        )
    ) );

    // Header Gradient Color 2
    $wp_customize->add_setting( 'bd_header_gradient_2', array(
        'default'           => '#f97316',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'bd_header_gradient_2',
        array(
            'label'   => esc_html__( 'Gradient Color 2', 'baloch-diamond' ),
            'section' => 'bd_header_section',
        )
    ) );

    // Header Gradient Direction
    $wp_customize->add_setting( 'bd_header_gradient_direction', array(
        'default'           => '135deg',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'bd_header_gradient_direction', array(
        'label'   => esc_html__( 'Gradient Direction', 'baloch-diamond' ),
        'section' => 'bd_header_section',
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


    // ================================================================
    //  SECTION 3: HERO SLIDER
    // ================================================================
    $wp_customize->add_section( 'bd_slider_section', array(
        'title'    => esc_html__( '🖼️ Hero Slider', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 20,
    ) );

    // Show Slider
    $wp_customize->add_setting( 'bd_slider_show', array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'bd_slider_show', array(
        'label'   => esc_html__( 'Show Hero Slider', 'baloch-diamond' ),
        'section' => 'bd_slider_section',
        'type'    => 'checkbox',
    ) );

    // Slider Source
    $wp_customize->add_setting( 'bd_slider_source', array(
        'default'           => 'recent',
        'sanitize_callback' => 'bd_sanitize_select',
    ) );
    $wp_customize->add_control( 'bd_slider_source', array(
        'label'   => esc_html__( 'Slider Source', 'baloch-diamond' ),
        'section' => 'bd_slider_section',
        'type'    => 'select',
        'choices' => array(
            'recent' => esc_html__( 'Recent Posts (with featured image)', 'baloch-diamond' ),
            'custom' => esc_html__( 'Custom Selected Posts/Pages', 'baloch-diamond' ),
        ),
    ) );

    // Slider Count (for recent)
    $wp_customize->add_setting( 'bd_slider_count', array(
        'default'           => 5,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'bd_slider_count', array(
        'label'       => esc_html__( 'Number of Slides (Recent)', 'baloch-diamond' ),
        'description' => esc_html__( 'Max 7 slides.', 'baloch-diamond' ),
        'section'     => 'bd_slider_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 7,
        ),
    ) );

    // Custom Slider Posts (1-7)
    for ( $i = 1; $i <= 7; $i++ ) {
        $wp_customize->add_setting( "bd_slider_post_{$i}", array(
            'default'           => 0,
            'sanitize_callback' => 'absint',
        ) );
        $wp_customize->add_control( "bd_slider_post_{$i}", array(
            'label'       => sprintf(
                /* translators: %d: Slide number */
                esc_html__( 'Slide %d — Post/Page ID', 'baloch-diamond' ),
                $i
            ),
            'description' => esc_html__( 'Enter the post or page ID. Used when "Custom" source is selected.', 'baloch-diamond' ),
            'section'     => 'bd_slider_section',
            'type'        => 'number',
            'input_attrs' => array( 'min' => 0 ),
        ) );
    }


    // ================================================================
    //  SECTION 3.5: SHOP SHOWCASE (WOOCOMMERCE)
    // ================================================================
    $wp_customize->add_section( 'bd_shop_section', array(
        'title'    => esc_html__( '🛍️ Shop Showcase (WooCommerce)', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 21,
    ) );

    // Show Shop
    $wp_customize->add_setting( 'bd_shop_show', array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'bd_shop_show', array(
        'label'   => esc_html__( 'Show Shop Section', 'baloch-diamond' ),
        'section' => 'bd_shop_section',
        'type'    => 'checkbox',
    ) );

    // Section Headers
    bd_add_section_header_controls( $wp_customize, 'shop', 'bd_shop_section', array(
        'badge' => esc_html__( 'Premium Marketplace', 'baloch-diamond' ),
        'title' => esc_html__( 'Artisanal Collections', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Explore hand-embroidered apparel, authentic Baloch crafts, and modern designer goods made with exquisite attention to detail.', 'baloch-diamond' ),
    ) );

    // Shop Layout
    $wp_customize->add_setting( 'bd_shop_layout', array(
        'default'           => 'grid',
        'sanitize_callback' => 'bd_sanitize_select',
    ) );
    $wp_customize->add_control( 'bd_shop_layout', array(
        'label'   => esc_html__( 'Product Layout Style', 'baloch-diamond' ),
        'section' => 'bd_shop_section',
        'type'    => 'select',
        'choices' => array(
            'grid'   => esc_html__( 'Product Grid', 'baloch-diamond' ),
            'slider' => esc_html__( 'Product Slider (Carousels)', 'baloch-diamond' ),
        ),
    ) );

    // Shop Filters
    $wp_customize->add_setting( 'bd_shop_filter', array(
        'default'           => 'recent',
        'sanitize_callback' => 'bd_sanitize_select',
    ) );
    $wp_customize->add_control( 'bd_shop_filter', array(
        'label'   => esc_html__( 'Product Showcase Filter', 'baloch-diamond' ),
        'section' => 'bd_shop_section',
        'type'    => 'select',
        'choices' => array(
            'recent'   => esc_html__( 'New Arrivals / Recent Products', 'baloch-diamond' ),
            'sale'     => esc_html__( 'On Sale (Discounted Products)', 'baloch-diamond' ),
            'featured' => esc_html__( 'Featured Products (Recommended)', 'baloch-diamond' ),
            'popular'  => esc_html__( 'Best Selling / Popular Products', 'baloch-diamond' ),
        ),
    ) );

    // Products Count
    $wp_customize->add_setting( 'bd_shop_count', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'bd_shop_count', array(
        'label'   => esc_html__( 'Number of Products to Show', 'baloch-diamond' ),
        'section' => 'bd_shop_section',
        'type'    => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 12 ),
    ) );


    // ================================================================
    //  SECTION 3.6: FORUM SHOWCASE (BBPRESS)
    // ================================================================
    $wp_customize->add_section( 'bd_forum_section', array(
        'title'    => esc_html__( '💬 Forum Showcase (bbPress)', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 22,
    ) );

    // Show Forum
    $wp_customize->add_setting( 'bd_forum_show', array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'bd_forum_show', array(
        'label'   => esc_html__( 'Show Forum Section', 'baloch-diamond' ),
        'section' => 'bd_forum_section',
        'type'    => 'checkbox',
    ) );

    // Section Headers
    bd_add_section_header_controls( $wp_customize, 'forum', 'bd_forum_section', array(
        'badge' => esc_html__( 'Thriving Community', 'baloch-diamond' ),
        'title' => esc_html__( 'Discussion Board', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Join the conversations with embroidery enthusiasts, local artisans, and history lovers from all around the world.', 'baloch-diamond' ),
    ) );

    // Forum Showcase Mode
    $wp_customize->add_setting( 'bd_forum_mode', array(
        'default'           => 'topics',
        'sanitize_callback' => 'bd_sanitize_select',
    ) );
    $wp_customize->add_control( 'bd_forum_mode', array(
        'label'   => esc_html__( 'Forum Display Mode', 'baloch-diamond' ),
        'section' => 'bd_forum_section',
        'type'    => 'select',
        'choices' => array(
            'topics' => esc_html__( 'List Latest Active Topics', 'baloch-diamond' ),
            'cta'    => esc_html__( 'Show Styled Community Registration & Stats', 'baloch-diamond' ),
        ),
    ) );

    // Topics Count
    $wp_customize->add_setting( 'bd_forum_count', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'bd_forum_count', array(
        'label'   => esc_html__( 'Number of Topics to Show', 'baloch-diamond' ),
        'section' => 'bd_forum_section',
        'type'    => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 10 ),
    ) );


    // ================================================================
    //  SECTION 4: PORTFOLIO
    // ================================================================
    $wp_customize->add_section( 'bd_portfolio_section', array(
        'title'    => esc_html__( '💼 Portfolio Section', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 25,
    ) );

    // Show Portfolio
    $wp_customize->add_setting( 'bd_portfolio_show', array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'bd_portfolio_show', array(
        'label'   => esc_html__( 'Show Portfolio Section', 'baloch-diamond' ),
        'section' => 'bd_portfolio_section',
        'type'    => 'checkbox',
    ) );

    // Section Header Controls
    bd_add_section_header_controls( $wp_customize, 'portfolio', 'bd_portfolio_section', array(
        'badge' => esc_html__( 'Our Portfolio', 'baloch-diamond' ),
        'title' => esc_html__( 'Featured Projects', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Showcasing our finest work blending tradition with innovation. Each project tells a unique story of creativity and craftsmanship.', 'baloch-diamond' ),
    ) );

    // Button Text
    $wp_customize->add_setting( 'bd_portfolio_btn_text', array(
        'default'           => esc_html__( 'More Info', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'bd_portfolio_btn_text', array(
        'label'   => esc_html__( 'Button Text', 'baloch-diamond' ),
        'section' => 'bd_portfolio_section',
        'type'    => 'text',
    ) );

    // Portfolio Items (1-10)
    for ( $i = 1; $i <= 10; $i++ ) {

        // Separator
        $wp_customize->add_setting( "bd_portfolio_sep_{$i}", array(
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( new BD_Separator_Control(
            $wp_customize,
            "bd_portfolio_sep_{$i}",
            array(
                'label'   => sprintf(
                    /* translators: %d: Project number */
                    esc_html__( '── Project %d ──', 'baloch-diamond' ),
                    $i
                ),
                'section' => 'bd_portfolio_section',
            )
        ) );

        // Title
        $wp_customize->add_setting( "bd_portfolio_item_{$i}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "bd_portfolio_item_{$i}_title", array(
            'label'   => sprintf( esc_html__( 'Project %d Title', 'baloch-diamond' ), $i ),
            'section' => 'bd_portfolio_section',
            'type'    => 'text',
        ) );

        // Description
        $wp_customize->add_setting( "bd_portfolio_item_{$i}_desc", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ) );
        $wp_customize->add_control( "bd_portfolio_item_{$i}_desc", array(
            'label'   => sprintf( esc_html__( 'Project %d Description', 'baloch-diamond' ), $i ),
            'section' => 'bd_portfolio_section',
            'type'    => 'textarea',
        ) );

        // Image
        $wp_customize->add_setting( "bd_portfolio_item_{$i}_image", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( new WP_Customize_Image_Control(
            $wp_customize,
            "bd_portfolio_item_{$i}_image",
            array(
                'label'   => sprintf( esc_html__( 'Project %d Image', 'baloch-diamond' ), $i ),
                'section' => 'bd_portfolio_section',
            )
        ) );

        // Link
        $wp_customize->add_setting( "bd_portfolio_item_{$i}_link", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( "bd_portfolio_item_{$i}_link", array(
            'label'       => sprintf( esc_html__( 'Project %d Link', 'baloch-diamond' ), $i ),
            'description' => esc_html__( 'URL to a page or post.', 'baloch-diamond' ),
            'section'     => 'bd_portfolio_section',
            'type'        => 'url',
        ) );
    }


    // ================================================================
    //  SECTION 5: BLOG
    // ================================================================
    $wp_customize->add_section( 'bd_blog_section', array(
        'title'    => esc_html__( '📝 Blog Section', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 30,
    ) );

    // Show Blog
    $wp_customize->add_setting( 'bd_blog_show', array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'bd_blog_show', array(
        'label'   => esc_html__( 'Show Blog Section', 'baloch-diamond' ),
        'section' => 'bd_blog_section',
        'type'    => 'checkbox',
    ) );

    // Section Header Controls
    bd_add_section_header_controls( $wp_customize, 'blog', 'bd_blog_section', array(
        'badge' => esc_html__( 'Blog', 'baloch-diamond' ),
        'title' => esc_html__( 'Latest Updates', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Stay updated with our latest articles, tutorials, and industry insights. Fresh content delivered regularly.', 'baloch-diamond' ),
    ) );

    // Posts Count
    $wp_customize->add_setting( 'bd_blog_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'bd_blog_count', array(
        'label'       => esc_html__( 'Number of Posts to Show', 'baloch-diamond' ),
        'section'     => 'bd_blog_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 12,
        ),
    ) );

    // Read More Text
    $wp_customize->add_setting( 'bd_blog_readmore_text', array(
        'default'           => esc_html__( 'Read More', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'bd_blog_readmore_text', array(
        'label'   => esc_html__( 'Read More Button Text', 'baloch-diamond' ),
        'section' => 'bd_blog_section',
        'type'    => 'text',
    ) );


    // ================================================================
    //  SECTION 6: RESOURCES
    // ================================================================
    $wp_customize->add_section( 'bd_resources_section', array(
        'title'    => esc_html__( '📚 Resources Section', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 35,
    ) );

    // Show Resources
    $wp_customize->add_setting( 'bd_resources_show', array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'bd_resources_show', array(
        'label'   => esc_html__( 'Show Resources Section', 'baloch-diamond' ),
        'section' => 'bd_resources_section',
        'type'    => 'checkbox',
    ) );

    // Section Header
    bd_add_section_header_controls( $wp_customize, 'resources', 'bd_resources_section', array(
        'badge' => esc_html__( 'Resources', 'baloch-diamond' ),
        'title' => esc_html__( 'Project Documentation', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Comprehensive documentation to help you get started and make the most of our projects.', 'baloch-diamond' ),
    ) );

    // Link Text
    $wp_customize->add_setting( 'bd_resources_link_text', array(
        'default'           => esc_html__( 'Read Documentation', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'bd_resources_link_text', array(
        'label'   => esc_html__( 'Link Text', 'baloch-diamond' ),
        'section' => 'bd_resources_section',
        'type'    => 'text',
    ) );

    // Icon choices
    $icon_choices = array(
        'file'   => esc_html__( '📄 File', 'baloch-diamond' ),
        'code'   => esc_html__( '💻 Code', 'baloch-diamond' ),
        'layout' => esc_html__( '📐 Layout', 'baloch-diamond' ),
        'shield' => esc_html__( '🛡️ Shield', 'baloch-diamond' ),
        'book'   => esc_html__( '📖 Book', 'baloch-diamond' ),
        'zap'    => esc_html__( '⚡ Zap', 'baloch-diamond' ),
        'globe'  => esc_html__( '🌐 Globe', 'baloch-diamond' ),
        'cpu'    => esc_html__( '🔧 CPU', 'baloch-diamond' ),
        'heart'  => esc_html__( '❤️ Heart', 'baloch-diamond' ),
        'star'   => esc_html__( '⭐ Star', 'baloch-diamond' ),
    );

    // Resource Items (1-10)
    for ( $i = 1; $i <= 10; $i++ ) {

        // Separator
        $wp_customize->add_setting( "bd_resource_sep_{$i}", array(
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( new BD_Separator_Control(
            $wp_customize,
            "bd_resource_sep_{$i}",
            array(
                'label'   => sprintf( esc_html__( '── Resource %d ──', 'baloch-diamond' ), $i ),
                'section' => 'bd_resources_section',
            )
        ) );

        // Icon
        $wp_customize->add_setting( "bd_resource_item_{$i}_icon", array(
            'default'           => 'file',
            'sanitize_callback' => 'bd_sanitize_select',
        ) );
        $wp_customize->add_control( "bd_resource_item_{$i}_icon", array(
            'label'   => sprintf( esc_html__( 'Resource %d Icon', 'baloch-diamond' ), $i ),
            'section' => 'bd_resources_section',
            'type'    => 'select',
            'choices' => $icon_choices,
        ) );

        // Title
        $wp_customize->add_setting( "bd_resource_item_{$i}_title", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "bd_resource_item_{$i}_title", array(
            'label'   => sprintf( esc_html__( 'Resource %d Title', 'baloch-diamond' ), $i ),
            'section' => 'bd_resources_section',
            'type'    => 'text',
        ) );

        // Description
        $wp_customize->add_setting( "bd_resource_item_{$i}_desc", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ) );
        $wp_customize->add_control( "bd_resource_item_{$i}_desc", array(
            'label'   => sprintf( esc_html__( 'Resource %d Description', 'baloch-diamond' ), $i ),
            'section' => 'bd_resources_section',
            'type'    => 'textarea',
        ) );

        // Link
        $wp_customize->add_setting( "bd_resource_item_{$i}_link", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( "bd_resource_item_{$i}_link", array(
            'label'   => sprintf( esc_html__( 'Resource %d Link', 'baloch-diamond' ), $i ),
            'section' => 'bd_resources_section',
            'type'    => 'url',
        ) );
    }


    // ================================================================
    //  SECTION 7: TEAM
    // ================================================================
    $wp_customize->add_section( 'bd_team_section', array(
        'title'    => esc_html__( '👥 Team Section', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 40,
    ) );

    // Show Team
    $wp_customize->add_setting( 'bd_team_show', array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'bd_team_show', array(
        'label'   => esc_html__( 'Show Team Section', 'baloch-diamond' ),
        'section' => 'bd_team_section',
        'type'    => 'checkbox',
    ) );

    // Section Header
    bd_add_section_header_controls( $wp_customize, 'team', 'bd_team_section', array(
        'badge' => esc_html__( 'The Crew', 'baloch-diamond' ),
        'title' => esc_html__( 'Meet Our Team', 'baloch-diamond' ),
        'desc'  => esc_html__( 'The talented individuals behind our success. Passionate, creative, and dedicated to excellence.', 'baloch-diamond' ),
    ) );

    // Team Members (1-10)
    for ( $i = 1; $i <= 10; $i++ ) {

        // Separator
        $wp_customize->add_setting( "bd_team_sep_{$i}", array(
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( new BD_Separator_Control(
            $wp_customize,
            "bd_team_sep_{$i}",
            array(
                'label'   => sprintf( esc_html__( '── Member %d ──', 'baloch-diamond' ), $i ),
                'section' => 'bd_team_section',
            )
        ) );

        // Name
        $wp_customize->add_setting( "bd_team_member_{$i}_name", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "bd_team_member_{$i}_name", array(
            'label'   => sprintf( esc_html__( 'Member %d Name', 'baloch-diamond' ), $i ),
            'section' => 'bd_team_section',
            'type'    => 'text',
        ) );

        // Role
        $wp_customize->add_setting( "bd_team_member_{$i}_role", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( "bd_team_member_{$i}_role", array(
            'label'   => sprintf( esc_html__( 'Member %d Role', 'baloch-diamond' ), $i ),
            'section' => 'bd_team_section',
            'type'    => 'text',
        ) );

        // Bio
        $wp_customize->add_setting( "bd_team_member_{$i}_bio", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ) );
        $wp_customize->add_control( "bd_team_member_{$i}_bio", array(
            'label'   => sprintf( esc_html__( 'Member %d Bio', 'baloch-diamond' ), $i ),
            'section' => 'bd_team_section',
            'type'    => 'textarea',
        ) );

        // Avatar
        $wp_customize->add_setting( "bd_team_member_{$i}_avatar", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( new WP_Customize_Image_Control(
            $wp_customize,
            "bd_team_member_{$i}_avatar",
            array(
                'label'   => sprintf( esc_html__( 'Member %d Photo', 'baloch-diamond' ), $i ),
                'section' => 'bd_team_section',
            )
        ) );

        // Header Background Type
        $wp_customize->add_setting( "bd_team_member_{$i}_header_type", array(
            'default'           => 'gradient',
            'sanitize_callback' => 'bd_sanitize_select',
        ) );
        $wp_customize->add_control( "bd_team_member_{$i}_header_type", array(
            'label'   => sprintf( esc_html__( 'Member %d Card Header', 'baloch-diamond' ), $i ),
            'section' => 'bd_team_section',
            'type'    => 'select',
            'choices' => array(
                'default'  => esc_html__( 'Default Gradient', 'baloch-diamond' ),
                'solid'    => esc_html__( 'Solid Color', 'baloch-diamond' ),
                'gradient' => esc_html__( 'Custom Gradient', 'baloch-diamond' ),
            ),
        ) );

        // Header Solid Color
        $wp_customize->add_setting( "bd_team_member_{$i}_header_color", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control(
            $wp_customize,
            "bd_team_member_{$i}_header_color",
            array(
                'label'   => sprintf( esc_html__( 'Member %d Header Color', 'baloch-diamond' ), $i ),
                'section' => 'bd_team_section',
            )
        ) );

        // Gradient Color 1
        $wp_customize->add_setting( "bd_team_member_{$i}_grad_1", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control(
            $wp_customize,
            "bd_team_member_{$i}_grad_1",
            array(
                'label'   => sprintf( esc_html__( 'Member %d Gradient 1', 'baloch-diamond' ), $i ),
                'section' => 'bd_team_section',
            )
        ) );

        // Gradient Color 2
        $wp_customize->add_setting( "bd_team_member_{$i}_grad_2", array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control(
            $wp_customize,
            "bd_team_member_{$i}_grad_2",
            array(
                'label'   => sprintf( esc_html__( 'Member %d Gradient 2', 'baloch-diamond' ), $i ),
                'section' => 'bd_team_section',
            )
        ) );

        // Social: Twitter
        $wp_customize->add_setting( "bd_team_member_{$i}_twitter", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( "bd_team_member_{$i}_twitter", array(
            'label'   => sprintf( esc_html__( 'Member %d Twitter URL', 'baloch-diamond' ), $i ),
            'section' => 'bd_team_section',
            'type'    => 'url',
        ) );

        // Social: LinkedIn
        $wp_customize->add_setting( "bd_team_member_{$i}_linkedin", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( "bd_team_member_{$i}_linkedin", array(
            'label'   => sprintf( esc_html__( 'Member %d LinkedIn URL', 'baloch-diamond' ), $i ),
            'section' => 'bd_team_section',
            'type'    => 'url',
        ) );

        // Social: GitHub
        $wp_customize->add_setting( "bd_team_member_{$i}_github", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( "bd_team_member_{$i}_github", array(
            'label'   => sprintf( esc_html__( 'Member %d GitHub URL', 'baloch-diamond' ), $i ),
            'section' => 'bd_team_section',
            'type'    => 'url',
        ) );

        // Social: Instagram
        $wp_customize->add_setting( "bd_team_member_{$i}_instagram", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( "bd_team_member_{$i}_instagram", array(
            'label'   => sprintf( esc_html__( 'Member %d Instagram URL', 'baloch-diamond' ), $i ),
            'section' => 'bd_team_section',
            'type'    => 'url',
        ) );

        // Social: Website
        $wp_customize->add_setting( "bd_team_member_{$i}_website", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( "bd_team_member_{$i}_website", array(
            'label'   => sprintf( esc_html__( 'Member %d Website URL', 'baloch-diamond' ), $i ),
            'section' => 'bd_team_section',
            'type'    => 'url',
        ) );
    }
    
    
    // ================================================================
    //  SECTION 8: NEWSLETTER
    // ================================================================
    $wp_customize->add_section( 'bd_newsletter_section', array(
        'title'    => esc_html__( '📧 Newsletter Section', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 45,
    ) );

    // Show Newsletter
    $wp_customize->add_setting( 'bd_newsletter_show', array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'bd_newsletter_show', array(
        'label'   => esc_html__( 'Show Newsletter Section', 'baloch-diamond' ),
        'section' => 'bd_newsletter_section',
        'type'    => 'checkbox',
    ) );

    // Show Title
    $wp_customize->add_setting( 'bd_newsletter_show_title', array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'bd_newsletter_show_title', array(
        'label'   => esc_html__( 'Show Title', 'baloch-diamond' ),
        'section' => 'bd_newsletter_section',
        'type'    => 'checkbox',
    ) );

    // Show Description
    $wp_customize->add_setting( 'bd_newsletter_show_desc', array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'bd_newsletter_show_desc', array(
        'label'   => esc_html__( 'Show Description', 'baloch-diamond' ),
        'section' => 'bd_newsletter_section',
        'type'    => 'checkbox',
    ) );

    // Title
    $wp_customize->add_setting( 'bd_newsletter_title', array(
        'default'           => esc_html__( 'Stay Connected', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'bd_newsletter_title', array(
        'label'   => esc_html__( 'Title', 'baloch-diamond' ),
        'section' => 'bd_newsletter_section',
        'type'    => 'text',
    ) );

    // Description
    $wp_customize->add_setting( 'bd_newsletter_desc', array(
        'default'           => esc_html__( 'Subscribe to our newsletter and never miss an update. Get exclusive content, project news, and insights delivered to your inbox.', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'bd_newsletter_desc', array(
        'label'   => esc_html__( 'Description', 'baloch-diamond' ),
        'section' => 'bd_newsletter_section',
        'type'    => 'textarea',
    ) );

    // Placeholder
    $wp_customize->add_setting( 'bd_newsletter_placeholder', array(
        'default'           => esc_html__( 'Enter your email...', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'bd_newsletter_placeholder', array(
        'label'   => esc_html__( 'Input Placeholder Text', 'baloch-diamond' ),
        'section' => 'bd_newsletter_section',
        'type'    => 'text',
    ) );

    // Button Text
    $wp_customize->add_setting( 'bd_newsletter_btn_text', array(
        'default'           => esc_html__( 'Subscribe', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'bd_newsletter_btn_text', array(
        'label'   => esc_html__( 'Button Text', 'baloch-diamond' ),
        'section' => 'bd_newsletter_section',
        'type'    => 'text',
    ) );


    // ================================================================
    //  SECTION 9: FOOTER
    // ================================================================
    $wp_customize->add_section( 'bd_footer_section', array(
        'title'    => esc_html__( '🦶 Footer Settings', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 50,
    ) );

    // Show Footer
    $wp_customize->add_setting( 'bd_footer_show', array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'bd_footer_show', array(
        'label'   => esc_html__( 'Show Footer', 'baloch-diamond' ),
        'section' => 'bd_footer_section',
        'type'    => 'checkbox',
    ) );

    // Footer About Text
    $wp_customize->add_setting( 'bd_footer_about', array(
        'default'           => esc_html__( 'A premium WordPress theme inspired by the timeless beauty of Balochi needlework artistry. Where tradition meets modern web design excellence.', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'bd_footer_about', array(
        'label'   => esc_html__( 'Footer About Text', 'baloch-diamond' ),
        'section' => 'bd_footer_section',
        'type'    => 'textarea',
    ) );

    // Column 1 Title
    $wp_customize->add_setting( 'bd_footer_col1_title', array(
        'default'           => esc_html__( 'Quick Links', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'bd_footer_col1_title', array(
        'label'   => esc_html__( 'Column 1 Title', 'baloch-diamond' ),
        'section' => 'bd_footer_section',
        'type'    => 'text',
    ) );

    // Column 2 Title
    $wp_customize->add_setting( 'bd_footer_col2_title', array(
        'default'           => esc_html__( 'Resources', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'bd_footer_col2_title', array(
        'label'   => esc_html__( 'Column 2 Title', 'baloch-diamond' ),
        'section' => 'bd_footer_section',
        'type'    => 'text',
    ) );

    // Column 3 Title
    $wp_customize->add_setting( 'bd_footer_col3_title', array(
        'default'           => esc_html__( 'Contact', 'baloch-diamond' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'bd_footer_col3_title', array(
        'label'   => esc_html__( 'Column 3 Title', 'baloch-diamond' ),
        'section' => 'bd_footer_section',
        'type'    => 'text',
    ) );

    // Copyright Text
    $wp_customize->add_setting( 'bd_footer_copyright', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'bd_footer_copyright', array(
        'label'       => esc_html__( 'Custom Copyright Text', 'baloch-diamond' ),
        'description' => esc_html__( 'Leave empty to use default. HTML allowed.', 'baloch-diamond' ),
        'section'     => 'bd_footer_section',
        'type'        => 'textarea',
    ) );


    // ================================================================
    //  SECTION 10: CONTACT INFO
    // ================================================================
    $wp_customize->add_section( 'bd_contact_section', array(
        'title'    => esc_html__( '📞 Contact Info', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 55,
    ) );

    // Email
    $wp_customize->add_setting( 'bd_contact_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ) );
    $wp_customize->add_control( 'bd_contact_email', array(
        'label'   => esc_html__( 'Email Address', 'baloch-diamond' ),
        'section' => 'bd_contact_section',
        'type'    => 'email',
    ) );

    // Address
    $wp_customize->add_setting( 'bd_contact_address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'bd_contact_address', array(
        'label'   => esc_html__( 'Address', 'baloch-diamond' ),
        'section' => 'bd_contact_section',
        'type'    => 'text',
    ) );

    // Phone
    $wp_customize->add_setting( 'bd_contact_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'bd_contact_phone', array(
        'label'   => esc_html__( 'Phone Number', 'baloch-diamond' ),
        'section' => 'bd_contact_section',
        'type'    => 'text',
    ) );


    // ================================================================
    //  SECTION 11: SOCIAL MEDIA
    // ================================================================
    $wp_customize->add_section( 'bd_social_section', array(
        'title'    => esc_html__( '🔗 Social Media', 'baloch-diamond' ),
        'panel'    => 'bd_panel',
        'priority' => 60,
    ) );

    $social_networks = array(
        'twitter'   => 'Twitter / X',
        'github'    => 'GitHub',
        'linkedin'  => 'LinkedIn',
        'instagram' => 'Instagram',
        'facebook'  => 'Facebook',
        'youtube'   => 'YouTube',
        'telegram'  => 'Telegram',
        'whatsapp'  => 'WhatsApp',
    );

    foreach ( $social_networks as $key => $label ) {
        $wp_customize->add_setting( "bd_social_{$key}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( "bd_social_{$key}", array(
            'label'   => $label . ' URL',
            'section' => 'bd_social_section',
            'type'    => 'url',
        ) );
    }

}
add_action( 'customize_register', 'bd_customize_register' );


// ================================================================
//  HELPER: Add Section Header Controls
// ================================================================
function bd_add_section_header_controls( $wp_customize, $section_id, $section_name, $defaults ) {

    // Show Badge
    $wp_customize->add_setting( "bd_{$section_id}_show_badge", array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( "bd_{$section_id}_show_badge", array(
        'label'   => esc_html__( 'Show Badge', 'baloch-diamond' ),
        'section' => $section_name,
        'type'    => 'checkbox',
    ) );

    // Badge Text
    $wp_customize->add_setting( "bd_{$section_id}_badge", array(
        'default'           => $defaults['badge'],
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( "bd_{$section_id}_badge", array(
        'label'   => esc_html__( 'Badge Text', 'baloch-diamond' ),
        'section' => $section_name,
        'type'    => 'text',
    ) );

    // Show Title
    $wp_customize->add_setting( "bd_{$section_id}_show_title", array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( "bd_{$section_id}_show_title", array(
        'label'   => esc_html__( 'Show Title', 'baloch-diamond' ),
        'section' => $section_name,
        'type'    => 'checkbox',
    ) );

    // Title
    $wp_customize->add_setting( "bd_{$section_id}_title", array(
        'default'           => $defaults['title'],
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( "bd_{$section_id}_title", array(
        'label'   => esc_html__( 'Section Title', 'baloch-diamond' ),
        'section' => $section_name,
        'type'    => 'text',
    ) );

    // Show Description
    $wp_customize->add_setting( "bd_{$section_id}_show_desc", array(
        'default'           => true,
        'sanitize_callback' => 'bd_sanitize_checkbox',
    ) );
    $wp_customize->add_control( "bd_{$section_id}_show_desc", array(
        'label'   => esc_html__( 'Show Description', 'baloch-diamond' ),
        'section' => $section_name,
        'type'    => 'checkbox',
    ) );

    // Description
    $wp_customize->add_setting( "bd_{$section_id}_desc", array(
        'default'           => $defaults['desc'],
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( "bd_{$section_id}_desc", array(
        'label'   => esc_html__( 'Section Description', 'baloch-diamond' ),
        'section' => $section_name,
        'type'    => 'textarea',
    ) );
}


// ================================================================
//  CUSTOM CONTROL: SEPARATOR
// ================================================================
if ( class_exists( 'WP_Customize_Control' ) ) {

    class BD_Separator_Control extends WP_Customize_Control {

        public $type = 'bd_separator';

        public function render_content() {
            ?>
            <div style="border-top:2px dashed #ccc;margin:20px 0 10px;padding-top:10px">
                <?php if ( $this->label ) : ?>
                    <span style="font-weight:700;font-size:13px;color:#555;text-transform:uppercase;letter-spacing:0.5px">
                        <?php echo esc_html( $this->label ); ?>
                    </span>
                <?php endif; ?>
            </div>
            <?php
        }
    }
}


// ================================================================
//  SANITIZE FUNCTIONS
// ================================================================
function bd_sanitize_checkbox( $input ) {
    return ( $input === true || $input === '1' || $input === 1 ) ? true : false;
}

function bd_sanitize_select( $input, $setting ) {
    $control = $setting->manager->get_control( $setting->id );
    $choices = $control ? $control->choices : array();
    return ( array_key_exists( $input, $choices ) ) ? $input : $setting->default;
}


// ================================================================
//  CUSTOMIZER PREVIEW JS
// ================================================================
function bd_customizer_preview_js() {
    wp_enqueue_script(
        'bd-customizer-preview',
        BD_URI . '/assets/js/customizer-preview.js',
        array( 'customize-preview' ),
        BD_VERSION,
        true
    );
}
add_action( 'customize_preview_init', 'bd_customizer_preview_js' );

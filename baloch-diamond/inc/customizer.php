<?php
/**
 * Baloch Diamond Theme — Customizer Definitions
 *
 * Sections: Colors, Typography, Advanced Features, Header, Hero Slider,
 * Shop (WooCommerce), Blog, Portfolio (standalone - full control),
 * Team (standalone - full control), Resources (full control),
 * Community/Forum (with button links + hide/show), Members, Newsletter,
 * Footer (full control), Advanced Options.
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register all customizer settings
 */
function bd_customize_register( $wp_customize ) {

	// Main Panel
	$wp_customize->add_panel( 'bd_panel', array(
		'title'    => esc_html__( '💎 Baloch Diamond Settings', 'baloch-diamond' ),
		'priority' => 10,
	) );

	// ================================================
	// SECTION 1: COLORS
	// ================================================
	$wp_customize->add_section( 'bd_colors_section', array(
		'title'    => esc_html__( '🎨 Colors & Presets', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 10,
	) );

	// Color Preset
	$wp_customize->add_setting( 'bd_color_preset', array(
		'default'           => 'default',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_color_preset', array(
		'label'   => esc_html__( 'Color Preset', 'baloch-diamond' ),
		'section' => 'bd_colors_section',
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
	$wp_customize->add_setting( 'bd_primary_color', array(
		'default'           => '#38bdf8',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_primary_color',
		array(
			'label'       => esc_html__( 'Primary Color', 'baloch-diamond' ),
			'description' => esc_html__( 'Used for buttons, links, and accents.', 'baloch-diamond' ),
			'section'     => 'bd_colors_section',
		)
	) );

	// Secondary Color
	$wp_customize->add_setting( 'bd_secondary_color', array(
		'default'           => '#f97316',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_secondary_color',
		array(
			'label'       => esc_html__( 'Secondary Color', 'baloch-diamond' ),
			'description' => esc_html__( 'Used for hover states and highlights.', 'baloch-diamond' ),
			'section'     => 'bd_colors_section',
		)
	) );

	// Text Shadow Color for Slider
	$wp_customize->add_setting( 'bd_slider_shadow_color', array(
		'default'           => 'rgba(0,0,0,0.5)',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_slider_shadow_color',
		array(
			'label'       => esc_html__( 'Slider Text Shadow Color', 'baloch-diamond' ),
			'description' => esc_html__( 'Pick a custom shadow color for the main hero slider titles.', 'baloch-diamond' ),
			'section'     => 'bd_colors_section',
		)
	) );

	// --- BALOCHI EMBROIDERY DECORATION ---
	$wp_customize->add_setting( 'bd_embroidery_enable', array(
		'default'           => false,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_embroidery_enable', array(
		'label'       => esc_html__( 'Enable Balochi Embroidery Decoration', 'baloch-diamond' ),
		'description' => esc_html__( 'Decorates every gradient line, bar, and button across the site (buttons, dividers, badges, dark-mode toggle, pagination, etc.) with a traditional Baloch needlework stitch pattern.', 'baloch-diamond' ),
		'section'     => 'bd_colors_section',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_embroidery_thread_1', array(
		'default'           => '#fde68a',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_embroidery_thread_1',
		array(
			'label'       => esc_html__( 'Embroidery Thread Color 1', 'baloch-diamond' ),
			'description' => esc_html__( 'Primary stitch/thread color (used for the dashed running-stitch line).', 'baloch-diamond' ),
			'section'     => 'bd_colors_section',
		)
	) );

	$wp_customize->add_setting( 'bd_embroidery_thread_2', array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_embroidery_thread_2',
		array(
			'label'       => esc_html__( 'Embroidery Thread Color 2', 'baloch-diamond' ),
			'description' => esc_html__( 'Secondary stitch color (used for the small diamond motifs).', 'baloch-diamond' ),
			'section'     => 'bd_colors_section',
		)
	) );

	// ================================================
	// SECTION 1.5: TYPOGRAPHY
	// ================================================
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
		'label'   => esc_html__( 'Primary Font (Body Text)', 'baloch-diamond' ),
		'section' => 'bd_typography_section',
		'type'    => 'select',
		'choices' => array(
			'Poppins'   => 'Poppins (Modern Sans-Serif)',
			'Roboto'    => 'Roboto (Clean Sans-Serif)',
			'Inter'     => 'Inter (Minimalist Sans-Serif)',
			'Montserrat'=> 'Montserrat (Geometric Sans-Serif)',
			'Lora'      => 'Lora (Elegant Serif)',
			'OpenSans'  => 'Open Sans (Universal)',
			'Nunito'    => 'Nunito (Friendly Sans)',
			'Rubik'     => 'Rubik (Modern Rounded)',
			'WorkSans'  => 'Work Sans (Clean Professional)',
			'DM Sans'   => 'DM Sans (Versatile Sans)',
			'Outfit'    => 'Outfit (Clean Geometric)',
			'custom'    => esc_html__( 'Custom Upload (see below)', 'baloch-diamond' ),
		),
	) );

	// Custom Primary Font Upload
	$wp_customize->add_setting( 'bd_custom_primary_font', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Upload_Control(
		$wp_customize,
		'bd_custom_primary_font',
		array(
			'label'       => esc_html__( 'Upload Custom Primary Font', 'baloch-diamond' ),
			'description' => esc_html__( 'Upload a .woff2 file for body text. Select "Custom Upload" above to use.', 'baloch-diamond' ),
			'section'     => 'bd_typography_section',
		)
	) );

	// Heading Font
	$wp_customize->add_setting( 'bd_heading_font', array(
		'default'           => 'Playfair Display',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_heading_font', array(
		'label'   => esc_html__( 'Heading Font', 'baloch-diamond' ),
		'section' => 'bd_typography_section',
		'type'    => 'select',
		'choices' => array(
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
	$wp_customize->add_setting( 'bd_custom_heading_font', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Upload_Control(
		$wp_customize,
		'bd_custom_heading_font',
		array(
			'label'       => esc_html__( 'Upload Custom Heading Font', 'baloch-diamond' ),
			'description' => esc_html__( 'Upload a .woff2 file for headings. Select "Custom Upload" above to use.', 'baloch-diamond' ),
			'section'     => 'bd_typography_section',
		)
	) );

	// RTL Font (Persian & Balochi)
	$wp_customize->add_setting( 'bd_rtl_font', array(
		'default'           => 'Vazirmatn',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_rtl_font', array(
		'label'       => esc_html__( 'RTL Font (Persian / Arabic / Balochi)', 'baloch-diamond' ),
		'description' => esc_html__( 'Select the font family for Persian, Balochi, Arabic, and other Right-to-Left (RTL) scripts.', 'baloch-diamond' ),
		'section'     => 'bd_typography_section',
		'type'        => 'select',
		'choices'     => array(
			'Vazirmatn'      => 'Vazirmatn (Recommended for Persian)',
			'Cairo'          => 'Cairo (Modern Geometric)',
			'Tajawal'        => 'Tajawal (Clean & Elegant)',
			'Amiri'          => 'Amiri (Traditional Naskh)',
			'NotoSansArabic' => 'Noto Sans Arabic',
			'Almarai'        => 'Almarai (Popular Arabic)',
			'system'         => 'System default (No web font)',
			'custom'         => esc_html__( 'Custom Upload (see below)', 'baloch-diamond' ),
		),
	) );

	// Custom RTL Font Upload (for Persian/Arabic)
	$wp_customize->add_setting( 'bd_custom_rtl_font', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Upload_Control(
		$wp_customize,
		'bd_custom_rtl_font',
		array(
			'label'       => esc_html__( 'Upload Custom RTL Font', 'baloch-diamond' ),
			'description' => esc_html__( 'Upload your custom font file (recommended: .woff2). Only works if "Custom Upload" is selected above.', 'baloch-diamond' ),
			'section'     => 'bd_typography_section',
		)
	) );

	// ================================================
	// SECTION 1.6: ADVANCED FEATURES
	// ================================================
	$wp_customize->add_section( 'bd_advanced_section', array(
		'title'    => esc_html__( '🚀 Advanced Core Features', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 13,
	) );

	// Animated backgrounds
	$wp_customize->add_setting( 'bd_animated_patterns', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_animated_patterns', array(
		'label'       => esc_html__( 'Enable Animated Needlework Patterns', 'baloch-diamond' ),
		'description' => esc_html__( 'Check to activate slow, elegant stitch background scroll animations.', 'baloch-diamond' ),
		'section'     => 'bd_advanced_section',
		'type'        => 'checkbox',
	) );

	// Skeleton Loading
	$wp_customize->add_setting( 'bd_skeleton_loading', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_skeleton_loading', array(
		'label'       => esc_html__( 'Enable Skeleton Shimmer Loading', 'baloch-diamond' ),
		'description' => esc_html__( 'Simulate highly optimized content block transitions on slow networks.', 'baloch-diamond' ),
		'section'     => 'bd_advanced_section',
		'type'        => 'checkbox',
	) );

	// ================================================
	// SECTION 2: HEADER
	// ================================================
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
			'image'    => esc_html__( 'Custom Image', 'baloch-diamond' ),
		),
	) );

	// Header Background Image (for 'image' type)
	$wp_customize->add_setting( 'bd_header_bg_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'bd_header_bg_image',
		array(
			'label'       => esc_html__( 'Header Background Image', 'baloch-diamond' ),
			'description' => esc_html__( 'Used when "Custom Image" is selected above.', 'baloch-diamond' ),
			'section'     => 'bd_header_section',
		)
	) );

	// Header Background Image Overlay (darkens/tints the image so text stays readable)
	$wp_customize->add_setting( 'bd_header_bg_image_overlay', array(
		'default'           => 'rgba(0,0,0,0.35)',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_header_bg_image_overlay',
		array(
			'label'       => esc_html__( 'Header Image Overlay Color', 'baloch-diamond' ),
			'description' => esc_html__( 'A semi-transparent tint placed over the header image to keep the logo/menu readable.', 'baloch-diamond' ),
			'section'     => 'bd_header_section',
		)
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
			'0deg'   => esc_html__( 'Top to Bottom', 'baloch-diamond' ),
			'90deg'  => esc_html__( 'Left to Right', 'baloch-diamond' ),
			'135deg' => esc_html__( 'Diagonal (↘)', 'baloch-diamond' ),
			'180deg' => esc_html__( 'Bottom to Top', 'baloch-diamond' ),
			'270deg' => esc_html__( 'Right to Left', 'baloch-diamond' ),
			'315deg' => esc_html__( 'Diagonal (↗)', 'baloch-diamond' ),
		),
	) );

	// ================================================
	// SECTION 3: HERO SLIDER
	// ================================================
	$wp_customize->add_section( 'bd_slider_section', array(
		'title'    => esc_html__( '🖼️ Hero Slider', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 20,
	) );


	// Slider Height
	$wp_customize->add_setting( 'bd_slider_height', array(
		'default'           => '55vh',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_slider_height', array(
		'label'       => esc_html__( 'Slider Height', 'baloch-diamond' ),
		'description' => esc_html__( 'Choose a preset height for the hero slider (responsive and easy to use).', 'baloch-diamond' ),
		'section'     => 'bd_slider_section',
		'type'        => 'select',
		'choices'     => array(
			'120px' => esc_html__( 'Tiny — 120px',             'baloch-diamond' ),
			'180px' => esc_html__( 'Very Small — 180px',       'baloch-diamond' ),
			'240px' => esc_html__( 'Small Fixed — 240px',      'baloch-diamond' ),
			'300px' => esc_html__( 'Compact — 300px',          'baloch-diamond' ),
			'360px' => esc_html__( 'Narrow — 360px',           'baloch-diamond' ),
			'20vh'  => esc_html__( 'Slim — 20% of screen',     'baloch-diamond' ),
			'25vh'  => esc_html__( 'Short — 25% of screen',    'baloch-diamond' ),
			'30vh'  => esc_html__( 'Mini — 30% of screen',     'baloch-diamond' ),
			'35vh'  => esc_html__( 'Small — 35% of screen',    'baloch-diamond' ),
			'40vh'  => esc_html__( 'Medium-Small — 40% of screen', 'baloch-diamond' ),
			'50vh'  => esc_html__( 'Medium — 50% of screen',   'baloch-diamond' ),
			'55vh'  => esc_html__( 'Default — 55% of screen',  'baloch-diamond' ),
			'65vh'  => esc_html__( 'Large — 65% of screen',    'baloch-diamond' ),
			'75vh'  => esc_html__( 'Extra Large — 75% of screen', 'baloch-diamond' ),
			'100vh' => esc_html__( 'Full Screen — 100% of screen', 'baloch-diamond' ),
			'400px' => esc_html__( 'Fixed — 400 pixels',       'baloch-diamond' ),
			'500px' => esc_html__( 'Fixed — 500 pixels',       'baloch-diamond' ),
			'600px' => esc_html__( 'Fixed — 600 pixels',       'baloch-diamond' ),
			'700px' => esc_html__( 'Fixed — 700 pixels',       'baloch-diamond' ),
		),
	) );

	// ---- Text Overlay (the color band under slide titles) ----
	$wp_customize->add_setting( 'bd_slider_overlay_color', array(
		'default'           => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_slider_overlay_color',
		array(
			'label'       => esc_html__( '🎨 Text Overlay Color', 'baloch-diamond' ),
			'description' => esc_html__( 'The gradient color behind the slide title/excerpt. Default is black; try your brand color for a tinted look.', 'baloch-diamond' ),
			'section'     => 'bd_slider_section',
		)
	) );

	$wp_customize->add_setting( 'bd_slider_overlay_opacity', array(
		'default'           => 80,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bd_slider_overlay_opacity', array(
		'label'       => esc_html__( '🌫️ Text Overlay Strength (%)', 'baloch-diamond' ),
		'description' => esc_html__( '0 = fully transparent (no band at all), 100 = solid color. Default 80. Fine-tune freely — the title text shadow keeps text readable at low values.', 'baloch-diamond' ),
		'section'     => 'bd_slider_section',
		'type'        => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 5,
		),
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

	// Custom Slider Posts — dropdown of published posts + pages
	for ( $i = 1; $i <= 7; $i++ ) {
		$wp_customize->add_setting( "bd_slider_post_{$i}", array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		) );

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
				$label .= ' ★';
			}
			$type_label                = ( $post->post_type === 'page' ) ? esc_html__( ' (Page)', 'baloch-diamond' ) : '';
			$posts_choices[ $post->ID ] = $label . $type_label;
		}

		$wp_customize->add_control( "bd_slider_post_{$i}", array(
			'label'       => sprintf(
				/* translators: %d: Slide number */
				esc_html__( 'Slide %d — Choose Post/Page', 'baloch-diamond' ),
				$i
			),
			'description' => esc_html__( 'Select any published post or page. Posts with featured images are preferred. ★ means it has an image.', 'baloch-diamond' ),
			'section'     => 'bd_slider_section',
			'type'        => 'select',
			'choices'     => $posts_choices,
		) );
	}

	// ================================================
	// SECTION 3.5: SHOP SHOWCASE (WOOCOMMERCE)
	// ================================================
	$wp_customize->add_section( 'bd_shop_section', array(
		'title'    => esc_html__( '🛍️ Shop Showcase (WooCommerce)', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 21,
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
		'label'       => esc_html__( 'Product Display Style', 'baloch-diamond' ),
		'section'     => 'bd_shop_section',
		'type'        => 'select',
		'choices'     => array(
			'grid'              => esc_html__( 'Grid Layout (Cards)', 'baloch-diamond' ),
			'horizontal-scroll' => esc_html__( 'Horizontal Scrollable Slider (RTL / LTR friendly)', 'baloch-diamond' ),
			'single-big'        => esc_html__( 'Single Large Card + Navigation Buttons', 'baloch-diamond' ),
		),
		'description' => esc_html__( 'Choose the main display. All layouts pull real product data (image, price, discount, rating).', 'baloch-diamond' ),
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
		'label'       => esc_html__( 'Number of Products to Show', 'baloch-diamond' ),
		'section'     => 'bd_shop_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 1, 'max' => 12 ),
	) );

	// Dynamic Product Selection (up to 12 cards)
	$product_choices = array( 0 => esc_html__( '— None / Empty —', 'baloch-diamond' ) );
	if ( class_exists( 'WooCommerce' ) ) {
		$products = wc_get_products( array( 'limit' => 80, 'status' => 'publish' ) );
		foreach ( $products as $product ) {
			$product_choices[ $product->get_id() ] = $product->get_name() . ' (' . $product->get_price_html() . ')';
		}
	}

	for ( $i = 1; $i <= 12; $i++ ) {
		$wp_customize->add_setting( "bd_shop_custom_product_{$i}", array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( "bd_shop_custom_product_{$i}", array(
			'label'       => sprintf( esc_html__( 'Custom Product %d', 'baloch-diamond' ), $i ),
			'description' => esc_html__( 'Select a product for this card position.', 'baloch-diamond' ),
			'section'     => 'bd_shop_section',
			'type'        => 'select',
			'choices'     => $product_choices,
		) );
	}

	// ================================================
	// SECTION 4: BLOG
	// ================================================
	$wp_customize->add_section( 'bd_blog_section', array(
		'title'    => esc_html__( '📝 Blog Section', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 30,
	) );

	bd_add_section_header_controls( $wp_customize, 'blog', 'bd_blog_section', array(
		'badge' => esc_html__( 'Latest Insights', 'baloch-diamond' ),
		'title' => esc_html__( 'From the Studio', 'baloch-diamond' ),
		'desc'  => esc_html__( 'Stories, tutorials, and inspiration from the world of Balochi art and modern design.', 'baloch-diamond' ),
	) );

	// Show / Hide Blog Badge
	$wp_customize->add_setting( 'bd_blog_show_badge', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_blog_show_badge', array(
		'label'   => esc_html__( 'Show Section Badge', 'baloch-diamond' ),
		'section' => 'bd_blog_section',
		'type'    => 'checkbox',
	) );

	// Show / Hide Blog Section Title
	$wp_customize->add_setting( 'bd_blog_show_title', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_blog_show_title', array(
		'label'   => esc_html__( 'Show Section Title', 'baloch-diamond' ),
		'section' => 'bd_blog_section',
		'type'    => 'checkbox',
	) );

	// Note: Post count is read from WordPress Settings → Reading → "Blog pages show at most"
	// No separate Customizer control needed — uses get_option( 'posts_per_page' ).

	// Read More button text
	$wp_customize->add_setting( 'bd_blog_readmore_text', array(
		'default'           => esc_html__( 'Read More', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_blog_readmore_text', array(
		'label'   => esc_html__( '"Read More" Button Text', 'baloch-diamond' ),
		'section' => 'bd_blog_section',
		'type'    => 'text',
	) );

	// --- Hide/Show individual elements ---

	$wp_customize->add_setting( 'bd_blog_show_thumbnail', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_blog_show_thumbnail', array(
		'label'   => esc_html__( 'Show Featured Image', 'baloch-diamond' ),
		'section' => 'bd_blog_section',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_blog_show_date_badge', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_blog_show_date_badge', array(
		'label'   => esc_html__( 'Show Date Badge on Image', 'baloch-diamond' ),
		'section' => 'bd_blog_section',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_blog_show_author', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_blog_show_author', array(
		'label'   => esc_html__( 'Show Author Name', 'baloch-diamond' ),
		'section' => 'bd_blog_section',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_blog_show_comments', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_blog_show_comments', array(
		'label'   => esc_html__( 'Show Comment Count', 'baloch-diamond' ),
		'section' => 'bd_blog_section',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_blog_show_category', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_blog_show_category', array(
		'label'   => esc_html__( 'Show Category Badge', 'baloch-diamond' ),
		'section' => 'bd_blog_section',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_blog_show_excerpt', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_blog_show_excerpt', array(
		'label'   => esc_html__( 'Show Post Excerpt', 'baloch-diamond' ),
		'section' => 'bd_blog_section',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_blog_show_readmore', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_blog_show_readmore', array(
		'label'   => esc_html__( 'Show "Read More" Button', 'baloch-diamond' ),
		'section' => 'bd_blog_section',
		'type'    => 'checkbox',
	) );

	// --- Blog Pagination Mode ---
	$wp_customize->add_setting( 'bd_blog_pagination_mode', array(
		'default'           => 'numbered',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_blog_pagination_mode', array(
		'label'       => esc_html__( '📊 Blog Pagination Mode', 'baloch-diamond' ),
		'description' => esc_html__( 'Choose how visitors browse more posts in the blog section. "Numbered" is the standard WordPress way and needs no extra page — older posts are reachable at /page/2/, /page/3/ and so on.', 'baloch-diamond' ),
		'section'     => 'bd_blog_section',
		'type'        => 'select',
		'choices'     => array(
			'numbered'     => esc_html__( '🔢 Numbered — Standard WordPress pagination on the front page (no extra page needed)', 'baloch-diamond' ),
			'archive_link' => esc_html__( '🔗 Archive Link — Button links to the blog archive page (requires a Posts page in Settings → Reading)', 'baloch-diamond' ),
			'load_more'    => esc_html__( '⚡ Load More — AJAX button loads more posts inline (no page refresh)', 'baloch-diamond' ),
		),
	) );

	// --- Show "View All Posts" Link ---
	// Uses the SAME key as the original theme (bd_blog_show_viewall) for backward compat.
	$wp_customize->add_setting( 'bd_blog_show_viewall', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_blog_show_viewall', array(
		'label'       => esc_html__( 'Show "View All Posts" Link', 'baloch-diamond' ),
		'description' => esc_html__( 'Links to the blog archive page. Go to Settings → Reading and set a "Posts page" to configure the blog URL. A "Blog" page is created automatically on theme activation.', 'baloch-diamond' ),
		'section'     => 'bd_blog_section',
		'type'        => 'checkbox',
	) );

	// --- "View All Posts" Link Text ---
	// Uses the SAME key as the original theme (bd_blog_viewall_text) for backward compat.
	$wp_customize->add_setting( 'bd_blog_viewall_text', array(
		'default'           => esc_html__( 'View All Posts', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_blog_viewall_text', array(
		'label'   => esc_html__( '"View All Posts" Link Text', 'baloch-diamond' ),
		'section' => 'bd_blog_section',
		'type'    => 'text',
	) );

	// --- Load More Settings ---
	// Note: Posts per load uses WordPress Settings → Reading → "Blog pages show at most"
	// No separate control needed — uses get_option( 'posts_per_page' ).

	$wp_customize->add_setting( 'bd_blog_loadmore_text', array(
		'default'           => esc_html__( 'Load More Posts', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_blog_loadmore_text', array(
		'label'       => esc_html__( '"Load More" Button Text', 'baloch-diamond' ),
		'section'     => 'bd_blog_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'bd_blog_loadmore_loading_text', array(
		'default'           => esc_html__( 'Loading...', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_blog_loadmore_loading_text', array(
		'label'   => esc_html__( '"Loading" Text', 'baloch-diamond' ),
		'section' => 'bd_blog_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'bd_blog_loadmore_nomore_text', array(
		'default'           => esc_html__( 'No more posts to show', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_blog_loadmore_nomore_text', array(
		'label'       => esc_html__( '"No More Posts" Message', 'baloch-diamond' ),
		'description' => esc_html__( 'Shown when all posts are loaded. An archive link appears below.', 'baloch-diamond' ),
		'section'     => 'bd_blog_section',
		'type'        => 'text',
	) );

	// ================================================
	// SECTION 5: PORTFOLIO — STANDALONE FULL CUSTOMIZATION
	// ================================================
	$wp_customize->add_section( 'bd_portfolio_section', array(
		'title'    => esc_html__( '🖼️ Portfolio Section', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 35,
	) );


	// Section Header Controls
	bd_add_section_header_controls( $wp_customize, 'portfolio', 'bd_portfolio_section', array(
		'badge' => esc_html__( 'Our Work', 'baloch-diamond' ),
		'title' => esc_html__( 'Masterpieces & Projects', 'baloch-diamond' ),
		'desc'  => esc_html__( 'A curated selection of our finest handcrafted work and creative collaborations.', 'baloch-diamond' ),
	) );

	// Layout Style
	$wp_customize->add_setting( 'bd_portfolio_layout', array(
		'default'           => 'grid',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_portfolio_layout', array(
		'label'   => esc_html__( 'Layout Style', 'baloch-diamond' ),
		'section' => 'bd_portfolio_section',
		'type'    => 'select',
		'choices' => array(
			'grid'    => esc_html__( 'Grid (Cards)', 'baloch-diamond' ),
			'masonry' => esc_html__( 'Masonry (Pinterest-style)', 'baloch-diamond' ),
			'slider'  => esc_html__( 'Horizontal Slider', 'baloch-diamond' ),
		),
	) );

	// Columns
	$wp_customize->add_setting( 'bd_portfolio_columns', array(
		'default'           => '3',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_portfolio_columns', array(
		'label'   => esc_html__( 'Grid Columns', 'baloch-diamond' ),
		'section' => 'bd_portfolio_section',
		'type'    => 'select',
		'choices' => array(
			'2' => esc_html__( '2 Columns', 'baloch-diamond' ),
			'3' => esc_html__( '3 Columns (Default)', 'baloch-diamond' ),
			'4' => esc_html__( '4 Columns', 'baloch-diamond' ),
		),
	) );

	// Number of projects
	$wp_customize->add_setting( 'bd_portfolio_count', array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bd_portfolio_count', array(
		'label'       => esc_html__( 'Number of Projects to Show', 'baloch-diamond' ),
		'section'     => 'bd_portfolio_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 1, 'max' => 12 ),
	) );

	// Filter Tabs
	$wp_customize->add_setting( 'bd_portfolio_show_filter', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_portfolio_show_filter', array(
		'label'       => esc_html__( 'Show Category Filter Tabs', 'baloch-diamond' ),
		'description' => esc_html__( 'Display filter tabs to let visitors filter projects by category.', 'baloch-diamond' ),
		'section'     => 'bd_portfolio_section',
		'type'        => 'checkbox',
	) );

	// Show Overlay Effect
	$wp_customize->add_setting( 'bd_portfolio_overlay', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_portfolio_overlay', array(
		'label'       => esc_html__( 'Show Hover Overlay on Cards', 'baloch-diamond' ),
		'description' => esc_html__( 'Show title/category overlay on card hover.', 'baloch-diamond' ),
		'section'     => 'bd_portfolio_section',
		'type'        => 'checkbox',
	) );

	// Show View All Button
	$wp_customize->add_setting( 'bd_portfolio_show_viewall', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_portfolio_show_viewall', array(
		'label'   => esc_html__( 'Show "View All" Button', 'baloch-diamond' ),
		'section' => 'bd_portfolio_section',
		'type'    => 'checkbox',
	) );

	// View All Button Text
	$wp_customize->add_setting( 'bd_portfolio_viewall_text', array(
		'default'           => esc_html__( 'View All Projects', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_portfolio_viewall_text', array(
		'label'   => esc_html__( '"View All" Button Text', 'baloch-diamond' ),
		'section' => 'bd_portfolio_section',
		'type'    => 'text',
	) );

	// View All Button URL
	$wp_customize->add_setting( 'bd_portfolio_viewall_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'bd_portfolio_viewall_url', array(
		'label'       => esc_html__( '"View All" Button URL', 'baloch-diamond' ),
		'description' => esc_html__( 'Link for the View All button. Leave empty to use the portfolio page URL.', 'baloch-diamond' ),
		'section'     => 'bd_portfolio_section',
		'type'        => 'url',
	) );

	// Background Color
	$wp_customize->add_setting( 'bd_portfolio_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_portfolio_bg_color',
		array(
			'label'       => esc_html__( 'Section Background Color', 'baloch-diamond' ),
			'description' => esc_html__( 'Custom background color for the portfolio section. Leave empty to use the theme default.', 'baloch-diamond' ),
			'section'     => 'bd_portfolio_section',
		)
	) );

	// Card Style
	$wp_customize->add_setting( 'bd_portfolio_card_style', array(
		'default'           => 'shadow',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_portfolio_card_style', array(
		'label'   => esc_html__( 'Card Style', 'baloch-diamond' ),
		'section' => 'bd_portfolio_section',
		'type'    => 'select',
		'choices' => array(
			'shadow'   => esc_html__( 'Shadow Card (Elevated)', 'baloch-diamond' ),
			'bordered' => esc_html__( 'Bordered Card', 'baloch-diamond' ),
			'flat'     => esc_html__( 'Flat (No border/shadow)', 'baloch-diamond' ),
			'glass'    => esc_html__( 'Glass Effect', 'baloch-diamond' ),
		),
	) );

	// Image Aspect Ratio
	$wp_customize->add_setting( 'bd_portfolio_aspect_ratio', array(
		'default'           => '4/3',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_portfolio_aspect_ratio', array(
		'label'   => esc_html__( 'Image Aspect Ratio', 'baloch-diamond' ),
		'section' => 'bd_portfolio_section',
		'type'    => 'select',
		'choices' => array(
			'1/1'  => esc_html__( 'Square (1:1)', 'baloch-diamond' ),
			'4/3'  => esc_html__( 'Landscape (4:3) — Default', 'baloch-diamond' ),
			'16/9' => esc_html__( 'Widescreen (16:9)', 'baloch-diamond' ),
			'3/4'  => esc_html__( 'Portrait (3:4)', 'baloch-diamond' ),
		),
	) );

	// Show Project Title on Card
	$wp_customize->add_setting( 'bd_portfolio_show_title', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_portfolio_show_title', array(
		'label'   => esc_html__( 'Show Project Title on Card', 'baloch-diamond' ),
		'section' => 'bd_portfolio_section',
		'type'    => 'checkbox',
	) );

	// Show Project Category on Card
	$wp_customize->add_setting( 'bd_portfolio_show_category', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_portfolio_show_category', array(
		'label'   => esc_html__( 'Show Project Category/Tag on Card', 'baloch-diamond' ),
		'section' => 'bd_portfolio_section',
		'type'    => 'checkbox',
	) );

	// Show Project Excerpt
	$wp_customize->add_setting( 'bd_portfolio_show_excerpt', array(
		'default'           => false,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_portfolio_show_excerpt', array(
		'label'   => esc_html__( 'Show Project Excerpt/Description', 'baloch-diamond' ),
		'section' => 'bd_portfolio_section',
		'type'    => 'checkbox',
	) );

	// ---- Portfolio content source ----
	// Default: admin-defined custom items (standalone)
	// Optional: pull from WordPress posts
	$wp_customize->add_setting( 'bd_portfolio_source', array(
		'default'           => 'custom',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_portfolio_source', array(
		'label'       => esc_html__( 'Portfolio Content Source', 'baloch-diamond' ),
		'description' => esc_html__( 'Choose "Custom Items (Standalone)" to define your own projects below — fully independent of WordPress posts. Choose "WordPress Posts" only if you want to pull published posts automatically.', 'baloch-diamond' ),
		'section'     => 'bd_portfolio_section',
		'type'        => 'select',
		'choices'     => array(
			'custom' => esc_html__( '✅ Custom Items — Defined Below (Standalone, Recommended)', 'baloch-diamond' ),
			'posts'  => esc_html__( 'WordPress Posts (auto-pull published posts with featured image)', 'baloch-diamond' ),
		),
	) );

	// ---- Portfolio items (up to 12 standalone items) ----
	for ( $i = 1; $i <= 12; $i++ ) {
		// Item Title
		$wp_customize->add_setting( "bd_portfolio_item_{$i}_title", array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "bd_portfolio_item_{$i}_title", array(
			'label'   => sprintf( esc_html__( 'Item %d — Title', 'baloch-diamond' ), $i ),
			'section' => 'bd_portfolio_section',
			'type'    => 'text',
		) );

		// Item Category
		$wp_customize->add_setting( "bd_portfolio_item_{$i}_category", array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "bd_portfolio_item_{$i}_category", array(
			'label'   => sprintf( esc_html__( 'Item %d — Category / Tag', 'baloch-diamond' ), $i ),
			'section' => 'bd_portfolio_section',
			'type'    => 'text',
		) );

		// Item Description
		$wp_customize->add_setting( "bd_portfolio_item_{$i}_desc", array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		) );
		$wp_customize->add_control( "bd_portfolio_item_{$i}_desc", array(
			'label'   => sprintf( esc_html__( 'Item %d — Short Description', 'baloch-diamond' ), $i ),
			'section' => 'bd_portfolio_section',
			'type'    => 'textarea',
		) );

		// Item Image
		$wp_customize->add_setting( "bd_portfolio_item_{$i}_image", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			"bd_portfolio_item_{$i}_image",
			array(
				'label'   => sprintf( esc_html__( 'Item %d — Image', 'baloch-diamond' ), $i ),
				'section' => 'bd_portfolio_section',
			)
		) );

		// Item Link
		$wp_customize->add_setting( "bd_portfolio_item_{$i}_link", array(
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( "bd_portfolio_item_{$i}_link", array(
			'label'   => sprintf( esc_html__( 'Item %d — Link URL', 'baloch-diamond' ), $i ),
			'section' => 'bd_portfolio_section',
			'type'    => 'url',
		) );

		// Item Open in New Tab
		$wp_customize->add_setting( "bd_portfolio_item_{$i}_newtab", array(
			'default'           => false,
			'sanitize_callback' => 'bd_sanitize_checkbox',
		) );
		$wp_customize->add_control( "bd_portfolio_item_{$i}_newtab", array(
			'label'   => sprintf( esc_html__( 'Item %d — Open Link in New Tab', 'baloch-diamond' ), $i ),
			'section' => 'bd_portfolio_section',
			'type'    => 'checkbox',
		) );
	}

	// ================================================
	// SECTION 6: TEAM — STANDALONE FULL CUSTOMIZATION
	// ================================================
	$wp_customize->add_section( 'bd_team_section', array(
		'title'    => esc_html__( '👥 Team Section', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 40,
	) );


	// Section Header Controls
	bd_add_section_header_controls( $wp_customize, 'team', 'bd_team_section', array(
		'badge' => esc_html__( 'The Artisans', 'baloch-diamond' ),
		'title' => esc_html__( 'Meet Our Masters', 'baloch-diamond' ),
		'desc'  => esc_html__( 'Talented craftspeople and designers behind every stitch and creation.', 'baloch-diamond' ),
	) );

	// Layout Style
	$wp_customize->add_setting( 'bd_team_layout', array(
		'default'           => 'grid',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_team_layout', array(
		'label'   => esc_html__( 'Layout Style', 'baloch-diamond' ),
		'section' => 'bd_team_section',
		'type'    => 'select',
		'choices' => array(
			'grid'   => esc_html__( 'Grid Cards', 'baloch-diamond' ),
			'slider' => esc_html__( 'Horizontal Slider', 'baloch-diamond' ),
			'list'   => esc_html__( 'List (Photo + Info)', 'baloch-diamond' ),
		),
	) );

	// Columns
	$wp_customize->add_setting( 'bd_team_columns', array(
		'default'           => '3',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_team_columns', array(
		'label'   => esc_html__( 'Grid Columns', 'baloch-diamond' ),
		'section' => 'bd_team_section',
		'type'    => 'select',
		'choices' => array(
			'2' => esc_html__( '2 Columns', 'baloch-diamond' ),
			'3' => esc_html__( '3 Columns (Default)', 'baloch-diamond' ),
			'4' => esc_html__( '4 Columns', 'baloch-diamond' ),
		),
	) );

	// Card Style
	$wp_customize->add_setting( 'bd_team_card_style', array(
		'default'           => 'shadow',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_team_card_style', array(
		'label'   => esc_html__( 'Card Style', 'baloch-diamond' ),
		'section' => 'bd_team_section',
		'type'    => 'select',
		'choices' => array(
			'shadow'   => esc_html__( 'Shadow Card (Elevated)', 'baloch-diamond' ),
			'bordered' => esc_html__( 'Bordered Card', 'baloch-diamond' ),
			'flat'     => esc_html__( 'Flat (Minimal)', 'baloch-diamond' ),
			'glass'    => esc_html__( 'Glass Effect', 'baloch-diamond' ),
		),
	) );

	// Photo Shape
	$wp_customize->add_setting( 'bd_team_photo_shape', array(
		'default'           => 'circle',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_team_photo_shape', array(
		'label'   => esc_html__( 'Photo Shape', 'baloch-diamond' ),
		'section' => 'bd_team_section',
		'type'    => 'select',
		'choices' => array(
			'circle'  => esc_html__( 'Circle', 'baloch-diamond' ),
			'square'  => esc_html__( 'Square', 'baloch-diamond' ),
			'rounded' => esc_html__( 'Rounded Rectangle', 'baloch-diamond' ),
		),
	) );

	// Show Role/Position
	$wp_customize->add_setting( 'bd_team_show_role', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_team_show_role', array(
		'label'   => esc_html__( 'Show Role / Position', 'baloch-diamond' ),
		'section' => 'bd_team_section',
		'type'    => 'checkbox',
	) );

	// Show Bio
	$wp_customize->add_setting( 'bd_team_show_bio', array(
		'default'           => false,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_team_show_bio', array(
		'label'   => esc_html__( 'Show Short Bio', 'baloch-diamond' ),
		'section' => 'bd_team_section',
		'type'    => 'checkbox',
	) );

	// Show Social Links
	$wp_customize->add_setting( 'bd_team_show_social', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_team_show_social', array(
		'label'   => esc_html__( 'Show Social Links on Cards', 'baloch-diamond' ),
		'section' => 'bd_team_section',
		'type'    => 'checkbox',
	) );

	// Background Color
	$wp_customize->add_setting( 'bd_team_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_team_bg_color',
		array(
			'label'       => esc_html__( 'Section Background Color', 'baloch-diamond' ),
			'description' => esc_html__( 'Custom background color for the team section. Leave empty for theme default.', 'baloch-diamond' ),
			'section'     => 'bd_team_section',
		)
	) );

	// Individual Team Members (up to 8)
	for ( $i = 1; $i <= 8; $i++ ) {
		// Name
		$wp_customize->add_setting( "bd_team_member_{$i}_name", array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "bd_team_member_{$i}_name", array(
			'label'   => sprintf( esc_html__( 'Member %d — Name', 'baloch-diamond' ), $i ),
			'section' => 'bd_team_section',
			'type'    => 'text',
		) );

		// Role
		$wp_customize->add_setting( "bd_team_member_{$i}_role", array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "bd_team_member_{$i}_role", array(
			'label'   => sprintf( esc_html__( 'Member %d — Role / Position', 'baloch-diamond' ), $i ),
			'section' => 'bd_team_section',
			'type'    => 'text',
		) );

		// Bio
		$wp_customize->add_setting( "bd_team_member_{$i}_bio", array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		) );
		$wp_customize->add_control( "bd_team_member_{$i}_bio", array(
			'label'   => sprintf( esc_html__( 'Member %d — Short Bio', 'baloch-diamond' ), $i ),
			'section' => 'bd_team_section',
			'type'    => 'textarea',
		) );

		// Photo
		$wp_customize->add_setting( "bd_team_member_{$i}_photo", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			"bd_team_member_{$i}_photo",
			array(
				'label'   => sprintf( esc_html__( 'Member %d — Photo', 'baloch-diamond' ), $i ),
				'section' => 'bd_team_section',
			)
		) );

		// Twitter
		$wp_customize->add_setting( "bd_team_member_{$i}_twitter", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( "bd_team_member_{$i}_twitter", array(
			'label'   => sprintf( esc_html__( 'Member %d — Twitter URL', 'baloch-diamond' ), $i ),
			'section' => 'bd_team_section',
			'type'    => 'url',
		) );

		// LinkedIn
		$wp_customize->add_setting( "bd_team_member_{$i}_linkedin", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( "bd_team_member_{$i}_linkedin", array(
			'label'   => sprintf( esc_html__( 'Member %d — LinkedIn URL', 'baloch-diamond' ), $i ),
			'section' => 'bd_team_section',
			'type'    => 'url',
		) );

		// Instagram
		$wp_customize->add_setting( "bd_team_member_{$i}_instagram", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( "bd_team_member_{$i}_instagram", array(
			'label'   => sprintf( esc_html__( 'Member %d — Instagram URL', 'baloch-diamond' ), $i ),
			'section' => 'bd_team_section',
			'type'    => 'url',
		) );

		// Profile/Portfolio Link
		$wp_customize->add_setting( "bd_team_member_{$i}_link", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( "bd_team_member_{$i}_link", array(
			'label'       => sprintf( esc_html__( 'Member %d — Profile/Portfolio URL', 'baloch-diamond' ), $i ),
			'description' => esc_html__( 'Leave empty to make the card non-clickable.', 'baloch-diamond' ),
			'section'     => 'bd_team_section',
			'type'        => 'url',
		) );
	}

	// ================================================
	// SECTION 7: RESOURCES — FULL CUSTOMIZATION
	// ================================================
	$wp_customize->add_section( 'bd_resources_section', array(
		'title'    => esc_html__( '📚 Resources Section', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 45,
	) );


	// Section Header Controls
	bd_add_section_header_controls( $wp_customize, 'resources', 'bd_resources_section', array(
		'badge' => esc_html__( 'Learn & Grow', 'baloch-diamond' ),
		'title' => esc_html__( 'Free Guides & Downloads', 'baloch-diamond' ),
		'desc'  => esc_html__( 'Free tutorials, templates, and downloadable resources to help you master traditional and modern techniques.', 'baloch-diamond' ),
	) );

	// Layout Style
	$wp_customize->add_setting( 'bd_resources_layout', array(
		'default'           => 'grid',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_resources_layout', array(
		'label'   => esc_html__( 'Layout Style', 'baloch-diamond' ),
		'section' => 'bd_resources_section',
		'type'    => 'select',
		'choices' => array(
			'grid' => esc_html__( 'Grid (Cards)', 'baloch-diamond' ),
			'list' => esc_html__( 'List (Icon + Text)', 'baloch-diamond' ),
		),
	) );

	// Columns
	$wp_customize->add_setting( 'bd_resources_columns', array(
		'default'           => '3',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_resources_columns', array(
		'label'   => esc_html__( 'Grid Columns', 'baloch-diamond' ),
		'section' => 'bd_resources_section',
		'type'    => 'select',
		'choices' => array(
			'2' => esc_html__( '2 Columns', 'baloch-diamond' ),
			'3' => esc_html__( '3 Columns (Default)', 'baloch-diamond' ),
			'4' => esc_html__( '4 Columns', 'baloch-diamond' ),
		),
	) );

	// Background Color
	$wp_customize->add_setting( 'bd_resources_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_resources_bg_color',
		array(
			'label'       => esc_html__( 'Section Background Color', 'baloch-diamond' ),
			'description' => esc_html__( 'Leave empty for theme default.', 'baloch-diamond' ),
			'section'     => 'bd_resources_section',
		)
	) );

	// Show Download Button on Cards
	$wp_customize->add_setting( 'bd_resources_show_btn', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_resources_show_btn', array(
		'label'   => esc_html__( 'Show Download/Link Button on Cards', 'baloch-diamond' ),
		'section' => 'bd_resources_section',
		'type'    => 'checkbox',
	) );

	// Default Button Text
	$wp_customize->add_setting( 'bd_resources_link_text', array(
		'default'           => esc_html__( 'Read Documentation', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_resources_link_text', array(
		'label'       => esc_html__( 'Default Button Text', 'baloch-diamond' ),
		'description' => esc_html__( 'Used as the button label unless overridden per item.', 'baloch-diamond' ),
		'section'     => 'bd_resources_section',
		'type'        => 'text',
	) );

	// Individual Resource Items (up to 10)
	for ( $i = 1; $i <= 10; $i++ ) {
		// Title
		$wp_customize->add_setting( "bd_resource_item_{$i}_title", array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "bd_resource_item_{$i}_title", array(
			'label'   => sprintf( esc_html__( 'Resource %d — Title', 'baloch-diamond' ), $i ),
			'section' => 'bd_resources_section',
			'type'    => 'text',
		) );

		// Description
		$wp_customize->add_setting( "bd_resource_item_{$i}_desc", array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		) );
		$wp_customize->add_control( "bd_resource_item_{$i}_desc", array(
			'label'   => sprintf( esc_html__( 'Resource %d — Description', 'baloch-diamond' ), $i ),
			'section' => 'bd_resources_section',
			'type'    => 'textarea',
		) );

		// Icon
		$wp_customize->add_setting( "bd_resource_item_{$i}_icon", array(
			'default'           => 'book',
			'sanitize_callback' => 'bd_sanitize_select',
		) );
		$wp_customize->add_control( "bd_resource_item_{$i}_icon", array(
			'label'   => sprintf( esc_html__( 'Resource %d — Icon', 'baloch-diamond' ), $i ),
			'section' => 'bd_resources_section',
			'type'    => 'select',
			'choices' => array(
				'book'   => esc_html__( '📖 Book', 'baloch-diamond' ),
				'code'   => esc_html__( '💻 Code', 'baloch-diamond' ),
				'layout' => esc_html__( '🗂️ Layout', 'baloch-diamond' ),
				'shield' => esc_html__( '🛡️ Shield', 'baloch-diamond' ),
				'zap'    => esc_html__( '⚡ Zap', 'baloch-diamond' ),
				'globe'  => esc_html__( '🌐 Globe', 'baloch-diamond' ),
				'cpu'    => esc_html__( '🖥️ CPU', 'baloch-diamond' ),
				'heart'  => esc_html__( '❤️ Heart', 'baloch-diamond' ),
				'star'   => esc_html__( '⭐ Star', 'baloch-diamond' ),
				'file'   => esc_html__( '📄 File', 'baloch-diamond' ),
				'video'  => esc_html__( '🎬 Video', 'baloch-diamond' ),
				'music'  => esc_html__( '🎵 Music', 'baloch-diamond' ),
			),
		) );

		// Link URL
		$wp_customize->add_setting( "bd_resource_item_{$i}_url", array(
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( "bd_resource_item_{$i}_url", array(
			'label'   => sprintf( esc_html__( 'Resource %d — Link URL', 'baloch-diamond' ), $i ),
			'section' => 'bd_resources_section',
			'type'    => 'url',
		) );

		// Button Text Override
		$wp_customize->add_setting( "bd_resource_item_{$i}_btn_text", array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "bd_resource_item_{$i}_btn_text", array(
			'label'       => sprintf( esc_html__( 'Resource %d — Button Text (optional override)', 'baloch-diamond' ), $i ),
			'description' => esc_html__( 'Leave empty to use the default button text above.', 'baloch-diamond' ),
			'section'     => 'bd_resources_section',
			'type'        => 'text',
		) );

		// Open in New Tab
		$wp_customize->add_setting( "bd_resource_item_{$i}_newtab", array(
			'default'           => false,
			'sanitize_callback' => 'bd_sanitize_checkbox',
		) );
		$wp_customize->add_control( "bd_resource_item_{$i}_newtab", array(
			'label'   => sprintf( esc_html__( 'Resource %d — Open in New Tab', 'baloch-diamond' ), $i ),
			'section' => 'bd_resources_section',
			'type'    => 'checkbox',
		) );
	}

	// ================================================
	// SECTION 8: FORUM / COMMUNITY — FULL CUSTOMIZATION WITH BUTTON LINKS + HIDE/SHOW
	// ================================================
	$wp_customize->add_section( 'bd_forum_section', array(
		'title'    => esc_html__( '💬 Community Section', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 50,
	) );


	bd_add_section_header_controls( $wp_customize, 'forum', 'bd_forum_section', array(
		'badge' => esc_html__( 'Join the Circle', 'baloch-diamond' ),
		'title' => esc_html__( 'Community Hub', 'baloch-diamond' ),
		'desc'  => esc_html__( 'Connect with fellow artisans, ask questions, and share your creations.', 'baloch-diamond' ),
	) );

	// Forum Display Mode
	$wp_customize->add_setting( 'bd_forum_mode', array(
		'default'           => 'topics',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_forum_mode', array(
		'label'   => esc_html__( 'Display Mode', 'baloch-diamond' ),
		'section' => 'bd_forum_section',
		'type'    => 'select',
		'choices' => array(
			'topics'     => esc_html__( 'Latest Topics (List)', 'baloch-diamond' ),
			'categories' => esc_html__( 'Forum Categories Grid', 'baloch-diamond' ),
			'featured'   => esc_html__( 'Featured Discussions + Topics', 'baloch-diamond' ),
			'live-stats' => esc_html__( 'Live Stats + Quick Actions', 'baloch-diamond' ),
			'cta'        => esc_html__( 'Call to Action + Statistics', 'baloch-diamond' ),
		),
	) );

	// Number of items
	$wp_customize->add_setting( 'bd_forum_count', array(
		'default'           => 4,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bd_forum_count', array(
		'label'       => esc_html__( 'Number of Topics / Items', 'baloch-diamond' ),
		'section'     => 'bd_forum_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 2, 'max' => 12 ),
	) );

	// Show statistics row
	$wp_customize->add_setting( 'bd_forum_show_stats', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_forum_show_stats', array(
		'label'   => esc_html__( 'Show Community Statistics', 'baloch-diamond' ),
		'section' => 'bd_forum_section',
		'type'    => 'checkbox',
	) );

	// ---- Button 1 (Ask a Question) ----
	$wp_customize->add_setting( 'bd_forum_btn1_show', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_forum_btn1_show', array(
		'label'   => esc_html__( 'Show Button 1', 'baloch-diamond' ),
		'section' => 'bd_forum_section',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_forum_btn_ask', array(
		'default'           => esc_html__( 'Ask a Question', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_forum_btn_ask', array(
		'label'   => esc_html__( 'Button 1 — Text', 'baloch-diamond' ),
		'section' => 'bd_forum_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'bd_forum_btn1_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'bd_forum_btn1_url', array(
		'label'       => esc_html__( 'Button 1 — Link URL', 'baloch-diamond' ),
		'description' => esc_html__( 'Set the URL this button points to. Leave # to use the forum archive link.', 'baloch-diamond' ),
		'section'     => 'bd_forum_section',
		'type'        => 'url',
	) );

	$wp_customize->add_setting( 'bd_forum_btn1_newtab', array(
		'default'           => false,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_forum_btn1_newtab', array(
		'label'   => esc_html__( 'Button 1 — Open in New Tab', 'baloch-diamond' ),
		'section' => 'bd_forum_section',
		'type'    => 'checkbox',
	) );

	// ---- Button 2 (Share Your Pattern) ----
	$wp_customize->add_setting( 'bd_forum_btn2_show', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_forum_btn2_show', array(
		'label'   => esc_html__( 'Show Button 2', 'baloch-diamond' ),
		'section' => 'bd_forum_section',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_forum_btn_share', array(
		'default'           => esc_html__( 'Share Your Pattern', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_forum_btn_share', array(
		'label'   => esc_html__( 'Button 2 — Text', 'baloch-diamond' ),
		'section' => 'bd_forum_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'bd_forum_btn2_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'bd_forum_btn2_url', array(
		'label'       => esc_html__( 'Button 2 — Link URL', 'baloch-diamond' ),
		'section'     => 'bd_forum_section',
		'type'        => 'url',
	) );

	$wp_customize->add_setting( 'bd_forum_btn2_newtab', array(
		'default'           => false,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_forum_btn2_newtab', array(
		'label'   => esc_html__( 'Button 2 — Open in New Tab', 'baloch-diamond' ),
		'section' => 'bd_forum_section',
		'type'    => 'checkbox',
	) );

	// ---- Button 3 (Join Workshop) ----
	$wp_customize->add_setting( 'bd_forum_btn3_show', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_forum_btn3_show', array(
		'label'   => esc_html__( 'Show Button 3', 'baloch-diamond' ),
		'section' => 'bd_forum_section',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_forum_btn_workshop', array(
		'default'           => esc_html__( 'Join Workshop', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_forum_btn_workshop', array(
		'label'   => esc_html__( 'Button 3 — Text', 'baloch-diamond' ),
		'section' => 'bd_forum_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'bd_forum_btn3_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'bd_forum_btn3_url', array(
		'label'       => esc_html__( 'Button 3 — Link URL', 'baloch-diamond' ),
		'section'     => 'bd_forum_section',
		'type'        => 'url',
	) );

	$wp_customize->add_setting( 'bd_forum_btn3_newtab', array(
		'default'           => false,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_forum_btn3_newtab', array(
		'label'   => esc_html__( 'Button 3 — Open in New Tab', 'baloch-diamond' ),
		'section' => 'bd_forum_section',
		'type'    => 'checkbox',
	) );

	// Bottom link text
	$wp_customize->add_setting( 'bd_forum_visit_text', array(
		'default'           => esc_html__( 'Visit Full Community Forums →', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_forum_visit_text', array(
		'label'       => esc_html__( 'Visit Full Forums — Link Text', 'baloch-diamond' ),
		'section'     => 'bd_forum_section',
		'type'        => 'text',
		'description' => esc_html__( 'Text shown at the bottom of most modes to link to full forums.', 'baloch-diamond' ),
	) );

	// Bottom "Visit Forums" link URL
	$wp_customize->add_setting( 'bd_forum_visit_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'bd_forum_visit_url', array(
		'label'       => esc_html__( 'Visit Full Forums — Link URL', 'baloch-diamond' ),
		'description' => esc_html__( 'Leave # to auto-link to bbPress forum archive.', 'baloch-diamond' ),
		'section'     => 'bd_forum_section',
		'type'        => 'url',
	) );

	// ================================================
	// SECTION: MEMBERS / COMMUNITY
	// ================================================
	$wp_customize->add_section( 'bd_members_section', array(
		'title'    => esc_html__( '👥 Community Members', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 52,
	) );

	

	bd_add_section_header_controls( $wp_customize, 'members', 'bd_members_section', array(
		'badge' => esc_html__( 'Join the Circle', 'baloch-diamond' ),
		'title' => esc_html__( 'Our Community', 'baloch-diamond' ),
		'desc'  => esc_html__( 'Meet some of the passionate artisans and creators in our growing community.', 'baloch-diamond' ),
	) );

	$wp_customize->add_setting( 'bd_members_count', array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bd_members_count', array(
		'label'       => esc_html__( 'Number of Members to Show', 'baloch-diamond' ),
		'section'     => 'bd_members_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 3, 'max' => 8 ),
	) );

	// ================================================
	// SECTION 9: NEWSLETTER
	// ================================================
	$wp_customize->add_section( 'bd_newsletter_section', array(
		'title'    => esc_html__( '✉️ Newsletter Section', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 55,
	) );


	bd_add_section_header_controls( $wp_customize, 'newsletter', 'bd_newsletter_section', array(
		'badge' => esc_html__( 'Stay Connected', 'baloch-diamond' ),
		'title' => esc_html__( 'Join Our Circle', 'baloch-diamond' ),
		'desc'  => esc_html__( 'Get monthly inspiration, new patterns, exclusive discounts, and early access to new collections.', 'baloch-diamond' ),
	) );

	$wp_customize->add_setting( 'bd_newsletter_placeholder', array(
		'default'           => esc_html__( 'Your email address', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_newsletter_placeholder', array(
		'label'   => esc_html__( 'Email Field Placeholder', 'baloch-diamond' ),
		'section' => 'bd_newsletter_section',
		'type'    => 'text',
	) );

	// ================================================
	// SECTION 10: FOOTER — FULL CUSTOMIZATION
	// ================================================
	$wp_customize->add_section( 'bd_footer_section', array(
		'title'    => esc_html__( '🦶 Footer Settings', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 60,
	) );

	// --- LOGO ---
	$wp_customize->add_setting( 'bd_footer_logo', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'bd_footer_logo',
		array(
			'label'       => esc_html__( 'Footer Logo', 'baloch-diamond' ),
			'description' => esc_html__( 'Upload a custom logo for the footer. Leave empty to use the site name.', 'baloch-diamond' ),
			'section'     => 'bd_footer_section',
		)
	) );

	// --- ABOUT TEXT ---
	$wp_customize->add_setting( 'bd_footer_about', array(
		'default'           => esc_html__( 'A premium WordPress theme inspired by the timeless beauty of Balochi needlework artistry. Where tradition meets modern web design excellence.', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'bd_footer_about', array(
		'label'   => esc_html__( 'Footer About Text', 'baloch-diamond' ),
		'section' => 'bd_footer_section',
		'type'    => 'textarea',
	) );

	// --- COPYRIGHT ---
	$wp_customize->add_setting( 'bd_footer_copyright', array(
		'default'           => esc_html__( '© {year} Baloch Diamond. Crafted with love and heritage.', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_footer_copyright', array(
		'label'       => esc_html__( 'Copyright Text', 'baloch-diamond' ),
		'description' => esc_html__( 'Use {year} to auto-insert the current year.', 'baloch-diamond' ),
		'section'     => 'bd_footer_section',
		'type'        => 'text',
	) );

	// --- BACKGROUND COLOR ---
	$wp_customize->add_setting( 'bd_footer_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_footer_bg_color',
		array(
			'label'       => esc_html__( 'Footer Background Color', 'baloch-diamond' ),
			'description' => esc_html__( 'Leave empty for the theme default dark footer background. Ignored when a Footer Background Image is set below.', 'baloch-diamond' ),
			'section'     => 'bd_footer_section',
		)
	) );

	// --- BACKGROUND IMAGE ---
	$wp_customize->add_setting( 'bd_footer_bg_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'bd_footer_bg_image',
		array(
			'label'       => esc_html__( 'Footer Background Image', 'baloch-diamond' ),
			'description' => esc_html__( 'Optional. Overrides the Footer Background Color above.', 'baloch-diamond' ),
			'section'     => 'bd_footer_section',
		)
	) );

	$wp_customize->add_setting( 'bd_footer_bg_image_overlay', array(
		'default'           => 'rgba(0,0,0,0.55)',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_footer_bg_image_overlay',
		array(
			'label'       => esc_html__( 'Footer Image Overlay Color', 'baloch-diamond' ),
			'description' => esc_html__( 'A semi-transparent tint placed over the footer image to keep text readable.', 'baloch-diamond' ),
			'section'     => 'bd_footer_section',
		)
	) );

	// --- TEXT COLOR ---
	$wp_customize->add_setting( 'bd_footer_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_footer_text_color',
		array(
			'label'       => esc_html__( 'Footer Text Color', 'baloch-diamond' ),
			'description' => esc_html__( 'Leave empty for the theme default.', 'baloch-diamond' ),
			'section'     => 'bd_footer_section',
		)
	) );

	// --- LINK COLOR ---
	$wp_customize->add_setting( 'bd_footer_link_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_footer_link_color',
		array(
			'label'       => esc_html__( 'Footer Link Color', 'baloch-diamond' ),
			'description' => esc_html__( 'Color for hyperlinks inside the footer.', 'baloch-diamond' ),
			'section'     => 'bd_footer_section',
		)
	) );

	// --- LAYOUT ---
	$wp_customize->add_setting( 'bd_footer_layout', array(
		'default'           => '4col',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_footer_layout', array(
		'label'   => esc_html__( 'Footer Column Layout', 'baloch-diamond' ),
		'section' => 'bd_footer_section',
		'type'    => 'select',
		'choices' => array(
			'1col'       => esc_html__( '1 Column (Centered)', 'baloch-diamond' ),
			'2col'       => esc_html__( '2 Columns', 'baloch-diamond' ),
			'3col'       => esc_html__( '3 Columns', 'baloch-diamond' ),
			'4col'       => esc_html__( '4 Columns (Default)', 'baloch-diamond' ),
			'wide-about' => esc_html__( 'Wide About + 3 Narrow Columns', 'baloch-diamond' ),
		),
	) );

	// --- COLUMN TITLES ---
	$wp_customize->add_setting( 'bd_footer_col2_title', array(
		'default'           => esc_html__( 'Quick Links', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_footer_col2_title', array(
		'label'   => esc_html__( 'Column 2 Title (Quick Links)', 'baloch-diamond' ),
		'section' => 'bd_footer_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'bd_footer_col3_title', array(
		'default'           => esc_html__( 'Categories', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_footer_col3_title', array(
		'label'   => esc_html__( 'Column 3 Title (Categories)', 'baloch-diamond' ),
		'section' => 'bd_footer_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'bd_footer_col4_title', array(
		'default'           => esc_html__( 'Connect With Us', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_footer_col4_title', array(
		'label'   => esc_html__( 'Column 4 Title (Social/Connect)', 'baloch-diamond' ),
		'section' => 'bd_footer_section',
		'type'    => 'text',
	) );

	// --- SOCIAL LINKS ---
	// Labels are pre-translated literals (no variables inside gettext calls).
	$social_networks = array(
		'twitter'   => esc_html__( 'Twitter / X URL', 'baloch-diamond' ),
		'github'    => esc_html__( 'GitHub URL', 'baloch-diamond' ),
		'linkedin'  => esc_html__( 'LinkedIn URL', 'baloch-diamond' ),
		'instagram' => esc_html__( 'Instagram URL', 'baloch-diamond' ),
		'facebook'  => esc_html__( 'Facebook URL', 'baloch-diamond' ),
		'youtube'   => esc_html__( 'YouTube URL', 'baloch-diamond' ),
		'telegram'  => esc_html__( 'Telegram URL', 'baloch-diamond' ),
		'whatsapp'  => esc_html__( 'WhatsApp URL', 'baloch-diamond' ),
	);

	foreach ( $social_networks as $key => $label ) {
		$wp_customize->add_setting( "bd_footer_social_{$key}", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( "bd_footer_social_{$key}", array(
			'label'       => $label,
			'description' => esc_html__( 'Leave empty to hide this icon.', 'baloch-diamond' ),
			'section'     => 'bd_footer_section',
			'type'        => 'url',
		) );
	}

	// --- SHOW / HIDE FOOTER WIDGETS ---
	$wp_customize->add_setting( 'bd_footer_show_pages', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_footer_show_pages', array(
		'label'   => esc_html__( 'Show Quick Links (Pages) Column', 'baloch-diamond' ),
		'section' => 'bd_footer_section',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_footer_show_categories', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_footer_show_categories', array(
		'label'   => esc_html__( 'Show Categories Column', 'baloch-diamond' ),
		'section' => 'bd_footer_section',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_footer_show_social', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_footer_show_social', array(
		'label'   => esc_html__( 'Show Social Links Column', 'baloch-diamond' ),
		'section' => 'bd_footer_section',
		'type'    => 'checkbox',
	) );

	// Show Footer Menu
	$wp_customize->add_setting( 'bd_footer_show_menu', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_footer_show_menu', array(
		'label'       => esc_html__( 'Show Footer Navigation Menu', 'baloch-diamond' ),
		'description' => esc_html__( 'Assign a "Footer" menu in Appearance > Menus for this to appear.', 'baloch-diamond' ),
		'section'     => 'bd_footer_section',
		'type'        => 'checkbox',
	) );

	// Show "Powered by" text
	$wp_customize->add_setting( 'bd_footer_show_powered', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_footer_show_powered', array(
		'label'   => esc_html__( 'Show "Powered by WordPress" Text', 'baloch-diamond' ),
		'section' => 'bd_footer_section',
		'type'    => 'checkbox',
	) );

	// Custom "Powered by" / bottom bar text
	$wp_customize->add_setting( 'bd_footer_powered_text', array(
		'default'           => esc_html__( 'Powered by WordPress & Baloch Diamond Theme.', 'baloch-diamond' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bd_footer_powered_text', array(
		'label'       => esc_html__( '"Powered by" / Bottom Bar Text', 'baloch-diamond' ),
		'description' => esc_html__( 'Custom text shown below the copyright line.', 'baloch-diamond' ),
		'section'     => 'bd_footer_section',
		'type'        => 'text',
	) );

	// Bottom bar separator
	$wp_customize->add_setting( 'bd_footer_show_separator', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_footer_show_separator', array(
		'label'   => esc_html__( 'Show Separator Line Above Bottom Bar', 'baloch-diamond' ),
		'section' => 'bd_footer_section',
		'type'    => 'checkbox',
	) );

	// ================================================
	// SECTION 11: ADVANCED
	// ================================================
	$wp_customize->add_section( 'bd_advanced_core', array(
		'title'    => esc_html__( '⚙️ Advanced Options', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 65,
	) );

	$wp_customize->add_setting( 'bd_enable_dark_mode_toggle', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_enable_dark_mode_toggle', array(
		'label'   => esc_html__( 'Show Dark/Light Mode Toggle', 'baloch-diamond' ),
		'section' => 'bd_advanced_core',
		'type'    => 'checkbox',
	) );

	// ---- Default theme mode (visitors without a saved preference) ----
	$wp_customize->add_setting( 'bd_default_theme_mode', array(
		'default'           => 'light',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_default_theme_mode', array(
		'label'       => esc_html__( '🌗 Default Theme Mode', 'baloch-diamond' ),
		'description' => esc_html__( 'The mode first-time visitors see. Once a visitor uses the toggle, their own choice is remembered in their browser.', 'baloch-diamond' ),
		'section'     => 'bd_advanced_core',
		'type'        => 'select',
		'choices'     => array(
			'light' => esc_html__( '☀️ Light', 'baloch-diamond' ),
			'dark'  => esc_html__( '🌙 Dark', 'baloch-diamond' ),
			'auto'  => esc_html__( '🖥️ Auto — follow the visitor\'s system preference', 'baloch-diamond' ),
		),
	) );

	// ---- Custom LIGHT mode background ----
	$wp_customize->add_setting( 'bd_light_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_light_bg_color',
		array(
			'label'       => esc_html__( '🎨 Light Mode — Custom Background', 'baloch-diamond' ),
			'description' => esc_html__( 'Replace the white background with any color (e.g. cream, light blue). Card, border and text shades are derived automatically so text always stays readable. Leave empty for default white.', 'baloch-diamond' ),
			'section'     => 'bd_advanced_core',
		)
	) );

	// ---- Custom DARK mode background ----
	$wp_customize->add_setting( 'bd_dark_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'bd_dark_bg_color',
		array(
			'label'       => esc_html__( '🎨 Dark Mode — Custom Background', 'baloch-diamond' ),
			'description' => esc_html__( 'Replace the navy background with any dark color (e.g. deep green, warm charcoal). Derived shades keep contrast safe. Leave empty for the default.', 'baloch-diamond' ),
			'section'     => 'bd_advanced_core',
		)
	) );

	// ================================================
	// SECTION: TOPICS (CATEGORIES) — hidden by default
	// ================================================
	$wp_customize->add_section( 'bd_topics_section', array(
		'title'    => esc_html__( '🏷️ Topics Section', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 46,
	) );

	

	bd_add_section_header_controls( $wp_customize, 'topics', 'bd_topics_section', array(
		'badge' => esc_html__( 'Explore', 'baloch-diamond' ),
		'title' => esc_html__( 'Browse by Topic', 'baloch-diamond' ),
		'desc'  => esc_html__( 'Find the content you care about, organized by subject.', 'baloch-diamond' ),
	) );

	$wp_customize->add_setting( 'bd_topics_count', array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bd_topics_count', array(
		'label'       => esc_html__( 'Number of Topics', 'baloch-diamond' ),
		'section'     => 'bd_topics_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 1, 'max' => 24, 'step' => 1 ),
	) );

	$wp_customize->add_setting( 'bd_topics_style', array(
		'default'           => 'image',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_topics_style', array(
		'label'   => esc_html__( 'Card Style', 'baloch-diamond' ),
		'section' => 'bd_topics_section',
		'type'    => 'select',
		'choices' => array(
			'image' => esc_html__( 'Latest Post Image (icon fallback)', 'baloch-diamond' ),
			'icon'  => esc_html__( 'Icon Tiles', 'baloch-diamond' ),
		),
	) );

	$wp_customize->add_setting( 'bd_topics_show_count', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_topics_show_count', array(
		'label'   => esc_html__( 'Show Post Count', 'baloch-diamond' ),
		'section' => 'bd_topics_section',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_topics_orderby', array(
		'default'           => 'count',
		'sanitize_callback' => 'bd_sanitize_select',
	) );
	$wp_customize->add_control( 'bd_topics_orderby', array(
		'label'   => esc_html__( 'Order Topics By', 'baloch-diamond' ),
		'section' => 'bd_topics_section',
		'type'    => 'select',
		'choices' => array(
			'count' => esc_html__( 'Most Posts First', 'baloch-diamond' ),
			'name'  => esc_html__( 'Alphabetical', 'baloch-diamond' ),
		),
	) );

	// ================================================
	// SECTION: POPULAR TAGS — hidden by default
	// ================================================
	$wp_customize->add_section( 'bd_tags_section', array(
		'title'    => esc_html__( '🔖 Tags Section', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 47,
	) );

	

	bd_add_section_header_controls( $wp_customize, 'tags', 'bd_tags_section', array(
		'badge' => esc_html__( 'Keywords', 'baloch-diamond' ),
		'title' => esc_html__( 'Popular Tags', 'baloch-diamond' ),
		'desc'  => esc_html__( 'Jump straight to the subjects everyone is reading about.', 'baloch-diamond' ),
	) );

	$wp_customize->add_setting( 'bd_tags_count', array(
		'default'           => 20,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bd_tags_count', array(
		'label'       => esc_html__( 'Number of Tags', 'baloch-diamond' ),
		'section'     => 'bd_tags_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 1, 'max' => 60, 'step' => 1 ),
	) );

	// ================================================
	// SECTION: SITE ARCHIVE — hidden by default
	// ================================================
	$wp_customize->add_section( 'bd_archive_section', array(
		'title'    => esc_html__( '🗄️ Archive Section', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 48,
	) );

	

	bd_add_section_header_controls( $wp_customize, 'archive', 'bd_archive_section', array(
		'badge' => esc_html__( 'Time Machine', 'baloch-diamond' ),
		'title' => esc_html__( 'Site Archive', 'baloch-diamond' ),
		'desc'  => esc_html__( 'Browse everything we have published, month by month.', 'baloch-diamond' ),
	) );

	$wp_customize->add_setting( 'bd_archive_months', array(
		'default'           => 8,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bd_archive_months', array(
		'label'       => esc_html__( 'Number of Months', 'baloch-diamond' ),
		'section'     => 'bd_archive_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 1, 'max' => 36, 'step' => 1 ),
	) );

	$wp_customize->add_setting( 'bd_archive_show_stats', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_archive_show_stats', array(
		'label'   => esc_html__( 'Show Site Statistics (posts, categories, tags, comments)', 'baloch-diamond' ),
		'section' => 'bd_archive_section',
		'type'    => 'checkbox',
	) );

	// ================================================
	// SECTION: COMMENT PROTECTION
	// ================================================
	$wp_customize->add_section( 'bd_comments_section', array(
		'title'       => esc_html__( '🛡️ Comment Protection', 'baloch-diamond' ),
		'description' => esc_html__( 'Extra filters applied on top of the WordPress core comment settings (Settings → Discussion).', 'baloch-diamond' ),
		'panel'       => 'bd_panel',
		'priority'    => 50,
	) );

	// Strip ALL HTML from comments
	$wp_customize->add_setting( 'bd_comments_strip_html', array(
		'default'           => false,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_comments_strip_html', array(
		'label'       => esc_html__( 'Strip ALL HTML Tags from Comments', 'baloch-diamond' ),
		'description' => esc_html__( 'WordPress already removes dangerous tags; this removes EVERY tag (links, bold, images…) so comments are always plain text.', 'baloch-diamond' ),
		'section'     => 'bd_comments_section',
		'type'        => 'checkbox',
	) );

	// Block links in comments
	$wp_customize->add_setting( 'bd_comments_block_links', array(
		'default'           => false,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_comments_block_links', array(
		'label'       => esc_html__( 'Reject Comments Containing Links (URLs)', 'baloch-diamond' ),
		'description' => esc_html__( 'Comments that include http(s) URLs or www. addresses are rejected with a friendly error — a very effective anti-spam measure.', 'baloch-diamond' ),
		'section'     => 'bd_comments_section',
		'type'        => 'checkbox',
	) );

	// Blocked words
	$wp_customize->add_setting( 'bd_comments_blocked_words', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'bd_comments_blocked_words', array(
		'label'       => esc_html__( 'Blocked Words / Characters', 'baloch-diamond' ),
		'description' => esc_html__( 'One entry per line. Any comment containing one of these words or character sequences is rejected before it is saved.', 'baloch-diamond' ),
		'section'     => 'bd_comments_section',
		'type'        => 'textarea',
	) );

	// Min length
	$wp_customize->add_setting( 'bd_comments_min_length', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bd_comments_min_length', array(
		'label'       => esc_html__( 'Minimum Comment Length (characters)', 'baloch-diamond' ),
		'description' => esc_html__( '0 = disabled. Rejects ultra-short spam like "nice".', 'baloch-diamond' ),
		'section'     => 'bd_comments_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 0, 'max' => 500, 'step' => 5 ),
	) );

	// Max length
	$wp_customize->add_setting( 'bd_comments_max_length', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bd_comments_max_length', array(
		'label'       => esc_html__( 'Maximum Comment Length (characters)', 'baloch-diamond' ),
		'description' => esc_html__( '0 = disabled. Blocks wall-of-text spam floods.', 'baloch-diamond' ),
		'section'     => 'bd_comments_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 0, 'max' => 65000, 'step' => 100 ),
	) );

	// Apply to logged-in users too?
	$wp_customize->add_setting( 'bd_comments_filter_logged_in', array(
		'default'           => false,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_comments_filter_logged_in', array(
		'label'       => esc_html__( 'Also Apply Filters to Logged-in Users', 'baloch-diamond' ),
		'description' => esc_html__( 'By default administrators/editors are exempt. Users who can moderate comments are always exempt.', 'baloch-diamond' ),
		'section'     => 'bd_comments_section',
		'type'        => 'checkbox',
	) );

	// ================================================
	// SECTION: STATIC PAGE SETTINGS
	// ================================================
	$wp_customize->add_section( 'bd_page_settings', array(
		'title'    => esc_html__( '📄 Page Settings', 'baloch-diamond' ),
		'panel'    => 'bd_panel',
		'priority' => 49,
	) );

	$wp_customize->add_setting( 'bd_page_show_slider', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_page_show_slider', array(
		'label'       => esc_html__( 'Show Hero Slider on Pages', 'baloch-diamond' ),
		'description' => esc_html__( 'Static pages only show the Hero Slider and Newsletter — no other front-page sections. The slider also respects its own global visibility setting.', 'baloch-diamond' ),
		'section'     => 'bd_page_settings',
		'type'        => 'checkbox',
	) );

	$wp_customize->add_setting( 'bd_page_show_newsletter', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_page_show_newsletter', array(
		'label'       => esc_html__( 'Show Newsletter on Pages', 'baloch-diamond' ),
		'description' => esc_html__( 'Renders full-width above the footer. Also respects the global Newsletter visibility setting.', 'baloch-diamond' ),
		'section'     => 'bd_page_settings',
		'type'        => 'checkbox',
	) );

	// ================================================
	// SECTION: PAGE SECTIONS ORDER & VISIBILITY
	// ================================================
	$wp_customize->add_section( 'bd_sections_order', array(
		'title'       => esc_html__( '📋 Sections Order & Visibility', 'baloch-diamond' ),
		'description' => esc_html__( 'The ONLY place to show/hide front-page sections: use the eye icon. Drag rows to reorder or move them into a sidebar column.', 'baloch-diamond' ),
		'panel'       => 'bd_panel',
		'priority'    => 5,
	) );

	// ---- Paged views (/page/2/ …): per-section visibility ----
	// Master switch: filter sections on paged views at all?
	$wp_customize->add_setting( 'bd_paged_blog_only', array(
		'default'           => true,
		'sanitize_callback' => 'bd_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'bd_paged_blog_only', array(
		'label'       => esc_html__( '📑 Paged Views: Filter Sections', 'baloch-diamond' ),
		'description' => esc_html__( 'When visitors browse older posts (/page/2/ and beyond via Numbered pagination), show only the Blog grid plus the sections ticked below. Page 1 always shows the full layout. Untick to show everything on every page.', 'baloch-diamond' ),
		'section'     => 'bd_sections_order',
		'type'        => 'checkbox',
	) );

	// Per-section checkboxes: which sections ALSO appear on paged views.
	// Defaults: slider ON, everything else OFF. (Blog itself is always shown.)
	$bd_paged_sections = array(
		'slider'     => array( '🖼️ ' . esc_html__( 'Hero Slider',        'baloch-diamond' ), true ),
		'shop'       => array( '🛍️ ' . esc_html__( 'Shop',               'baloch-diamond' ), false ),
		'forum'      => array( '💬 ' . esc_html__( 'Community / Forum',  'baloch-diamond' ), false ),
		'portfolio'  => array( '🗂️ ' . esc_html__( 'Portfolio',          'baloch-diamond' ), false ),
		'resources'  => array( '📚 ' . esc_html__( 'Resources',          'baloch-diamond' ), false ),
		'team'       => array( '👥 ' . esc_html__( 'Team',               'baloch-diamond' ), false ),
		'newsletter' => array( '✉️ ' . esc_html__( 'Newsletter',         'baloch-diamond' ), false ),
		'members'    => array( '👤 ' . esc_html__( 'Community Members',  'baloch-diamond' ), false ),
		'topics'     => array( '🏷️ ' . esc_html__( 'Topics',             'baloch-diamond' ), false ),
		'tags'       => array( '🔖 ' . esc_html__( 'Popular Tags',       'baloch-diamond' ), false ),
		'archive'    => array( '🗄️ ' . esc_html__( 'Site Archive',       'baloch-diamond' ), false ),
	);
	foreach ( $bd_paged_sections as $bd_ps_key => $bd_ps ) {
		$wp_customize->add_setting( 'bd_paged_show_' . $bd_ps_key, array(
			'default'           => $bd_ps[1],
			'sanitize_callback' => 'bd_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'bd_paged_show_' . $bd_ps_key, array(
			/* translators: %s: section name. */
			'label'           => sprintf( esc_html__( 'Paged: show %s', 'baloch-diamond' ), $bd_ps[0] ),
			'section'         => 'bd_sections_order',
			'type'            => 'checkbox',
			'active_callback' => function () {
				return (bool) get_theme_mod( 'bd_paged_blog_only', true );
			},
		) );
	}

	// Single JSON setting — stores order, visibility AND column-zone for all sections
	$wp_customize->add_setting( 'bd_sections_layout', array(
		'default'           => wp_json_encode( array(
			array( 'key' => 'slider',     'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'shop',       'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'forum',      'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'portfolio',  'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'blog',       'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'topics',     'visible' => false, 'zone' => 'main' ),
			array( 'key' => 'tags',       'visible' => false, 'zone' => 'main' ),
			array( 'key' => 'archive',    'visible' => false, 'zone' => 'main' ),
			array( 'key' => 'resources',  'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'team',       'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'newsletter', 'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'members',    'visible' => true,  'zone' => 'main' ),
		) ),
		'sanitize_callback' => 'bd_sanitize_sections_layout',
		'transport'         => 'refresh',
	) );
	if ( class_exists( 'BD_Sections_Sorter_Control' ) ) {
		$wp_customize->add_control(
			new BD_Sections_Sorter_Control(
				$wp_customize,
				'bd_sections_layout',
				array(
					'label'   => esc_html__( 'Drag between columns — toggle eye to show/hide', 'baloch-diamond' ),
					'section' => 'bd_sections_order',
				)
			)
		);
	}

}

/**
 * Section keys that can never be moved into a sidebar zone.
 * (Hero slider, Newsletter banner and the Blog grid stay in the main column.)
 */
function bd_get_locked_section_keys() {
	return array( 'slider', 'newsletter', 'blog' );
}

/**
 * Sanitize the sections layout JSON value.
 */
function bd_sanitize_sections_layout( $value ) {
	$decoded = json_decode( $value, true );
	if ( ! is_array( $decoded ) ) {
		return get_theme_mod( 'bd_sections_layout' );
	}
	$allowed_keys  = array( 'slider','shop','forum','portfolio','blog','resources','team','newsletter','members','topics','tags','archive' );
	$allowed_zones = array( 'main', 'left', 'right' );
	$locked_keys   = bd_get_locked_section_keys();
	$sanitized     = array();
	foreach ( $decoded as $item ) {
		if ( isset( $item['key'] ) && in_array( $item['key'], $allowed_keys, true ) ) {
			$key  = sanitize_key( $item['key'] );
			$zone = ( isset( $item['zone'] ) && in_array( $item['zone'], $allowed_zones, true ) )
				? $item['zone']
				: 'main';

			// Locked sections are always forced back into the main column
			if ( in_array( $key, $locked_keys, true ) ) {
				$zone = 'main';
			}

			$sanitized[] = array(
				'key'     => $key,
				'visible' => ! empty( $item['visible'] ),
				'zone'    => $zone,
			);
		}
	}
	return wp_json_encode( $sanitized );
}

/**
 * Custom Drag & Drop + Toggle Control for Section Ordering.
 *
 * Wrapped in class_exists check so it only loads when WP_Customize_Control
 * is available (i.e., inside the Customizer context).
 */
/**
 * Register the custom sorter control class.
 * Hooked to 'customize_register' (priority 1) so WP_Customize_Control is guaranteed available.
 */
function bd_register_sorter_control_class() {
    if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'BD_Sections_Sorter_Control' ) ) :

class BD_Sections_Sorter_Control extends WP_Customize_Control {

	public $type = 'bd_sections_sorter';

	/**
	 * Human-readable labels for each section key.
	 */
	private function get_labels() {
		return array(
			'slider'     => '🖼️ ' . esc_html__( 'Hero Slider',             'baloch-diamond' ),
			'shop'       => '🛍️ ' . esc_html__( 'Shop (WooCommerce)',       'baloch-diamond' ),
			'forum'      => '💬 ' . esc_html__( 'Community / Forum',        'baloch-diamond' ),
			'portfolio'  => '🗂️ ' . esc_html__( 'Portfolio',               'baloch-diamond' ),
			'blog'       => '📝 ' . esc_html__( 'Blog',                     'baloch-diamond' ),
			'resources'  => '📚 ' . esc_html__( 'Resources',                'baloch-diamond' ),
			'team'       => '👥 ' . esc_html__( 'Team',                     'baloch-diamond' ),
			'newsletter' => '✉️ ' . esc_html__( 'Newsletter',               'baloch-diamond' ),
			'members'    => '👤 ' . esc_html__( 'Community Members',        'baloch-diamond' ),
			'topics'     => '🏷️ ' . esc_html__( 'Topics (Categories)',      'baloch-diamond' ),
			'tags'       => '🔖 ' . esc_html__( 'Popular Tags',             'baloch-diamond' ),
			'archive'    => '🗄️ ' . esc_html__( 'Site Archive',            'baloch-diamond' ),
		);
	}

	/**
	 * Section keys that must stay in the main column.
	 */
	private function get_locked_keys() {
		return function_exists( 'bd_get_locked_section_keys' )
			? bd_get_locked_section_keys()
			: array( 'slider', 'newsletter', 'blog' );
	}

	/**
	 * Enqueue the Sorter scripts & styles (only in Customizer).
	 */
	public function enqueue() {
		// Cache-bust with the file's modification time so CDNs/proxies can
		// never serve a stale copy of the sorter after a theme update.
		$sorter_path = get_template_directory() . '/assets/js/sections-sorter.js';
		$sorter_ver  = file_exists( $sorter_path ) ? BD_VERSION . '.' . filemtime( $sorter_path ) : BD_VERSION;

		wp_enqueue_script(
			'bd-sections-sorter',
			get_template_directory_uri() . '/assets/js/sections-sorter.js',
			array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'customize-controls' ),
			$sorter_ver,
			true
		);
		wp_localize_script( 'bd-sections-sorter', 'bdSorterL10n', array(
			'dropHere' => esc_html__( 'Drop sections here to activate this sidebar', 'baloch-diamond' ),
		) );
		wp_add_inline_style( 'customize-controls', '
			.bd-sorter-list { list-style:none; margin:0; padding:0; }
			.bd-sorter-item {
				display:flex; align-items:center; gap:8px;
				background:#fff; border:1px solid #ddd; border-radius:8px;
				padding:9px 10px; margin-bottom:8px; cursor:grab;
				transition:box-shadow .2s, opacity .2s; user-select:none;
			}
			.bd-sorter-item:active { cursor:grabbing; }
			.bd-sorter-item.ui-sortable-helper { box-shadow:0 6px 20px rgba(0,0,0,.15); opacity:.95; }
			.bd-sorter-item.ui-sortable-placeholder { visibility:visible!important; background:#f0f7ff; border:2px dashed #7eb8f7; min-height:38px; }
			.bd-sorter-handle { color:#aaa; flex-shrink:0; cursor:grab; line-height:1; }
			.bd-sorter-handle:active { cursor:grabbing; }
			.bd-sorter-label { flex:1; font-size:12px; font-weight:500; color:#1e1e1e; line-height:1.3; }
			.bd-sorter-item.is-hidden .bd-sorter-label { opacity:.4; text-decoration:line-through; }
			.bd-sorter-toggle {
				background:none; border:none; cursor:pointer; padding:4px;
				color:#007cba; border-radius:4px; flex-shrink:0; line-height:1;
				transition:color .2s;
			}
			.bd-sorter-toggle:hover { color:#005a87; }
			.bd-sorter-item.is-hidden .bd-sorter-toggle { color:#aaa; }
			.bd-sorter-hint {
				font-size:11px; color:#757575; margin-bottom:10px; line-height:1.5;
			}

			/* ---- Multi-zone layout ---- */
			.bd-sorter-zones { display:flex; flex-direction:column; gap:12px; }
			.bd-sorter-zone {
				border:1px solid #dcdcde; border-radius:10px;
				background:#f6f7f7; padding:8px;
			}
			.bd-sorter-zone-title {
				display:flex; align-items:center; gap:6px;
				font-size:11px; font-weight:700; text-transform:uppercase;
				letter-spacing:.4px; color:#50575e; margin:0 2px 8px;
			}
			.bd-sorter-zone .bd-sorter-list {
				min-height:44px;
				border-radius:8px;
				transition:background .2s, outline .2s;
			}
			.bd-sorter-zone .bd-sorter-list.bd-drop-active {
				background:#eef6fc; outline:2px dashed #7eb8f7; outline-offset:-2px;
			}
			.bd-sorter-zone .bd-sorter-list:empty::after,
			.bd-sorter-zone .bd-sorter-list .bd-sorter-empty {
				content:"";
			}
			.bd-sorter-empty {
				display:block; font-size:11px; color:#9aa0a6; text-align:center;
				padding:12px 6px; border:1px dashed #cfd4d9; border-radius:8px;
				margin-bottom:8px; pointer-events:none;
			}
			.bd-sorter-item.bd-is-locked { background:#fbfbfc; }
			.bd-sorter-lock {
				color:#b5bcc2; flex-shrink:0; line-height:1;
			}
			.bd-sorter-item .bd-sorter-zone-badge {
				font-size:9px; font-weight:700; color:#2271b1;
				background:#eef6fc; border-radius:4px; padding:2px 5px;
				flex-shrink:0; text-transform:uppercase; letter-spacing:.3px;
			}
		' );
	}

	/**
	 * Render one sortable row (li).
	 */
	private function render_item( $key, $visible, $zone, $label, $is_locked ) {
		$hidden_class = $visible ? '' : ' is-hidden';
		$locked_class = $is_locked ? ' bd-is-locked' : '';
		// Eye SVG (shown vs hidden)
		$eye_on  = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
		$eye_off = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
		$lock    = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>';
		?>
		<li class="bd-sorter-item<?php echo esc_attr( $hidden_class . $locked_class ); ?>"
			data-key="<?php echo esc_attr( $key ); ?>"
			data-visible="<?php echo $visible ? '1' : '0'; ?>"
			data-zone="<?php echo esc_attr( $zone ); ?>"
			data-locked="<?php echo $is_locked ? '1' : '0'; ?>">
			<span class="bd-sorter-handle" title="<?php esc_attr_e( 'Drag to reorder or move between columns', 'baloch-diamond' ); ?>">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
			</span>
			<span class="bd-sorter-label"><?php echo esc_html( $label ); ?></span>
			<?php if ( $is_locked ) : ?>
				<span class="bd-sorter-lock" title="<?php esc_attr_e( 'This section always stays in the main column', 'baloch-diamond' ); ?>">
					<?php echo $lock; // phpcs:ignore ?>
				</span>
			<?php endif; ?>
			<button type="button" class="bd-sorter-toggle"
				title="<?php echo $visible ? esc_attr__( 'Click to hide', 'baloch-diamond' ) : esc_attr__( 'Click to show', 'baloch-diamond' ); ?>">
				<?php echo $visible ? $eye_on : $eye_off; // phpcs:ignore ?>
			</button>
		</li>
		<?php
	}

	/**
	 * Render the control HTML — three drop zones (Left / Main / Right).
	 */
	public function render_content() {
		$raw    = $this->value();
		$items  = json_decode( $raw, true );
		$labels = $this->get_labels();
		$locked = $this->get_locked_keys();

		$default_items = array(
			array( 'key' => 'slider',     'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'shop',       'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'forum',      'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'portfolio',  'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'blog',       'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'topics',     'visible' => false, 'zone' => 'main' ),
			array( 'key' => 'tags',       'visible' => false, 'zone' => 'main' ),
			array( 'key' => 'archive',    'visible' => false, 'zone' => 'main' ),
			array( 'key' => 'resources',  'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'team',       'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'newsletter', 'visible' => true,  'zone' => 'main' ),
			array( 'key' => 'members',    'visible' => true,  'zone' => 'main' ),
		);

		// Fallback to default order if JSON is invalid
		if ( ! is_array( $items ) || empty( $items ) ) {
			$items = $default_items;
		}

		// Merge in any NEW section keys missing from a saved layout
		// (appended hidden so existing sites keep their appearance)
		$existing_keys = wp_list_pluck( $items, 'key' );
		foreach ( $default_items as $default_item ) {
			if ( ! in_array( $default_item['key'], $existing_keys, true ) ) {
				$default_item['visible'] = false;
				$items[] = $default_item;
			}
		}

		// Group items into zones (order preserved)
		$zones = array( 'left' => array(), 'main' => array(), 'right' => array() );
		foreach ( $items as $item ) {
			$key  = sanitize_key( $item['key'] );
			$zone = ( isset( $item['zone'] ) && isset( $zones[ $item['zone'] ] ) ) ? $item['zone'] : 'main';
			if ( in_array( $key, $locked, true ) ) {
				$zone = 'main';
			}
			$zones[ $zone ][] = array(
				'key'     => $key,
				'visible' => ! empty( $item['visible'] ),
			);
		}

		$zone_meta = array(
			'left'  => array( 'icon' => '⬅️', 'title' => esc_html__( 'Left Sidebar',  'baloch-diamond' ) ),
			'main'  => array( 'icon' => '▣',  'title' => esc_html__( 'Main Column',   'baloch-diamond' ) ),
			'right' => array( 'icon' => '➡️', 'title' => esc_html__( 'Right Sidebar', 'baloch-diamond' ) ),
		);
		?>
		<p class="bd-sorter-hint">
			<?php esc_html_e( '⠿ Drag rows to reorder — or drag them into the Left/Right sidebar boxes to create a 2- or 3-column layout.', 'baloch-diamond' ); ?><br>
			<?php esc_html_e( '👁 Click the eye icon to show or hide a section.', 'baloch-diamond' ); ?><br>
			<?php esc_html_e( '🔒 Locked sections (Hero Slider, Newsletter, Blog) always stay in the main column.', 'baloch-diamond' ); ?>
		</p>

		<div class="bd-sorter-zones" id="bd-sorter-zones-<?php echo esc_attr( $this->id ); ?>" data-setting-id="<?php echo esc_attr( $this->id ); ?>">
			<?php foreach ( array( 'left', 'main', 'right' ) as $zone_key ) : ?>
				<div class="bd-sorter-zone" data-zone="<?php echo esc_attr( $zone_key ); ?>">
					<p class="bd-sorter-zone-title">
						<span><?php echo esc_html( $zone_meta[ $zone_key ]['icon'] ); ?></span>
						<?php echo esc_html( $zone_meta[ $zone_key ]['title'] ); ?>
					</p>
					<ul class="bd-sorter-list"
						data-zone="<?php echo esc_attr( $zone_key ); ?>"
						id="bd-sorter-list-<?php echo esc_attr( $this->id . '-' . $zone_key ); ?>">
						<?php
						if ( empty( $zones[ $zone_key ] ) && 'main' !== $zone_key ) {
							echo '<li class="bd-sorter-empty">' . esc_html__( 'Drop sections here to activate this sidebar', 'baloch-diamond' ) . '</li>';
						}
						foreach ( $zones[ $zone_key ] as $item ) {
							$label = isset( $labels[ $item['key'] ] ) ? $labels[ $item['key'] ] : $item['key'];
							$this->render_item(
								$item['key'],
								$item['visible'],
								$zone_key,
								$label,
								in_array( $item['key'], $locked, true )
							);
						}
						?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>

		<input type="hidden"
			id="<?php echo esc_attr( $this->id ); ?>"
			<?php $this->link(); ?>
			value="<?php echo esc_attr( $this->value() ); ?>">
		<?php
	}
}

	endif;
}
add_action( 'customize_register', 'bd_register_sorter_control_class', 1 );

add_action( 'customize_register', 'bd_customize_register', 10 );

/**
 * Helper function to add consistent section headers
 */
function bd_add_section_header_controls( $wp_customize, $section_id, $section_name, $defaults ) {

	// Badge
	$wp_customize->add_setting( "bd_{$section_id}_badge", array(
		'default'           => $defaults['badge'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( "bd_{$section_id}_badge", array(
		'label'   => esc_html__( 'Badge Text', 'baloch-diamond' ),
		'section' => $section_name,
		'type'    => 'text',
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

/**
 * Sanitize functions
 */
function bd_sanitize_checkbox( $input ) {
	return ( $input === true || $input === '1' || $input === 1 ) ? true : false;
}

function bd_sanitize_select( $input, $setting ) {
	$control = $setting->manager->get_control( $setting->id );
	$choices = $control ? $control->choices : array();
	return ( array_key_exists( $input, $choices ) ) ? $input : $setting->default;
}

/**
 * Customizer Preview JS
 */
function bd_customizer_preview_js() {
	wp_enqueue_script(
		'bd-customizer-preview',
		get_template_directory_uri() . '/assets/js/customizer-preview.js',
		array( 'customize-preview' ),
		BD_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'bd_customizer_preview_js' );

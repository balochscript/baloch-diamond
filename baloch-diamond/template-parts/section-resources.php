<?php
/**
 * Resources / Documentation Section Template Part
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Default SVG icons for resource cards
$resource_icons = array(
    'file'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>',
    'code'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',
    'layout' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>',
    'shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
    'book'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>',
    'zap'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
    'globe'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>',
    'cpu'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/></svg>',
    'heart'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>',
    'star'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
);

$icon_keys = array_keys( $resource_icons );

// Check how many resources exist
$resource_count = 0;
for ( $i = 1; $i <= 10; $i++ ) {
    $title = get_theme_mod( "4392bd_resource_item_{$i}_title", '' );
    if ( $title ) {
        $resource_count++;
    }
}

if ( $resource_count === 0 ) {
    return;
}

$link_text = get_theme_mod( '4392bd_resources_link_text', esc_html__( 'Read Documentation', 'baloch-diamond' ) );
?>

<section class="section" id="docs">

    <?php
    4392bd_section_header( 'resources', array(
        'badge' => esc_html__( 'Resources', 'baloch-diamond' ),
        'title' => esc_html__( 'Project Documentation', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Comprehensive documentation to help you get started and make the most of our projects.', 'baloch-diamond' ),
        'icon'  => 'book',
    ) );
    ?>

    <div class="docs-grid">

        <?php for ( $i = 1; $i <= 10; $i++ ) :

            $title      = get_theme_mod( "4392bd_resource_item_{$i}_title", '' );
            $desc       = get_theme_mod( "4392bd_resource_item_{$i}_desc", '' );
            $link       = get_theme_mod( "4392bd_resource_item_{$i}_link", '' );
            $icon_index = get_theme_mod( "4392bd_resource_item_{$i}_icon", 'file' );

            if ( ! $title ) {
                continue;
            }

            // Get icon SVG
            $icon_svg = isset( $resource_icons[ $icon_index ] ) ? $resource_icons[ $icon_index ] : $resource_icons['file'];
        ?>

            <div class="doc-card">
                <div class="doc-icon">
                    <?php echo $icon_svg; ?>
                </div>
                <h4 class="doc-title"><?php echo esc_html( $title ); ?></h4>

                <?php if ( $desc ) : ?>
                    <p class="doc-desc"><?php echo esc_html( $desc ); ?></p>
                <?php endif; ?>

                <?php if ( $link ) : ?>
                    <a href="<?php echo esc_url( $link ); ?>" class="doc-link">
                        <?php echo esc_html( $link_text ); ?>
                        <?php echo 4392bd_icon( 'arrow-right', 14, 14 ); ?>
                    </a>
                <?php endif; ?>
            </div>

        <?php endfor; ?>

    </div>
</section>
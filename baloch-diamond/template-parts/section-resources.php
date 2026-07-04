<?php
/**
 * Resources Section Template Part
 *
 * Fully customizable via the Customizer.
 * Up to 10 standalone resource items: title, description, icon, link, button text.
 * Show/Hide toggle, layout (grid/list), columns, background color.
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hide/Show toggle
if ( ! get_theme_mod( 'bd_resources_show', true ) ) {
    return;
}

$show_btn          = get_theme_mod( 'bd_resources_show_btn', true );
$link_text_default = get_theme_mod( 'bd_resources_link_text', esc_html__( 'Read Documentation', 'baloch-diamond' ) );
$bg_color          = get_theme_mod( 'bd_resources_bg_color', '' );
$section_style     = $bg_color ? ' style="background-color:' . esc_attr( $bg_color ) . ';"' : '';

// Icon SVG map
$resource_icons = array(
    'book'   => '',
    'code'   => '',
    'layout' => '',
    'shield' => '',
    'zap'    => '',
    'globe'  => '',
    'cpu'    => '',
    'heart'  => '',
    'star'   => '',
    'file'   => '',
    'video'  => '',
    'music'  => '',
);

// Build items
$items = array();
for ( $i = 1; $i <= 10; $i++ ) {
    $title = get_theme_mod( "bd_resource_item_{$i}_title", '' );
    if ( ! $title ) {
        continue;
    }
    $items[] = array(
        'title'    => $title,
        'desc'     => get_theme_mod( "bd_resource_item_{$i}_desc", '' ),
        'icon'     => get_theme_mod( "bd_resource_item_{$i}_icon", 'book' ),
        'url'      => get_theme_mod( "bd_resource_item_{$i}_url", '#' ),
        'btn_text' => get_theme_mod( "bd_resource_item_{$i}_btn_text", '' ),
        'newtab'   => get_theme_mod( "bd_resource_item_{$i}_newtab", false ),
    );
}

if ( empty( $items ) ) {
    return;
}
?>

<section class="section" id="resources"<?php echo $section_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

    <?php
    bd_section_header( 'resources', array(
        'badge' => esc_html__( 'Resources', 'baloch-diamond' ),
        'title' => esc_html__( 'Project Documentation', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Comprehensive documentation to help you get started and make the most of our projects.', 'baloch-diamond' ),
        'icon'  => 'book',
    ) );
    ?>

    <div class="docs-grid">

        <?php foreach ( $items as $item ) :
            $btn_label = ! empty( $item['btn_text'] ) ? $item['btn_text'] : $link_text_default;
            $target    = ! empty( $item['newtab'] ) ? '_blank' : '_self';
            $rel       = ! empty( $item['newtab'] ) ? ' rel="noopener noreferrer"' : '';
            $icon_key  = ! empty( $item['icon'] ) ? $item['icon'] : 'book';
        ?>

        <div class="doc-card">

            <div class="doc-icon">
                <?php echo bd_icon( $icon_key, 28, 28 ); ?>
            </div>

            <h3 class="doc-title"><?php echo esc_html( $item['title'] ); ?></h3>

            <?php if ( ! empty( $item['desc'] ) ) : ?>
            <p class="doc-desc"><?php echo esc_html( $item['desc'] ); ?></p>
            <?php endif; ?>

            <?php if ( $show_btn ) : ?>
            <a href="<?php echo esc_url( $item['url'] ); ?>"
               class="doc-link"
               target="<?php echo esc_attr( $target ); ?>"
               <?php echo $rel; // phpcs:ignore ?>
               aria-label="<?php echo esc_attr( $btn_label . ': ' . $item['title'] ); ?>">
                <?php echo esc_html( $btn_label ); ?>
                <?php echo bd_icon( 'arrow-right', 14, 14 ); ?>
            </a>
            <?php endif; ?>

        </div><!-- .doc-card -->

        <?php endforeach; ?>

    </div><!-- .docs-grid -->

</section>

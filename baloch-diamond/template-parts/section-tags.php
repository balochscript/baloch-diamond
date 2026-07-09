<?php
/**
 * Tag Cloud Section Template Part (Front Page)
 *
 * Displays the site's most used tags as a stylish pill cloud.
 *
 * Hidden by default — enable via:
 * Appearance → Customize → 💎 Baloch Diamond Settings → 🔖 Tags Section
 *
 * @package Baloch_Diamond
 * @version 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! bd_is_section_visible( 'tags' ) ) {
    return;
}

// ---- Customizer settings ----
$tags_count = (int) get_theme_mod( 'bd_tags_count', 20 );

$tags = get_tags( array(
    'orderby'    => 'count',
    'order'      => 'DESC',
    'number'     => max( 1, $tags_count ),
    'hide_empty' => true,
) );

if ( empty( $tags ) ) {
    return;
}
?>

<section class="section" id="site-tags">

    <?php
    bd_section_header( 'tags', array(
        'badge' => esc_html__( 'Keywords', 'baloch-diamond' ),
        'title' => esc_html__( 'Popular Tags', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Jump straight to the subjects everyone is reading about.', 'baloch-diamond' ),
        'icon'  => 'tag',
    ) );
    ?>

    <div class="tags-cloud">
        <?php foreach ( $tags as $tag ) : ?>
            <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag-pill">
                <?php echo bd_icon( 'tag', 12, 12 ); ?>
                <span><?php echo esc_html( $tag->name ); ?></span>
                <span class="tag-pill-count"><?php echo esc_html( number_format_i18n( $tag->count ) ); ?></span>
            </a>
        <?php endforeach; ?>
    </div>

</section>

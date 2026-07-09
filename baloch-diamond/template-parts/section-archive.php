<?php
/**
 * Archive Section Template Part (Front Page)
 *
 * Displays the site archive: monthly archive links plus quick
 * stats (total posts, categories, tags, comments).
 *
 * Hidden by default — enable via:
 * Appearance → Customize → 💎 Baloch Diamond Settings → 🗄️ Archive Section
 *
 * @package Baloch_Diamond
 * @version 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! bd_is_section_visible( 'archive' ) ) {
    return;
}

// ---- Customizer settings ----
$archive_months     = (int) get_theme_mod( 'bd_archive_months', 8 );
$archive_show_stats = get_theme_mod( 'bd_archive_show_stats', true );

// ---- Monthly archives ----
global $wp_locale;
$months = wp_get_archives( array(
    'type'   => 'monthly',
    'limit'  => max( 1, $archive_months ),
    'echo'   => false,
    'format' => 'custom',
    'before' => '',
    'after'  => '|||',
    'show_post_count' => true,
) );
$month_items = array_filter( array_map( 'trim', explode( '|||', (string) $months ) ) );

// ---- Site stats ----
$count_posts = wp_count_posts();
$stats = array(
    array(
        'icon'  => 'file-text',
        'label' => esc_html__( 'Posts', 'baloch-diamond' ),
        'value' => isset( $count_posts->publish ) ? (int) $count_posts->publish : 0,
    ),
    array(
        'icon'  => 'tag',
        'label' => esc_html__( 'Categories', 'baloch-diamond' ),
        'value' => (int) wp_count_terms( array( 'taxonomy' => 'category', 'hide_empty' => true ) ),
    ),
    array(
        'icon'  => 'book',
        'label' => esc_html__( 'Tags', 'baloch-diamond' ),
        'value' => (int) wp_count_terms( array( 'taxonomy' => 'post_tag', 'hide_empty' => true ) ),
    ),
    array(
        'icon'  => 'comment',
        'label' => esc_html__( 'Comments', 'baloch-diamond' ),
        'value' => (int) wp_count_comments()->approved,
    ),
);
?>

<section class="section" id="site-archive">

    <?php
    bd_section_header( 'archive', array(
        'badge' => esc_html__( 'Time Machine', 'baloch-diamond' ),
        'title' => esc_html__( 'Site Archive', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Browse everything we have published, month by month.', 'baloch-diamond' ),
        'icon'  => 'calendar',
    ) );
    ?>

    <?php if ( $archive_show_stats ) : ?>
    <div class="archive-stats-grid">
        <?php foreach ( $stats as $stat ) : ?>
        <div class="archive-stat-card">
            <span class="archive-stat-icon"><?php echo bd_icon( $stat['icon'], 22, 22 ); ?></span>
            <span class="archive-stat-value"><?php echo esc_html( number_format_i18n( $stat['value'] ) ); ?></span>
            <span class="archive-stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ( ! empty( $month_items ) ) : ?>
    <div class="archive-months-grid">
        <?php foreach ( $month_items as $item ) : ?>
            <div class="archive-month-card"><?php echo wp_kses_post( $item ); ?></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</section>

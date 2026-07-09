<?php
/**
 * Search form template
 *
 * Used everywhere via get_search_form() so plugins can filter it.
 * The header search overlay passes 'bd_context' => 'overlay' through
 * get_search_form( $args ) to render its AJAX-enabled variant (same
 * form, plus the IDs the live-search script hooks into).
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$bd_is_overlay = isset( $args['bd_context'] ) && 'overlay' === $args['bd_context'];
?>
<?php if ( $bd_is_overlay ) : ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" id="bdSearchForm">
    <label class="screen-reader-text" for="searchInput"><?php esc_html_e( 'Search for:', 'baloch-diamond' ); ?></label>
    <input type="search"
           class="search-input"
           id="searchInput"
           name="s"
           placeholder="<?php esc_attr_e( 'Search posts, pages...', 'baloch-diamond' ); ?>"
           value="<?php echo esc_attr( get_search_query() ); ?>"
           autocomplete="off">
</form>
<?php else : ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="search-input-wrapper" style="box-shadow:none">
        <label class="screen-reader-text" for="bd-search-field"><?php esc_html_e( 'Search for:', 'baloch-diamond' ); ?></label>
        <input type="search"
               class="search-input"
               id="bd-search-field"
               placeholder="<?php esc_attr_e( 'Search...', 'baloch-diamond' ); ?>"
               value="<?php echo esc_attr( get_search_query() ); ?>"
               name="s"
               style="padding:14px 20px;font-size:1rem">
    </div>
</form>
<?php endif; ?>

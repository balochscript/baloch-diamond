<?php
/**
 * Search form template
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="search-input-wrapper" style="box-shadow:none">
        <input type="search"
               class="search-input"
               placeholder="<?php esc_attr_e( 'Search...', 'baloch-diamond' ); ?>"
               value="<?php echo get_search_query(); ?>"
               name="s"
               style="padding:14px 20px;font-size:1rem">
    </div>
</form>
<?php
/**
 * Shop (WooCommerce) Section Template Part
 *
 * @package Baloch_Diamond
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Customizer options
$show_shop   = get_theme_mod( 'bd_shop_show', true );
$layout      = get_theme_mod( 'bd_shop_layout', 'grid' ); // 'grid' or 'slider'
$filter      = get_theme_mod( 'bd_shop_filter', 'recent' ); // 'recent', 'sale', 'featured', 'popular'
$count       = get_theme_mod( 'bd_shop_count', 4 );

if ( ! $show_shop ) {
    return;
}

// WooCommerce query setup
$products_found = false;
$products_list  = array();

if ( class_exists( 'WooCommerce' ) ) {
    
    $args = array(
        'limit'   => $count,
        'status'  => 'publish',
        'orderby' => 'date',
        'order'   => 'DESC',
    );

    // Apply filters
    if ( $filter === 'sale' ) {
        $args['on_sale'] = true;
    } elseif ( $filter === 'featured' ) {
        $args['featured'] = true;
    } elseif ( $filter === 'popular' ) {
        $args['orderby'] = 'popularity';
    }

    $products = wc_get_products( $args );

    if ( ! empty( $products ) ) {
        $products_found = true;
        foreach ( $products as $product ) {
            $products_list[] = array(
                'id'         => $product->get_id(),
                'title'      => $product->get_name(),
                'price'      => $product->get_price_html(),
                'link'       => get_permalink( $product->get_id() ),
                'image'      => wp_get_attachment_image_url( $product->get_image_id(), 'bd-card' ),
                'rating'     => $product->get_average_rating(),
                'on_sale'    => $product->is_on_sale(),
            );
        }
    }
}

// Fallback Mock products if WooCommerce not active or empty
if ( ! $products_found ) {
    $products_list = array(
        array(
            'id'      => 1,
            'title'   => esc_html__( 'Royal Baloch Shawl', 'baloch-diamond' ),
            'price'   => '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>120.00</bdi></span>',
            'link'    => '#_shop',
            'image'   => '',
            'rating'  => 5,
            'on_sale' => true,
        ),
        array(
            'id'      => 2,
            'title'   => esc_html__( 'Traditional Needlework Dress', 'baloch-diamond' ),
            'price'   => '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>280.00</bdi></span>',
            'link'    => '#_shop',
            'image'   => '',
            'rating'  => 5,
            'on_sale' => false,
        ),
        array(
            'id'      => 3,
            'title'   => esc_html__( 'Embroidered Pattern Guide', 'baloch-diamond' ),
            'price'   => '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>19.99</bdi></span>',
            'link'    => '#_shop',
            'image'   => '',
            'rating'  => 4.5,
            'on_sale' => true,
        ),
        array(
            'id'      => 4,
            'title'   => esc_html__( 'Diamond Motif Handbag', 'baloch-diamond' ),
            'price'   => '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>45.00</bdi></span>',
            'link'    => '#_shop',
            'image'   => '',
            'rating'  => 4,
            'on_sale' => false,
        ),
    );
    // Limit to user configured count
    $products_list = array_slice( $products_list, 0, $count );
}
?>

<section class="section shop-showcase-section" id="shop-showcase">
    
    <?php
    bd_section_header( 'shop', array(
        'badge' => esc_html__( 'Premium Marketplace', 'baloch-diamond' ),
        'title' => esc_html__( 'Artisanal Collections', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Explore hand-embroidered apparel, authentic Baloch crafts, and modern designer goods made with exquisite attention to detail.', 'baloch-diamond' ),
        'icon'  => 'tag',
    ) );
    ?>

    <?php if ( $layout === 'slider' ) : ?>
        <!-- Slider Layout -->
        <div class="shop-slider-container" style="position:relative; overflow:hidden; padding:20px 0;">
            <div class="shop-slider-wrapper" id="shopSliderWrapper" style="display:flex; transition: transform 0.5s ease; gap:24px;">
                <?php foreach ( $products_list as $prod ) : ?>
                    <div class="shop-product-card" style="flex: 0 0 calc(33.333% - 16px); min-width: 280px; box-sizing: border-box;">
                        <?php bd_render_product_card_html( $prod ); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if ( count( $products_list ) > 1 ) : ?>
                <div class="shop-slider-nav" style="display:flex; justify-content:center; gap:12px; margin-top:24px;">
                    <button class="btn-outline" id="shopSliderPrev" style="padding:8px 16px; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center;">
                        <?php echo bd_icon( 'arrow-left', 16, 16 ); ?>
                    </button>
                    <button class="btn-outline" id="shopSliderNext" style="padding:8px 16px; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center;">
                        <?php echo bd_icon( 'arrow-right-small', 16, 16 ); ?>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <!-- Grid Layout -->
        <div class="products-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:28px;">
            <?php foreach ( $products_list as $prod ) : ?>
                <?php bd_render_product_card_html( $prod ); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div style="text-align:center; margin-top:40px;">
        <a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : '#_shop' ); ?>" class="btn-gradient">
            <?php echo bd_icon( 'tag', 16, 16 ); ?>
            <?php esc_html_e( 'View Full Store', 'baloch-diamond' ); ?>
        </a>
    </div>

</section>

<?php
/**
 * Helper function to render a product card
 */
function bd_render_product_card_html( $prod ) {
    ?>
    <div class="project-card product-card">
        <div class="project-card-img-wrapper" style="position:relative; overflow:hidden; height:240px;">
            <?php if ( $prod['on_sale'] ) : ?>
                <span class="sale-badge" style="position:absolute; top:16px; left:16px; background:var(--color-secondary); color:white; padding:4px 12px; border-radius:12px; font-size:0.75rem; font-weight:700; z-index:2; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                    <?php esc_html_e( 'SALE', 'baloch-diamond' ); ?>
                </span>
            <?php endif; ?>
            
            <?php if ( $prod['image'] ) : ?>
                <img class="project-card-image" src="<?php echo esc_url( $prod['image'] ); ?>" alt="<?php echo esc_attr( $prod['title'] ); ?>" style="width:100%; height:100%; object-fit:cover;">
            <?php else : ?>
                <div style="width:100%; height:100%; background:var(--bg-alt); display:flex; align-items:center; justify-content:center;">
                    <div style="opacity:0.15; transform:scale(1.5);"><?php echo bd_icon( 'tag', 48, 48 ); ?></div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="project-card-content" style="padding:24px; text-align:center; display:flex; flex-direction:column; align-items:center;">
            <!-- Rating -->
            <div class="product-rating" style="display:flex; gap:4px; margin-bottom:8px; color:#fbbf24;">
                <?php
                $full_stars = floor( $prod['rating'] );
                for ( $s = 1; $s <= 5; $s++ ) {
                    if ( $s <= $full_stars ) {
                        echo '★';
                    } else {
                        echo '☆';
                    }
                }
                ?>
            </div>
            
            <h3 class="project-card-title" style="font-size:1.15rem; margin-bottom:8px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; width:100%;">
                <a href="<?php echo esc_url( $prod['link'] ); ?>" style="text-decoration:none; color:inherit; transition:color 0.3s;" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color='inherit'">
                    <?php echo esc_html( $prod['title'] ); ?>
                </a>
            </h3>
            
            <div class="product-price" style="font-size:1.2rem; font-weight:700; background:var(--gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; margin-bottom:16px;">
                <?php echo $prod['price']; ?>
            </div>
            
            <a href="<?php echo esc_url( $prod['link'] ); ?>" class="btn-outline" style="width:100%; justify-content:center; border-radius:10px; padding:8px 16px;">
                <?php esc_html_e( 'Select Option', 'baloch-diamond' ); ?>
            </a>
        </div>
    </div>
    <?php
}

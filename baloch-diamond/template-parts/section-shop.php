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
$layout      = get_theme_mod( 'bd_shop_layout', 'grid' ); // 'grid', 'slider', 'single'
$filter      = get_theme_mod( 'bd_shop_filter', 'recent' ); // 'recent', 'sale', 'featured', 'popular'
$count       = get_theme_mod( 'bd_shop_count', 4 );

if ( ! $show_shop ) {
    return;
}

// WooCommerce query setup
$products_found = false;
$products_list  = array();

if ( class_exists( 'WooCommerce' ) ) {
    
    // Check if Custom Selection is used
    $selected_pids = array();
    for ( $i = 1; $i <= 12; $i++ ) {
        $pid = get_theme_mod( "bd_shop_custom_product_{$i}", 0 );
        if ( $pid ) {
            $selected_pids[] = intval( $pid );
        }
    }

    if ( ! empty( $selected_pids ) ) {
        // Query only user chosen custom products
        $args = array(
            'include' => $selected_pids,
            'limit'   => count( $selected_pids ),
            'status'  => 'publish',
        );
    } else {
        // Fallback to standard filters
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
    }

    $products = wc_get_products( $args );

    if ( ! empty( $products ) ) {
        $products_found = true;
        foreach ( $products as $product ) {
            // Get original and sale price
            $reg_price = floatval( $product->get_regular_price() );
            $sale_price = floatval( $product->get_sale_price() );
            $discount_pct = 0;
            if ( $product->is_on_sale() && $reg_price > 0 ) {
                $discount_pct = round( ( ( $reg_price - $sale_price ) / $reg_price ) * 100 );
            }

            $products_list[] = array(
                'id'         => $product->get_id(),
                'title'      => $product->get_name(),
                'price'      => $product->get_price_html(),
                'link'       => get_permalink( $product->get_id() ),
                'image'      => wp_get_attachment_image_url( $product->get_image_id(), 'bd-card' ),
                'rating'     => $product->get_average_rating(),
                'on_sale'    => $product->is_on_sale(),
                'discount'   => $discount_pct,
                'desc'       => wp_trim_words( $product->get_short_description(), 20 ),
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
            'price'   => '<del><span class="amount">$150.00</span></del> <ins><span class="amount">$120.00</span></ins>',
            'link'    => '#_shop',
            'image'   => '',
            'rating'  => 5,
            'on_sale' => true,
            'discount'=> 20,
            'desc'    => esc_html__( 'A luxurious shawl featuring intricate hand-embroidered borders inspired by ancient Balochi geometric designs.', 'baloch-diamond' ),
        ),
        array(
            'id'      => 2,
            'title'   => esc_html__( 'Traditional Needlework Dress', 'baloch-diamond' ),
            'price'   => '<span class="amount">$280.00</span>',
            'link'    => '#_shop',
            'image'   => '',
            'rating'  => 5,
            'on_sale' => false,
            'discount'=> 0,
            'desc'    => esc_html__( 'Authentic Balochi dress adorned with delicate red and gold patterns, completely hand-stitched by native masters.', 'baloch-diamond' ),
        ),
        array(
            'id'      => 3,
            'title'   => esc_html__( 'Embroidered Pattern Guide', 'baloch-diamond' ),
            'price'   => '<del><span class="amount">$25.00</span></del> <ins><span class="amount">$19.99</span></ins>',
            'link'    => '#_shop',
            'image'   => '',
            'rating'  => 4.5,
            'on_sale' => true,
            'discount'=> 20,
            'desc'    => esc_html__( 'Comprehensive digital guide explaining the techniques, stitches, and maps of Balochi needlework art.', 'baloch-diamond' ),
        ),
        array(
            'id'      => 4,
            'title'   => esc_html__( 'Diamond Motif Handbag', 'baloch-diamond' ),
            'price'   => '<span class="amount">$45.00</span>',
            'link'    => '#_shop',
            'image'   => '',
            'rating'  => 4,
            'on_sale' => false,
            'discount'=> 0,
            'desc'    => esc_html__( 'Modern canvas purse featuring traditional silk embroideries of the signature Baloch Diamond motif.', 'baloch-diamond' ),
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

    <?php if ( $layout === 'single' && ! empty( $products_list ) ) : 
        // Single Product Layout - Big Card Showcase with Slide Controls
        $single_prod = $products_list[0];
        ?>
        <div class="shop-single-showcase" id="shopSingleShowcase" style="background:var(--card-bg); border:1px solid var(--border); border-radius:24px; box-shadow:var(--shadow); overflow:hidden; display:flex; flex-wrap:wrap; margin:20px auto; position:relative; max-width:960px;">
            <!-- Left Column: Big Image & Ribbon -->
            <div style="flex:1.2; min-width:300px; position:relative; overflow:hidden; height:400px; background:var(--bg-alt);">
                <?php if ( $single_prod['on_sale'] && $single_prod['discount'] > 0 ) : ?>
                    <!-- Red Ribbon Badge -->
                    <div class="discount-ribbon" style="position:absolute; top:20px; left:-10px; background:#ef4444; color:white; padding:6px 36px; transform:rotate(-45deg); font-size:0.8rem; font-weight:900; z-index:5; box-shadow:0 2px 10px rgba(0,0,0,0.25); text-transform:uppercase; letter-spacing:1px;">
                        <?php echo esc_html( $single_prod['discount'] ); ?>% OFF
                    </div>
                <?php endif; ?>

                <?php if ( $single_prod['image'] ) : ?>
                    <img src="<?php echo esc_url( $single_prod['image'] ); ?>" alt="<?php echo esc_attr( $single_prod['title'] ); ?>" style="width:100%; height:100%; object-fit:cover;">
                <?php else : ?>
                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                        <div style="opacity:0.15; transform:scale(2);"><?php echo bd_icon( 'tag', 48, 48 ); ?></div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Info & Action Buttons -->
            <div style="flex:1; min-width:300px; padding:40px; display:flex; flex-direction:column; justify-content:center; border-left:1px solid var(--border);">
                <!-- Stars -->
                <div style="display:flex; gap:4px; margin-bottom:12px; color:#fbbf24; font-size:1.1rem;">
                    <?php
                    $full_stars = floor( $single_prod['rating'] );
                    for ( $s = 1; $s <= 5; $s++ ) {
                        echo $s <= $full_stars ? '★' : '☆';
                    }
                    ?>
                </div>

                <h3 style="font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:900; margin-bottom:12px; line-height:1.3; color:var(--text);">
                    <?php echo esc_html( $single_prod['title'] ); ?>
                </h3>

                <p style="color:var(--text-muted); font-size:0.95rem; line-height:1.7; margin-bottom:24px;">
                    <?php echo esc_html( $single_prod['desc'] ); ?>
                </p>

                <div style="font-size:1.5rem; font-weight:800; background:var(--gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; margin-bottom:30px;">
                    <?php echo $single_prod['price']; ?>
                </div>

                <div style="display:flex; gap:12px; flex-wrap:wrap; width:100%;">
                    <a href="<?php echo esc_url( $single_prod['link'] ); ?>" class="btn-gradient" style="flex:2; justify-content:center; padding:12px 24px;">
                        <?php echo bd_icon( 'tag', 16, 16 ); ?>
                        <?php esc_html_e( 'View Product details', 'baloch-diamond' ); ?>
                    </a>

                    <?php if ( count( $products_list ) > 1 ) : ?>
                        <!-- Quick Mini Slider controls -->
                        <div style="display:flex; gap:6px;">
                            <button class="btn-outline" id="singlePrev" style="padding:12px; border-radius:12px; width:48px; height:48px; cursor:pointer;" title="<?php esc_attr_e( 'Previous Product', 'baloch-diamond' ); ?>">
                                <?php echo bd_icon( 'arrow-left', 16, 16 ); ?>
                            </button>
                            <button class="btn-outline" id="singleNext" style="padding:12px; border-radius:12px; width:48px; height:48px; cursor:pointer;" title="<?php esc_attr_e( 'Next Product', 'baloch-diamond' ); ?>">
                                <?php echo bd_icon( 'arrow-right-small', 16, 16 ); ?>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Render remaining products data for the JavaScript slider -->
        <script id="bd-single-products-json" type="application/json">
            <?php echo wp_json_encode( $products_list ); ?>
        </script>

    <?php elseif ( $layout === 'slider' ) : ?>
        <!-- Modern Scrollable Native Horizontal Slider (LTR & RTL compatible) -->
        <div class="shop-scroll-slider-container" style="position:relative; width:100%; padding:20px 0;">
            <div class="shop-scroll-wrapper" id="shopScrollWrapper" style="display:flex; overflow-x:auto; gap:24px; scroll-snap-type:x mandatory; scroll-behavior:smooth; padding-bottom:16px; -webkit-overflow-scrolling:touch;">
                <?php foreach ( $products_list as $prod ) : ?>
                    <div class="shop-product-card" style="flex:0 0 calc(33.333% - 16px); min-width:280px; scroll-snap-align:start; box-sizing:border-box;">
                        <?php bd_render_product_card_html( $prod ); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if ( count( $products_list ) > 1 ) : ?>
                <!-- Simple CSS hints or arrows to help horizontal scrolling -->
                <div style="display:flex; justify-content:center; gap:8px; margin-top:16px;">
                    <span style="font-size:0.8rem; color:var(--text-muted); font-weight:600; display:flex; align-items:center; gap:6px;">
                        <?php echo bd_icon( 'arrow-left', 14, 14 ); ?>
                        <?php esc_html_e( 'Scroll or Drag', 'baloch-diamond' ); ?>
                        <?php echo bd_icon( 'arrow-right-small', 14, 14 ); ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <!-- Grid Layout -->
        <div class="products-grid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:28px;">
            <?php foreach ( $products_list as $prod ) : ?>
                <div class="shop-product-card">
                    <?php bd_render_product_card_html( $prod ); ?>
                </div>
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
if ( ! function_exists( 'bd_render_product_card_html' ) ) {
    function bd_render_product_card_html( $prod ) {
        ?>
        <div class="project-card product-card">
            <div class="project-card-img-wrapper" style="position:relative; overflow:hidden; height:240px;">
                <?php if ( $prod['on_sale'] && $prod['discount'] > 0 ) : ?>
                    <!-- Red Ribbon Badge -->
                    <div class="discount-ribbon" style="position:absolute; top:12px; left:-10px; background:#ef4444; color:white; padding:4px 24px; transform:rotate(-45deg); font-size:0.65rem; font-weight:900; z-index:2; box-shadow:0 1px 5px rgba(0,0,0,0.2); text-transform:uppercase;">
                        <?php echo esc_html( $prod['discount'] ); ?>% OFF
                    </div>
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
                        echo $s <= $full_stars ? '★' : '☆';
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
}

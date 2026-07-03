<?php
/**
 * Shop (WooCommerce) Section - Fully Dynamic + 3 Layouts
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$show_shop   = get_theme_mod( 'bd_shop_show', true );
$layout      = get_theme_mod( 'bd_shop_layout', 'grid' );
$count       = get_theme_mod( 'bd_shop_count', 4 );
$filter      = get_theme_mod( 'bd_shop_filter', 'recent' );

if ( ! $show_shop ) return;

$products_list = array();
$use_real_products = false;

// Collect up to 12 selected products from customizer
$selected_ids = array();
for ( $i = 1; $i <= 12; $i++ ) {
    $pid = (int) get_theme_mod( "bd_shop_custom_product_{$i}", 0 );
    if ( $pid > 0 ) $selected_ids[] = $pid;
}

if ( class_exists( 'WooCommerce' ) ) {
    if ( ! empty( $selected_ids ) ) {
        // Manual selection takes priority
        $args = array(
            'include' => $selected_ids,
            'limit'   => count( $selected_ids ),
            'status'  => 'publish',
            'orderby' => 'post__in',
        );
    } else {
        // Apply filter from Customizer
        $args = array(
            'limit'   => $count,
            'status'  => 'publish',
        );

        switch ( $filter ) {
            case 'sale':
                $sale_ids = wc_get_product_ids_on_sale();
                if ( ! empty( $sale_ids ) ) {
                    $args['include'] = $sale_ids;
                    $args['orderby'] = 'post__in';
                } else {
                    $args['orderby'] = 'date';
                    $args['order']   = 'DESC';
                }
                break;

            case 'featured':
                $featured_ids = wc_get_featured_product_ids();
                if ( ! empty( $featured_ids ) ) {
                    $args['include'] = $featured_ids;
                    $args['orderby'] = 'post__in';
                } else {
                    $args['orderby'] = 'date';
                    $args['order']   = 'DESC';
                }
                break;

            case 'popular':
                $args['orderby'] = 'popularity';
                $args['order']   = 'DESC';
                break;

            case 'recent':
            default:
                $args['orderby'] = 'date';
                $args['order']   = 'DESC';
                break;
        }
    }

    $products = wc_get_products( $args );

    if ( ! empty( $products ) ) {
        $use_real_products = true;
        foreach ( $products as $product ) {
            $reg  = (float) $product->get_regular_price();
            $sale = (float) $product->get_sale_price();
            $discount = ( $product->is_on_sale() && $reg > 0 ) ? round( ( ($reg - $sale) / $reg ) * 100 ) : 0;

            $products_list[] = array(
                'id'        => $product->get_id(),
                'title'     => $product->get_name(),
                'price'     => $product->get_price_html(),
                'link'      => get_permalink( $product->get_id() ),
                'image'     => wp_get_attachment_image_url( $product->get_image_id(), 'bd-card' ) ?: '',
                'rating'    => (float) $product->get_average_rating(),
                'on_sale'   => $product->is_on_sale(),
                'discount'  => $discount,
                'desc'      => wp_trim_words( $product->get_short_description(), 18 ),
            );
        }
    }
}

// Fallback mock data (kept for demo when no WooCommerce)
if ( empty( $products_list ) ) {
    $products_list = array(
        array('id'=>1,'title'=>'Royal Baloch Shawl','price'=>'<del>$150</del> <ins>$120</ins>','link'=>'#_shop','image'=>'','rating'=>5,'on_sale'=>true,'discount'=>20,'desc'=>'Luxurious hand-embroidered shawl.'),
        array('id'=>2,'title'=>'Traditional Needlework Dress','price'=>'$280','link'=>'#_shop','image'=>'','rating'=>4.8,'on_sale'=>false,'discount'=>0,'desc'=>'Authentic Balochi dress.'),
        array('id'=>3,'title'=>'Embroidered Pattern Guide','price'=>'$19.99','link'=>'#_shop','image'=>'','rating'=>4.5,'on_sale'=>true,'discount'=>20,'desc'=>'Digital guide to stitches.'),
    );
    $products_list = array_slice( $products_list, 0, $count );
}
?>

<section class="section shop-showcase-section" id="shop-showcase">
    <?php bd_section_header( 'shop', array(
        'badge' => esc_html__( 'Premium Marketplace', 'baloch-diamond' ),
        'title' => esc_html__( 'Artisanal Collections', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Discover authentic Balochi crafts and modern designer goods.', 'baloch-diamond' ),
        'icon'  => 'tag',
    ) ); ?>

    <?php if ( $layout === 'single-big' && ! empty( $products_list ) ) : ?>
        <!-- SINGLE BIG CARD + Mini Navigation -->
        <?php $prod = $products_list[0]; ?>
        <div class="shop-single-big" id="shopSingleBig" style="max-width:980px;margin:0 auto;background:var(--card-bg);border:1px solid var(--border);border-radius:24px;overflow:hidden;display:flex;flex-wrap:wrap;box-shadow:var(--shadow);">
            
            <!-- Image with ribbon -->
            <div style="flex:1;min-width:320px;position:relative;height:420px;background:var(--bg-alt);">
                <?php if ( $prod['on_sale'] && $prod['discount'] > 0 ) : ?>
                    <div style="position:absolute;top:18px;left:-8px;background:#ef4444;color:white;padding:7px 38px;font-size:0.8rem;font-weight:900;transform:rotate(-42deg);box-shadow:0 3px 12px rgba(0,0,0,0.25);z-index:3;letter-spacing:0.5px;">
                        -<?php echo esc_html( $prod['discount'] ); ?>%
                    </div>
                <?php endif; ?>
                
                <?php if ( $prod['image'] ) : ?>
                    <img src="<?php echo esc_url( $prod['image'] ); ?>" alt="<?php echo esc_attr( $prod['title'] ); ?>" style="width:100%;height:100%;object-fit:cover;">
                <?php else : ?>
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;opacity:0.15;">
                        <?php echo bd_icon( 'tag', 80, 80 ); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Info -->
            <div style="flex:1;min-width:320px;padding:42px 38px;display:flex;flex-direction:column;justify-content:center;">
                <div style="display:flex;gap:4px;margin-bottom:10px;color:#fbbf24;font-size:1.15rem;">
                    <?php for ( $s=1; $s<=5; $s++ ) echo $s <= floor($prod['rating']) ? '★' : '☆'; ?>
                </div>

                <h3 style="font-size:1.85rem;font-weight:900;margin-bottom:12px;line-height:1.2;color:var(--text);"><?php echo esc_html( $prod['title'] ); ?></h3>
                
                <p style="color:var(--text-muted);font-size:1rem;line-height:1.7;margin-bottom:22px;"><?php echo esc_html( $prod['desc'] ); ?></p>

                <div style="font-size:1.65rem;font-weight:800;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:28px;">
                    <?php echo $prod['price']; ?>
                </div>

                <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                    <a href="<?php echo esc_url( $prod['link'] ); ?>" class="btn-gradient" style="flex:1;min-width:160px;justify-content:center;">
                        <?php esc_html_e( 'View Product', 'baloch-diamond' ); ?>
                    </a>

                    <?php if ( count( $products_list ) > 1 ) : ?>
                        <div style="display:flex;gap:8px;">
                            <button onclick="shopSingleBigPrev()" class="btn-outline" style="width:48px;height:48px;padding:0;border-radius:12px;" aria-label="Previous">←</button>
                            <button onclick="shopSingleBigNext()" class="btn-outline" style="width:48px;height:48px;padding:0;border-radius:12px;" aria-label="Next">→</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <script>
        (function(){
            var data = <?php echo wp_json_encode( $products_list ); ?>;
            var idx = 0;
            window.shopSingleBigNext = function(){ idx = (idx+1) % data.length; updateBigCard(idx); };
            window.shopSingleBigPrev = function(){ idx = (idx-1+data.length) % data.length; updateBigCard(idx); };
            
            function updateBigCard(i){
                var p = data[i];
                var container = document.getElementById('shopSingleBig');
                if(!container) return;
                
                // Update image
                var imgWrap = container.children[0];
                imgWrap.innerHTML = '';
                if(p.image){
                    var img = document.createElement('img');
                    img.src = p.image; img.style.cssText='width:100%;height:100%;object-fit:cover;';
                    imgWrap.appendChild(img);
                } else {
                    imgWrap.innerHTML = '<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;opacity:.15;"><?php echo bd_icon("tag",80,80); ?></div>';
                }
                
                // Ribbon
                if(p.on_sale && p.discount > 0){
                    var rib = document.createElement('div');
                    rib.style.cssText='position:absolute;top:18px;left:-8px;background:#ef4444;color:white;padding:7px 38px;font-size:.8rem;font-weight:900;transform:rotate(-42deg);box-shadow:0 3px 12px rgba(0,0,0,0.25);z-index:3;letter-spacing:.5px;';
                    rib.textContent = '-' + p.discount + '%';
                    imgWrap.appendChild(rib);
                }
                
                // Info
                var info = container.children[1];
                info.querySelector('h3').textContent = p.title;
                info.querySelector('p').textContent = p.desc;
                info.querySelector('div[style*="1.65rem"]').innerHTML = p.price;
                
                var stars = info.querySelector('div[style*="fbbf24"]');
                if(stars){
                    stars.innerHTML = '';
                    for(var s=1;s<=5;s++) stars.innerHTML += (s <= Math.floor(p.rating)) ? '★' : '☆';
                }
            }
        })();
        </script>

    <?php elseif ( $layout === 'horizontal-scroll' ) : ?>
        <!-- HORIZONTAL SCROLLABLE SLIDER (RTL / LTR friendly) -->
        <div class="shop-horizontal-scroll" style="overflow-x:auto;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;padding:8px 0;">
            <div style="display:flex;gap:22px;min-width:max-content;padding:0 8px;">
                <?php foreach ( $products_list as $prod ) : ?>
                    <div style="flex:0 0 280px;scroll-snap-align:start;">
                        <?php bd_render_product_card_html( $prod ); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    <?php else : ?>
        <!-- GRID -->
        <div class="products-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(270px,1fr));gap:28px;">
            <?php foreach ( $products_list as $prod ) : ?>
                <div class="shop-product-card"><?php bd_render_product_card_html( $prod ); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div style="text-align:center;margin-top:44px;">
        <a href="<?php echo esc_url( class_exists('WooCommerce') ? wc_get_page_permalink('shop') : '#_shop' ); ?>" class="btn-gradient">
            <?php echo bd_icon( 'tag', 16, 16 ); ?> <?php esc_html_e( 'Browse Full Store', 'baloch-diamond' ); ?>
        </a>
    </div>
</section>

<?php
// Reusable clean product card (used by grid + horizontal)
if ( ! function_exists( 'bd_render_product_card_html' ) ) {
    function bd_render_product_card_html( $prod ) {
        ?>
        <div class="project-card product-card" style="height:100%;">
            <div class="project-card-img-wrapper" style="position:relative;height:240px;overflow:hidden;">
                <?php if ( $prod['on_sale'] && $prod['discount'] > 0 ) : ?>
                    <div style="position:absolute;top:14px;left:-6px;background:#ef4444;color:#fff;font-weight:900;font-size:.68rem;padding:5px 28px;transform:rotate(-43deg);box-shadow:0 2px 8px rgba(239,68,68,.3);z-index:2;letter-spacing:.3px;">
                        -<?php echo esc_html( $prod['discount'] ); ?>%
                    </div>
                <?php endif; ?>
                
                <?php if ( $prod['image'] ) : ?>
                    <img class="project-card-image" src="<?php echo esc_url( $prod['image'] ); ?>" alt="<?php echo esc_attr( $prod['title'] ); ?>" style="width:100%;height:100%;object-fit:cover;">
                <?php else : ?>
                    <div style="width:100%;height:100%;background:var(--bg-alt);display:flex;align-items:center;justify-content:center;opacity:.12;">
                        <?php echo bd_icon( 'tag', 62, 62 ); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="project-card-content" style="padding:22px 20px 24px;text-align:center;">
                <div style="color:#fbbf24;font-size:1rem;margin-bottom:6px;">
                    <?php for ( $s=1; $s<=5; $s++ ) echo $s <= floor($prod['rating']) ? '★' : '☆'; ?>
                </div>
                
                <h3 class="project-card-title" style="font-size:1.1rem;margin-bottom:8px;">
                    <a href="<?php echo esc_url( $prod['link'] ); ?>" style="color:inherit;text-decoration:none;"><?php echo esc_html( $prod['title'] ); ?></a>
                </h3>
                
                <div style="font-size:1.18rem;font-weight:700;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:16px;">
                    <?php echo $prod['price']; ?>
                </div>
                
                <a href="<?php echo esc_url( $prod['link'] ); ?>" class="btn-outline" style="width:100%;justify-content:center;border-radius:10px;">
                    <?php esc_html_e( 'View Details', 'baloch-diamond' ); ?>
                </a>
            </div>
        </div>
        <?php
    }
}

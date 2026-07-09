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

if ( ! bd_is_section_visible( 'shop' ) ) {
    return;
}

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
            // Prefer the variation price range for variable products —
            // get_regular_price()/get_sale_price() return an empty string
            // on the parent WC_Product_Variable, which previously made the
            // discount always calculate to 0 (and the sale badge never show)
            // for any store using product variations.
            if ( $product->is_type( 'variable' ) ) {
                $reg  = (float) $product->get_variation_regular_price( 'min' );
                $sale = (float) $product->get_variation_sale_price( 'min' );
            } else {
                $reg  = (float) $product->get_regular_price();
                $sale = (float) $product->get_sale_price();
            }
            $discount = ( $product->is_on_sale() && $reg > 0 && $sale > 0 && $sale < $reg ) ? round( ( ( $reg - $sale ) / $reg ) * 100 ) : 0;

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
            
            <!-- Image with discount badge -->
            <div style="flex:1;min-width:320px;position:relative;height:420px;background:var(--bg-alt);">
                <?php if ( $prod['on_sale'] && $prod['discount'] > 0 ) : ?>
                    <?php echo bd_render_discount_bookmark( $prod['discount'], 'md' ); ?>
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
                    <?php for ( $s = 1; $s <= 5; $s++ ) { echo esc_html( $s <= floor( $prod['rating'] ) ? '★' : '☆' ); } ?>
                </div>

                <h3 style="font-size:1.85rem;font-weight:900;margin-bottom:12px;line-height:1.2;color:var(--text);"><?php echo esc_html( $prod['title'] ); ?></h3>
                
                <p style="color:var(--text-muted);font-size:1rem;line-height:1.7;margin-bottom:22px;"><?php echo esc_html( $prod['desc'] ); ?></p>

                <div style="font-size:1.65rem;font-weight:800;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:28px;">
                    <?php echo wp_kses_post( $prod['price'] ); ?>
                </div>

                <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                    <a href="<?php echo esc_url( $prod['link'] ); ?>" class="btn-gradient" style="flex:1;min-width:160px;justify-content:center;">
                        <?php esc_html_e( 'View Product', 'baloch-diamond' ); ?>
                    </a>

                    <?php if ( count( $products_list ) > 1 ) : ?>
                        <!-- Dot indicators -->
                        <div class="bd-shop-dots" id="shopBigDots" style="display:flex;gap:7px;align-items:center;">
                            <?php foreach ( $products_list as $di => $dp ) : ?>
                            <span class="bd-shop-dot<?php echo $di === 0 ? ' active' : ''; ?>"
                                  data-index="<?php echo esc_attr( $di ); ?>"
                                  style="display:block;width:<?php echo $di === 0 ? '22px' : '7px'; ?>;height:7px;border-radius:4px;background:<?php echo $di === 0 ? 'var(--color-primary)' : 'var(--border)'; ?>;cursor:pointer;transition:all .3s;">
                            </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <script>
        (function(){
            var data    = <?php echo wp_json_encode( $products_list ); ?>;
            var idx     = 0;
            var total   = data.length;
            var container = document.getElementById('shopSingleBig');
            var dotsWrap  = document.getElementById('shopBigDots');
            var bookmarkUid = 0;

            /* ---- Build the Balochi-embroidered bookmark ribbon markup ---- */
            function buildBookmarkHTML( discount, size ){
                bookmarkUid++;
                var gradId = 'bdBookmarkGradJS' + bookmarkUid;
                var sizeClass = ( size === 'sm' ) ? ' bd-bookmark--sm' : '';
                return '<div class="bd-bookmark' + sizeClass + '" role="img" aria-label="' + discount + '% off">' +
                    '<svg viewBox="0 0 52 76" xmlns="http://www.w3.org/2000/svg" focusable="false" aria-hidden="true">' +
                        '<defs><linearGradient id="' + gradId + '" x1="0" y1="0" x2="0" y2="1">' +
                            '<stop offset="0%" stop-color="#f43f5e"/>' +
                            '<stop offset="55%" stop-color="#dc2626"/>' +
                            '<stop offset="100%" stop-color="#9f1239"/>' +
                        '</linearGradient></defs>' +
                        '<path d="M2,0 H50 V70 L26,52 L2,70 Z" fill="url(#' + gradId + ')"/>' +
                        '<rect x="2" y="0" width="48" height="4" fill="#fbbf24"/>' +
                        '<path d="M2,0 H50 V70 L26,52 L2,70 Z" fill="none" stroke="#fde68a" stroke-width="1.2" stroke-dasharray="3 2" opacity="0.9"/>' +
                        '<g fill="none" stroke="#fde68a" stroke-width="1.1">' +
                            '<path d="M13,10 L16,14 L13,18 L10,14 Z"/>' +
                            '<path d="M26,10 L29,14 L26,18 L23,14 Z"/>' +
                            '<path d="M39,10 L42,14 L39,18 L36,14 Z"/>' +
                        '</g>' +
                        '<g fill="#38bdf8">' +
                            '<circle cx="13" cy="14" r="1.1"/>' +
                            '<circle cx="26" cy="14" r="1.1"/>' +
                            '<circle cx="39" cy="14" r="1.1"/>' +
                        '</g>' +
                        '<text x="26" y="38" text-anchor="middle" fill="#ffffff" font-size="14" font-weight="900" font-family="Arial, sans-serif">-' + discount + '%</text>' +
                        '<text x="26" y="47" text-anchor="middle" fill="#fde68a" font-size="6" font-weight="700" letter-spacing="1.2" font-family="Arial, sans-serif">OFF</text>' +
                    '</svg>' +
                '</div>';
            }

            /* ---- Dot indicators ---- */
            function updateDots(i){
                if(!dotsWrap) return;
                var dots = dotsWrap.querySelectorAll('.bd-shop-dot');
                dots.forEach(function(d, di){
                    if(di === i){
                        d.style.width   = '22px';
                        d.style.background = 'var(--color-primary)';
                    } else {
                        d.style.width   = '7px';
                        d.style.background = 'var(--border)';
                    }
                });
                /* click on dot */
                dots.forEach(function(d){
                    d.onclick = function(){ goTo(parseInt(this.dataset.index)); };
                });
            }

            /* ---- Render card ---- */
            function updateBigCard(i){
                if(!container) return;
                var p = data[i];

                var imgWrap = container.children[0];
                imgWrap.innerHTML = '';

                /* Sale badge */
                if(p.on_sale && p.discount > 0){
                    imgWrap.insertAdjacentHTML('beforeend', buildBookmarkHTML(p.discount, 'md'));
                }

                if(p.image){
                    var img = document.createElement('img');
                    img.src = p.image;
                    img.alt = p.title;
                    img.style.cssText = 'width:100%;height:100%;object-fit:cover;transition:opacity .35s;';
                    img.style.opacity = '0';
                    imgWrap.appendChild(img);
                    setTimeout(function(){ img.style.opacity = '1'; }, 16);
                } else {
                    imgWrap.innerHTML += '<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;opacity:.15;"><?php echo bd_icon("tag",80,80); ?></div>';
                }

                var info = container.children[1];
                info.querySelector('h3').textContent = p.title;
                info.querySelector('p').textContent  = p.desc;
                info.querySelector('div[style*="1.65rem"]').innerHTML = p.price;
                info.querySelector('a.btn-gradient').href = p.link || '#';

                var stars = info.querySelector('div[style*="fbbf24"]');
                if(stars){
                    stars.innerHTML = '';
                    for(var s=1;s<=5;s++) stars.innerHTML += (s<=Math.floor(p.rating))?'★':'☆';
                }

                updateDots(i);
            }

            function goTo(i){
                idx = (i + total) % total;
                updateBigCard(idx);
            }

            /* ---- Touch / Mouse swipe on image ---- */
            function addSwipe(el){
                var startX = 0, startY = 0, isDragging = false, moved = false;

                /* Pointer events (covers mouse + touch + stylus) */
                el.addEventListener('pointerdown', function(e){
                    startX = e.clientX;
                    startY = e.clientY;
                    isDragging = true;
                    moved = false;
                    el.style.cursor = 'grabbing';
                    el.setPointerCapture(e.pointerId);
                }, {passive:true});

                el.addEventListener('pointermove', function(e){
                    if(!isDragging) return;
                    if(Math.abs(e.clientX - startX) > 8) moved = true;
                }, {passive:true});

                el.addEventListener('pointerup', function(e){
                    if(!isDragging) return;
                    isDragging = false;
                    el.style.cursor = 'grab';
                    if(!moved) return;
                    var diff = startX - e.clientX;
                    if(Math.abs(diff) > 40){
                        goTo(diff > 0 ? idx + 1 : idx - 1);
                    }
                }, {passive:true});

                /* Prevent image drag ghost */
                el.addEventListener('dragstart', function(e){ e.preventDefault(); });
            }

            /* Init */
            if(container && total > 1){
                var imgWrap = container.children[0];
                imgWrap.style.cursor = 'grab';
                addSwipe(imgWrap);
                updateDots(0);

                /* Also swipe on the full card */
                addSwipe(container);
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

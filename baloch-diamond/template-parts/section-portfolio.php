<?php
/**
 * Portfolio Section Template Part
 *
 * Fully standalone — content is defined in the Customizer.
 * Default: custom items entered manually by the site admin.
 * Optional: admin can switch the source to WordPress posts.
 *
 * Customizer: Appearance → Customize → 💎 Baloch Diamond Settings → 🖼️ Portfolio Section
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ---- Hide / Show ----
if ( ! bd_is_section_visible( 'portfolio' ) ) {
    return;
}

// ---- Display settings ----
$source       = get_theme_mod( 'bd_portfolio_source', 'custom' ); // 'custom' | 'posts'
$count        = max( 1, (int) get_theme_mod( 'bd_portfolio_count', 6 ) );
$show_cat     = get_theme_mod( 'bd_portfolio_show_category', true );
$show_excerpt = get_theme_mod( 'bd_portfolio_show_excerpt', false );
$show_title   = get_theme_mod( 'bd_portfolio_show_title', true );
$show_viewall = get_theme_mod( 'bd_portfolio_show_viewall', true );
$viewall_text = get_theme_mod( 'bd_portfolio_viewall_text', esc_html__( 'View All Projects', 'baloch-diamond' ) );
$viewall_url  = get_theme_mod( 'bd_portfolio_viewall_url', '' );
$bg_color     = get_theme_mod( 'bd_portfolio_bg_color', '' );
$btn_txt      = get_theme_mod( 'bd_portfolio_btn_text', esc_html__( 'More Info', 'baloch-diamond' ) );

$section_style = $bg_color ? ' style="background-color:' . esc_attr( $bg_color ) . ';"' : '';

if ( ! $viewall_url ) {
    $viewall_url = home_url( '/' );
}

// ---- Build items array ----
$items = array();

if ( $source === 'posts' ) {

    // ---- Optional mode: WordPress posts ----
    $q = new WP_Query( array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $count,
        'meta_key'       => '_thumbnail_id',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    if ( $q->have_posts() ) {
        while ( $q->have_posts() ) {
            $q->the_post();
            $cats    = get_the_category();
            $items[] = array(
                'title'    => get_the_title(),
                'category' => ! empty( $cats ) ? esc_html( $cats[0]->name ) : '',
                'desc'     => get_the_excerpt(),
                'image'    => get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ),
                'link'     => get_permalink(),
                'newtab'   => false,
            );
        }
        wp_reset_postdata();
    }

} else {

    // ---- Default mode: manual Customizer items (fully standalone) ----
    for ( $i = 1; $i <= 12; $i++ ) {
        $title = get_theme_mod( "bd_portfolio_item_{$i}_title", '' );
        if ( ! $title ) {
            continue;
        }
        $items[] = array(
            'title'    => $title,
            'category' => get_theme_mod( "bd_portfolio_item_{$i}_category", '' ),
            'desc'     => get_theme_mod( "bd_portfolio_item_{$i}_desc", '' ),
            'image'    => get_theme_mod( "bd_portfolio_item_{$i}_image", '' ),
            'link'     => get_theme_mod( "bd_portfolio_item_{$i}_link", '' ),
            'newtab'   => get_theme_mod( "bd_portfolio_item_{$i}_newtab", false ),
        );
        if ( count( $items ) >= $count ) {
            break;
        }
    }

    // No items configured yet — show a setup hint to admins only
    if ( empty( $items ) && is_user_logged_in() && current_user_can( 'manage_options' ) ) {
        echo '<div style="background:var(--bg-alt);border:2px dashed var(--border);border-radius:16px;padding:40px;text-align:center;margin:40px 24px;">'
           . '<p style="font-size:1rem;color:var(--text-muted);margin:0;">'
           . '🖼️ <strong>' . esc_html__( 'Portfolio Section', 'baloch-diamond' ) . '</strong> — '
           . esc_html__( 'No items yet. Go to Appearance → Customize → 🖼️ Portfolio Section and add your projects (Title, Image, Link).', 'baloch-diamond' )
           . '</p></div>';
        return;
    }

}

// No items at all — hide the section
if ( empty( $items ) ) {
    return;
}

// ---- Collect unique categories for filter tabs ----
$all_cats = array();
foreach ( $items as $item ) {
    if ( ! empty( $item['category'] ) && ! in_array( $item['category'], $all_cats, true ) ) {
        $all_cats[] = $item['category'];
    }
}

$show_filter_tabs = get_theme_mod( 'bd_portfolio_show_filter', true ) && count( $all_cats ) > 1;
?>

<section class="section balochi-pattern" id="projects"<?php echo $section_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

    <?php
    bd_section_header( 'portfolio', array(
        'badge' => esc_html__( 'Our Portfolio', 'baloch-diamond' ),
        'title' => esc_html__( 'Featured Projects', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Showcasing our finest work blending tradition with innovation. Each project tells a unique story of creativity and craftsmanship.', 'baloch-diamond' ),
        'icon'  => 'monitor',
    ) );
    ?>

    <?php if ( $show_filter_tabs ) : ?>
    <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center;margin-bottom:32px;position:relative;z-index:1;">
        <button
            class="bd-filter-btn active"
            data-filter="*"
            onclick="bdFilterPortfolio(this,'*')"
            style="padding:8px 22px;border-radius:30px;border:2px solid var(--color-primary);background:var(--gradient);color:white;font-weight:600;font-size:0.85rem;cursor:pointer;transition:all .3s;">
            <?php esc_html_e( 'All', 'baloch-diamond' ); ?>
        </button>
        <?php foreach ( $all_cats as $cat ) : ?>
        <button
            class="bd-filter-btn"
            data-filter="<?php echo esc_attr( sanitize_title( $cat ) ); ?>"
            onclick="bdFilterPortfolio(this,'<?php echo esc_attr( sanitize_title( $cat ) ); ?>')"
            style="padding:8px 22px;border-radius:30px;border:2px solid var(--border);background:transparent;color:var(--text);font-weight:600;font-size:0.85rem;cursor:pointer;transition:all .3s;">
            <?php echo esc_html( $cat ); ?>
        </button>
        <?php endforeach; ?>
    </div>

    <style>
    .bd-filter-btn.active {
        background: var(--gradient) !important;
        border-color: var(--color-primary) !important;
        color: white !important;
    }
    .bd-filter-btn:hover:not(.active) {
        border-color: var(--color-primary) !important;
        color: var(--color-primary) !important;
    }
    .bd-portfolio-item-wrap {
        transition: opacity .3s, transform .3s;
    }
    .bd-portfolio-item-wrap.bd-hidden {
        display: none;
    }
    </style>
    <?php endif; ?>

    <div class="projects-grid" id="bd-portfolio-grid" style="position:relative;z-index:1;">

        <?php foreach ( $items as $item ) :
            $target   = ! empty( $item['newtab'] ) ? '_blank' : '_self';
            $rel      = ! empty( $item['newtab'] ) ? ' rel="noopener noreferrer"' : '';
            $cat_slug = ! empty( $item['category'] ) ? sanitize_title( $item['category'] ) : '';
        ?>

        <div class="bd-portfolio-item-wrap" data-category="<?php echo esc_attr( $cat_slug ); ?>">
        <div class="project-card">

            <div class="project-card-img-wrapper">
                <?php if ( ! empty( $item['image'] ) ) : ?>
                <img class="project-card-image"
                     src="<?php echo esc_url( $item['image'] ); ?>"
                     alt="<?php echo esc_attr( $item['title'] ); ?>"
                     loading="lazy">
                <?php else : ?>
                <div class="project-card-image"
                     style="background:linear-gradient(135deg,var(--bg-alt),var(--border));display:flex;align-items:center;justify-content:center;">
                    <div style="opacity:0.25;"><?php echo bd_icon( 'monitor', 48, 48 ); ?></div>
                </div>
                <?php endif; ?>

                <?php if ( $show_cat && ! empty( $item['category'] ) ) : ?>
                <span style="position:absolute;top:12px;left:12px;padding:4px 14px;border-radius:20px;font-size:0.75rem;font-weight:700;background:var(--gradient);color:white;letter-spacing:0.3px;">
                    <?php echo esc_html( $item['category'] ); ?>
                </span>
                <?php endif; ?>
            </div><!-- .project-card-img-wrapper -->

            <div class="project-card-content">

                <?php if ( $show_title ) : ?>
                <h3 class="project-card-title">
                    <?php if ( ! empty( $item['link'] ) ) : ?>
                    <a href="<?php echo esc_url( $item['link'] ); ?>"
                       target="<?php echo esc_attr( $target ); ?>"
                       <?php echo $rel; // phpcs:ignore ?>
                       style="color:inherit;text-decoration:none;">
                        <?php echo esc_html( $item['title'] ); ?>
                    </a>
                    <?php else : ?>
                    <?php echo esc_html( $item['title'] ); ?>
                    <?php endif; ?>
                </h3>
                <?php endif; ?>

                <?php if ( $show_excerpt && ! empty( $item['desc'] ) ) : ?>
                <p class="project-card-excerpt">
                    <?php echo esc_html( wp_trim_words( $item['desc'], 18, '…' ) ); ?>
                </p>
                <?php endif; ?>

                <?php if ( ! empty( $item['link'] ) ) : ?>
                <a href="<?php echo esc_url( $item['link'] ); ?>"
                   target="<?php echo esc_attr( $target ); ?>"
                   <?php echo $rel; // phpcs:ignore ?>
                   class="btn-gradient">
                    <?php echo esc_html( $btn_txt ); ?>
                    <?php echo bd_icon( 'arrow-right', 16, 16 ); ?>
                </a>
                <?php endif; ?>

            </div><!-- .project-card-content -->

        </div><!-- .project-card -->
        </div><!-- .bd-portfolio-item-wrap -->

        <?php endforeach; ?>

    </div><!-- #bd-portfolio-grid -->

    <?php if ( $show_viewall ) : ?>
    <div style="text-align:center;margin-top:40px;position:relative;z-index:1;">
        <a href="<?php echo esc_url( $viewall_url ); ?>" class="btn-outline">
            <?php echo esc_html( $viewall_text ); ?>
            <?php echo bd_icon( 'arrow-right', 16, 16 ); ?>
        </a>
    </div>
    <?php endif; ?>

    <?php if ( $show_filter_tabs ) : ?>
    <script>
    function bdFilterPortfolio(btn, filter) {
        // Update active button
        document.querySelectorAll('.bd-filter-btn').forEach(function(b) {
            b.classList.remove('active');
        });
        btn.classList.add('active');

        // Filter cards
        document.querySelectorAll('#bd-portfolio-grid .bd-portfolio-item-wrap').forEach(function(card) {
            if (filter === '*' || card.dataset.category === filter) {
                card.classList.remove('bd-hidden');
            } else {
                card.classList.add('bd-hidden');
            }
        });
    }
    </script>
    <?php endif; ?>

</section>

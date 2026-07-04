<?php
/**
 * Forum / Community Section Template Part — FULLY ENHANCED
 *
 * All 3 quick-action buttons support: custom text, custom URL, new-tab, individual hide/show.
 * "Visit Full Forums" link is also fully customizable.
 * Section-level Show/Hide toggle.
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// All Customizer options
$show_forum  = get_theme_mod( 'bd_forum_show', true );
$mode        = get_theme_mod( 'bd_forum_mode', 'topics' );
$count       = get_theme_mod( 'bd_forum_count', 4 );
$show_stats  = get_theme_mod( 'bd_forum_show_stats', true );

$forum_badge = get_theme_mod( 'bd_forum_badge', esc_html__( 'Join the Circle', 'baloch-diamond' ) );
$forum_title = get_theme_mod( 'bd_forum_title', esc_html__( 'Community Hub', 'baloch-diamond' ) );
$forum_desc  = get_theme_mod( 'bd_forum_desc', esc_html__( 'Connect with fellow artisans, ask questions, and share your creations.', 'baloch-diamond' ) );

// Buttons
$btn1_show   = get_theme_mod( 'bd_forum_btn1_show', true );
$btn_ask     = get_theme_mod( 'bd_forum_btn_ask', esc_html__( 'Ask a Question', 'baloch-diamond' ) );
$btn1_url    = get_theme_mod( 'bd_forum_btn1_url', '' );
$btn1_newtab = get_theme_mod( 'bd_forum_btn1_newtab', false );

$btn2_show   = get_theme_mod( 'bd_forum_btn2_show', true );
$btn_share   = get_theme_mod( 'bd_forum_btn_share', esc_html__( 'Share Your Pattern', 'baloch-diamond' ) );
$btn2_url    = get_theme_mod( 'bd_forum_btn2_url', '' );
$btn2_newtab = get_theme_mod( 'bd_forum_btn2_newtab', false );

$btn3_show     = get_theme_mod( 'bd_forum_btn3_show', true );
$btn_workshop  = get_theme_mod( 'bd_forum_btn_workshop', esc_html__( 'Join Workshop', 'baloch-diamond' ) );
$btn3_url      = get_theme_mod( 'bd_forum_btn3_url', '' );
$btn3_newtab   = get_theme_mod( 'bd_forum_btn3_newtab', false );

$visit_full_text = get_theme_mod( 'bd_forum_visit_text', esc_html__( 'Visit Full Community Forums →', 'baloch-diamond' ) );
$visit_url       = get_theme_mod( 'bd_forum_visit_url', '' );

// Featured Discussions label
$featured_label = esc_html__( 'Featured Discussions', 'baloch-diamond' );

// Fallback URL when bbPress is not active
$forum_fallback_url = home_url( '/' );
if ( class_exists( 'bbPress' ) && function_exists( 'bbp_get_forum_archive_link' ) ) {
    $forum_archive = bbp_get_forum_archive_link();
    if ( $forum_archive ) {
        $forum_fallback_url = $forum_archive;
    }
}

// Resolve button URLs: empty or "#" → forum fallback
$btn1_href   = ( ! $btn1_url || $btn1_url === '#' ) ? $forum_fallback_url : $btn1_url;
$btn2_href   = ( ! $btn2_url || $btn2_url === '#' ) ? $forum_fallback_url : $btn2_url;
$btn3_href   = ( ! $btn3_url || $btn3_url === '#' ) ? $forum_fallback_url : $btn3_url;
$visit_href  = ( ! $visit_url || $visit_url === '#' ) ? $forum_fallback_url : $visit_url;

$btn1_target = $btn1_newtab ? '_blank' : '_self';
$btn1_rel    = $btn1_newtab ? ' rel="noopener noreferrer"' : '';
$btn2_target = $btn2_newtab ? '_blank' : '_self';
$btn2_rel    = $btn2_newtab ? ' rel="noopener noreferrer"' : '';
$btn3_target = $btn3_newtab ? '_blank' : '_self';
$btn3_rel    = $btn3_newtab ? ' rel="noopener noreferrer"' : '';

if ( ! $show_forum ) {
    return;
}

// Build community statistics
$stats = array();
if ( class_exists( 'bbPress' ) ) {
    $topic_count = bbp_get_public_topic_count();
    $reply_count = bbp_get_public_reply_count();
    $forum_count = bbp_get_forum_count();
    $user_count  = function_exists( 'bbp_get_total_user_count' ) ? bbp_get_total_user_count() : count( get_users( array( 'fields' => 'ID' ) ) );

    $stats = array(
        array( 'num' => number_format_i18n( $user_count ),  'label' => esc_html__( 'Members', 'baloch-diamond' ) ),
        array( 'num' => number_format_i18n( $topic_count ), 'label' => esc_html__( 'Discussions', 'baloch-diamond' ) ),
        array( 'num' => number_format_i18n( $reply_count ), 'label' => esc_html__( 'Replies', 'baloch-diamond' ) ),
        array( 'num' => number_format_i18n( $forum_count ), 'label' => esc_html__( 'Forums', 'baloch-diamond' ) ),
    );
} else {
    $stats = array(
        array( 'num' => '1,240+', 'label' => esc_html__( 'Artisans', 'baloch-diamond' ) ),
        array( 'num' => '4,800+', 'label' => esc_html__( 'Discussions', 'baloch-diamond' ) ),
        array( 'num' => '350+',   'label' => esc_html__( 'Patterns Shared', 'baloch-diamond' ) ),
        array( 'num' => '99%',    'label' => esc_html__( 'Help Rate', 'baloch-diamond' ) ),
    );
}

// Build topics list (bbPress or fallback)
$topics_found = false;
$topics_list  = array();

if ( class_exists( 'bbPress' ) && ( $mode === 'topics' || $mode === 'featured' ) ) {
    $forum_query = new WP_Query( array(
        'post_type'      => 'topic',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    if ( $forum_query->have_posts() ) {
        $topics_found = true;
        while ( $forum_query->have_posts() ) {
            $forum_query->the_post();
            $topics_list[] = array(
                'id'       => get_the_ID(),
                'title'    => get_the_title(),
                'link'     => get_permalink(),
                'author'   => get_the_author(),
                'replies'  => bbp_get_topic_reply_count( get_the_ID() ),
                'date'     => get_the_date(),
                'category' => bbp_get_forum_title( bbp_get_topic_forum_id( get_the_ID() ) ),
            );
        }
        wp_reset_postdata();
    }
}

// Mock fallback
if ( ! $topics_found && ( $mode === 'topics' || $mode === 'featured' ) ) {
    $mock_data = array(
        array( 'title' => esc_html__( 'Secret meaning of different needlework stitches', 'baloch-diamond' ),   'author' => 'Durdana Baloch', 'replies' => 14, 'category' => esc_html__( 'Art & History', 'baloch-diamond' ), 'date' => esc_html__( '2 hours ago', 'baloch-diamond' ),  'link' => $forum_fallback_url ),
        array( 'title' => esc_html__( 'How to clean vintage hand-woven fabrics safely', 'baloch-diamond' ),    'author' => 'Jahan Baloch',   'replies' => 8,  'category' => esc_html__( 'Fabric Care', 'baloch-diamond' ),  'date' => esc_html__( '1 day ago', 'baloch-diamond' ),    'link' => $forum_fallback_url ),
        array( 'title' => esc_html__( 'Upcoming local artisans exhibition in Quetta 2026', 'baloch-diamond' ), 'author' => 'Mehrab Script',  'replies' => 22, 'category' => esc_html__( 'Exhibitions', 'baloch-diamond' ),  'date' => esc_html__( '3 days ago', 'baloch-diamond' ),   'link' => $forum_fallback_url ),
        array( 'title' => esc_html__( 'Which colored threads work best with navy fabrics?', 'baloch-diamond' ),'author' => 'Naznin G.',      'replies' => 5,  'category' => esc_html__( 'Design Help', 'baloch-diamond' ),  'date' => esc_html__( '1 week ago', 'baloch-diamond' ),   'link' => $forum_fallback_url ),
        array( 'title' => esc_html__( 'Best Balochi patterns for summer clothing', 'baloch-diamond' ),         'author' => 'Farah Baloch',   'replies' => 31, 'category' => esc_html__( 'Design Help', 'baloch-diamond' ),  'date' => esc_html__( '2 weeks ago', 'baloch-diamond' ),  'link' => $forum_fallback_url ),
        array( 'title' => esc_html__( 'How to start your first Balochi embroidery project', 'baloch-diamond' ),'author' => 'Khalid Khan',    'replies' => 19, 'category' => esc_html__( 'Tutorials', 'baloch-diamond' ),    'date' => esc_html__( '3 weeks ago', 'baloch-diamond' ),  'link' => $forum_fallback_url ),
    );
    $topics_list = array_slice( $mock_data, 0, $count );
}

$featured   = array_slice( $topics_list, 0, 2 );

// Categories
$categories = array();
if ( class_exists( 'bbPress' ) ) {
    $forums = get_posts( array(
        'post_type'      => bbp_get_forum_post_type(),
        'posts_per_page' => 8,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ) );
    foreach ( $forums as $forum ) {
        $categories[] = array(
            'name'  => $forum->post_title,
            'count' => bbp_get_forum_topic_count( $forum->ID ),
            'icon'  => 'users',
            'link'  => get_permalink( $forum->ID ),
        );
    }
}
if ( empty( $categories ) ) {
    $categories = array(
        array( 'name' => esc_html__( 'Art & History', 'baloch-diamond' ), 'count' => 87,  'icon' => 'book',   'link' => '#' ),
        array( 'name' => esc_html__( 'Fabric Care', 'baloch-diamond' ),   'count' => 42,  'icon' => 'shield', 'link' => '#' ),
        array( 'name' => esc_html__( 'Design Help', 'baloch-diamond' ),   'count' => 156, 'icon' => 'zap',    'link' => '#' ),
        array( 'name' => esc_html__( 'Tutorials', 'baloch-diamond' ),     'count' => 63,  'icon' => 'code',   'link' => '#' ),
        array( 'name' => esc_html__( 'Exhibitions', 'baloch-diamond' ),   'count' => 29,  'icon' => 'globe',  'link' => '#' ),
        array( 'name' => esc_html__( 'Workshops', 'baloch-diamond' ),     'count' => 18,  'icon' => 'users',  'link' => '#' ),
    );
}
?>

<section class="section" id="community">

    <?php
    bd_section_header( 'forum', array(
        'badge' => $forum_badge,
        'title' => $forum_title,
        'desc'  => $forum_desc,
        'icon'  => 'users',
    ) );
    ?>

    <?php if ( $mode === 'cta' ) : ?>

        <!-- CTA Mode -->
        <?php if ( $show_stats && ! empty( $stats ) ) : ?>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:16px;margin:0 0 36px;">
            <?php foreach ( $stats as $stat ) : ?>
            <div class="doc-card" style="text-align:center;padding:20px;">
                <div style="font-size:1.85rem;font-weight:900;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    <?php echo esc_html( $stat['num'] ); ?>
                </div>
                <span style="font-size:0.78rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">
                    <?php echo esc_html( $stat['label'] ); ?>
                </span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center;">
            <?php if ( $btn1_show ) : ?>
            <a href="<?php echo esc_url( $btn1_href ); ?>" class="btn-gradient" target="<?php echo esc_attr( $btn1_target ); ?>"<?php echo $btn1_rel; // phpcs:ignore ?>>
                <?php echo bd_icon( 'users', 16, 16 ); ?>
                <?php echo esc_html( $btn_ask ); ?>
            </a>
            <?php endif; ?>
            <?php if ( $btn2_show ) : ?>
            <a href="<?php echo esc_url( $btn2_href ); ?>" class="btn-outline" target="<?php echo esc_attr( $btn2_target ); ?>"<?php echo $btn2_rel; // phpcs:ignore ?>>
                <?php echo esc_html( $btn_share ); ?>
            </a>
            <?php endif; ?>
            <?php if ( $btn3_show ) : ?>
            <a href="<?php echo esc_url( $btn3_href ); ?>" class="btn-outline" target="<?php echo esc_attr( $btn3_target ); ?>"<?php echo $btn3_rel; // phpcs:ignore ?>>
                <?php echo esc_html( $btn_workshop ); ?>
            </a>
            <?php endif; ?>
        </div>

    <?php elseif ( $mode === 'categories' ) : ?>

        <!-- Categories Grid -->
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-top:24px;">
            <?php foreach ( $categories as $cat ) : ?>
            <a href="<?php echo esc_url( $cat['link'] ?? '#' ); ?>" class="doc-card" style="display:block;text-align:center;text-decoration:none;">
                <div style="width:52px;height:52px;margin:0 auto 12px;background:var(--gradient);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;">
                    <?php echo bd_icon( $cat['icon'] ?? 'users', 24, 24 ); ?>
                </div>
                <h4 class="doc-title" style="margin-bottom:4px;"><?php echo esc_html( $cat['name'] ?? '' ); ?></h4>
                <span style="font-size:0.9rem;color:var(--text-muted);">
                    <?php echo esc_html( number_format_i18n( $cat['count'] ?? 0 ) ); ?> <?php esc_html_e( 'topics', 'baloch-diamond' ); ?>
                </span>
            </a>
            <?php endforeach; ?>
        </div>

    <?php elseif ( $mode === 'live-stats' ) : ?>

        <!-- Live Stats + Quick Actions -->
        <?php if ( $show_stats && ! empty( $stats ) ) : ?>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:16px;margin:28px 0 32px;">
            <?php foreach ( $stats as $stat ) : ?>
            <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:20px 16px;text-align:center;">
                <div style="font-size:1.9rem;font-weight:900;background:var(--gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                    <?php echo esc_html( $stat['num'] ); ?>
                </div>
                <div style="font-size:0.8rem;color:var(--text-muted);font-weight:600;margin-top:4px;">
                    <?php echo esc_html( $stat['label'] ); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center;">
            <?php if ( $btn1_show ) : ?>
            <a href="<?php echo esc_url( $btn1_href ); ?>" class="btn-gradient" target="<?php echo esc_attr( $btn1_target ); ?>"<?php echo $btn1_rel; // phpcs:ignore ?>>
                <?php echo esc_html( $btn_ask ); ?>
            </a>
            <?php endif; ?>
            <?php if ( $btn2_show ) : ?>
            <a href="<?php echo esc_url( $btn2_href ); ?>" class="btn-outline" target="<?php echo esc_attr( $btn2_target ); ?>"<?php echo $btn2_rel; // phpcs:ignore ?>>
                <?php echo esc_html( $btn_share ); ?>
            </a>
            <?php endif; ?>
            <?php if ( $btn3_show ) : ?>
            <a href="<?php echo esc_url( $btn3_href ); ?>" class="btn-outline" target="<?php echo esc_attr( $btn3_target ); ?>"<?php echo $btn3_rel; // phpcs:ignore ?>>
                <?php echo esc_html( $btn_workshop ); ?>
            </a>
            <?php endif; ?>
        </div>

    <?php elseif ( $mode === 'featured' ) : ?>

        <!-- Featured + Latest Topics -->
        <?php if ( ! empty( $featured ) ) : ?>
        <h4 style="margin:0 0 16px 8px;font-size:1rem;font-weight:700;color:var(--text-muted);"><?php echo esc_html( $featured_label ); ?></h4>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;margin-bottom:32px;">
            <?php foreach ( $featured as $feat ) : ?>
            <a href="<?php echo esc_url( $feat['link'] ); ?>" style="display:block;background:var(--card-bg);border:1px solid var(--border);border-radius:18px;overflow:hidden;text-decoration:none;">
                <?php if ( ! empty( $feat['image'] ?? '' ) ) : ?>
                <img src="<?php echo esc_url( $feat['image'] ); ?>" style="width:100%;height:160px;object-fit:cover;" alt="" loading="lazy">
                <?php endif; ?>
                <div style="padding:18px;">
                    <h4 style="margin:0;font-size:1.05rem;color:var(--text);line-height:1.3;"><?php echo esc_html( $feat['title'] ?? '' ); ?></h4>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="topics-board" style="display:flex;flex-direction:column;gap:16px;">
            <?php foreach ( $topics_list as $topic ) : ?>
            <div class="forum-topic-card" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;padding:20px 28px;background:var(--card-bg);border:1px solid var(--border);border-radius:16px;">
                <div style="flex:2;min-width:240px;">
                    <a href="<?php echo esc_url( $topic['link'] ?? $forum_fallback_url ); ?>" style="font-weight:700;color:var(--text);text-decoration:none;font-size:1.02rem;">
                        <?php echo esc_html( $topic['title'] ?? '' ); ?>
                    </a>
                    <div style="font-size:0.78rem;color:var(--text-muted);margin-top:6px;">
                        <?php echo esc_html( $topic['author'] ?? '' ); ?> • <?php echo esc_html( $topic['category'] ?? '' ); ?>
                    </div>
                </div>
                <div style="text-align:right;min-width:100px;">
                    <span style="font-weight:700;font-size:1.1rem;"><?php echo intval( $topic['replies'] ?? 0 ); ?></span>
                    <span style="font-size:0.75rem;display:block;color:var(--text-muted);"><?php esc_html_e( 'replies', 'baloch-diamond' ); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    <?php else : // topics mode (default) ?>

        <!-- Classic Latest Topics -->
        <div class="topics-board" style="display:flex;flex-direction:column;gap:16px;margin-top:20px;">
            <?php foreach ( $topics_list as $topic ) : ?>
            <div class="forum-topic-card" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;padding:20px 28px;background:var(--card-bg);border:1px solid var(--border);border-radius:16px;transition:transform .3s;">
                <div style="display:flex;align-items:center;gap:16px;flex:2;min-width:260px;">
                    <div style="width:48px;height:44px;border-radius:12px;background:var(--gradient);display:flex;align-items:center;justify-content:center;color:white;flex-shrink:0;">
                        <?php echo bd_icon( 'users', 22, 22 ); ?>
                    </div>
                    <div>
                        <a href="<?php echo esc_url( $topic['link'] ?? $forum_fallback_url ); ?>" style="font-weight:700;font-size:1.02rem;color:var(--text);text-decoration:none;">
                            <?php echo esc_html( $topic['title'] ?? '' ); ?>
                        </a>
                        <div style="font-size:0.78rem;color:var(--text-muted);margin-top:3px;">
                            <?php echo esc_html( $topic['author'] ?? '' ); ?> • <span style="color:var(--color-primary);font-weight:600;"><?php echo esc_html( $topic['category'] ?? '' ); ?></span>
                        </div>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:22px;flex-shrink:0;">
                    <div style="text-align:center;">
                        <span style="font-size:1.15rem;font-weight:700;"><?php echo intval( $topic['replies'] ?? 0 ); ?></span>
                        <span style="font-size:0.75rem;display:block;color:var(--text-muted);"><?php esc_html_e( 'Replies', 'baloch-diamond' ); ?></span>
                    </div>
                    <div style="font-size:0.85rem;color:var(--text-muted);min-width:90px;text-align:right;">
                        <?php echo esc_html( $topic['date'] ?? '' ); ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <!-- Bottom CTA Buttons -->
    <?php if ( $mode !== 'live-stats' && $mode !== 'cta' ) : ?>
    <div style="text-align:center;margin-top:36px;">
        <div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center;">
            <?php if ( $btn1_show ) : ?>
            <a href="<?php echo esc_url( $btn1_href ); ?>" class="btn-gradient" target="<?php echo esc_attr( $btn1_target ); ?>"<?php echo $btn1_rel; // phpcs:ignore ?>>
                <?php echo bd_icon( 'users', 16, 16 ); ?>
                <?php echo esc_html( $btn_ask ); ?>
            </a>
            <?php endif; ?>
            <?php if ( $btn2_show ) : ?>
            <a href="<?php echo esc_url( $btn2_href ); ?>" class="btn-outline" target="<?php echo esc_attr( $btn2_target ); ?>"<?php echo $btn2_rel; // phpcs:ignore ?>>
                <?php echo esc_html( $btn_share ); ?>
            </a>
            <?php endif; ?>
            <?php if ( $btn3_show ) : ?>
            <a href="<?php echo esc_url( $btn3_href ); ?>" class="btn-outline" target="<?php echo esc_attr( $btn3_target ); ?>"<?php echo $btn3_rel; // phpcs:ignore ?>>
                <?php echo esc_html( $btn_workshop ); ?>
            </a>
            <?php endif; ?>
        </div>
        <?php if ( $visit_full_text ) : ?>
        <div style="margin-top:16px;">
            <a href="<?php echo esc_url( $visit_href ); ?>" style="color:var(--text-muted);font-size:0.9rem;">
                <?php echo esc_html( $visit_full_text ); ?>
            </a>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

</section>

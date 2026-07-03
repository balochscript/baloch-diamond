<?php
/**
 * Forum / Community Section Template Part - FULLY ENHANCED
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// All Customizer options
$show_forum       = get_theme_mod( 'bd_forum_show', true );
$mode             = get_theme_mod( 'bd_forum_mode', 'topics' );
$count            = get_theme_mod( 'bd_forum_count', 4 );
$show_stats       = get_theme_mod( 'bd_forum_show_stats', true );

$forum_badge      = get_theme_mod( 'bd_forum_badge', esc_html__( 'Join the Circle', 'baloch-diamond' ) );
$forum_title      = get_theme_mod( 'bd_forum_title', esc_html__( 'Community Hub', 'baloch-diamond' ) );
$forum_desc       = get_theme_mod( 'bd_forum_desc', esc_html__( 'Connect with fellow artisans, ask questions, and share your creations.', 'baloch-diamond' ) );

// Quick action buttons
$btn_ask          = get_theme_mod( 'bd_forum_btn_ask', esc_html__( 'Ask a Question', 'baloch-diamond' ) );
$btn_share        = get_theme_mod( 'bd_forum_btn_share', esc_html__( 'Share Your Pattern', 'baloch-diamond' ) );
$btn_workshop     = get_theme_mod( 'bd_forum_btn_workshop', esc_html__( 'Join Workshop', 'baloch-diamond' ) );

// CTA mode specific texts
$cta_title        = get_theme_mod( 'bd_forum_cta_title', esc_html__( 'Connect with Fellow Creators', 'baloch-diamond' ) );
$cta_desc         = get_theme_mod( 'bd_forum_cta_desc', esc_html__( 'Sign up today and get instant access to hundreds of topics.', 'baloch-diamond' ) );
$cta_btn_text     = get_theme_mod( 'bd_forum_cta_btn_text', esc_html__( 'Join Discussions', 'baloch-diamond' ) );

// Featured Discussions heading label (customizable)
$featured_label   = get_theme_mod( 'bd_forum_featured_label', esc_html__( 'Featured Discussions', 'baloch-diamond' ) );

// Bottom link text (fully customizable)
$visit_full_text  = get_theme_mod( 'bd_forum_visit_text', esc_html__( 'Visit Full Community Forums →', 'baloch-diamond' ) );
if ( ! $show_forum ) {
    return;
}

// Collect 6 statistics
$stats = array();
for ( $s = 1; $s <= 6; $s++ ) {
    $num   = get_theme_mod( "bd_forum_stat{$s}_num", '' );
    $label = get_theme_mod( "bd_forum_stat{$s}_label", '' );
    if ( $num && $label ) {
        $stats[] = array( 'num' => $num, 'label' => $label );
    }
}

// Featured discussions
$featured = array();
for ( $f = 1; $f <= 4; $f++ ) {
    $post_id = get_theme_mod( "bd_forum_featured_{$f}", 0 );
    if ( $post_id && get_post( $post_id ) ) {
        $featured[] = array(
            'id'    => $post_id,
            'title' => get_the_title( $post_id ),
            'link'  => get_permalink( $post_id ),
            'image' => has_post_thumbnail( $post_id ) ? get_the_post_thumbnail_url( $post_id, 'medium' ) : '',
        );
    }
}

// Build topics list (bbPress or fallback)
$topics_found = false;
$topics_list  = array();

if ( class_exists( 'bbPress' ) && ( $mode === 'topics' || $mode === 'featured' ) ) {
    $args = array(
        'post_type'      => 'topic',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $forum_query = new WP_Query( $args );

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

// Mock fallback data
if ( ! $topics_found && ( $mode === 'topics' || $mode === 'featured' ) ) {
    $mock_data = array(
        array( 'title' => esc_html__( 'Secret meaning of different needlework stitches', 'baloch-diamond' ), 'author' => 'Durdana Baloch', 'replies' => 14, 'category' => esc_html__( 'Art & History', 'baloch-diamond' ), 'date' => esc_html__( '2 hours ago', 'baloch-diamond' ) ),
        array( 'title' => esc_html__( 'How to clean vintage hand-woven fabrics safely', 'baloch-diamond' ), 'author' => 'Jahan Baloch', 'replies' => 8, 'category' => esc_html__( 'Fabric Care', 'baloch-diamond' ), 'date' => esc_html__( '1 day ago', 'baloch-diamond' ) ),
        array( 'title' => esc_html__( 'Upcoming local artisans exhibition in Quetta 2026', 'baloch-diamond' ), 'author' => 'Mehrab Script', 'replies' => 22, 'category' => esc_html__( 'Exhibitions', 'baloch-diamond' ), 'date' => esc_html__( '3 days ago', 'baloch-diamond' ) ),
        array( 'title' => esc_html__( 'Which colored threads work best with navy fabrics?', 'baloch-diamond' ), 'author' => 'Naznin G.', 'replies' => 5, 'category' => esc_html__( 'Design Help', 'baloch-diamond' ), 'date' => esc_html__( '1 week ago', 'baloch-diamond' ) ),
        array( 'title' => esc_html__( 'Best Balochi patterns for summer clothing', 'baloch-diamond' ), 'author' => 'Farah Baloch', 'replies' => 31, 'category' => esc_html__( 'Design Help', 'baloch-diamond' ), 'date' => esc_html__( '2 weeks ago', 'baloch-diamond' ) ),
        array( 'title' => esc_html__( 'How to start your first Balochi embroidery project', 'baloch-diamond' ), 'author' => 'Khalid Khan', 'replies' => 19, 'category' => esc_html__( 'Tutorials', 'baloch-diamond' ), 'date' => esc_html__( '3 weeks ago', 'baloch-diamond' ) ),
    );
    $topics_list = array_slice( $mock_data, 0, $count );
}

// Categories mock (used in 'categories' mode)
$categories = array(
    array( 'name' => esc_html__( 'Art & History', 'baloch-diamond' ), 'count' => 87, 'icon' => 'book' ),
    array( 'name' => esc_html__( 'Fabric Care', 'baloch-diamond' ), 'count' => 42, 'icon' => 'shield' ),
    array( 'name' => esc_html__( 'Design Help', 'baloch-diamond' ), 'count' => 156, 'icon' => 'zap' ),
    array( 'name' => esc_html__( 'Tutorials', 'baloch-diamond' ), 'count' => 63, 'icon' => 'code' ),
    array( 'name' => esc_html__( 'Exhibitions', 'baloch-diamond' ), 'count' => 29, 'icon' => 'globe' ),
    array( 'name' => esc_html__( 'Workshops', 'baloch-diamond' ), 'count' => 18, 'icon' => 'users' ),
);
?>

<section class="section forum-showcase-section" id="forum-showcase" style="background:var(--bg-alt); padding:80px 24px; border-radius:30px; margin-top:40px; margin-bottom:40px;">

    <?php
    bd_section_header( 'forum', array(
        'badge' => $forum_badge,
        'title' => $forum_title,
        'desc'  => $forum_desc,
        'icon'  => 'users',
    ) );
    ?>

    <?php if ( $mode === 'cta' ) : ?>

        <!-- CTA + Statistics -->
        <div class="forum-cta-box" style="display:flex; flex-wrap:wrap; gap:40px; align-items:center; background:var(--card-bg); border:1px solid var(--border); border-radius:24px; padding:48px; box-shadow:var(--shadow); margin-top:20px;">
            <div style="flex:1.5; min-width:300px;">
                <h3 style="font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:900; margin-bottom:16px;">
                    <?php echo esc_html( $cta_title ); ?>
                </h3>
                <p style="color:var(--text-muted); font-size:1rem; line-height:1.7; margin-bottom:24px;">
                    <?php echo esc_html( $cta_desc ); ?>
                </p>
                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    <a href="<?php echo esc_url( class_exists( 'bbPress' ) ? '#bbpress-forums' : '#_forum' ); ?>" class="btn-gradient">
                        <?php echo bd_icon( 'users', 16, 16 ); ?>
                        <?php echo esc_html( $cta_btn_text ); ?>
                    </a>
                </div>
            </div>

            <?php if ( $show_stats && ! empty( $stats ) ) : ?>
            <div style="flex:1; min-width:260px; display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <?php foreach ( array_slice( $stats, 0, 4 ) as $stat ) : ?>
                    <div class="doc-card" style="text-align:center; padding:20px;">
                        <div style="font-size:1.85rem; font-weight:900; background:var(--gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">
                            <?php echo esc_html( $stat['num'] ); ?>
                        </div>
                        <span style="font-size:0.78rem; color:var(--text-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">
                            <?php echo esc_html( $stat['label'] ); ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

    <?php elseif ( $mode === 'categories' ) : ?>

        <!-- Categories Grid -->
        <div class="forum-categories-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px; margin-top:24px;">
            <?php foreach ( $categories as $cat ) : ?>
                <div class="forum-category-card" style="background:var(--card-bg); border:1px solid var(--border); border-radius:18px; padding:24px; text-align:center; transition:transform .3s;">
                    <div style="width:52px;height:52px;margin:0 auto 12px;background:var(--gradient);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;">
                        <?php echo bd_icon( $cat['icon'], 24, 24 ); ?>
                    </div>
                    <h4 style="margin:0 0 4px;font-size:1.05rem;font-weight:700;"><?php echo esc_html( $cat['name'] ); ?></h4>
                    <span style="font-size:0.9rem;color:var(--text-muted);"><?php echo esc_html( $cat['count'] ); ?> <?php esc_html_e( 'topics', 'baloch-diamond' ); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

    <?php elseif ( $mode === 'live-stats' ) : ?>

        <!-- Live Stats + Quick Actions -->
        <?php if ( $show_stats && ! empty( $stats ) ) : ?>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(140px, 1fr)); gap:16px; margin:28px 0 32px;">
                <?php foreach ( $stats as $stat ) : ?>
                    <div style="background:var(--card-bg); border:1px solid var(--border); border-radius:16px; padding:20px 16px; text-align:center;">
                        <div style="font-size:1.9rem; font-weight:900; background:var(--gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">
                            <?php echo esc_html( $stat['num'] ); ?>
                        </div>
                        <div style="font-size:0.8rem; color:var(--text-muted); font-weight:600; margin-top:4px;">
                            <?php echo esc_html( $stat['label'] ); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div style="display:flex; gap:12px; flex-wrap:wrap; justify-content:center;">
            <a href="#forum" class="btn-gradient"><?php echo esc_html( $btn_ask ); ?></a>
            <a href="#forum" class="btn-outline"><?php echo esc_html( $btn_share ); ?></a>
            <a href="#forum" class="btn-outline"><?php echo esc_html( $btn_workshop ); ?></a>
        </div>

    <?php elseif ( $mode === 'featured' ) : ?>

        <!-- Featured + Latest Topics -->
        <?php if ( ! empty( $featured ) ) : ?>
            <h4 style="margin:0 0 16px 8px; font-size:1rem; font-weight:700; color:var(--text-muted);"><?php echo esc_html( $featured_label ); ?></h4>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:20px; margin-bottom:32px;">
                <?php foreach ( $featured as $feat ) : ?>
                    <a href="<?php echo esc_url( $feat['link'] ); ?>" style="display:block; background:var(--card-bg); border:1px solid var(--border); border-radius:18px; overflow:hidden; text-decoration:none;">
                        <?php if ( $feat['image'] ) : ?>
                            <img src="<?php echo esc_url( $feat['image'] ); ?>" style="width:100%; height:160px; object-fit:cover;">
                        <?php endif; ?>
                        <div style="padding:18px;">
                            <h4 style="margin:0; font-size:1.05rem; color:var(--text); line-height:1.3;"><?php echo esc_html( $feat['title'] ); ?></h4>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Latest topics list -->
        <div class="topics-board" style="display:flex; flex-direction:column; gap:16px;">
            <?php foreach ( $topics_list as $topic ) : ?>
                <div class="forum-topic-card" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px; padding:20px 28px; background:var(--card-bg); border:1px solid var(--border); border-radius:16px;">
                    <div style="flex:2; min-width:240px;">
                        <a href="<?php echo esc_url( $topic['link'] ); ?>" style="font-weight:700; color:var(--text); text-decoration:none; font-size:1.02rem;">
                            <?php echo esc_html( $topic['title'] ); ?>
                        </a>
                        <div style="font-size:0.78rem; color:var(--text-muted); margin-top:6px;">
                            <?php echo esc_html( $topic['author'] ); ?> • <?php echo esc_html( $topic['category'] ); ?>
                        </div>
                    </div>
                    <div style="text-align:right; min-width:100px;">
                        <span style="font-weight:700; font-size:1.1rem;"><?php echo intval( $topic['replies'] ); ?></span>
                        <span style="font-size:0.75rem; display:block; color:var(--text-muted);"><?php esc_html_e( 'replies', 'baloch-diamond' ); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else : // topics mode ?>

        <!-- Classic Latest Topics -->
        <div class="topics-board" style="display:flex; flex-direction:column; gap:16px; margin-top:20px;">
            <?php foreach ( $topics_list as $topic ) : ?>
                <div class="forum-topic-card" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px; padding:20px 28px; background:var(--card-bg); border:1px solid var(--border); border-radius:16px; transition:transform .3s;">
                    <div style="display:flex; align-items:center; gap:16px; flex:2; min-width:260px;">
                        <div style="width:48px; height:44px; border-radius:12px; background:var(--gradient); display:flex; align-items:center; justify-content:center; color:white; flex-shrink:0;">
                            <?php echo bd_icon( 'users', 22, 22 ); ?>
                        </div>
                        <div>
                            <a href="<?php echo esc_url( $topic['link'] ); ?>" style="font-weight:700; font-size:1.02rem; color:var(--text); text-decoration:none;">
                                <?php echo esc_html( $topic['title'] ); ?>
                            </a>
                            <div style="font-size:0.78rem; color:var(--text-muted); margin-top:3px;">
                                <?php echo esc_html( $topic['author'] ); ?> • <span style="color:var(--color-primary); font-weight:600;"><?php echo esc_html( $topic['category'] ); ?></span>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:22px; flex-shrink:0;">
                        <div style="text-align:center;">
                            <span style="font-size:1.15rem; font-weight:700;"><?php echo intval( $topic['replies'] ); ?></span>
                            <span style="font-size:0.75rem; display:block; color:var(--text-muted);"><?php esc_html_e( 'Replies', 'baloch-diamond' ); ?></span>
                        </div>
                        <div style="font-size:0.85rem; color:var(--text-muted); min-width:90px; text-align:right;">
                            <?php echo esc_html( $topic['date'] ); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <!-- Bottom CTA -->
    <?php if ( $mode !== 'live-stats' ) : ?>
        <div style="text-align:center; margin-top:36px;">
            <div style="display:flex; gap:12px; flex-wrap:wrap; justify-content:center;">
                <a href="#forum" class="btn-gradient">
                    <?php echo bd_icon( 'users', 16, 16 ); ?>
                    <?php echo esc_html( $btn_ask ); ?>
                </a>
                <a href="#forum" class="btn-outline">
                    <?php echo esc_html( $btn_share ); ?>
                </a>
                <a href="#forum" class="btn-outline">
                    <?php echo esc_html( $btn_workshop ); ?>
                </a>
            </div>
            <div style="margin-top:16px;">
                <a href="<?php echo esc_url( class_exists( 'bbPress' ) ? bbp_get_forum_archive_link() : '#_forum' ); ?>" style="color:var(--text-muted); font-size:0.9rem;">
                    <?php echo esc_html( $visit_full_text ); ?>
                </a>
            </div>
        </div>
    <?php endif; ?>

</section>
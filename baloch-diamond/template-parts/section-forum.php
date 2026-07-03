<?php
/**
 * Forum (bbPress) Section Template Part
 *
 * @package Baloch_Diamond
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Customizer options
$show_forum = get_theme_mod( 'bd_forum_show', true );
$mode       = get_theme_mod( 'bd_forum_mode', 'topics' ); // 'topics' or 'cta'
$count      = get_theme_mod( 'bd_forum_count', 4 );

if ( ! $show_forum ) {
    return;
}

// bbPress query setup
$topics_found = false;
$topics_list  = array();

if ( class_exists( 'bbPress' ) && $mode === 'topics' ) {
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

// Fallback Mock topics for engaging presentation if bbPress is not active
if ( ! $topics_found ) {
    $topics_list = array(
        array(
            'id'       => 1,
            'title'    => esc_html__( 'Secret meaning of different needlework stitches', 'baloch-diamond' ),
            'link'     => '#_forum',
            'author'   => 'Durdana Baloch',
            'replies'  => 14,
            'date'     => esc_html__( '2 hours ago', 'baloch-diamond' ),
            'category' => esc_html__( 'Art & History', 'baloch-diamond' ),
        ),
        array(
            'id'       => 2,
            'title'    => esc_html__( 'How to clean vintage hand-woven fabrics safely', 'baloch-diamond' ),
            'link'     => '#_forum',
            'author'   => 'Jahan Baloch',
            'replies'  => 8,
            'date'     => esc_html__( '1 day ago', 'baloch-diamond' ),
            'category' => esc_html__( 'Fabric Care', 'baloch-diamond' ),
        ),
        array(
            'id'       => 3,
            'title'    => esc_html__( 'Upcoming local artisans exhibition in Quetta 2026', 'baloch-diamond' ),
            'link'     => '#_forum',
            'author'   => 'Mehrab Script',
            'replies'  => 22,
            'date'     => esc_html__( '3 days ago', 'baloch-diamond' ),
            'category' => esc_html__( 'Exhibitions', 'baloch-diamond' ),
        ),
        array(
            'id'       => 4,
            'title'    => esc_html__( 'Which colored threads work best with navy fabrics?', 'baloch-diamond' ),
            'link'     => '#_forum',
            'author'   => 'Naznin G.',
            'replies'  => 5,
            'date'     => esc_html__( '1 week ago', 'baloch-diamond' ),
            'category' => esc_html__( 'Design Help', 'baloch-diamond' ),
        ),
    );
    $topics_list = array_slice( $topics_list, 0, $count );
}
?>

<section class="section forum-showcase-section" id="forum-showcase" style="background:var(--bg-alt); padding:80px 24px; border-radius:30px; margin-top:40px; margin-bottom:40px; box-shadow:inset 0 4px 24px rgba(0,0,0,0.02);">
    
    <?php
    bd_section_header( 'forum', array(
        'badge' => esc_html__( 'Thriving Community', 'baloch-diamond' ),
        'title' => esc_html__( 'Discussion Board', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Join the conversations with embroidery enthusiasts, local artisans, and history lovers from all around the world.', 'baloch-diamond' ),
        'icon'  => 'users',
    ) );
    ?>

    <?php if ( $mode === 'cta' ) : ?>
        <!-- Call to Action Presentation -->
        <div class="forum-cta-box" style="display:flex; flex-wrap:wrap; gap:40px; align-items:center; background:var(--card-bg); border:1px solid var(--border); border-radius:24px; padding:48px; box-shadow:var(--shadow); margin-top:20px;">
            <div style="flex:1.5; min-width:300px;">
                <h3 style="font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:900; margin-bottom:16px;">
                    <?php esc_html_e( 'Connect with Fellow Creators', 'baloch-diamond' ); ?>
                </h3>
                <p style="color:var(--text-muted); font-size:1rem; line-height:1.7; margin-bottom:24px;">
                    <?php esc_html_e( 'Sign up today and get instant access to hundreds of topics. Explore patterns, share your design progress, get feedback from senior needlework masters, and join community workshops.', 'baloch-diamond' ); ?>
                </p>
                <div style="display:flex; gap:16px; flex-wrap:wrap;">
                    <a href="<?php echo esc_url( class_exists( 'bbPress' ) ? get_post_type_archive_link( 'forum' ) : '#_forum' ); ?>" class="btn-gradient">
                        <?php echo bd_icon( 'users', 16, 16 ); ?>
                        <?php esc_html_e( 'Join Discussions', 'baloch-diamond' ); ?>
                    </a>
                    <a href="#newsletter" class="btn-outline">
                        <?php esc_html_e( 'Subscribe to Invites', 'baloch-diamond' ); ?>
                    </a>
                </div>
            </div>
            
            <!-- Statistics Card -->
            <div style="flex:1; min-width:260px; display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                <div class="doc-card" style="text-align:center; padding:24px;">
                    <div style="font-size:2rem; font-weight:900; background:var(--gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; margin-bottom:4px;">1,240+</div>
                    <span style="font-size:0.85rem; color:var(--text-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"><?php esc_html_e( 'Artisans', 'baloch-diamond' ); ?></span>
                </div>
                <div class="doc-card" style="text-align:center; padding:24px;">
                    <div style="font-size:2rem; font-weight:900; background:var(--gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; margin-bottom:4px;">4,800+</div>
                    <span style="font-size:0.85rem; color:var(--text-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"><?php esc_html_e( 'Discussions', 'baloch-diamond' ); ?></span>
                </div>
                <div class="doc-card" style="text-align:center; padding:24px;">
                    <div style="font-size:2rem; font-weight:900; background:var(--gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; margin-bottom:4px;">350+</div>
                    <span style="font-size:0.85rem; color:var(--text-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"><?php esc_html_e( 'Patterns', 'baloch-diamond' ); ?></span>
                </div>
                <div class="doc-card" style="text-align:center; padding:24px;">
                    <div style="font-size:2rem; font-weight:900; background:var(--gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; margin-bottom:4px;">99%</div>
                    <span style="font-size:0.85rem; color:var(--text-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.5px;"><?php esc_html_e( 'Help Rate', 'baloch-diamond' ); ?></span>
                </div>
            </div>
        </div>
    <?php else : ?>
        <!-- Latest Topics Presentation -->
        <div class="topics-board" style="display:flex; flex-direction:column; gap:16px; margin-top:20px;">
            <?php foreach ( $topics_list as $topic ) : ?>
                <div class="forum-topic-card" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px; padding:20px 28px; background:var(--card-bg); border:1px solid var(--border); border-radius:16px; box-shadow:0 4px 12px rgba(0,0,0,0.02); transition:transform 0.3s, border-color 0.3s;" onmouseover="this.style.transform='translateX(4px)'; this.style.borderColor='var(--color-primary)';" onmouseout="this.style.transform='translateX(0)'; this.style.borderColor='var(--border)';">
                    <div style="display:flex; align-items:center; gap:16px; min-width:300px; flex:2;">
                        <div class="promo-icon-wrapper" style="width:48px; height:44px; margin-bottom:0; border-radius:12px; flex-shrink:0;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 style="font-size:1.05rem; font-weight:700; margin-bottom:4px;">
                                <a href="<?php echo esc_url( $topic['link'] ); ?>" style="color:var(--text); text-decoration:none; transition:color 0.3s;" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color='var(--text)'">
                                    <?php echo esc_html( $topic['title'] ); ?>
                                </a>
                            </h4>
                            <div style="font-size:0.8rem; color:var(--text-muted); display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                                <span><?php esc_html_e( 'By', 'baloch-diamond' ); ?> <strong><?php echo esc_html( $topic['author'] ); ?></strong></span>
                                <span style="display:inline-block; width:4px; height:4px; border-radius:50%; background:var(--text-muted); opacity:0.4;"></span>
                                <span style="background:linear-gradient(135deg, rgba(56,189,248,0.1), rgba(249,115,22,0.1)); color:var(--color-primary); padding:2px 8px; border-radius:6px; font-weight:600; font-size:0.75rem;"><?php echo esc_html( $topic['category'] ); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div style="display:flex; align-items:center; gap:24px; flex-shrink:0;">
                        <!-- Replies count -->
                        <div style="text-align:center;">
                            <span style="display:block; font-size:1.15rem; font-weight:700; color:var(--text);"><?php echo intval( $topic['replies'] ); ?></span>
                            <span style="font-size:0.75rem; color:var(--text-muted); text-transform:uppercase; font-weight:600; letter-spacing:0.5px;"><?php esc_html_e( 'Replies', 'baloch-diamond' ); ?></span>
                        </div>
                        
                        <!-- Date -->
                        <div style="font-size:0.85rem; color:var(--text-muted); text-align:right; min-width:100px;">
                            <?php echo esc_html( $topic['date'] ); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div style="text-align:center; margin-top:36px;">
            <a href="<?php echo esc_url( class_exists( 'bbPress' ) ? get_post_type_archive_link( 'forum' ) : '#_forum' ); ?>" class="btn-gradient">
                <?php echo bd_icon( 'users', 16, 16 ); ?>
                <?php esc_html_e( 'Visit Full Forums', 'baloch-diamond' ); ?>
            </a>
        </div>
    <?php endif; ?>

</section>

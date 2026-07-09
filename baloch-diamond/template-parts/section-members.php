<?php
/**
 * Community Members Section
 *
 * Pulls real forum members (bbPress users with activity) or recent WordPress users.
 * Demo data is only used as a last resort on a fresh site with no users.
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! bd_is_section_visible( 'members' ) ) {
    return;
}

$members_title = get_theme_mod( 'bd_members_title', esc_html__( 'Our Community', 'baloch-diamond' ) );
$members_badge = get_theme_mod( 'bd_members_badge', esc_html__( 'Join the Circle', 'baloch-diamond' ) );
$members_count = get_theme_mod( 'bd_members_count', 6 );
$members_count = max( 1, intval( $members_count ) );

$members = array();

// If bbPress is active, prefer users with forum activity.
if ( class_exists( 'bbPress' ) ) {
    $user_ids = get_users( array(
        'fields'  => 'ID',
        'orderby' => 'registered',
        'order'   => 'DESC',
        'number'  => $members_count * 3,
    ) );

    foreach ( $user_ids as $user_id ) {
        $topic_count = function_exists( 'bbp_get_user_topic_count' ) ? bbp_get_user_topic_count( $user_id ) : 0;
        $reply_count = function_exists( 'bbp_get_user_reply_count' ) ? bbp_get_user_reply_count( $user_id ) : 0;

        if ( $topic_count > 0 || $reply_count > 0 ) {
            $user = get_userdata( $user_id );
            if ( $user ) {
                $members[] = array(
                    'name'   => $user->display_name,
                    'role'   => sprintf(
                        /* translators: 1: Topic count, 2: Reply count */
                        esc_html__( '%1$s topics · %2$s replies', 'baloch-diamond' ),
                        number_format_i18n( $topic_count ),
                        number_format_i18n( $reply_count )
                    ),
                    'avatar' => get_avatar_url( $user_id, array( 'size' => 150 ) ),
                    'link'   => function_exists( 'bbp_get_user_profile_url' ) ? bbp_get_user_profile_url( $user_id ) : get_author_posts_url( $user_id ),
                );
            }
        }

        if ( count( $members ) >= $members_count ) {
            break;
        }
    }
}

// Fallback to recent WordPress users.
if ( empty( $members ) ) {
    $users = get_users( array(
        'orderby' => 'registered',
        'order'   => 'DESC',
        'number'  => $members_count,
    ) );

    foreach ( $users as $user ) {
        $members[] = array(
            'name'   => $user->display_name,
            'role'   => esc_html__( 'Member', 'baloch-diamond' ),
            'avatar' => get_avatar_url( $user->ID, array( 'size' => 150 ) ),
            'link'   => get_author_posts_url( $user->ID ),
        );
    }
}

// Demo fallback only when there are no real users to display.
if ( empty( $members ) ) {
    $members = array(
        array( 'name' => 'Durdana Baloch', 'role' => esc_html__( 'Master Artisan', 'baloch-diamond' ), 'avatar' => '', 'link' => '#' ),
        array( 'name' => 'Jahan Baloch',   'role' => esc_html__( 'Pattern Designer', 'baloch-diamond' ), 'avatar' => '', 'link' => '#' ),
        array( 'name' => 'Mehrab Script',  'role' => esc_html__( 'Embroidery Expert', 'baloch-diamond' ), 'avatar' => '', 'link' => '#' ),
        array( 'name' => 'Naznin G.',      'role' => esc_html__( 'Textile Artist', 'baloch-diamond' ), 'avatar' => '', 'link' => '#' ),
        array( 'name' => 'Farah Baloch',   'role' => esc_html__( 'Workshop Leader', 'baloch-diamond' ), 'avatar' => '', 'link' => '#' ),
        array( 'name' => 'Khalid Khan',    'role' => esc_html__( 'Community Moderator', 'baloch-diamond' ), 'avatar' => '', 'link' => '#' ),
    );
}

$members = array_slice( $members, 0, $members_count );

$members_archive_url = home_url( '/' );
if ( class_exists( 'bbPress' ) && function_exists( 'bbp_get_forum_archive_link' ) ) {
    $members_archive_url = bbp_get_forum_archive_link();
}
?>

<section class="section members-showcase" id="community-members" style="background:var(--bg-alt); padding:60px 24px; margin-top:30px; margin-bottom:30px; border-radius:24px;">
    <?php
    bd_section_header( 'members', array(
        'badge' => $members_badge,
        'title' => $members_title,
        'desc'  => esc_html__( 'Meet some of the passionate artisans and creators in our growing community.', 'baloch-diamond' ),
        'icon'  => 'users',
    ) );
    ?>

    <div class="members-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(140px, 1fr)); gap:24px; max-width:1100px; margin:0 auto;">
        <?php foreach ( $members as $member ) : ?>
            <a href="<?php echo esc_url( $member['link'] ?: '#' ); ?>" class="member-card" style="display:block; background:var(--card-bg); border:1px solid var(--border); border-radius:16px; padding:20px 14px; text-align:center; text-decoration:none; transition:transform .2s, box-shadow .2s;">
                <div style="width:72px; height:72px; margin:0 auto 14px; border-radius:50%; overflow:hidden; background:var(--bg-alt); border:3px solid var(--card-bg); box-shadow:0 4px 12px rgba(0,0,0,0.08);">
                    <?php if ( ! empty( $member['avatar'] ) ) : ?>
                        <img src="<?php echo esc_url( $member['avatar'] ); ?>" alt="<?php echo esc_attr( $member['name'] ); ?>" style="width:100%; height:100%; object-fit:cover;">
                    <?php else : ?>
                        <div style="width:100%; height:100%; background:linear-gradient(135deg, var(--color-primary), var(--color-secondary)); display:flex; align-items:center; justify-content:center; color:white; font-size:1.6rem; font-weight:700;">
                            <?php echo esc_html( strtoupper( mb_substr( $member['name'], 0, 1 ) ) ); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <h4 style="margin:0 0 4px; font-size:1rem; font-weight:700; color:var(--text);"><?php echo esc_html( $member['name'] ); ?></h4>
                <?php if ( ! empty( $member['role'] ) ) : ?>
                    <p style="margin:0; font-size:0.8rem; color:var(--text-muted);"><?php echo esc_html( $member['role'] ); ?></p>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div style="text-align:center; margin-top:32px;">
        <a href="<?php echo esc_url( $members_archive_url ); ?>" class="btn-outline" style="padding:10px 28px; border-radius:999px;">
            <?php esc_html_e( 'Meet All Members →', 'baloch-diamond' ); ?>
        </a>
    </div>
</section>

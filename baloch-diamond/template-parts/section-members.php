<?php
/**
 * Community Members Section (Lightweight)
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$show_members = get_theme_mod( '4392bd_members_show', true );
if ( ! $show_members ) {
    return;
}

$members_title   = get_theme_mod( '4392bd_members_title', esc_html__( 'Our Community', 'baloch-diamond' ) );
$members_badge   = get_theme_mod( '4392bd_members_badge', esc_html__( 'Join the Circle', 'baloch-diamond' ) );
$members_count   = get_theme_mod( '4392bd_members_count', 6 );

$members = array();
for ( $i = 1; $i <= 8; $i++ ) {
    $name = get_theme_mod( "4392bd_member_{$i}_name", '' );
    if ( $name ) {
        $members[] = array(
            'name'   => $name,
            'role'   => get_theme_mod( "4392bd_member_{$i}_role", '' ),
            'avatar' => get_theme_mod( "4392bd_member_{$i}_avatar", '' ),
            'link'   => get_theme_mod( "4392bd_member_{$i}_link", '#' ),
        );
    }
}

// Fallback demo members
if ( empty( $members ) ) {
    $members = array(
        array( 'name' => 'Durdana Baloch', 'role' => 'Master Artisan', 'avatar' => '', 'link' => '#' ),
        array( 'name' => 'Jahan Baloch',   'role' => 'Pattern Designer', 'avatar' => '', 'link' => '#' ),
        array( 'name' => 'Mehrab Script',  'role' => 'Embroidery Expert', 'avatar' => '', 'link' => '#' ),
        array( 'name' => 'Naznin G.',      'role' => 'Textile Artist', 'avatar' => '', 'link' => '#' ),
        array( 'name' => 'Farah Baloch',   'role' => 'Workshop Leader', 'avatar' => '', 'link' => '#' ),
        array( 'name' => 'Khalid Khan',    'role' => 'Community Moderator', 'avatar' => '', 'link' => '#' ),
    );
}

$members = array_slice( $members, 0, $members_count );
?>

<section class="section members-showcase" id="community-members" style="background:var(--bg-alt); padding:60px 24px; margin-top:30px; margin-bottom:30px; border-radius:24px;">
    <?php
    4392bd_section_header( 'members', array(
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
                            <?php echo esc_html( strtoupper( substr( $member['name'], 0, 1 ) ) ); ?>
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
        <a href="<?php echo esc_url( class_exists( 'bbPress' ) ? bbp_get_forum_archive_link() : '#forum' ); ?>" class="btn-outline" style="padding:10px 28px; border-radius:999px;">
            <?php esc_html_e( 'Meet All Members →', 'baloch-diamond' ); ?>
        </a>
    </div>
</section>

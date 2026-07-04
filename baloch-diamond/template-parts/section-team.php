<?php
/**
 * Team Section Template Part
 *
 * Standalone — fully customizable via the Customizer.
 * Up to 8 members with photo, role, bio, social links.
 * Show/Hide toggle, photo shape, show/hide role, bio, socials.
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hide/Show toggle
if ( ! get_theme_mod( 'bd_team_show', true ) ) {
    return;
}

$show_role   = get_theme_mod( 'bd_team_show_role', true );
$show_bio    = get_theme_mod( 'bd_team_show_bio', false );
$show_social = get_theme_mod( 'bd_team_show_social', true );
$photo_shape = get_theme_mod( 'bd_team_photo_shape', 'circle' );
$bg_color    = get_theme_mod( 'bd_team_bg_color', '' );

$photo_border_radius = ( $photo_shape === 'square' ) ? '12px' : ( ( $photo_shape === 'rounded' ) ? '20px' : '50%' );
$section_style       = $bg_color ? ' style="background-color:' . esc_attr( $bg_color ) . ';"' : ' style="background:var(--bg-alt)"';

// Default header gradients (same as original)
$header_gradients = array(
    'linear-gradient(135deg, #38bdf8, #818cf8)',
    'linear-gradient(135deg, #f97316, #ef4444)',
    'linear-gradient(135deg, #10b981, #38bdf8)',
    'linear-gradient(135deg, #a855f7, #ec4899)',
    'linear-gradient(135deg, #eab308, #f97316)',
    'linear-gradient(135deg, #06b6d4, #3b82f6)',
    'linear-gradient(135deg, #ec4899, #f43f5e)',
    'linear-gradient(135deg, #8b5cf6, #6366f1)',
);

// Build members from Customizer
$members = array();
for ( $i = 1; $i <= 8; $i++ ) {
    $name = get_theme_mod( "bd_team_member_{$i}_name", '' );
    if ( ! $name ) {
        continue;
    }
    $members[] = array(
        'index'     => $i,
        'name'      => $name,
        'role'      => get_theme_mod( "bd_team_member_{$i}_role", '' ),
        'bio'       => get_theme_mod( "bd_team_member_{$i}_bio", '' ),
        'photo'     => get_theme_mod( "bd_team_member_{$i}_photo", '' ),
        'twitter'   => get_theme_mod( "bd_team_member_{$i}_twitter", '' ),
        'linkedin'  => get_theme_mod( "bd_team_member_{$i}_linkedin", '' ),
        'instagram' => get_theme_mod( "bd_team_member_{$i}_instagram", '' ),
        'link'      => get_theme_mod( "bd_team_member_{$i}_link", '' ),
    );
}

// Demo fallback
if ( empty( $members ) ) {
    $members = array(
        array( 'index' => 1, 'name' => 'Durdana Baloch', 'role' => esc_html__( 'Master Artisan', 'baloch-diamond' ),        'bio' => '', 'photo' => '', 'twitter' => '', 'linkedin' => '', 'instagram' => '', 'link' => '' ),
        array( 'index' => 2, 'name' => 'Jahan Baloch',   'role' => esc_html__( 'Pattern Designer', 'baloch-diamond' ),      'bio' => '', 'photo' => '', 'twitter' => '', 'linkedin' => '', 'instagram' => '', 'link' => '' ),
        array( 'index' => 3, 'name' => 'Mehrab Script',  'role' => esc_html__( 'Embroidery Expert', 'baloch-diamond' ),     'bio' => '', 'photo' => '', 'twitter' => '', 'linkedin' => '', 'instagram' => '', 'link' => '' ),
    );
}

// Social icons SVG
$social_icons = array(
    'twitter'   => '<svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>',
    'linkedin'  => '<svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>',
    'instagram' => '<svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
);
?>

<section class="section balochi-pattern" id="team"<?php echo $section_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

    <?php
    bd_section_header( 'team', array(
        'badge' => esc_html__( 'The Artisans', 'baloch-diamond' ),
        'title' => esc_html__( 'Meet Our Masters', 'baloch-diamond' ),
        'desc'  => esc_html__( 'Talented craftspeople and designers behind every stitch and creation.', 'baloch-diamond' ),
        'icon'  => 'users',
    ) );
    ?>

    <div class="team-grid" style="position:relative;z-index:1">

        <?php foreach ( $members as $idx => $member ) :
            $default_grad  = $header_gradients[ $idx % count( $header_gradients ) ];
            $header_style  = 'background:' . $default_grad . ';';
            $has_social    = $member['twitter'] || $member['linkedin'] || $member['instagram'];
        ?>

        <div class="team-card">

            <!-- Header gradient bar -->
            <div class="team-card-header" style="<?php echo esc_attr( $header_style ); ?>"></div>

            <!-- Avatar -->
            <div class="team-avatar" style="border-radius:<?php echo esc_attr( $photo_border_radius ); ?>;overflow:hidden;">
                <?php if ( ! empty( $member['photo'] ) ) : ?>
                <img src="<?php echo esc_url( $member['photo'] ); ?>"
                     alt="<?php echo esc_attr( $member['name'] ); ?>"
                     style="width:100%;height:100%;object-fit:cover;"
                     loading="lazy">
                <?php else : ?>
                <div style="width:100%;height:100%;background:<?php echo esc_attr( $default_grad ); ?>;display:flex;align-items:center;justify-content:center;color:white;font-size:2rem;font-weight:700;">
                    <?php echo esc_html( mb_strtoupper( mb_substr( $member['name'], 0, 1 ) ) ); ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Name -->
            <h4 class="team-name">
                <?php if ( ! empty( $member['link'] ) ) : ?>
                <a href="<?php echo esc_url( $member['link'] ); ?>" style="color:inherit;text-decoration:none;">
                    <?php echo esc_html( $member['name'] ); ?>
                </a>
                <?php else : ?>
                <?php echo esc_html( $member['name'] ); ?>
                <?php endif; ?>
            </h4>

            <!-- Role -->
            <?php if ( $show_role && ! empty( $member['role'] ) ) : ?>
            <p class="team-role"><?php echo esc_html( $member['role'] ); ?></p>
            <?php endif; ?>

            <!-- Bio -->
            <?php if ( $show_bio && ! empty( $member['bio'] ) ) : ?>
            <p class="team-bio"><?php echo esc_html( $member['bio'] ); ?></p>
            <?php endif; ?>

            <!-- Social Links -->
            <?php if ( $show_social && $has_social ) : ?>
            <div class="team-socials">
                <?php if ( $member['twitter'] ) : ?>
                <a href="<?php echo esc_url( $member['twitter'] ); ?>" class="team-social" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                    <?php echo $social_icons['twitter']; // phpcs:ignore ?>
                </a>
                <?php endif; ?>
                <?php if ( $member['linkedin'] ) : ?>
                <a href="<?php echo esc_url( $member['linkedin'] ); ?>" class="team-social" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                    <?php echo $social_icons['linkedin']; // phpcs:ignore ?>
                </a>
                <?php endif; ?>
                <?php if ( $member['instagram'] ) : ?>
                <a href="<?php echo esc_url( $member['instagram'] ); ?>" class="team-social" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                    <?php echo $social_icons['instagram']; // phpcs:ignore ?>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div><!-- .team-card -->

        <?php endforeach; ?>

    </div><!-- .team-grid -->

</section>

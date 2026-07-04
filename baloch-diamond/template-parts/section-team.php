<?php
/**
 * Team Section Template Part
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Default gradients for team card headers
$header_gradients = array(
    'linear-gradient(135deg, #38bdf8, #818cf8)',
    'linear-gradient(135deg, #f97316, #ef4444)',
    'linear-gradient(135deg, #10b981, #38bdf8)',
    'linear-gradient(135deg, #a855f7, #ec4899)',
    'linear-gradient(135deg, #eab308, #f97316)',
    'linear-gradient(135deg, #06b6d4, #3b82f6)',
    'linear-gradient(135deg, #ec4899, #f43f5e)',
    'linear-gradient(135deg, #8b5cf6, #6366f1)',
    'linear-gradient(135deg, #14b8a6, #10b981)',
    'linear-gradient(135deg, #f59e0b, #d97706)',
);

// Social icons
$social_icons = array(
    'twitter'   => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>',
    'linkedin'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>',
    'github'    => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22"/></svg>',
    'instagram' => '<svg viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
    'website'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>',
);

// Count team members
$team_count = 0;
for ( $i = 1; $i <= 10; $i++ ) {
    $name = get_theme_mod( "bd_team_member_{$i}_name", '' );
    if ( $name ) {
        $team_count++;
    }
}

if ( $team_count === 0 ) {
    return;
}
?>

<section class="section balochi-pattern" id="team" style="background:var(--bg-alt)">

    <?php
    bd_section_header( 'team', array(
        'badge' => esc_html__( 'The Crew', 'baloch-diamond' ),
        'title' => esc_html__( 'Meet Our Team', 'baloch-diamond' ),
        'desc'  => esc_html__( 'The talented individuals behind our success. Passionate, creative, and dedicated to excellence.', 'baloch-diamond' ),
        'icon'  => 'users',
    ) );
    ?>

    <div class="team-grid" style="position:relative;z-index:1">

        <?php for ( $i = 1; $i <= 10; $i++ ) :

            $name     = get_theme_mod( "bd_team_member_{$i}_name", '' );
            $role     = get_theme_mod( "bd_team_member_{$i}_role", '' );
            $bio      = get_theme_mod( "bd_team_member_{$i}_bio", '' );
            $avatar   = get_theme_mod( "bd_team_member_{$i}_avatar", '' );

            // Header background
            $header_bg_type  = get_theme_mod( "bd_team_member_{$i}_header_type", 'gradient' );
            $header_bg_color = get_theme_mod( "bd_team_member_{$i}_header_color", '' );
            $header_grad_1   = get_theme_mod( "bd_team_member_{$i}_grad_1", '' );
            $header_grad_2   = get_theme_mod( "bd_team_member_{$i}_grad_2", '' );

            // Social links
            $s_twitter   = get_theme_mod( "bd_team_member_{$i}_twitter", '' );
            $s_linkedin  = get_theme_mod( "bd_team_member_{$i}_linkedin", '' );
            $s_github    = get_theme_mod( "bd_team_member_{$i}_github", '' );
            $s_instagram = get_theme_mod( "bd_team_member_{$i}_instagram", '' );
            $s_website   = get_theme_mod( "bd_team_member_{$i}_website", '' );

            if ( ! $name ) {
                continue;
            }

            // Determine header style
            if ( $header_bg_type === 'solid' && $header_bg_color ) {
                $header_style = 'background:' . esc_attr( $header_bg_color ) . ';';
            } elseif ( $header_bg_type === 'gradient' && $header_grad_1 && $header_grad_2 ) {
                $header_style = 'background:linear-gradient(135deg,' . esc_attr( $header_grad_1 ) . ',' . esc_attr( $header_grad_2 ) . ');';
            } else {
                // Use default gradient based on index
                $default_index = ( $i - 1 ) % count( $header_gradients );
                $header_style = 'background:' . $header_gradients[ $default_index ] . ';';
            }
        ?>

            <div class="team-card">

                <!-- Header with gradient/color -->
                <div class="team-card-header" style="<?php echo $header_style; ?>"></div>

                <!-- Avatar -->
                <div class="team-avatar">
                    <?php if ( $avatar ) : ?>
                        <img src="<?php echo esc_url( $avatar ); ?>"
                             alt="<?php echo esc_attr( $name ); ?>"
                             loading="lazy">
                    <?php else : ?>
                        <?php echo bd_icon( 'user', 40, 40 ); ?>
                    <?php endif; ?>
                </div>

                <!-- Info -->
                <h4 class="team-name"><?php echo esc_html( $name ); ?></h4>

                <?php if ( $role ) : ?>
                    <p class="team-role"><?php echo esc_html( $role ); ?></p>
                <?php endif; ?>

                <?php if ( $bio ) : ?>
                    <p class="team-bio"><?php echo esc_html( $bio ); ?></p>
                <?php endif; ?>

                <!-- Social Links -->
                <?php
                $has_social = $s_twitter || $s_linkedin || $s_github || $s_instagram || $s_website;
                if ( $has_social ) :
                ?>
                    <div class="team-socials">
                        <?php if ( $s_twitter ) : ?>
                            <a href="<?php echo esc_url( $s_twitter ); ?>" class="team-social" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                                <?php echo $social_icons['twitter']; ?>
                            </a>
                        <?php endif; ?>
                        <?php if ( $s_linkedin ) : ?>
                            <a href="<?php echo esc_url( $s_linkedin ); ?>" class="team-social" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                <?php echo $social_icons['linkedin']; ?>
                            </a>
                        <?php endif; ?>
                        <?php if ( $s_github ) : ?>
                            <a href="<?php echo esc_url( $s_github ); ?>" class="team-social" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                                <?php echo $social_icons['github']; ?>
                            </a>
                        <?php endif; ?>
                        <?php if ( $s_instagram ) : ?>
                            <a href="<?php echo esc_url( $s_instagram ); ?>" class="team-social" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                                <?php echo $social_icons['instagram']; ?>
                            </a>
                        <?php endif; ?>
                        <?php if ( $s_website ) : ?>
                            <a href="<?php echo esc_url( $s_website ); ?>" class="team-social" target="_blank" rel="noopener noreferrer" aria-label="Website">
                                <?php echo $social_icons['website']; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>

        <?php endfor; ?>

    </div>
</section>
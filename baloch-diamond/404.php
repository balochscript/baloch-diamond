<?php
/**
 * 404 Error Page Template
 *
 * @package Baloch_Diamond
 */

get_header();
?>

<main class="site-main" id="mainContent">

    <div class="error-404">

        <!-- Big 404 Number -->
        <div class="error-number">404</div>

        <!-- Diamond Decoration -->
        <div class="error-diamond"></div>

        <!-- Title -->
        <h2 class="error-title">
            <?php esc_html_e( 'Lost in the Desert', 'baloch-diamond' ); ?>
        </h2>

        <!-- Description -->
        <p class="error-desc">
            <?php esc_html_e( 'The page you\'re looking for has wandered off into the vast Balochi desert. Let\'s guide you back home.', 'baloch-diamond' ); ?>
        </p>

        <!-- Search Form -->
        <div style="max-width:500px;margin:0 auto 32px">
            <?php get_search_form(); ?>
        </div>

        <!-- Buttons -->
        <div class="error-buttons">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-gradient">
                <?php echo bd_icon( 'home', 18, 18 ); ?>
                <?php esc_html_e( 'Back to Home', 'baloch-diamond' ); ?>
            </a>
        </div>

        <!-- Decorative Balochi Pattern -->
        <div style="margin-top:60px;opacity:0.15">
            <svg width="300" height="80" viewBox="0 0 300 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M50 10 L65 30 L50 50 L35 30Z" stroke="var(--color-primary)" stroke-width="1.5"/>
                <path d="M100 10 L115 30 L100 50 L85 30Z" stroke="var(--color-secondary)" stroke-width="1.5"/>
                <path d="M150 10 L165 30 L150 50 L135 30Z" stroke="var(--color-primary)" stroke-width="1.5"/>
                <path d="M200 10 L215 30 L200 50 L185 30Z" stroke="var(--color-secondary)" stroke-width="1.5"/>
                <path d="M250 10 L265 30 L250 50 L235 30Z" stroke="var(--color-primary)" stroke-width="1.5"/>
                <line x1="0" y1="60" x2="300" y2="60" stroke="var(--color-primary)" stroke-width="1" stroke-dasharray="8 4"/>
                <line x1="0" y1="70" x2="300" y2="70" stroke="var(--color-secondary)" stroke-width="1" stroke-dasharray="4 8"/>
            </svg>
        </div>

    </div>

</main>

<?php
get_footer();
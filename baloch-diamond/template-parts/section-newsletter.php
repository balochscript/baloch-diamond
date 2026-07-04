<?php
/**
 * Newsletter / CTA Section Template Part
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$nl_title       = get_theme_mod( '4392bd_newsletter_title', esc_html__( 'Stay Connected', 'baloch-diamond' ) );
$nl_desc        = get_theme_mod( '4392bd_newsletter_desc', esc_html__( 'Subscribe to our newsletter and never miss an update. Get exclusive content, project news, and insights delivered to your inbox.', 'baloch-diamond' ) );
$nl_placeholder = get_theme_mod( '4392bd_newsletter_placeholder', esc_html__( 'Enter your email...', 'baloch-diamond' ) );
$nl_btn_text    = get_theme_mod( '4392bd_newsletter_btn_text', esc_html__( 'Subscribe', 'baloch-diamond' ) );
$nl_show_title  = get_theme_mod( '4392bd_newsletter_show_title', true );
$nl_show_desc   = get_theme_mod( '4392bd_newsletter_show_desc', true );
?>

<section class="newsletter-section" id="newsletter">
    <div class="newsletter-pattern"></div>

    <div class="newsletter-inner">

        <?php if ( $nl_show_title && $nl_title ) : ?>
            <h2 class="newsletter-title"><?php echo esc_html( $nl_title ); ?></h2>
        <?php endif; ?>

        <?php if ( $nl_show_desc && $nl_desc ) : ?>
            <p class="newsletter-desc"><?php echo esc_html( $nl_desc ); ?></p>
        <?php endif; ?>

        <form class="newsletter-form" id="newsletterForm">
            <?php wp_nonce_field( '4392bd_nonce', '4392bd_newsletter_nonce', false ); ?>

            <input type="email"
                   class="newsletter-input"
                   id="newsletterEmail"
                   name="email"
                   placeholder="<?php echo esc_attr( $nl_placeholder ); ?>"
                   required>

            <button type="submit" class="newsletter-btn" id="newsletterBtn">
                <?php echo esc_html( $nl_btn_text ); ?>
            </button>
        </form>

    </div>
</section>
<?php
/**
 * Comments Template
 *
 * @package Baloch_Diamond
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Don't load if comments are closed and no existing comments
if ( post_password_required() ) {
    return;
}

$commenter = wp_get_current_commenter();
?>

<div id="comments" class="comments-area" style="margin-top:48px">

    <?php if ( have_comments() ) : ?>

        <!-- Comments Title -->
        <h3 style="font-family:var(--font-heading);font-size:1.4rem;margin-bottom:24px">
            <?php
            printf(
                /* translators: %s: Number of comments */
                esc_html( _n( 'Comments (%s)', 'Comments (%s)', get_comments_number(), 'baloch-diamond' ) ),
                number_format_i18n( get_comments_number() )
            );
            ?>
        </h3>

        <!-- Comments List -->
        <div style="display:flex;flex-direction:column;gap:20px;margin-bottom:32px">
            <?php
            wp_list_comments( array(
                'style'       => 'div',
                'short_ping'  => true,
                'avatar_size' => 44,
                'callback'    => 'bd_comment_callback',
                'max_depth'   => 3,
            ) );
            ?>
        </div>

        <!-- Comment Pagination -->
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <div class="pagination" style="margin-bottom:32px">
                <?php
                paginate_comments_links( array(
                    'prev_text' => bd_icon( 'arrow-left', 16, 16 ),
                    'next_text' => bd_icon( 'arrow-right-small', 16, 16 ),
                ) );
                ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p style="color:var(--text-muted);text-align:center;padding:20px;background:var(--bg-alt);border-radius:12px;font-size:0.9rem">
            <?php esc_html_e( 'Comments are closed.', 'baloch-diamond' ); ?>
        </p>
    <?php endif; ?>

    <?php if ( comments_open() ) : ?>

        <!-- Comment Form -->
        <div class="comment-form-wrapper" id="respond">

            <h4>
                <?php
                if ( get_comments_number() > 0 ) {
                    esc_html_e( 'Leave a Comment', 'baloch-diamond' );
                } else {
                    esc_html_e( 'Be the First to Comment', 'baloch-diamond' );
                }
                ?>
            </h4>

            <?php
            // Cancel reply link
            if ( get_comment_reply_link() !== '' ) :
            ?>
                <small id="cancel-comment-reply-link-wrapper" style="display:block;margin-bottom:12px">
                    <?php cancel_comment_reply_link( esc_html__( '← Cancel Reply', 'baloch-diamond' ) ); ?>
                </small>
            <?php endif; ?>

            <form action="<?php echo esc_url( site_url( '/wp-comments-post.php' ) ); ?>"
                  method="post"
                  id="commentform"
                  class="comment-form">

                <?php if ( is_user_logged_in() ) : ?>

                    <p style="margin-bottom:12px;font-size:0.9rem;color:var(--text-muted)">
                        <?php
                        $current_user = wp_get_current_user();
                        /* translators: %s: User display name */
                        printf(
                            esc_html__( 'Logged in as %s.', 'baloch-diamond' ),
                            '<strong>' . esc_html( $current_user->display_name ) . '</strong>'
                        );
                        ?>
                        <a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>"
                           style="color:var(--color-primary);text-decoration:none">
                            <?php esc_html_e( 'Log out?', 'baloch-diamond' ); ?>
                        </a>
                    </p>

                <?php else : ?>

                    <div class="comment-form-fields">
                        <input type="text"
                               name="author"
                               id="author"
                               placeholder="<?php esc_attr_e( 'Your Name *', 'baloch-diamond' ); ?>"
                               value="<?php echo esc_attr( $commenter['comment_author'] ?? '' ); ?>"
                               required>

                        <input type="email"
                               name="email"
                               id="email"
                               placeholder="<?php esc_attr_e( 'Your Email *', 'baloch-diamond' ); ?>"
                               value="<?php echo esc_attr( $commenter['comment_author_email'] ?? '' ); ?>"
                               required>
                    </div>

                    <input type="url"
                           name="url"
                           id="url"
                           placeholder="<?php esc_attr_e( 'Website (optional)', 'baloch-diamond' ); ?>"
                           value="<?php echo esc_attr( $commenter['comment_author_url'] ?? '' ); ?>"
                           style="padding:12px 16px;border:1px solid var(--border);border-radius:10px;background:var(--card-bg);color:var(--text);font-family:var(--font-body);outline:none;width:100%;margin-bottom:12px">

                <?php endif; ?>

                <textarea name="comment"
                          id="comment"
                          rows="4"
                          placeholder="<?php esc_attr_e( 'Write your comment...', 'baloch-diamond' ); ?>"
                          required></textarea>

                <?php comment_id_fields(); ?>
                <?php do_action( 'comment_form', get_the_ID() ); ?>

                <button type="submit" class="btn-gradient">
                    <?php echo bd_icon( 'send', 16, 16 ); ?>
                    <?php esc_html_e( 'Post Comment', 'baloch-diamond' ); ?>
                </button>

            </form>

        </div>

    <?php endif; ?>

</div>
<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentyeleven_comment() which is
 * located in the functions.php file.
 *
 * @since Japibas 1.0
 */
?>

<section id="comments" <?php /* Hide comments div if it's empty */ if ( ! comments_open() && ! have_comments() && ( is_page() || ! post_type_supports( get_post_type(), 'comments' ) ) ) echo 'class="hide"'; ?>>

	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'japibas' ); ?></p>
	</div><!-- #comments -->
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

<?php // You can start editing here ?>

<?php if ( have_comments() ) : ?>

    <h2 id="comments-title">
		<?php
        	printf( _n( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'japibas' ),
        		number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
        ?>
    </h2>

    <ol class="commentlist">
    	<?php wp_list_comments( array( 'callback' => 'japibas_comment' ) ); ?>
    </ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav">
			<h3 class="assistive-text"><?php _e( 'Comment navigation', 'japibas' ); ?></h3>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'japibas' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'japibas' ) ); ?></div>
		</nav>
	<?php endif; // check for comment navigation ?>

<?php endif; // have_comments() ?>
   
	<?php
        /* If there are no comments and comments are closed, let's leave a little note, shall we?
         * But we don't want the note on pages or post types that do not support comments.
         */
        if ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>

        <p class="nocomments"><?php _e( 'Comments are closed.', 'japibas' ); ?></p>

    <?php endif; ?>

	<?php comment_form(); ?>

</section> <!-- #comments -->
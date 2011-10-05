	
<div id="comments">

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

<?php // You can start editing here -- including this comment! ?>

<?php if ( have_comments() ) : ?>
    
    <h3 id="comments-title">
		<?php
        	printf( _n( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'japibas' ),
        		number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
        ?>
    </h3>
    
    <ol class="commentlist">
    	<?php wp_list_comments( array( 'callback' => 'japibas_comment' ) ); ?>
    </ol>
    
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
        <div id="comment-nav">
        	<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'japibas' ) ); ?></div>
        	<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'japibas' ) ); ?></div>
        </div>
    <?php endif; // check for comment navigation ?>
    
<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : // If comments are open, but there are no comments ?>

	<?php else : // or, if we don't have comments:

        /* If there are no comments and comments are closed,
         * let's leave a little note, shall we?
         * But only on posts! We don't want the note on pages.
         */
        if ( !comments_open() && !is_page() ) :
        ?>
        	<p class="nocomments"><?php _e( 'Comments are closed.', 'japibas' ); ?></p>
        <?php endif; // end ! comments_open() && ! is_page() ?>


    <?php endif; ?>
    
<?php endif; ?>

	<?php comment_form(); ?>

</div> <!-- #comments -->
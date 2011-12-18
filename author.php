<?php 
	get_header(); 

	$user_id = get_query_var( 'author' );
?>

<section id="content">

	<?php
		/**
		 * Get the authors recent comments
		 */
		$comments = get_comments( array(
			'status' => 'approve',
			'number' => 10,
			'user_id' => $user_id
		) );

		if ( ! empty( $comments ) ) :

			echo '<div class="post hentry recentcomments">';

			echo '<h3>' . sprintf( __( '%s\'s Latest Comments', 'japibas' ), get_the_author_meta( 'display_name', $user_id ) ) . '</h3>';

			echo '<ul>';

			// Loop through each comment
			foreach ( $comments as $comment ) :

				echo '<li class="recentcomment">';

					// Normal comment
					if ( $comment->comment_parent == 0 ) {
						printf( __( 'Commented on %s', 'japibas' ), '<a href="' . get_comment_link( $comment ) . '">' . get_the_title( $comment->comment_post_ID ) . '</a>' );
					} else {
						// Reply
						$reply = get_comment( $comment->comment_parent );
						printf( __( 'Replied to %1$s on %2$s', 'japibas' ), 
							'<a href="' . get_comment_link( $reply ) . '">' . $reply->comment_author . '</a>',
							'<a href="' . get_comment_link( $comment ) . '">' . get_the_title( $comment->comment_post_ID ) . '</a>'
						);
					}

				echo '</li>';

			endforeach;

			echo '</ul> </div> <!-- .recentcomments -->';

		endif;
	?>
    
	<?php if ( have_posts() ) : ?>

        <h3 class="assistive-text"><?php printf( __( '%s\'s Latest Posts', 'japibas' ), get_the_author_meta( 'display_name', $user_id ) ); ?></h3>

        <?php
            while ( have_posts() ) : the_post();
                get_template_part( 'loop', get_post_format() );
            endwhile;
        ?>

	<?php else : ?>

        <article id="post-0" class="post hentry no-results not-found">
        	<header class="entry-header">
            	<h1 class="entry-title"><?php printf( __( '%s hasn\'t written any posts yet', 'japibas' ), get_the_author_meta( 'display_name', $user_id ) ); ?></h1>
			</header> <!-- .entry-header -->
            <div class="entry-content">
                <p><?php printf( __( 'Apologies, but the user %s hasn\'t written any posts yet for this site yet.', 'japibas'), get_the_author_meta( 'display_name', $user_id ) ); ?></p>
            </div> <!-- .entry-content -->
        </article> <!-- #post-0 -->

	<?php endif; ?>

	<?php japibas_paginate_links(); ?> 

</section> <!-- #content -->

<?php
	get_sidebar(); 
	get_footer();
?>
<?php
/**
 * Loop Meta Template
 *
 * Displays information at the top of the page about archive and search results when viewing those pages.  
 * This is not shown on the front page or singular views.
 *
 * @package Cakifo
 * @subpackage Template
 */
?>

	<?php if ( ( is_home() && is_front_page() ) ) : ?>

		<?php global $wp_query; ?>

		<div class="loop-meta">

			<?php if ( ! is_front_page() ) { ?>
                <h1 class="page-title"><span><?php echo get_post_field( 'post_title', $wp_query->get_queried_object_id() ); ?></span></h1>

                <div class="loop-description">
                    <?php echo apply_filters( 'the_excerpt', get_post_field( 'post_excerpt', $wp_query->get_queried_object_id() ) ); ?>
                </div> <!-- .loop-description -->
            <?php } ?>

		</div> <!-- .loop-meta -->

	<?php elseif ( is_singular() && ! is_singular( 'attachment' ) && function_exists( 'yoast_breadcrumb' ) ) : ?>

    	<div class="loop-meta">
        	<?php
				// Get the breaccrumb, except for in attachment pages
            	if ( ! is_singular( 'attachment' ) )
					yoast_breadcrumb( '<p class="loop-description breadcrumb">', '</p>' );
			?>
        </div>

	<?php elseif ( is_singular( 'attachment' ) ) : ?>

        <div class="loop-meta">
            <nav id="nav-attachment">
                <h3 class="assistive-text"><?php _e( 'Image navigation', 'japibas' ); ?></h3>
                <span class="nav-previous"><?php previous_image_link( false, __( '&larr; Previous Image' , 'japibas' ) ); ?></span>
                <span class="nav-next"><?php next_image_link( false, __( 'Next Image &rarr;' , 'japibas' ) ); ?></span>
            </nav> <!-- #nav-attachment -->
        </div>

	<?php elseif ( is_category() ) : ?>

		<?php $category_description = category_description(); ?>

		<div class="loop-meta <?php if ( ! empty( $category_description ) ) echo 'has-archive-description'; ?>">

			<h1 class="page-title"><?php printf( __( 'Category Archives: %s', 'japibas' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>

			<div class="loop-description">
				<?php echo $category_description; ?>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php elseif ( is_tag() ) : ?>

    	<?php $tag_description = tag_description(); ?>

		<div class="loop-meta <?php if ( ! empty( $tag_description ) ) echo 'has-archive-description'; ?>">

            <h1 class="page-title"><?php printf( __( 'Tag Archives: %s', 'japibas' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>

			<div class="loop-description">
				<?php echo $tag_description; ?>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php elseif ( is_tax( 'post_format' ) ) : ?>

    	<?php $post_format_description = term_description( '', get_query_var( 'taxonomy' ) ); ?>

		<div class="loop-meta <?php if ( ! empty( $post_format_description ) ) echo 'has-archive-description'; ?>">

			<h1 class="page-title">
                <?php printf( __( 'Post format: %s', 'japibas' ), '<span>' . get_post_format_string( get_post_format( get_the_ID() ) ) . '</span>' ); ?>
            </h1>

			<div class="loop-description">
				<?php echo $post_format_description; ?>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php elseif ( is_tax() ) : ?>

		<?php $term_description = term_description( '', get_query_var( 'taxonomy' ) ); ?>

		<div class="loop-meta <?php if ( ! empty( $term_description ) ) echo 'has-archive-description'; ?>">

			<h1 class="page-title">
				<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>
                <?php printf( __( 'Archives: %s', 'japibas' ), '<span>' . $term->name . '</span>' ); ?>
            </h1>

			<div class="loop-description">
				<?php echo $term_description; ?>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php elseif ( is_author() ) : ?>

		<?php
        	$user_id = get_query_var( 'author' );
			$display_name = get_the_author_meta( 'display_name', $user_id );
		?>

		<div id="hcard-<?php the_author_meta( 'user_nicename', $user_id ); ?>" class="author-meta hentry vcard">

            <h1 class="page-title"><?php printf( __( 'User: %s', 'japibas' ), '<span class="fn n">' . $display_name . '</span>' ); ?></h1>

			<div class="loop-description">
				<?php $desc = get_the_author_meta( 'description', $user_id ); ?>

				<?php if ( !empty( $desc ) ) { ?>
					<?php echo get_avatar( get_the_author_meta( 'user_email', $user_id ), '48', '', $display_name ); ?>

					<p class="user-bio">
						<?php echo $desc; ?>
					</p> <!-- .user-bio -->
				<?php } ?>
			</div> <!-- .loop-description -->

            <div class="author-profiles">
            	<?php printf( __( 'Find %s on:', 'japibas' ), '<span class="fn n">' . $display_name . '</span>' ); ?>

                <?php
					/**
					 * Get the authors social profiles
					 */
					$social = array();
					$social['website'] = get_the_author_meta( 'user_url', $user_id );
					$social['facebook'] = get_the_author_meta( 'facebook', $user_id );
					$social['twitter'] = get_the_author_meta( 'twitter', $user_id );
					$social['googleplus'] = get_the_author_meta( 'google_profile', $user_id );
					$social['flickr'] = get_the_author_meta( 'flickr', $user_id );

					/**
					 * Try to figure out if the user has entered full links or just usernames
					 * If they've entered usernames it changes it to full links
					 */
					foreach ( $social as $profile => $name ) :

						// Not empty and has no http:// found
						if ( ! empty ( $name ) && strpos( $name, 'http://' ) === false ) {
							if ( $profile == 'twitter' )
								$social[$profile] = 'http://twitter.com/' . $name;

							if ( $profile == 'facebook' )
								$social[$profile] = 'http://facebook.com/' . $name;

							if ( $profile == 'googleplus' )
								$social[$profile] = 'https://plus.google.com/' . $name;

							if ( $profile == 'flickr' )
								$social[$profile] = 'http://www.flickr.com/photos/' . $name;
						}

					endforeach;
				?>

                <ul class="social-profiles">
                	<?php
						if ( ! empty( $social['website'] ) )	
							echo '<li class="social-profile-website"><a href="' . esc_url( $social['website'] ) . '" rel="me">Website</a></li>';

						if ( ! empty( $social['facebook'] ) )	
							echo '<li class="social-profile-facebook"><a href="' . esc_url( $social['facebook'] ) . '" rel="me">Facebook</a></li>';

						if ( ! empty( $social['twitter'] ) )	
							echo '<li class="social-profile-twitter"><a href="' . esc_url( $social['twitter'] ) . '" rel="me">Twitter</a></li>';

						if ( ! empty( $social['googleplus'] ) )	
							echo '<li class="social-profile-googleplus"><a href="' . esc_url( $social['googleplus'] ) . '" rel="me">Google+</a></li>';

						if ( ! empty( $social['flickr'] ) )	
							echo '<li class="social-profile-flickr"><a href="' . esc_url( $social['flickr'] ) . '" rel="me">Flickr</a></li>';
					?>
               </ul>
            </div> <!-- .author-profiles -->

		</div> <!-- .author-meta -->

	<?php elseif ( is_search() ) : ?>

		<div class="loop-meta has-archive-description">

            <?php $results = absint( $wp_query->found_posts ); ?>

            <h1 class="page-title">
				<?php printf( _n( "%d Search Result for:", "%d Search Results for:", $results, 'japibas' ), $results ); ?>
                <span><?php echo esc_attr( get_search_query() ); ?></span>
			</h1>

			<div class="loop-description">
				<p>
				<?php printf( __( 'You are browsing the search results for &quot;%1$s&quot;', 'japibas' ), esc_attr( get_search_query() ) ); ?>
				</p>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php elseif ( is_date() ) : ?>

		<div class="loop-meta has-archive-description">
        	<?php
				$type = '';

				if ( is_month() )
					$type = __( 'F Y', 'japibas' ); // Month, year
				elseif ( is_year() )
					$type = __( 'Y', 'japibas' ); // Year
			?>

			<h1 class="page-title"><?php printf( __( 'Archives for %s', 'japibas' ), '<span>' . get_the_date( $type ) . '</span>' ); ?></h1>

			<div class="loop-description">
				<p><?php _e( 'You are browsing the site archives by date.', 'japibas' ); ?></p>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php elseif ( is_post_type_archive() ) : ?>

		<?php $post_type = get_post_type_object( get_query_var( 'post_type' ) ); ?>

		<div class="loop-meta <?php if ( ! empty( $post_type->description ) ) echo 'has-archive-description'; ?>">

			<h1 class="page-title"><?php post_type_archive_title(); ?></h1>

			<div class="loop-description">
				<?php if ( ! empty( $post_type->description ) ) echo "<p>{$post_type->description}</p>"; ?>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php elseif ( is_archive() ) : ?>

		<div class="loop-meta has-archive-description">

			<h1 class="page-title"><?php _e( 'Blog Archives', 'japibas' ); ?></h1>

			<div class="loop-description">
				<p><?php _e( 'You are browsing the site archives.', 'japibas' ); ?></p>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php endif; ?>
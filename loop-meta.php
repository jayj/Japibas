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
        
	<?php elseif ( is_singular() && function_exists( 'yoast_breadcrumb' ) ) : ?>
    
    	<div class="loop-meta">
        	<?php yoast_breadcrumb( '<p class="loop-description breadcrumb"', '</p>' ); ?>
        </div>

	<?php elseif ( is_category() ) : ?>

		<div class="loop-meta">

			<h1 class="page-title"><?php printf( __( 'Category Archives: %s', 'japibas' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>

			<div class="loop-description">
				<?php echo category_description(); ?>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php elseif ( is_tag() ) : ?>

		<div class="loop-meta">

            <h1 class="page-title"><?php printf( __( 'Tag Archives: %s', 'japibas' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>

			<div class="loop-description">
				<?php echo tag_description(); ?>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->
        
	<?php elseif ( is_tax( 'post_format' ) ) : ?>

		<div class="loop-meta">

			<h1 class="page-title">
                <?php printf( __( 'Post format: %s', 'japibas' ), '<span>' . get_post_format_string( get_post_format( get_the_ID() ) ) . '</span>' ); ?>
            </h1>

			<div class="loop-description">
				<?php echo term_description( '', get_query_var( 'taxonomy' ) ); ?>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php elseif ( is_tax() ) : ?>

		<div class="loop-meta">

			<h1 class="page-title">
				<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>
                <?php printf( __( 'Archives: %s', 'japibas' ), '<span>' . $term->name . '</span>' ); ?>
            </h1>

			<div class="loop-description">
				<?php echo term_description( '', get_query_var( 'taxonomy' ) ); ?>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php elseif ( is_author() ) : ?>

		<?php $user_id = get_query_var( 'author' ); ?>

		<div id="hcard-<?php the_author_meta( 'user_nicename', $user_id ); ?>" class="author-meta hentry vcard">

            <h1 class="page-title"><?php printf( __( 'Author: %s', 'japibas' ), '<span class="fn n">' . get_the_author_meta( 'display_name', $user_id ) . '</span>' ); ?></h1>

			<div class="loop-description">
				<?php $desc = get_the_author_meta( 'description', $user_id ); ?>

				<?php if ( !empty( $desc ) ) { ?>
					<?php echo get_avatar( get_the_author_meta( 'user_email', $user_id ), '48', '', get_the_author_meta( 'display_name', $user_id ) ); ?>

					<p class="user-bio">
						<?php echo $desc; ?>
					</p> <!-- .user-bio -->
				<?php } ?>
			</div> <!-- .loop-description -->

		</div> <!-- .author-meta -->

	<?php elseif ( is_search() ) : ?>

		<div class="loop-meta">

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

		<div class="loop-meta">
        
        	<?php
				$type = '';
				
				if ( is_month() )
					$type = __( 'F Y', 'japibas' ); // Month, year
				elseif ( is_year() )
					$type = __( 'Y', 'japibas' ); // Year
			?>
        
			<h1 class="page-title"><?php printf( __( 'Archives for %s', 'japibas' ), get_the_date( $type ) ); ?></h1>

			<div class="loop-description">
				<p>
				<?php _e( 'You are browsing the site archives by date.', 'japibas' ); ?>
				</p>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php elseif ( is_post_type_archive() ) : ?>

		<?php $post_type = get_post_type_object( get_query_var( 'post_type' ) ); ?>

		<div class="loop-meta">

			<h1 class="page-title"><?php post_type_archive_title(); ?></h1>

			<div class="loop-description">
				<?php if ( !empty( $post_type->description ) ) echo "<p>{$post_type->description}</p>"; ?>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php elseif ( is_archive() ) : ?>

		<div class="loop-meta">

			<h1 class="page-title"><?php _e( 'Blog Archives', 'japibas' ); ?></h1>

			<div class="loop-description">
				<p>
					<?php _e( 'You are browsing the site archives.', 'japibas' ); ?>
				</p>
			</div> <!-- .loop-description -->

		</div> <!-- .loop-meta -->

	<?php endif; ?>
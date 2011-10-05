<?php
/**
 * The slider template consists of posts from a chosen category chosen 
 * in the theme options
 */

get_header(); ?>

	<?php
		/**
		 * Begin the featured posts section
		 */
		$featured_args = array(
			'cat' => japibas_get_setting( 'slider_category' ),
			'posts_per_page' => japibas_get_setting( 'slider_posts' ),
			'no_found_rows' => true,
		);
		
		// The Featured Posts query
		$featured = new WP_Query( $featured_args );
		
	if ( $featured->have_posts() ) :
		
			/**
			 * We will need to count featured posts starting from zero
			 * to create the slider navigation
			 */
			$counter_slider = 0;
    ?>
    
        <div id="featured-section">
			<div id="inner-slider">
            <ul class="slides">
				<?php
					// Let's roll
					while ( $featured->have_posts() ) : $featured->the_post();
					
					// Increase the counter
					$counter_slider++;
                ?>
                
                    <li class="slide" id="slide-<?php echo esc_attr( $counter_slider ); ?>">
						<?php
							get_the_image( array(
								'meta_key' => array( 'featured_image', 'thumbnail' ),
								'attachment' => false,
								'size' => 'slider',
							) );
							
							// Get image size of the featured image to see if the content needs to be removed
							$featured_image = array();
							$feature_size = array();
							
							if ( get_post_meta( $post->ID, 'featured_image', true ) || get_post_meta( $post->ID, 'thumbnail', true ) )
								$featured_image = array(
									get_post_meta( $post->ID, 'featured_image', true ),
									get_post_meta( $post->ID, 'thumbnail', true ),
								);
							
							foreach ( $featured_image as $image ) {
								$feature_size[] = getimagesize( esc_url( $image ) );
							}
							
							// If the size fills the entire slide, hide the content
							if ( empty( $feature_size ) || ! $feature_size[0][0] >= 920 ) :
						?>
                        
                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                            
                            <div class="entry-summary">
                            	<?php the_excerpt(); ?>
                            	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'japibas' ), 'after' => '</div>' ) ); ?>
                            </div> <!-- .entry-summary -->
                        
                        <?php else : ?>
                        
                        	<h2 class="entry-title full-image"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        
                        <?php endif; ?>
                    </li>

                <?php endwhile; ?>
            </ul> <!-- .slides -->
			</div> <!-- #inner-slider -->
        </div> <!-- #featured-section -->

<?php endif; ?>
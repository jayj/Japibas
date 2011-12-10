<?php
/**
 * The template for displaying image attachments.
 */

get_header(); ?>

<div id="content">

	<?php while ( have_posts() ) : the_post(); ?>

        <article <?php post_class(); ?>>

            <header class="entry-header">
                <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
            </header> <!-- .entry-header -->

            <div class="entry-content">
            
                <div class="entry-attachment">
                <div class="attachment">
					<?php
						/**
						* Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
						* or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
						*/
						$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
						
						foreach ( $attachments as $k => $attachment ) {
							if ( $attachment->ID == $post->ID )
							break;
						}
						
						$k++;
						
						// If there is more than 1 attachment in a gallery
						if ( count( $attachments ) > 1 ) {
							if ( isset( $attachments[ $k ] ) )
								// get the URL of the next image attachment
								$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
							else
								// or get the URL of the first image attachment
								$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
						} else {
							// or, if there's only 1 image, get the URL of the image
							$next_attachment_url = wp_get_attachment_url();
						}
                    ?>
                    
                    <a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
                    	$attachment_size = apply_filters( 'japibas_attachment_size', 848 );
                    	echo wp_get_attachment_image( $post->ID, array( $attachment_size, 1024 ) ); // filterable image width with 1024px limit for image height. ?>
					</a>
                    
                    <?php if ( ! empty( $post->post_excerpt ) ) : ?>
                    	<div class="entry-caption">
                    		<?php the_excerpt(); ?>
                    	</div>
                    <?php endif; ?>
                </div> <!-- .attachment -->
                
                </div> <!-- .entry-attachment -->
                
                <div class="entry-description">
                	<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( '<span>Pages:</span>', 'japibas' ), 'after' => '</div>' ) ); ?>
                </div><!-- .entry-description -->
            
            </div><!-- .entry-content -->

            <div class="clear"></div>
            
            <footer class="entry-meta">
				<?php
                	$metadata = wp_get_attachment_metadata();
                
					printf( __( 'Published <span class="entry-date"><abbr class="published" title="%1$s">%2$s</abbr></span> in <a href="%3$s" title="Return to %4$s" rel="gallery">%4$s</a>', 'japibas' ),
                		esc_attr( get_the_time() ),
                		get_the_date(),
                		esc_url( get_permalink( $post->post_parent ) ),
                		get_the_title( $post->post_parent )
                	);
					
					edit_post_link( __( 'Edit', 'japibas' ), '| ' );
                ?>
            
            </footer> <!-- .entry-meta -->

        </article> <!-- .post-<?php the_ID(); ?> -->

	<?php endwhile; ?>

    <?php comments_template(); ?>

</div> <!-- #content -->

<?php 
	get_sidebar(); 
	get_footer();
?>
<?php
/**
 * This is shown if the single post has a thumbnail larger than 920px i width
 */
?>
    
	<?php
        // Get image size of the featured image to see if the content needs to be removed
        $featured_image = array();
        $feature_size = array();
		
		$meta_featured_image = get_post_meta( $post->ID, 'featured_image', true );
		$meta_thumbnail = get_post_meta( $post->ID, 'thumbnail', true );
        
        if ( $meta_featured_image || $meta_thumbnail ) {
            $featured_image = array(
            	$meta_featured_image,
            	$meta_thumbnail,
        	);
		}
        
        foreach ( $featured_image as $image ) {
            $feature_size[] = @getimagesize( esc_url( $image ) );
        }
        
        // If the size fills the entire slide, hide the content
        if ( ! empty( $feature_size ) && $feature_size[0][0] >= 920 ) :
    ?>
    
        <section id="featured-section">

            <ul class="slides">

                <li class="slide single-slide">
                    <?php
                        get_the_image( array(
                            'meta_key' => array( 'featured_image', 'thumbnail' ),
                            'attachment' => false,
                            'size' => 'slider',
                        ) );
                    ?>

                    <h2 class="entry-title full-image"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2> 
                </li>

            </ul> <!-- .slides -->

        </section> <!-- #featured-section -->
    
    <?php else : ?>

        <!-- Fix margin if there's no large thumbnail for the post -->
        <div id="singular-no-large-thumbnail"></div>

    <?php endif; ?>
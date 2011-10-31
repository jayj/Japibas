<?php
/**
 * The default template for displaying posts with the 'image' format
 */
?>

<div <?php post_class( 'indexed' ); ?>>

	<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

    <div class="entry-content">
    	<?php
			get_the_image( array(
				'meta_key' => array( 'thumbnail' ),
				'attachment' => false,
				'link_to_post' => false,
				'size' => 'large',
			) );
		?>

        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'japibas' ) );  ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( '<span>Pages:</span>', 'japibas' ), 'after' => '</div>' ) ); ?>
    </div> <!-- .entry-content -->

    <div class="clear"></div>
    
    <div class="image-meta">
            
			<div>
				<?php
                    printf( __( '<a href="%1$s" rel="bookmark">%2$s</a> by <span class="author vcard"><a class="url fn n" href="%3$s" title="%4$s">%5$s</a></span>', 'japibas' ),
                        esc_url( get_permalink() ),
                        esc_html( get_the_date() ),
                        get_author_posts_url( get_the_author_meta( 'ID' ) ),
                        sprintf( esc_attr__( 'View all posts by %s', 'japibas' ), get_the_author() ),
                        get_the_author()
                    );
					
					edit_post_link( __( 'Edit', 'japibas' ), '<br />' );
                ?>
            </div>
            
            <div>
				<?php
                	// Check if there's any tags
					$tags_list = get_the_tag_list( '', __( ', ', 'japibas' ) );
					
					$tags = ( $tags_list ) ? sprintf( '<br />' . __( 'Tagged %s', 'japibas' ), $tags_list ) : '';
					
					// The entry meta
					printf( __( 'Posted in %1$s %2$s', 'japibas' ),
						get_the_category_list( __( ', ', 'japibas' ) ),
						$tags
					);
				?>
			</div>
            
            
            
    </div> <!-- .image-meta -->
    

       <!-- <a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Posted on %s', 'japibas' ), get_the_date() ); ?>" class="entry-date">
            <span><?php echo get_the_date( 'd' ); ?></span>
            <?php echo get_the_date( 'M' ); ?>
        </a>--> <!-- .entry-date -->

    
    <?php
        // Show the number of comments
        /*if ( comments_open() && ! post_password_required() )
            comments_popup_link( '0', '1', '%', 'entry-comments-number', '' );*/
    ?>
    
</div> <!-- .post-<?php the_ID(); ?> -->
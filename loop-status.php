<?php
/**
 * The default template for displaying posts with the 'status' format
 */
?>

<div <?php post_class(); ?>>
    
	<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

    <div class="entry-content">
    	

        <?php
			printf( '<div class="avatar"' . __( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>', 'japibas' ) . '</div>',
				get_author_posts_url( get_the_author_meta( 'ID' ) ),
				sprintf( esc_attr__( 'View all posts by %s', 'japibas' ), get_the_author() ),
				get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'japibas_status_avatar', '65' ) )
			);
		?>
        
        
        
        
        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'japibas' ) );  ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( '<span>Pages:</span>', 'japibas' ), 'after' => '</div>' ) ); ?>
    </div> <!-- .entry-content -->

    <div class="clear"></div>
    
    <div class="entry-meta">
            <?php
				// The quote meta
				printf( __( '<a href="%1$s" title="%2$s">Status</a> posted on <a href="%3$s" rel="bookmark">%4$s</a>', 'japibas' ),
					get_post_format_link( 'status' ),
					esc_attr__( 'View all Statuses', 'japibas' ),
					esc_url( get_permalink() ),
					esc_html( get_the_date() )
				);
                
                edit_post_link( __( 'Edit', 'japibas' ), ' | ', '' );
            ?>
    </div> <!-- .quote-meta -->
    
    <?php
        // Show the number of comments
        if ( comments_open() && ! post_password_required() )
            comments_popup_link( '0', '1', '%', 'entry-comments-number', '' );
    ?>
    
</div> <!-- .post-<?php the_ID(); ?> -->
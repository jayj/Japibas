<?php
/**
 * The default template for displaying posts with the 'video' format
 */
?>

<div <?php post_class(); ?>>
    
	<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

    <div class="entry-content">
        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'japibas' ) );  ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( '<span>Pages:</span>', 'japibas' ), 'after' => '</div>' ) ); ?>
    </div> <!-- .entry-content -->

    <div class="clear"></div>
    
    <div class="entry-meta">
            <?php
				// The entry meta
				printf( __( '<a href="%1$s" title="%2$s">Video</a> posted by <span class="author vcard"><a class="url fn n" href="%3$s" title="%4$s">%5$s</a></span> on <a href="%6$s" rel="bookmark">%7$s</a>', 'japibas' ),
					get_post_format_link( 'video' ),
					esc_attr__( 'View all Videoes', 'japibas' ),
					get_author_posts_url( get_the_author_meta( 'ID' ) ),
					sprintf( esc_attr__( 'View all posts by %s', 'japibas' ), get_the_author() ),
					get_the_author(),
					esc_url( get_permalink() ),
					esc_html( get_the_date() )
				);
                
                edit_post_link( __( 'Edit', 'japibas' ), ' | ', '' );
            ?>
    </div> <!-- .entry-meta -->
    
    <a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Posted on %s', 'japibas' ), get_the_date() ); ?>" class="entry-date">
        <span><?php echo get_the_date( 'd' ); ?></span>
        <?php echo get_the_date( 'M' ); ?>
    </a> <!-- .entry-date -->
        
    <?php
        // Show the number of comments
        if ( comments_open() && ! post_password_required() )
            comments_popup_link( '0', '1', '%', 'entry-comments-number', '' );
    ?>
    
</div> <!-- .post-<?php the_ID(); ?> -->
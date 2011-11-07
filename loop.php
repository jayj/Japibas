<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags and
 * http://codex.wordpress.org/Conditional_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 */
?>

<article <?php post_class(); ?>>
    
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        
		<?php if ( 'post' == get_post_type() ) : ?>
            <time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" pubdate>
                <a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Posted on %s', 'japibas' ), get_the_date() ); ?>">
                    <span><?php echo get_the_date( 'd' ); ?></span>
                    <?php echo get_the_date( 'M' ); ?>
                </a> <!-- .entry-date -->
            </time>
        <?php endif; ?>
        
        <?php
            // Show the number of comments
            if ( comments_open() && ! post_password_required() )
                comments_popup_link( '0', '1', '%', 'entry-comments-number', '' );
        ?>
	</header> <!-- .entry-header -->
    
    <?php if ( is_archive() || is_search() ) : ?>
    
		<?php
			if ( ! post_password_required() )
				get_the_image( array(
					'meta_key' => array( 'thumbnail' ),
					'attachment' => false,
					'size' => 'small',
				) );
		?>
        
        <div class="entry-summary">
            <?php the_excerpt(); ?>
            <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( '<span>Pages:</span>', 'japibas' ), 'after' => '</div>' ) ); ?>
        </div> <!-- .entry-summary -->
        
    <?php else : ?>
    
    	<?php
			if ( ! post_password_required() )
				get_the_image( array(
					'meta_key' => array( 'thumbnail' ),
					'attachment' => false,
					'size' => 'thumbnail',
				) );
		?>
        
        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'japibas' ) );  ?>
            <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( '<span>Pages:</span>', 'japibas' ), 'after' => '</div>' ) ); ?>
        </div> <!-- .entry-content -->
        
    <?php endif; ?>
    
    <div class="clear"></div>
    
    <footer class="entry-meta">
            <?php
				// Post meta, make sure it's a post
				if ( 'post' == get_post_type() ) :
				
					// Check if there's any tags
					$tags_list = get_the_tag_list( '', __( ', ', 'japibas' ) );
					
					$tags = ( $tags_list ) ? sprintf( __( '| Tagged %s', 'japibas' ), $tags_list ) : '';
					
					// The entry meta
					printf( __( 'Posted by <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span> in %4$s %5$s', 'japibas' ),
						get_author_posts_url( get_the_author_meta( 'ID' ) ),
						sprintf( esc_attr__( 'View all posts by %s', 'japibas' ), get_the_author() ),
						get_the_author(),
						get_the_category_list( __( ', ', 'japibas' ) ),
						$tags
					);
					
				endif;
                
                edit_post_link( __( 'Edit', 'japibas' ), ' | ', '' );
            ?>
    </footer> <!-- .entry-meta -->
    
</article> <!-- .post-<?php the_ID(); ?> -->
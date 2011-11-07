<?php
/**
 * The default template for displaying posts with the 'quote' format
 */
?>

<article <?php post_class(); ?>>
    
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header> <!-- .entry-header -->

    <div class="entry-content">
        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'japibas' ) );  ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( '<span>Pages:</span>', 'japibas' ), 'after' => '</div>' ) ); ?>
    </div> <!-- .entry-content -->

    <div class="clear"></div>
    
    <footer class="quote-meta">
            <?php
				// The quote meta
				printf( __( '<a href="%1$s" title="%2$s">Quote</a> posted by <span class="author vcard"><a class="url fn n" href="%3$s" title="%4$s">%5$s</a></span> on <a href="%6$s" rel="bookmark">%7$s</a>', 'japibas' ),
					get_post_format_link( 'quote' ),
					esc_attr__( 'View all Quotes', 'japibas' ),
					get_author_posts_url( get_the_author_meta( 'ID' ) ),
					sprintf( esc_attr__( 'View all posts by %s', 'japibas' ), get_the_author() ),
					get_the_author(),
					esc_url( get_permalink() ),
					esc_html( get_the_date() )
				);
                
                edit_post_link( __( 'Edit', 'japibas' ), ' | ', '' );
            ?>
    </footer> <!-- .quote-meta -->
    
</article> <!-- .post-<?php the_ID(); ?> -->
<?php
/**
 * The template for displaying content in the single.php template
 */
?>

<article <?php post_class(); ?>>

    <header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        <?php if ( 'post' == get_post_type() ) : ?>
            <time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" pubdate>
                <a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Posted on %s', 'japibas' ), get_the_date() ); ?>">
                    <span><?php echo get_the_date( 'd' ); ?></span>
                    <?php echo get_the_date( 'M' ); ?>
                </a> <!-- .entry-date -->
            </time>
        <?php endif; ?>
    </header> <!-- .entry-header -->

	<?php
        if ( ! post_password_required() )
            get_the_image( array(
                'meta_key' => array( 'thumbnail' ),
                'attachment' => false,
                'size' => 'thumbnail',
            ) );
    ?>

    <div class="entry-content">
        <?php the_content();  ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( '<span>Pages:</span>', 'japibas' ), 'after' => '</div>' ) ); ?>
    </div> <!-- .entry-content -->

    <div class="clear"></div>

    <?php if ( has_post_format( 'quote' ) ) : ?>
    	<footer class="quote-meta">
    <?php else : ?>
    	<footer class="entry-meta">
	<?php endif; ?>

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
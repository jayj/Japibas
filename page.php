<?php get_header(); ?>

<div id="main">

	<?php while ( have_posts() ) : the_post(); ?>

        <div <?php post_class(); ?>>

            <h1 class="entry-title"><?php the_title(); ?></h1>

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

			<?php edit_post_link( __( 'Edit', 'japibas' ), '<div class="entry-meta">', '</div> <!-- .entry-meta -->' ); ?>

        </div> <!-- .post-<?php the_ID(); ?> -->

	<?php endwhile; ?>

    <?php comments_template(); ?>

</div> <!-- #main -->

<?php 
	get_sidebar(); 
	get_footer();
?>
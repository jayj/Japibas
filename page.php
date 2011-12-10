<?php get_header(); ?>

<div id="content">

	<?php while ( have_posts() ) : the_post(); ?>

        <article <?php post_class(); ?>>

            <header class="entry-header">
                <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
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

			<?php edit_post_link( __( 'Edit', 'japibas' ), '<footer class="entry-meta">', '</footer> <!-- .entry-meta -->' ); ?>

        </article> <!-- .post-<?php the_ID(); ?> -->

	<?php endwhile; ?>

    <?php comments_template(); ?>

</div> <!-- #content -->

<?php 
	get_sidebar(); 
	get_footer();
?>
<?php get_header(); ?>

<div id="content">

	<?php
    	if ( have_posts() ) while( have_posts() ) : the_post();
			get_template_part( 'loop', 'single' );
    	endwhile;
	?>

	<?php if ( is_active_sidebar( 'single-widgets' ) ) : ?>

        <div id="single-widgets" class="clearfix">
            <?php dynamic_sidebar( 'single-widgets' ); ?> 
        </div> <!-- #single-widgets -->

    <?php endif; ?>

    <?php comments_template(); ?>

</div> <!-- #content -->

<?php 
	get_sidebar(); 
	get_footer();
?>
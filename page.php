<?php get_header(); ?>

<div id="main">

	<?php
		var_dump( get_option( 'japibas_theme_options' ), japibas_get_setting() );
	
    	while ( have_posts() ) : the_post();
			get_template_part( 'loop', 'page' );
    	endwhile;
	?>
    
    <?php comments_template(); ?>

</div> <!-- #main -->

<?php 
	get_sidebar(); 
	get_footer();
?>
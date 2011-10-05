<?php get_header(); ?>

    <div id="main">
    
    <?php
    	var_dump( get_option( 'japibas_theme_options' ) );
		//var_dump( japibas_get_setting() );
		//var_dump( japibas_get_setting( 'color_scheme' ) );
		//var_dump( japibas_get_setting( 'footer_text' ) );
	
		// Exclude categories entered in the admin panel
		global $wp_query;
		query_posts(
			array_merge(
				array( 'category__not_in' => japibas_get_setting( 'exclude_cats' ) ),
				$wp_query->query
			)
		);
		
		if ( have_posts() ) while( have_posts() ) : the_post();
		
			get_template_part( 'loop', 'index' );
		
		endwhile;
    ?>
    
	<?php japibas_paginate_links(); ?> 

</div> <!-- #main -->

<?php 
	get_sidebar(); 
	get_footer();
?>
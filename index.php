<?php get_header(); ?>

<div id="content">

    <?php
		// Exclude categories entered in the theme optionss
		global $wp_query;

		query_posts(
			array_merge(
				array( 'category__not_in' => (array) japibas_get_setting( 'exclude_cats' ) ),
				$wp_query->query
			)
		);

		if ( have_posts() ) while( have_posts() ) : the_post();

			get_template_part( 'loop', get_post_format() );

		endwhile;
    ?>

	<?php japibas_paginate_links(); ?> 

</div> <!-- #content -->

<?php 
	get_sidebar(); 
	get_footer();
?>
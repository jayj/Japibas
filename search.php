<?php get_header(); ?>

<div id="main">

	<?php
		if ( have_posts() ) : while ( have_posts() ) : the_post();
			get_template_part( 'loop', get_post_format() );
    	endwhile;
	?>
    
    <div class="post hentry">
        <h3><?php _e( 'Not what you\'re looking for?', 'japibas' ); ?></h3>
        
        <div class="entry-content">
            <p><?php _e( 'Try searching again with some different keywords', 'japibas' ); ?></p>
            <?php get_search_form(); ?>
        </div> <!-- .entry-content -->
    </div> <!-- .post -->
    
	<?php japibas_paginate_links(); ?> 
    
    <?php else : ?>
     
        <div class="post hentry not-found">
            <h1 class="entry-title"><?php _e( 'Nothing Found', 'japibas' ); ?></h1>
            
            <div class="entry-content">
                <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'japibas' ); ?></p>
                <?php get_search_form(); ?>
            </div> <!-- .entry-content -->
        </div> <!-- .post.not-found -->
    
    <?php endif; ?>
    
</div> <!-- end main -->

<?php 
	get_sidebar(); 
	get_footer();
?>
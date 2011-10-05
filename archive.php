<?php get_header(); ?>

<div id="main">

	<?php if ( have_posts() ) : ?>

		<?php
            while ( have_posts() ) : the_post();
                get_template_part( 'loop', get_post_format() );
            endwhile;
        ?>

	<?php else : ?>

        <div id="post-0" class="post hentry no-results not-found">
            <h2 class="entry-title"><?php _e( 'Nothing Found', 'japibas' ); ?></h2>

            <div class="entry-content">
                <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'japibas' ); ?></p>
                <?php get_search_form(); ?>
            </div> <!-- .entry-content -->
        </div> <!-- #post-0 -->

	<?php endif; ?>

	<?php japibas_paginate_links(); ?> 

</div> <!-- #main -->

<?php 
	get_sidebar(); 
	get_footer();
?>
<?php get_header(); ?>

<div id="content">

	<?php if ( have_posts() ) : ?>

		<?php
            while ( have_posts() ) : the_post();
                get_template_part( 'loop', get_post_format() );
            endwhile;
        ?>

	<?php else : ?>

        <article id="post-0" class="post hentry no-results not-found">
        	<header class="entry-header">
            	<h1 class="entry-title"><?php _e( 'Nothing Found', 'japibas' ); ?></h1>
            </header> <!-- .entry-header -->

            <div class="entry-content">
                <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'japibas' ); ?></p>
                <?php get_search_form(); ?>
            </div> <!-- .entry-content -->
        </article> <!-- #post-0 -->

	<?php endif; ?>

	<?php japibas_paginate_links(); ?> 

</div> <!-- #content -->

<?php
	get_sidebar();
	get_footer();
?>
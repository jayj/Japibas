<?php get_header(); ?>

<div id="content">

    <article class="hentry post error404 not-found">

        <h1 class="entry-title"><?php _e( 'Uh oh, 404, we can&rsquo;t find that page!', 'japibas' ); ?></h1>

        <?php
			$phrase = __( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'japibas' );

			if ( is_active_sidebar( 'error-page-widgets' ) )
				$phrase = __( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'japibas' );
        ?>

            <p><?php echo $phrase; ?></p>

        	<?php get_search_form(); ?>

			<?php 
				// Widget ready 404 page - You can use widgets to put content here
				if ( is_active_sidebar( 'error-page-widgets' ) ) {
					echo '<div class="not-found-widgets clearfix">';
						dynamic_sidebar( 'error-page-widgets' );
					echo '</div>';
				}
            ?>

    </article> <!-- .not-found -->

</div> <!-- #content -->

<?php get_footer(); ?>